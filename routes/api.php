<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
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

Route::prefix('user_type')->group(function () {
    Route::post('/',[UserTypeController::class, 'add', 'admin']);
    Route::get('/{type_id}',[UserTypeController::class, 'show', 'admin']);
    Route::put('/{type_id}',[UserTypeController::class, 'update', 'admin']);
    Route::patch('/{type_id}',[UserTypeController::class, 'destroy', 'admin']);
});

Route::prefix('user')->group(function () {
    Route::post('/',[UserController::class, 'register']);
    Route::post('/login',[UserController::class, 'login']);
    Route::get('/profile',[UserController::class, 'profile'])->middleware('jwt');
    Route::put('/profile',[UserController::class, 'updateProfile'])->middleware('jwt');
    Route::post('/logout',[UserController::class, 'logout'])->middleware('jwt');
    Route::get('/',[UserController::class, 'index'])->middleware('jwt');
    Route::get('/{userId}',[UserController::class, 'show'])->middleware(['jwt','admin']);
    Route::put('/{userId}',[UserController::class, 'update'])->middleware(['jwt','admin']);
    Route::patch('/{userId}',[UserController::class, 'destroy'])->middleware(['jwt','admin']);
});

Route::prefix('transaction')->middleware('jwt')->group(function () {
    Route::get('/',[TransactionController::class, 'index'])->middleware(['jwt']);
    Route::get('/{transactionId}',[TransactionController::class, 'show'])->middleware(['jwt']);
    Route::post('/{transactionId}/paid',[TransactionController::class, 'paidTransaction'])->middleware(['jwt']);
    Route::post('/',[TransactionController::class, 'store'])->middleware(['jwt']);
    });

Route::prefix('event')->group(function () {
    Route::get('/',[EventController::class, 'index']);
    Route::get('/{eventId}',[EventController::class, 'show']);
    Route::post('/',[EventController::class, 'store'])->middleware(['jwt','admin-organizer']);
    Route::put('/{eventId}',[EventController::class, 'update'])->middleware(['jwt','admin-organizer']);
    Route::patch('/{eventId}',[EventController::class, 'destroy'])->middleware(['jwt', 'admin-organizer']);
});
