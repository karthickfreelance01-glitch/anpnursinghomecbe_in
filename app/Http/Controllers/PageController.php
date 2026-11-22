<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function departments()
    {
        return view('pages.departments');
    }

    public function facilities()
    {
        return view('pages.facilities');
    }

    public function healthCheckup()
    {
        return view('pages.health-checkup');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
