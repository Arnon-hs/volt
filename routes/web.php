<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function (){

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('/nfc', [\App\Http\Controllers\NFCController::class, 'index'])->name('nfc_cards.index');

    Route::get('/clients', [\App\Http\Controllers\ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/{id}', [\App\Http\Controllers\ClientController::class, 'show'])->name('clients.show');

});