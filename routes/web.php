<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes – ANP Nursing Home (static pages)
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/departments', [PageController::class, 'departments'])->name('departments');
Route::get('/facilities', [PageController::class, 'facilities'])->name('facilities');
Route::get('/master-health-checkup', [PageController::class, 'healthCheckup'])->name('health-checkup');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
