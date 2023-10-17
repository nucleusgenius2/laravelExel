<?php

use App\Http\Controllers\ExelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [UserController::class, 'loginUser']);
Route::post('registration', [UserController::class, 'registrationUser'])->name('registration');

//user api
Route::middleware(['auth:sanctum', 'user_active'])->group(function () {

    Route::get('/authorization', [UserController::class, 'checkStatusUser']);
    Route::get('/logout', [UserController::class, 'logoutUser']);

    Route::get('/exel', [ExelController::class, 'get']);
    Route::post('/exel', [ExelController::class, 'upload']);

    Route::get('/profile', [ProfileController::class, 'profileInfo']);
    Route::patch('/profile', [ProfileController::class, 'profileUpdate']);
});
