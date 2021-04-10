<?php

use App\Http\Controllers\AutoBidConfigController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\User\AuthController;
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

Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'items'], function () {
        Route::get('', [ItemController::class, 'index']);
    });

    Route::group(['prefix' => 'auto-bid-config'], function () {
        Route::get('', [AutoBidConfigController::class, 'show']);
        Route::post('', [AutoBidConfigController::class, 'save']);
        Route::delete('', [AutoBidConfigController::class, 'disable']);
    });
});
