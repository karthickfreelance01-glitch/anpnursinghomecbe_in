<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Speciality;
use App\Support\Seo;

class LandingController extends Controller
{
    /** All departments + both speciality groups. */
    public function departments()
    {
        return view('pages.departments', [
            'seo' => Seo::page('departments', ['title' => 'Departments'], ['Departments' => route('departments')]),
        ]);
    }

    /** Landing page for one department. */
    public function department(string $slug)
    {
        $item = Department::active()->where('slug', $slug)->firstOrFail();

        return view('pages.landing', [
            'item'    => $item,
            'kind'    => 'Department',
            'parent'  => ['Departments', route('departments')],
            'related' => Department::active()->ordered()->where('id', '!=', $item->id)->get(),
            'seo'     => Seo::landing($item, ['Departments' => route('departments'), $item->name => null]),
        ]);
    }

    /** Medical or surgical speciality listing. */
    public function category(string $category)
    {
        $label = Speciality::CATEGORIES[$category];

        return view('pages.specialities', [
            'category' => $category,
            'label'    => $label,
            'items'    => Speciality::active()->category($category)->ordered()->get(),
            'seo'      => Seo::page('specialities.' . $category, ['title' => $label], [$label => null]),
        ]);
    }

    /** Landing page for one medical / surgical speciality. */
    public function speciality(string $slug)
    {
        $item = Speciality::active()->where('slug', $slug)->firstOrFail();
        $catUrl = route('specialities.category', $item->category);

        return view('pages.landing', [
            'item'    => $item,
            'kind'    => $item->category_label,
            'parent'  => [$item->category_label, $catUrl],
            'related' => Speciality::active()->category($item->category)->ordered()->where('id', '!=', $item->id)->get(),
            'seo'     => Seo::landing($item, [$item->category_label => $catUrl, $item->name => null]),
        ]);
    }
}
