<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Support\Seo;

class PageController extends Controller
{
    public function home()
    {
        $banners = collect();
        try { $banners = Banner::active()->ordered()->get(); } catch (\Throwable $e) {}

        $slides = $banners->isNotEmpty()
            ? $banners->map(fn ($b) => ['src' => $b->image_url, 'mobile' => $b->mobile_url, 'alt' => $b->alt ?: $b->title, 'link' => $b->link])
            : collect(config('anp.hero_slides'))->map(fn ($s) => ['src' => asset('assets/img/hero/' . $s['img']), 'mobile' => null, 'alt' => $s['alt'], 'link' => null]);

        return view('pages.home', [
            'slides'  => $slides->values(),
            'seo'     => Seo::page('home'),
        ]);
    }

    public function about()
    {
        return view('pages.about', ['seo' => Seo::page('about', ['title' => 'About Us'], ['About Us' => route('about')])]);
    }

    public function facilities()
    {
        return view('pages.facilities', ['seo' => Seo::page('facilities', ['title' => 'Facilities'], ['Facilities' => route('facilities')])]);
    }

    public function healthCheckup()
    {
        return view('pages.health-checkup', ['seo' => Seo::page('health-checkup', ['title' => 'Master Health Checkup'], ['Master Health Checkup' => route('health-checkup')])]);
    }

    public function contact()
    {
        return view('pages.contact', ['seo' => Seo::page('contact', ['title' => 'Contact Us'], ['Contact Us' => route('contact')])]);
    }
}
