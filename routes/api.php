<?php

use App\Infrastructure\Controllers\CreateWalletFormRequest;
use App\Infrastructure\Controllers\GetUserController;
use App\Infrastructure\Controllers\GetWalletBalanceFormRequest;
use App\Infrastructure\Controllers\GetWalletCryptoFormRequest;
use App\Infrastructure\Controllers\IsEarlyAdopterUserController;
use App\Infrastructure\Controllers\GetStatusController;
use App\Infrastructure\Controllers\SellCoinFormRequest;
use App\Infrastructure\Controllers\CoinBuyFormRequest;
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

//prueba

Route::get('/status', GetStatusController::class);
Route::post('/coin/buy', CoinBuyFormRequest::class);
Route::post('/coin/sell', SellCoinFormRequest::class);
Route::post('/wallet/open', CreateWalletFormRequest::class);
Route::get('/wallet/{wallet_id}', GetWalletCryptoFormRequest::class);
Route::get('/wallet/{wallet_id}/balance', GetWalletBalanceFormRequest::class);
