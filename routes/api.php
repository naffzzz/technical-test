<?php

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
    Route::post('/',[UserTypeController::class, 'add']);
    Route::get('/{type_id}',[UserTypeController::class, 'show']);
    Route::put('/{type_id}',[UserTypeController::class, 'update']);
    Route::patch('/{type_id}',[UserTypeController::class, 'destroy']);
});

// Route::prefix('user')->group(function () {
//     Route::post('/',[UserController::class, 'register']);
//     Route::post('/login',[UserController::class, 'login']);
//     Route::get('/profile',[UserController::class, 'profile'])->middleware('jwt');
//     Route::put('/profile',[UserController::class, 'updateProfile'])->middleware('jwt');
//     Route::post('/logout',[UserController::class, 'logout'])->middleware('jwt');
//     Route::get('/',[UserController::class, 'index'])->middleware('jwt');
//     Route::get('/{userId}',[UserController::class, 'show'])->middleware(['jwt','admin']);
//     Route::put('/{userId}',[UserController::class, 'update'])->middleware(['jwt','admin']);
//     Route::patch('/{userId}',[UserController::class, 'destroy'])->middleware(['jwt','admin']);
// });

// Route::prefix('sale')->middleware('jwt')->group(function () {
//     Route::get('/',[SaleController::class, 'index']);
//     Route::get('/{saleId}',[SaleController::class, 'show']);
//     Route::post('/{transportationId}',[SaleController::class, 'store']);
//     Route::put('/{saleId}',[SaleController::class, 'update']);
//     Route::patch('/{saleId}',[SaleController::class, 'destroy']);
// });

// Route::prefix('transportation')->group(function () {
//     Route::get('/',[TransportationController::class, 'index']);
//     Route::get('/motorcycle',[TransportationController::class, 'indexMotorcycle']);
//     Route::get('/car',[TransportationController::class, 'indexCar']);
//     Route::get('/{transportationId}',[TransportationController::class, 'show']);
//     Route::post('/',[TransportationController::class, 'store'])->middleware('jwt');
//     Route::put('/add_stock/{transportationId}',[TransportationController::class, 'updateStock'])->middleware(['jwt', 'admin']);
//     Route::put('/{transportationId}',[TransportationController::class, 'update'])->middleware(['jwt', 'admin']);
//     Route::patch('/{transportationId}',[TransportationController::class, 'destroy'])->middleware(['jwt', 'admin']);
// });
