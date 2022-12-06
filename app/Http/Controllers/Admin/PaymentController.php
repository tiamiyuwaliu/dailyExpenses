<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index(Request $request) {
        seo()->setTitle(__('Admin > Payments'));
        $payments = Payment::orderBy('id', config('results-order', 'asc'))->paginate(config('results-per-page', 10));
        $payments->getCollection()->transform(function($value) {
            return $value->prepare();

        });
        return Inertia::render('Admin/Payments/List', [
            'payments' => $payments
        ]);
    }

    public function edit(Request $request, $id) {
        seo()->setTitle(__('Admin > Payments'));
        $payment = Payment::find($id);
        $payment->prepare();

        return Inertia::render('Admin/Payments/Edit', [
            'payment' => $payment
        ]);
    }

    public function invoice(Request $request, $id) {
        seo()->setTitle(__('Admin > Invoice'));
        $payment = Payment::find($id);
        $payment->prepare();

        return Inertia::render('Admin/Payments/Invoice', [
            'payment' => $payment,
            'billing' =>  [
                'vendor' => config('billing-vendor'),
                'address' => config('billing-address'),
                'city' => config('billing-city'),
                'state' => config('billing-state'),
                'postcode' => config('billing-postcode'),
                'country' => config('billing-country'),
                'phone' => config('billing-phone'),
                'vat' => config('billing-vat'),
            ]
        ]);
    }
}
