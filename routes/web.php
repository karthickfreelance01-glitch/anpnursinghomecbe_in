<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website – ANP Nursing Home
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/facilities', [PageController::class, 'facilities'])->name('facilities');
Route::get('/master-health-checkup', [PageController::class, 'healthCheckup'])->name('health-checkup');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Departments + landing pages
Route::get('/departments', [LandingController::class, 'departments'])->name('departments');
Route::get('/departments/{slug}', [LandingController::class, 'department'])->name('departments.show');

// Medical / Surgical specialities + landing pages
Route::get('/specialities/{category}', [LandingController::class, 'category'])
    ->whereIn('category', ['medical', 'surgical'])->name('specialities.category');
Route::get('/speciality/{slug}', [LandingController::class, 'speciality'])->name('specialities.show');

// Enquiry / appointment form
Route::post('/enquiry', [EnquiryController::class, 'store'])->middleware('throttle:8,1')->name('enquiry.store');

// SEO
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots']);

/*
|--------------------------------------------------------------------------
| Admin panel
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [Admin\AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.submit');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('departments', Admin\DepartmentController::class)->except('show');
        Route::resource('specialities', Admin\SpecialityController::class)->except('show');
        Route::put('banners-hero', [Admin\BannerController::class, 'hero'])->name('banners.hero');
        Route::resource('banners', Admin\BannerController::class)->except('show');

        Route::get('enquiries/export', [Admin\EnquiryController::class, 'export'])->name('enquiries.export');
        Route::resource('enquiries', Admin\EnquiryController::class)->only(['index', 'show', 'update', 'destroy']);

        Route::get('seo', [Admin\SeoController::class, 'index'])->name('seo.index');
        Route::get('seo/{seoPage}/edit', [Admin\SeoController::class, 'edit'])->name('seo.edit');
        Route::put('seo/{seoPage}', [Admin\SeoController::class, 'update'])->name('seo.update');
        Route::put('seo-settings', [Admin\SeoController::class, 'settings'])->name('seo.settings');

        Route::get('account', [Admin\AuthController::class, 'account'])->name('account');
        Route::put('account', [Admin\AuthController::class, 'updateAccount'])->name('account.update');
    });
});

// Laravel's auth middleware redirects guests to the route named "login"
Route::redirect('/login', '/admin/login')->name('login');
