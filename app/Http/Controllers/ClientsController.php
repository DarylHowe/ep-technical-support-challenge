<?php

namespace App\Http\Controllers;

use App\Client;
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

    public function destroy($client)
    {
        Client::where('id', $client)->delete();

        return 'Deleted';
    }
}
