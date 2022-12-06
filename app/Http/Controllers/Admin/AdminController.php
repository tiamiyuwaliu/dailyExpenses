<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(Request $request) {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                ['title' => __('Users'), 'count' => 30, 'icon' => 'mdi-account-group-outline' ],
                ['title' => __('Pages'), 'count' => 5, 'icon' => 'mdi-note-text-outline' ],
                ['title' => __('Payments'), 'count' => 3, 'icon' => 'mdi-cash-multiple' ],
                ['title' => __('Plans'), 'count' => 10, 'icon' => 'mdi-view-grid-plus-outline' ]
            ]
        ]);
    }
}
