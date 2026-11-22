<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\SeoPage;
use App\Models\Setting;
use App\Models\Speciality;
use App\Support\Uploader;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        return view('admin.seo.index', [
            'pages'       => SeoPage::orderBy('id')->get(),
            'settings'    => Setting::all_(),
            'departments' => Department::ordered()->get(['id', 'name', 'slug', 'meta_title', 'meta_description']),
            'specialities'=> Speciality::ordered()->get(['id', 'name', 'category', 'meta_title', 'meta_description']),
        ]);
    }

    public function edit(SeoPage $seoPage)
    {
        return view('admin.seo.form', ['page' => $seoPage]);
    }

    public function update(Request $r, SeoPage $seoPage)
    {
        $v = $r->validate([
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords'    => ['nullable', 'string', 'max:500'],
            'canonical'        => ['nullable', 'url', 'max:255'],
            'og_image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
        $v['noindex'] = $r->boolean('noindex');
        unset($v['og_image']);
        if ($r->boolean('remove_og_image')) { Uploader::delete($seoPage->og_image); $v['og_image'] = null; }
        if ($r->hasFile('og_image')) $v['og_image'] = Uploader::store($r->file('og_image'), 'seo', $seoPage->og_image);

        $seoPage->update($v);

        return redirect()->route('admin.seo.index')->with('ok', 'SEO for "' . $seoPage->label . '" saved.');
    }

    public function settings(Request $r)
    {
        $v = $r->validate([
            'site_name'           => ['required', 'string', 'max:120'],
            'title_suffix'        => ['nullable', 'string', 'max:120'],
            'default_description' => ['nullable', 'string', 'max:500'],
            'default_keywords'    => ['nullable', 'string', 'max:500'],
            'google_verification' => ['nullable', 'string', 'max:120', 'regex:/^[A-Za-z0-9_\-]+$/'],
            'bing_verification'   => ['nullable', 'string', 'max:120', 'regex:/^[A-Za-z0-9_\-]+$/'],
            'ga4_id'              => ['nullable', 'string', 'max:30', 'regex:/^G-[A-Z0-9]+$/'],
            'default_og_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'google_verification.regex' => 'Paste only the content="…" code from Google Search Console.',
            'ga4_id.regex'              => 'GA4 Measurement ID looks like G-XXXXXXX.',
        ]);

        if ($r->hasFile('default_og_image')) {
            $v['default_og_image'] = Uploader::store($r->file('default_og_image'), 'seo', Setting::get('default_og_image'));
        } else {
            unset($v['default_og_image']);
        }
        Setting::put($v);

        return back()->with('ok', 'Global SEO settings saved.');
    }
}
