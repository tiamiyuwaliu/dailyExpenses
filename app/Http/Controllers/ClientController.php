<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index(Request $request) {
        seo()->setTitle(__('Clients'));
        $clients = Client::orderBy('id', config('results-order', 'asc'))->paginate(config('results-per-page', 10));
        $clients->getCollection()->transform(function($value) {
            $value->editUrl = route('clients.edit', ['id' => $value->id]);
            $value->deleteUrl = route('clients.delete', ['id' => $value->id]);
            $value->viewUrl = route('clients.view', ['id' => $value->id]);
            return $value;
        });
        return Inertia::render('Clients/List', [
            'clients' => $clients
        ]);
    }

    public function add(Request $request) {
        seo()->setTitle(__('Clients > Add'));

        if ($request->post()) {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required'
            ]);

            Client::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company_name' => $request->company_name,
                'email_address' => $request->email_address,
                'phone_number' => $request->phone_number,
                'country' => $request->country,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'tax_Name' => $request->tax_name,
                'tax_number' => $request->tax_number,
            ]);

            return redirect()->route('clients')->with('message', __('Client added successfully'));
        }

        return Inertia::render('Clients/Add', [
            'countries' => country_lists()
        ]);
    }

    public function edit(Request $request, $id) {
        seo()->setTitle(__('Clients > Edit'));

        $client  = Client::find($id);
        if (!$client) return redirect()->route('clients');

        if ($request->post()) {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required'
            ]);

            $client->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company_name' => $request->company_name,
                'email_address' => $request->email_address,
                'phone_number' => $request->phone_number,
                'country' => $request->country,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'tax_Name' => $request->tax_name,
                'tax_number' => $request->tax_number,
            ]);

            return redirect()->route('clients')->with('message', __('Client saved successfully'));
        }

        return Inertia::render('Clients/Edit', [
            'countries' => country_lists()
        ]);
    }

    public function view(Request $request, $id) {
        seo()->setTitle(__('Client > View'));

        $client = Client::find($id);
        if (!$client) return redirect()->route('clients');
        return Inertia::render('Clients/View', [
            'client' => $client,
            'expenses' => $client->expenses()
        ]);
    }

    public function delete(Request $request, $id) {
        Client::find($id)->delete();
        return redirect()->route('clients')->with('message', __('Client deleted successfully'));
    }
}
