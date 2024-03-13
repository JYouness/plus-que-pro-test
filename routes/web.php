<?php

use App\Http\Controllers\Dashboard\MovieGenresController;
use App\Http\Controllers\Dashboard\MoviesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

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

// Public Routes
Route::get('/', [PagesController::class, 'index'])->name('home');
Route::get('/movies/{movie}', [PagesController::class, 'showMovie'])->name('public.movies.show');

// Dashboard Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('movies')->name('dashboard.movies.')->controller(MoviesController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{movie}', 'show')->name('show');
        Route::get('/{movie}/edit', 'edit')->name('edit');
        Route::put('/{movie}/update', 'update')->name('update');
        Route::delete('/{movie}', 'destroy')->name('delete');
    });

    Route::prefix('movie-genres')->name('dashboard.movie-genres.')->controller(MovieGenresController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});
