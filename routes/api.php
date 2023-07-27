<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('/santri', App\Http\Controllers\Api\SantriController::class);
Route::apiResource('/divisi', App\Http\Controllers\Api\DivisiController::class);
Route::apiResource('/kamar', App\Http\Controllers\Api\KamarController::class);
// Route::group(['middleware' => 'auth'], function() {
//     Route::resource('santri', 'SantriController');
//   });
Route::post('/register',App\Http\Controllers\Api\RegisterController::class)->name('register');
Route::post('/login',App\Http\Controllers\Api\LoginController::class)->name('login');
Route::post('/logout',App\Http\Controllers\Api\LogoutController::class)->name('logout');
Route::put('/update',App\Http\Controllers\Api\UpdateController::class)->name('update');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

