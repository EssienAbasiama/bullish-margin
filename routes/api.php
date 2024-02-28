<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\LoginController;

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

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/verify-email', 'Auth\VerificationController@verifyEmail')->name('verify-email');
Route::post('update-password', [PasswordResetController::class, 'updatePassword']);
Route::put('/update-password-by-email', [PasswordResetController::class, 'updatePasswordByEmail']);
Route::post('/login', [LoginController::class, 'login']);
// routes/api.php


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
