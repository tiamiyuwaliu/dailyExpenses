<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request) {
        seo()->setTitle(__("Dashboard"));
        return Inertia::render('Dashboard');
    }
}
