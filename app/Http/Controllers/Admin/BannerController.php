<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Setting;
use App\Support\Uploader;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        return view('admin.banners.index', ['banners' => Banner::ordered()->get(), 'settings' => Setting::all_()]);
    }

    public function create()
    {
        return view('admin.banners.form', ['banner' => new Banner(['is_active' => true, 'sort_order' => Banner::max('sort_order') + 1])]);
    }

    public function store(Request $r)
    {
        Banner::create($this->data($r, null));

        return redirect()->route('admin.banners.index')->with('ok', 'Banner added to the home page slider.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.form', compact('banner'));
    }

    public function update(Request $r, Banner $banner)
    {
        $banner->update($this->data($r, $banner));

        return redirect()->route('admin.banners.index')->with('ok', 'Banner saved.');
    }

    public function destroy(Banner $banner)
    {
        Uploader::delete($banner->image);
        Uploader::delete($banner->mobile_image);
        $banner->delete();

        return back()->with('ok', 'Banner deleted.');
    }

    /** Home page hero: headline text + background photo. */
    public function hero(Request $r)
    {
        $v = $r->validate([
            'hero_eyebrow'   => ['nullable', 'string', 'max:120'],
            'hero_title'     => ['nullable', 'string', 'max:120'],
            'hero_highlight' => ['nullable', 'string', 'max:120'],
            'hero_tamil'     => ['nullable', 'string', 'max:250'],
            'hero_text'      => ['nullable', 'string', 'max:500'],
            'hero_image'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
        ]);
        unset($v['hero_image']);
        if ($r->hasFile('hero_image')) {
            $v['hero_image'] = Uploader::store($r->file('hero_image'), 'hero', Setting::get('hero_image'));
        }
        if ($r->boolean('remove_hero_image')) {
            Uploader::delete(Setting::get('hero_image'));
            $v['hero_image'] = null;
        }
        Setting::put($v);

        return back()->with('ok', 'Home page hero updated.');
    }

    private function data(Request $r, ?Banner $b): array
    {
        $v = $r->validate([
            'title'        => ['nullable', 'string', 'max:200'],
            'alt'          => ['nullable', 'string', 'max:200'],
            'link'         => ['nullable', 'string', 'max:255'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
            'image'        => [$b ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'mobile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $data = [
            'title'      => $v['title'] ?? null,
            'alt'        => $v['alt'] ?? $v['title'] ?? null,
            'link'       => $v['link'] ?? null,
            'sort_order' => (int) ($v['sort_order'] ?? 0),
            'is_active'  => $r->boolean('is_active'),
        ];
        if ($r->hasFile('image')) $data['image'] = Uploader::store($r->file('image'), 'banners', $b?->image);
        if ($r->boolean('remove_mobile_image')) { Uploader::delete($b?->mobile_image); $data['mobile_image'] = null; }
        if ($r->hasFile('mobile_image')) $data['mobile_image'] = Uploader::store($r->file('mobile_image'), 'banners', $b?->mobile_image);

        return $data;
    }
}
