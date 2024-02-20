<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\api\DashboardController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\Payment\StripeController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
  return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
  Route::post('/newsapi', [NewsApiController::class, 'index']);

  Route::resource('news', NewsController::class)->except(['create', 'edit']);

  Route::resource('category', CategoryController::class)->only(['index']);
});

Route::get('/payment_intent', [StripeController::class, 'listAllIntents']);
Route::post('/payment_intent', [StripeController::class, 'createIntent']);
Route::post('/payment_intent/retrieve', [StripeController::class, 'retrieveIntent']);
Route::post('/payment_intent/confirm', [StripeController::class, 'confirmIntent']);
Route::post('/payment_intent/cancel', [StripeController::class, 'cancelIntent']);
