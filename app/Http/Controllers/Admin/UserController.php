<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request) {
        seo()->setTitle(__('Admin > Users'));
        $users = User::orderBy('id', config('results-order', 'asc'))->paginate(config('results-per-page', 10));
        $users->getCollection()->transform(function($value) {
            $value->avatar = ($value->avatar) ?  storage_url($value->avatar, 100) : url('images/avatar.png');
            $value->editUrl = route('users.edit', ['id' => $value->id]);
            $value->deleteUrl = route('users.delete', ['id' => $value->id]);
            return $value;
        });
        return Inertia::render('Admin/Users/List', [
            'users' => $users,
            'stats' => [
                ['title' => __('All Users'), 'count' => 30, 'icon' => 'mdi-account-group-outline' ],
                ['title' => __('Active users'), 'count' => 5, 'icon' => 'mdi-note-text-outline' ],
                ['title' => __('Inactive users'), 'count' => 3, 'icon' => 'mdi-cash-multiple' ],

            ]
        ]);
    }

    public function create(Request $request) {
        seo()->setTitle('Admin > Users > Create');

        if ($request->post()) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'country' => $request->country
            ]);

            return redirect()->route('users')->with('message', __('User created successfully'));

        }
        return Inertia::render('Admin/Users/Create', [
            'countries' => country_lists()
        ]);
    }

    public function edit(Request $request, $id) {
        seo()->setTitle('Admin > Users > Edit');

        $user = User::find($id);

        if (!$user) return redirect()->route('users');
        if ($request->post()) {

            $validateRules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
            ];
            if ($request->password) $validateRules['password'] = [ 'confirmed', Password::defaults()];
            $request->validate($validateRules);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'country' => $request->country,
                'status' => $request->status,
                'timezone' => $request->timezone,
                'two_factor' => $request->two_factor,
                'is_admin' => $request->role,
            ];
            if ($request->password) $data['password'] = Hash::make($request->password);
            $user->update($data);

            return redirect()->route('users')->with('message', __('User saved successfully'));

        }
        return Inertia::render('Admin/Users/Edit', [
            'countries' => country_lists(),
            'timezones' => timezone_lists(),
            'user' => $user
        ]);
    }

    public function delete(Request $request, $id) {
        if ($id == 1) return redirect()->route('users');
        User::find($id)->delete();
        return redirect()->route('users')->with('message', __('User deleted successfully'));

    }
}
