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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/set/locale/{locale}', function (\Illuminate\Http\Request $request, $locale) {
    $request->session()->put('language', $locale);
    $request->session()->save();
    return back();
})->name('set-locale');

Route::get('/dashboard', function () {
    seo()->setTitle(__("Settings > General"));
    return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

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
