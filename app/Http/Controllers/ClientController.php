<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    //

    public function view(Request $request, $id) {
        seo()->setTitle(__('Expenses > View'));

        $expense = Expense::find($id);
        if (!$expense) return redirect()->route('expenses');
        return Inertia::render('Expenses/View', [
            'clients' => Client::limit(50)->get(),
            'expense' => $expense
        ]);
    }}
