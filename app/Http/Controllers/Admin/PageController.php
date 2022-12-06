<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index(Request $request) {
        seo()->setTitle(__('Admin > Pages'));
        $pages = Page::orderBy('id', config('results-order', 'asc'))->paginate(config('results-per-page', 10));
        $pages->getCollection()->transform(function($value) {
            $value->editUrl = route('pages.edit', ['id' => $value->id]);
            $value->deleteUrl = route('pages.delete', ['id' => $value->id]);
            $value->viewUrl = url('page/'.$value->slug);
            return $value;
        });
        return Inertia::render('Admin/Pages/List', [
            'pages' => $pages
        ]);
    }

    public function create(Request $request) {
        seo()->setTitle('Admin > Pages > Create');

        if ($request->post()) {
            $request->validate([
                'title' => 'required|string',
                'slug' => 'required|alpha_dash|alpha_num'
            ]);
            Page::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->detail,
                'position' => $request->position,
            ]);

            return redirect()->route('pages')->with('message', __('Page created successfully'));

        }
        return Inertia::render('Admin/Pages/Create', [
        ]);
    }

    public function edit(Request $request, $id) {
        seo()->setTitle('Admin > Pages > Edit');

        $page = Page::find($id);

        if (!$page) return redirect()->route('pages');
        if ($request->post()) {

            $validateRules = [
                'title' => 'required|string',
                'slug' => 'required|alpha_dash|alpha_num'
            ];
            $request->validate($validateRules);

            $data = [
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->detail,
                'position' => $request->position,
                'status' => $request->status
            ];
            $page->update($data);

            return redirect()->route('pages')->with('message', __('Page saved successfully'));

        }
        return Inertia::render('Admin/Pages/Edit', [
            'page' => $page
        ]);
    }

    public function delete(Request $request, $id) {
        Page::find($id)->delete();
        return redirect()->route('pages')->with('message', __('Page deleted successfully'));

    }
}
