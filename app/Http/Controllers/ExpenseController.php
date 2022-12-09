<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request) {
        seo()->setTitle(__('Expenses'));

    }

    public function add(Request $request) {

    }

    public function edit(Request $request, $id) {

    }

    public function view(Request $request, $id) {

    }

    public function delete(Request $request, $id) {

    }

    public function duplicate(Request $request, $id) {

    }
}
