<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapeController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\TestController;
use App\Models\Job;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/scrape', [ScrapeController::class, 'scrape']);

Route::get('/scrapeWorkUa/{position}/{category_id}', [ScrapeController::class, 'scrapeWorkUaPages']);

Route::get('/vacancies/send', [VacancyController::class, 'send'])->name('vacancies.send');

Route::post('/follow', [PreferenceController::class, 'follow'])->middleware('auth')->name('follow');

//Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test', [App\Http\Controllers\TestController::class, 'send']);

Route::get('/vacancies/recommended', [VacancyController::class, 'recommended'])->middleware('auth')->name('vacancies.recommended');


