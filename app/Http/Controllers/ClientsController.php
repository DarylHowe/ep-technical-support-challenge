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

    public function show($client)
    {
        /*
         * Support Ticket: Client Booking Visibility Issue
         * As this ticket is a 'Critical' item a 'quick fix' is likely the best approach.
         * I am not considering cleaning the code or refactoring due to the priority of the ticket.
         * I'm assuming many of our users are being affected by this issue and a fix needs to be implemented ASAP.
         * We can address how well the code is written/structured at a later time.
         */
        $client = Client::where('id', $client)->with('bookings')->first();

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
