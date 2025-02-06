<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {

        /*
         * SECURITY VULNERABILITY: Client Privacy Concern
         * As this ticket is an 'Urgent' item a 'quick fix' has been implemented.
         * I have ignored refactoring, tests and improve the code structure.
         * This ticket revolves around Client Privacy which needs to address ASAP (assuming the data is highly confidential).
         * This fix ignore what would happen to pre-existing users (they would not to be able to see ANY Clients, including those that had created).
         * This logic is explained further in ticket/proposed solutions.
         */
        $clients = auth()->user()->clients;

        foreach ($clients as $client) {
            $client->append('bookings_count');
        }

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }


    public function show($clientId)
    {
        // ** Additional Improvements **
        // Handle access control outside of controller

        /*
         * SECURITY VULNERABILITY: Client Privacy Concern
         * Access Control:
         * In real world scenario I would check if user has access to Client in another layer (outside of controller).
         * I've found an access control middleware to be effective in the past.
         */
        $user = auth()->user();
        $client = Client::where('id', $clientId)
            ->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with('bookings')
            ->first();

        if (!$client) {
            abort(403, 'Unauthorized access to this Client or Client does not exist.');
        }

        return view('clients.show', ['client' => $client]);
    }

    public function store(Request $request)
    {
        // ** Additional Improvements **
        // Add validation class and validate user input values i.e. ClientStoreRequest - https://laravel.com/docs/11.x/validation
        // Create Client Service / Repository class move this code into there (re-usable, easier to test, single responsibility, organisation)
        // Return ClientResource instead of Client object - https://laravel.com/docs/11.x/eloquent-resources#concept-overview
        // Wrap in try catch, handle failing scenario

        $client = new Client;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->save();

        auth()->user()->clients()->attach($client);

        return $client;
    }

    public function destroy(Request $request, $client): JsonResponse
    {
        // ** Additional Improvements **
        // Access control - check if the authenticated use is allowed to delete the Client (could be role, permission or owner based)
        // Consider non success responses (Client does not exist, user does not have permission to delete, server error)
        // 'url' in JSON response is following ClientsController@store response logic where we pass URL to UI to load
        // This is not my preferred approach but fixing this is outside the scope of the challenge, because of this I have
        // followed the existing format so the code is at least consistent although not idea
        // Wrap in try catch, handle failing scenario

        Client::where('id', $client)->delete();
        return response()->json(['url' => route('clients.index')]);
    }
}
