<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Plan;
use App\Models\Tax;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlanController extends Controller
{
    public function index(Request $request) {
        seo()->setTitle(__('Admin > Plans'));
        $plans = Plan::orderBy('id', config('results-order', 'asc'))->paginate(config('results-per-page', 10));
        $plans->getCollection()->transform(function($value) {
            $value->editUrl = route('plans.edit', ['id' => $value->id]);
            $value->deleteUrl = route('plans.delete', ['id' => $value->id]);
            $value->monthly = format_currency($value->monthly_price);
            $value->yearly = format_currency($value->yearly_price);
            $value->userCount = $value->users->count();
            return $value;
        });
        return Inertia::render('Admin/Plans/List', [
            'plans' => $plans
        ]);
    }

    public function create(Request $request) {
        seo()->setTitle('Admin > Plans > Create');

        if ($request->post()) {
            $request->validate([
                'name' => 'required|string',
                'monthly' => 'required',
                'yearly' => 'required',
            ]);
            Plan::create([
                'name' => $request->name,
                'description' => $request->description,
                'trial_days' => $request->trials,
                'monthly_price' => $request->monthly,
                'yearly_price' => $request->yearly,
                'visibility' => $request->visibility,
                'position' => $request->position,
                'features' => json_encode($request->features),
                'taxes' => json_encode($request->taxes),
                'coupons' => json_encode($request->coupons),
            ]);

            return redirect()->route('plans')->with('message', __('Plans created successfully'));

        }
        return Inertia::render('Admin/Plans/Create', [
            'taxes' => collect(Tax::all())->map(function($value) {
                $type = ($value->tax_type) ? __('Exclusive') : __('Inclusive');
                return ['title' => $value->name.' ('.$value->tax_value.'% '.$type.')', 'value' => $value->id];
            }),
            'coupons' => collect(Coupon::all())->map(function($value) {
                return ['title' => $value->name.' ('.$value->deduction.'% '.__('Discount').')', 'value' => $value->id];
            })
        ]);
    }

    public function edit(Request $request, $id) {
        seo()->setTitle('Admin > Plans > Edit');

        $plan = Plan::find($id);

        if (!$plan) return redirect()->route('plans');
        if ($request->post()) {

            $request->validate([
                'name' => 'required|string',
                'monthly' => 'required',
                'yearly' => 'required',
            ]);

            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'trial_days' => $request->trials,
                'monthly_price' => $request->monthly,
                'yearly_price' => $request->yearly,
                'visibility' => $request->visibility,
                'position' => $request->position,
                'features' => json_encode($request->features),
                'taxes' => json_encode($request->taxes),
                'coupons' => json_encode($request->coupons),
                'status' => $request->status
            ];
            $plan->update($data);

            return redirect()->route('plans')->with('message', __('Plan saved successfully'));

        }
        $plan->taxes = json_decode($plan->taxes);
        $plan->coupons = json_decode($plan->coupons);
        return Inertia::render('Admin/Plans/Edit', [
            'plan' => $plan,
            'taxes' => collect(Tax::all())->map(function($value) {
                $type = ($value->tax_type) ? __('Exclusive') : __('Inclusive');
                return ['title' => $value->name.' ('.$value->tax_value.'% '.$type.')', 'value' => $value->id];
            }),
            'coupons' => collect(Coupon::all())->map(function($value) {
                return ['title' => $value->name.' ('.$value->deduction.'% '.__('Discount').')', 'value' => $value->id];
            })
        ]);
    }

    public function delete(Request $request, $id) {
        Plan::find($id)->delete();
        return redirect()->route('plans')->with('message', __('Plans deleted successfully'));

    }
}
