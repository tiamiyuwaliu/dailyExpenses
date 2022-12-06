<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CouponController extends Controller
{
    public function index(Request $request) {
        seo()->setTitle(__('Admin > Coupons'));
        $coupons = Coupon::orderBy('id', config('results-order', 'asc'))->paginate(config('results-per-page', 10));
        $coupons->getCollection()->transform(function($value) {
            $value->editUrl = route('coupons.edit', ['id' => $value->id]);
            $value->deleteUrl = route('coupons.delete', ['id' => $value->id]);
            return $value;
        });
        return Inertia::render('Admin/Coupons/List', [
            'coupons' => $coupons
        ]);
    }

    public function create(Request $request) {
        seo()->setTitle('Admin > Coupons > Create');

        if ($request->post()) {
            $request->validate([
                'name' => 'required|string',
                'code' => 'required|alpha_dash|alpha_num',
                'deduction' => 'required',
                'quantity' => 'required'
            ]);
            Coupon::create([
                'name' => $request->name,
                'code' => $request->code,
                'deduction' => $request->deduction,
                'quantity' => $request->quantity,
            ]);

            return redirect()->route('coupons')->with('message', __('Coupons created successfully'));

        }
        return Inertia::render('Admin/Coupons/Create', [
        ]);
    }

    public function edit(Request $request, $id) {
        seo()->setTitle('Admin > Pages > Edit');

        $coupon = Coupon::find($id);

        if (!$coupon) return redirect()->route('coupons');
        if ($request->post()) {

            $request->validate([
                'name' => 'required|string',
                'code' => 'required|alpha_dash|alpha_num',
                'deduction' => 'required',
                'quantity' => 'required'
            ]);

            $data = [
                'name' => $request->name,
                'code' => $request->code,
                'deduction' => $request->deduction,
                'quantity' => $request->quantity,
                'status' => $request->status
            ];
            $coupon->update($data);

            return redirect()->route('coupons')->with('message', __('Coupon saved successfully'));

        }
        return Inertia::render('Admin/Coupons/Edit', [
            'coupon' => $coupon
        ]);
    }

    public function delete(Request $request, $id) {
        Coupon::find($id)->delete();
        return redirect()->route('coupons')->with('message', __('Coupons deleted successfully'));

    }
}
