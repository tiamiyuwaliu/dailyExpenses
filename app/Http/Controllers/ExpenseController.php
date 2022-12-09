<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index(Request $request) {
        seo()->setTitle(__('Expenses'));
        $expenses = Expense::orderBy('id', config('results-order', 'asc'))->paginate(config('results-per-page', 10));
        $expenses->getCollection()->transform(function($value) {
            $value->editUrl = route('expenses.edit', ['id' => $value->id]);
            $value->deleteUrl = route('expenses.delete', ['id' => $value->id]);
            $value->viewUrl = route('expenses.view', ['id' => $value->id]);
            return $value;
        });
        return Inertia::render('Expenses/List', [
            'expenses' => $expenses
        ]);
    }

    public function add(Request $request) {
        seo()->setTitle(__('Expenses > Add'));

        if ($request->post()) {
            $request->validate([
                'item' => 'required',
                'cost' => 'required',
                'record_date' => 'required'
            ]);

            Expense::create([
                'item' => $request->name,
                'cost' => $request->cost,
                'record_date' => $request->record_date,
                'client_id' => $request->client_id
            ]);
            return redirect()->route('expenses')->with('message', __('Expenses added successfully'));
        }

        return Inertia::render('Expenses/Add', [
           'clients' => Client::limit(50)->get(),
        ]);
    }

    public function edit(Request $request, $id) {
        seo()->setTitle(__('Expenses > Edit'));

        $expense = Expense::find($id);
        if (!$expense) return redirect()->route('expenses');

        if ($request->post()) {
            $request->validate([
                'item' => 'required',
                'cost' => 'required',
                'record_date' => 'required'
            ]);

            $expense->update([
                'item' => $request->name,
                'cost' => $request->cost,
                'record_date' => $request->record_date,
                'client_id' => $request->client_id
            ]);
            return redirect()->route('expenses')->with('message', __('Expenses saved successfully'));
        }

        return Inertia::render('Expenses/Edit', [
            'clients' => Client::limit(50)->get(),
            'expense' => $expense
        ]);
    }



    public function delete(Request $request, $id) {
        Expense::find($id)->delete($id);
        return redirect()->route('expenses')->with('message', __('Expense deleted successfully'));
    }

    public function duplicate(Request $request, $id) {
        $expense = Expense::find($id);
        $newExpense = new Expense();
        $newExpense->item = $expense->item;
        $newExpense->cost = $expense->cost;
        $newExpense->record_date = $expense->record_date;
        $newExpense->client_id = $expense->client_id;
        $newExpense->save();

        return json_encode($newExpense);
    }
}
