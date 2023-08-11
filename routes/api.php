<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\WithdrawalController;
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



Route::group(['middleware' => ['web']], function () {
    Route::prefix('auth')->group(function () {
        Route::get('/google', [AuthController::class, 'redirectToGoogle']);
        Route::get('/google/callback', [AuthController::class, 'handleGoogleCallback']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('bank')->group(function () {
    Route::post('/',[BankController::class, 'add'])->middleware(['jwt', 'admin']);
    Route::get('/',[BankController::class, 'index'])->middleware(['jwt', 'admin']);
    Route::get('/{bank_id}',[BankController::class, 'show'])->middleware(['jwt', 'admin']);
    Route::put('/{bank_id}',[BankController::class, 'update'])->middleware(['jwt', 'admin']);
    Route::patch('/{bank_id}',[BankController::class, 'destroy'])->middleware(['jwt', 'admin']);
});

Route::prefix('bank_account')->group(function () {
    Route::post('/',[BankAccountController::class, 'add'])->middleware(['jwt']);
    Route::get('/',[BankAccountController::class, 'index'])->middleware(['jwt', 'admin']);
    Route::get('/my_bank_accounts',[BankAccountController::class, 'userIndex'])->middleware(['jwt']);
    Route::get('/{bank_account_id}',[BankAccountController::class, 'show'])->middleware(['jwt']);
    Route::put('/{bank_account_id}',[BankAccountController::class, 'update'])->middleware(['jwt']);
    Route::patch('/{bank_account_id}',[BankAccountController::class, 'destroy'])->middleware(['jwt']);
});

Route::prefix('credit_card')->group(function () {
    Route::post('/',[CreditCardController::class, 'add'])->middleware(['jwt']);
    Route::get('/',[CreditCardController::class, 'index'])->middleware(['jwt', 'admin']);
    Route::get('/my_credit_cards',[CreditCardController::class, 'userIndex'])->middleware(['jwt']);
    Route::get('/{credit_card_id}',[CreditCardController::class, 'show'])->middleware(['jwt']);
    Route::put('/{credit_card_id}',[CreditCardController::class, 'update'])->middleware(['jwt']);
    Route::patch('/{credit_card_id}',[CreditCardController::class, 'destroy'])->middleware(['jwt']);
});

Route::prefix('download')->middleware('jwt')->group(function () {
    Route::get('/qrcode/{transactionId}',[DownloadController::class, 'downloadQrCode'])->middleware(['jwt']);
});

Route::prefix('event')->group(function () {
    Route::get('/',[EventController::class, 'index']);
    Route::get('/my_events',[EventController::class, 'userIndex'])->middleware(['jwt']);
    Route::get('/my_sell_events',[EventController::class, 'sellEvent'])->middleware(['jwt']);
    Route::get('/my_return_events',[EventController::class, 'returnEvent'])->middleware(['jwt']);
    Route::get('/{eventId}',[EventController::class, 'show']);
    Route::post('/',[EventController::class, 'store'])->middleware(['jwt','admin-promoter']);
    Route::put('/{eventId}',[EventController::class, 'update'])->middleware(['jwt','admin-promoter']);
    Route::patch('/{eventId}',[EventController::class, 'destroy'])->middleware(['jwt', 'admin-promoter']);
});

Route::prefix('transaction')->middleware('jwt')->group(function () {
    Route::get('/',[TransactionController::class, 'index'])->middleware(['jwt', 'admin']);
    Route::get('/my_transactions',[TransactionController::class, 'userIndex'])->middleware(['jwt']);
    Route::get('/{transactionId}',[TransactionController::class, 'show'])->middleware(['jwt']);
    Route::post('/{transactionId}/pay',[TransactionController::class, 'payTransaction'])->middleware(['jwt']);
    Route::post('/{transactionId}/return',[TransactionController::class, 'returnTransaction'])->middleware(['jwt']);
    Route::post('/',[TransactionController::class, 'store'])->middleware(['jwt']);
});

Route::prefix('user_type')->group(function () {
    Route::post('/',[UserTypeController::class, 'add', 'admin']);
    Route::get('/',[UserTypeController::class, 'index', 'admin']);
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
    Route::get('/',[UserController::class, 'index'])->middleware('jwt','admin');
    Route::get('/{userId}',[UserController::class, 'show'])->middleware(['jwt','admin']);
    Route::put('/{userId}',[UserController::class, 'update'])->middleware(['jwt','admin']);
    Route::patch('/{userId}',[UserController::class, 'destroy'])->middleware(['jwt','admin']);
});

Route::prefix('upload')->middleware('jwt')->group(function () {
    Route::post('/event',[UploadController::class, 'uploadEventImage'])->middleware(['jwt', 'admin-promoter']);
});

Route::prefix('withdrawal')->group(function () {
    Route::post('/',[WithdrawalController::class, 'add'])->middleware(['jwt']);
    Route::get('/',[WithdrawalController::class, 'index'])->middleware(['jwt', 'admin']);
    Route::get('/my_withdrawals',[WithdrawalController::class, 'userIndex'])->middleware(['jwt']);
    Route::get('/{withdrawal_id}',[WithdrawalController::class, 'show'])->middleware(['jwt']);
    Route::put('/{withdrawal_id}',[WithdrawalController::class, 'update'])->middleware(['jwt']);
    Route::patch('/{withdrawal_id}',[WithdrawalController::class, 'destroy'])->middleware(['jwt']);
});
