<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function (){

    Route::group(['prefix' => 'client'], function () {
        Route::post('/auth', [\App\Http\Controllers\Api\v1\ClientController::class, 'auth']);
        Route::post('/stats', [\App\Http\Controllers\Api\v1\ClientController::class, 'stat']);//todo

        Route::post('/store', [\App\Http\Controllers\Api\v1\ClientController::class, 'store'])->name('api.clients.store');
        Route::put('/update', [\App\Http\Controllers\Api\v1\ClientController::class, 'update'])->name('api.clients.update');
        Route::get('/show/{id}', [\App\Http\Controllers\Api\v1\ClientController::class, 'show'])->name('api.clients.show');
        Route::delete('/delete/{id}', [\App\Http\Controllers\Api\v1\ClientController::class, 'delete'])->name('api.clients.delete');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::post('/store', [\App\Http\Controllers\Api\v1\UserController::class, 'store'])->name('api.users.store');
        Route::put('/update', [\App\Http\Controllers\Api\v1\UserController::class, 'update'])->name('api.users.update');
        Route::get('/show/{id}', [\App\Http\Controllers\Api\v1\UserController::class, 'show'])->name('api.users.show');
        Route::delete('/delete/{id}', [\App\Http\Controllers\Api\v1\UserController::class, 'delete'])->name('api.users.delete');
    });

    Route::group(['prefix' => 'nfc'], function () {
        Route::post('/store', [\App\Http\Controllers\Api\v1\NFCController::class, 'store'])->name('api.nfc_cards.store');
        Route::put('/update', [\App\Http\Controllers\Api\v1\NFCController::class, 'update'])->name('api.nfc_cards.update');
        Route::get('/show/{id}', [\App\Http\Controllers\Api\v1\NFCController::class, 'show'])->name('api.nfc_cards.show');
        Route::delete('/delete/{id}', [\App\Http\Controllers\Api\v1\NFCController::class, 'delete'])->name('api.nfc_cards.delete');
    });

});