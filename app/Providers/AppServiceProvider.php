<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Department;
use App\Models\Enquiry;
use App\Models\Speciality;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Clear the cached menu whenever admin content changes
        foreach ([Department::class, Speciality::class, Banner::class] as $model) {
            $model::saved(fn () => Cache::forget('anp.nav'));
            $model::deleted(fn () => Cache::forget('anp.nav'));
        }

        // Menu / footer / appointment dropdown data for every public page
        View::composer(['layouts.app', 'partials.*', 'pages.*'], function ($view) {
            static $nav = null;
            $nav ??= static::navData();
            $view->with($nav);
        });

        View::composer('admin.*', function ($view) {
            static $newCount = null;
            try { $newCount ??= Enquiry::where('status', 'new')->count(); } catch (\Throwable $e) { $newCount = 0; }
            $view->with('newEnquiries', $newCount);
        });
    }

    public static function navData(): array
    {
        $empty = ['navDepartments' => collect(), 'medicalList' => collect(), 'surgicalList' => collect()];

        try {
            if (! Schema::hasTable('departments')) return $empty;

            return Cache::remember('anp.nav', 3600, fn () => [
                'navDepartments' => Department::active()->ordered()->get(['id', 'name', 'slug', 'icon', 'show_in_menu', 'image', 'short_description']),
                'medicalList'    => Speciality::active()->category('medical')->ordered()->get(['id', 'name', 'slug', 'icon', 'image', 'category', 'short_description']),
                'surgicalList'   => Speciality::active()->category('surgical')->ordered()->get(['id', 'name', 'slug', 'icon', 'image', 'category', 'short_description']),
            ]);
        } catch (\Throwable $e) {
            return $empty;
        }
    }
}
