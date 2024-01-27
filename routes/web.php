<?php

use App\Http\Controllers\AdvertisingSectionController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\StadiumController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

//Route::controller(SampleController::class)->group(function(){
//
//    Route::get('login', 'index')->name('login');
//
//    Route::get('registration', 'registration')->name('registration');
//
//    Route::get('logout', 'logout')->name('logout');
//
//    Route::post('validate_registration', 'validate_registration')->name('sample.validate_registration');
//
//    Route::post('validate_login', 'validate_login')->name('sample.validate_login');
//
//    Route::get('dashboard', 'dashboard')->name('dashboard');
//
//});

// Routes for guest users
Route::middleware('guest')->group(function () {
    Route::get('login', [SampleController::class, 'index'])->name('login');
    Route::get('registration', [SampleController::class, 'registration'])->name('registration');
    Route::post('validate_registration', [SampleController::class, 'validate_registration'])->name('sample.validate_registration');
    Route::post('validate_login', [SampleController::class, 'validate_login'])->name('sample.validate_login');
});

// Routes for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('logout', [SampleController::class, 'logout'])->name('logout');
    Route::get('dashboard', [SampleController::class, 'dashboard'])->name('dashboard');

    Route::resource('stadiums', StadiumController::class);
    Route::resource('advertising-sections', AdvertisingSectionController::class);
    Route::patch('/advertising-sections/{id}/update-status', [AdvertisingSectionController::class, 'updateStatus'])->name('advertising-sections.update-status');


});



