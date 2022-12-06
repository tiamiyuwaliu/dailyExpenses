<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaxController extends Controller
{
    public function index(Request $request) {
        seo()->setTitle(__('Admin > Tax'));
        $tax = Tax::orderBy('id', config('results-order', 'asc'))->paginate(config('results-per-page', 10));
        $tax->getCollection()->transform(function($value) {
            $value->editUrl = route('tax.edit', ['id' => $value->id]);
            $value->deleteUrl = route('tax.delete', ['id' => $value->id]);
            return $value;
        });
        return Inertia::render('Admin/Tax/List', [
            'taxes' => $tax
        ]);
    }

    public function create(Request $request) {
        seo()->setTitle('Admin > Tax > Create');

        if ($request->post()) {
            $request->validate([
                'name' => 'required|string',
                'regions' => 'required',
                'type' => 'required',
                'value' => 'required',
            ]);
            Tax::create([
                'name' => $request->name,
                'regions' => json_encode($request->regions),
                'tax_type' => $request->type,
                'tax_value' => $request->value,
            ]);

            return redirect()->route('tax')->with('message', __('Tax created successfully'));

        }
        return Inertia::render('Admin/Tax/Create', [
            'countries' => country_lists()
        ]);
    }

    public function edit(Request $request, $id) {
        seo()->setTitle('Admin > Taxes > Edit');

        $tax = Tax::find($id);

        if (!$tax) return redirect()->route('tax');
        if ($request->post()) {

            $request->validate([
                'name' => 'required|string',
                'regions' => 'required',
                'type' => 'required',
                'value' => 'required',
            ]);

            $data = [
                'name' => $request->name,
                'regions' => json_encode($request->regions),
                'tax_type' => $request->type,
                'tax_value' => $request->value,
                'status' => $request->status
            ];
            $tax->update($data);

            return redirect()->route('tax')->with('message', __('Tax saved successfully'));

        }
        $tax->regions = json_decode($tax->regions);
        return Inertia::render('Admin/Tax/Edit', [
            'tax' => $tax,
            'countries' => country_lists()
        ]);
    }

    public function delete(Request $request, $id) {
        Tax::find($id)->delete();
        return redirect()->route('tax')->with('message', __('Tax deleted successfully'));

    }
}
