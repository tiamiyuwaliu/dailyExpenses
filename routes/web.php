<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/set/locale/{locale}', function (\Illuminate\Http\Request $request, $locale) {
    $request->session()->put('language', $locale);
    $request->session()->save();
    return back();
})->name('set-locale');


require __DIR__.'/auth.php';
Route::any('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::any('/clients', [\App\Http\Controllers\ClientController::class, 'index'])->middleware(['auth', 'verified'])->name('clients');
Route::any('/clients/add', [\App\Http\Controllers\ClientController::class, 'add'])->middleware(['auth', 'verified'])->name('clients.add');
Route::any('/clients/edit/{id}', [\App\Http\Controllers\ClientController::class, 'edit'])->middleware(['auth', 'verified'])->name('clients.edit')->where('id', '[0-9]+');;
Route::any('/clients/delete/{id}', [\App\Http\Controllers\ClientController::class, 'delete'])->middleware(['auth', 'verified'])->name('clients.delete')->where('id', '[0-9]+');;
Route::any('/clients/{id}', [\App\Http\Controllers\ClientController::class, 'view'])->middleware(['auth', 'verified'])->name('clients.view')->where('id', '[0-9]+');;

Route::any('/expenses', [\App\Http\Controllers\ExpenseController::class, 'index'])->middleware(['auth', 'verified'])->name('expenses');
Route::any('/expenses/add', [\App\Http\Controllers\ExpenseController::class, 'add'])->middleware(['auth', 'verified'])->name('expenses.add');
Route::any('/expenses/edit/{id}', [\App\Http\Controllers\ExpenseController::class, 'edit'])->middleware(['auth', 'verified'])->name('expenses.edit');
Route::any('/expenses/delete/{id}', [\App\Http\Controllers\ExpenseController::class, 'delete'])->middleware(['auth', 'verified'])->name('expenses.delete');
Route::any('/expenses/duplicate/{id}', [\App\Http\Controllers\ExpenseController::class, 'duplicate'])->middleware(['auth', 'verified'])->name('expenses.duplicate');

Route::any('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->middleware(['auth', 'verified'])->name('profile');
Route::any('/profile/password', [\App\Http\Controllers\ProfileController::class, 'password'])->middleware(['auth', 'verified'])->name('profile.password');
Route::any('/profile/business', [\App\Http\Controllers\ProfileController::class, 'business'])->middleware(['auth', 'verified'])->name('profile.business');
Route::any('/profile/theme', [\App\Http\Controllers\ProfileController::class, 'theme'])->middleware(['auth', 'verified'])->name('profile.theme');

Route::any('/report/expenses', [\App\Http\Controllers\ReportController::class, 'expenses'])->middleware(['auth', 'verified'])->name('report.expenses');


Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(callback: function() {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index']);

    /**settings routes**/
    Route::any('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'general'])->name('settings.general');
    Route::any('/settings/appearance', [\App\Http\Controllers\Admin\SettingsController::class, 'appearance'])->name('settings.appearance');
    Route::any('/settings/email', [\App\Http\Controllers\Admin\SettingsController::class, 'email'])->name('settings.email');
    Route::any('/settings/users', [\App\Http\Controllers\Admin\SettingsController::class, 'users'])->name('settings.users');
    Route::any('/settings/social', [\App\Http\Controllers\Admin\SettingsController::class, 'social'])->name('settings.social');
    Route::any('/settings/announcement', [\App\Http\Controllers\Admin\SettingsController::class, 'announcement'])->name('settings.announcement');
    Route::any('/settings/payment', [\App\Http\Controllers\Admin\SettingsController::class, 'payment'])->name('settings.payment');
    Route::any('/settings/billing', [\App\Http\Controllers\Admin\SettingsController::class, 'billing'])->name('settings.billing');
    Route::any('/settings/legal', [\App\Http\Controllers\Admin\SettingsController::class, 'legal'])->name('settings.legal');
    Route::any('/settings/cron', [\App\Http\Controllers\Admin\SettingsController::class, 'cron'])->name('settings.cron');
    Route::any('/settings/license', [\App\Http\Controllers\Admin\SettingsController::class, 'license'])->name('settings.license');

    Route::any('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
    Route::any('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::any('/users/edit/{id}', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit')->where('id', '[0-9]+');
    Route::any('/users/delete/{id}', [\App\Http\Controllers\Admin\UserController::class, 'delete'])->name('users.delete')->where('id', '[0-9]+');


    Route::any('/pages', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('pages');
    Route::any('/pages/create', [\App\Http\Controllers\Admin\PageController::class, 'create'])->name('pages.create');
    Route::any('/pages/edit/{id}', [\App\Http\Controllers\Admin\PageController::class, 'edit'])->name('pages.edit')->where('id', '[0-9]+');
    Route::any('/pages/delete/{id}', [\App\Http\Controllers\Admin\PageController::class, 'delete'])->name('pages.delete')->where('id', '[0-9]+');


    Route::any('/coupons', [\App\Http\Controllers\Admin\CouponController::class, 'index'])->name('coupons');
    Route::any('/coupons/create', [\App\Http\Controllers\Admin\CouponController::class, 'create'])->name('coupons.create');
    Route::any('/coupons/edit/{id}', [\App\Http\Controllers\Admin\CouponController::class, 'edit'])->name('coupons.edit')->where('id', '[0-9]+');
    Route::any('/coupons/delete/{id}', [\App\Http\Controllers\Admin\CouponController::class, 'delete'])->name('coupons.delete')->where('id', '[0-9]+');


    Route::any('/tax', [\App\Http\Controllers\Admin\TaxController::class, 'index'])->name('tax');
    Route::any('/tax/create', [\App\Http\Controllers\Admin\TaxController::class, 'create'])->name('tax.create');
    Route::any('/tax/edit/{id}', [\App\Http\Controllers\Admin\TaxController::class, 'edit'])->name('tax.edit')->where('id', '[0-9]+');
    Route::any('/tax/delete/{id}', [\App\Http\Controllers\Admin\TaxController::class, 'delete'])->name('tax.delete')->where('id', '[0-9]+');


    Route::any('/plans', [\App\Http\Controllers\Admin\PlanController::class, 'index'])->name('plans');
    Route::any('/plans/create', [\App\Http\Controllers\Admin\PlanController::class, 'create'])->name('plans.create');
    Route::any('/plans/edit/{id}', [\App\Http\Controllers\Admin\PlanController::class, 'edit'])->name('plans.edit')->where('id', '[0-9]+');
    Route::any('/plans/delete/{id}', [\App\Http\Controllers\Admin\PlanController::class, 'delete'])->name('plans.delete')->where('id', '[0-9]+');


    Route::any('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments');
    Route::any('/payments/edit/{id}', [\App\Http\Controllers\Admin\PaymentController::class, 'edit'])->name('payments.edit')->where('id', '[0-9]+');
    Route::any('/invoice/{id}', [\App\Http\Controllers\Admin\PaymentController::class, 'invoice'])->name('payments.invoice')->where('id', '[0-9]+');

});
