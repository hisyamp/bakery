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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/apilogin', [App\Http\Controllers\API\auth\AuthController::class,'login']);
Route::middleware('jwt.auth')->group(function() {
    Route::get('/apitoskd2/{ju}', [App\Http\Controllers\API\SKD\API_SkdController::class,'getSoalTryout']);
    Route::get('/apitoskd/{ju}', [App\Http\Controllers\API\SKD\API_SkdController::class,'detailPaket']);
    Route::get('/apilatsoal/{ju}', [App\Http\Controllers\API\SKD\API_SkdController::class,'apiLatRandSkd']);
    Route::get('/allskd', [App\Http\Controllers\API\SKD\API_SkdController::class,'allskd']);
    Route::get('/getpaket/{ju}/{js}', [App\Http\Controllers\API\SKD\API_SkdController::class,'getpaket']);
    Route::get('/detaildatapaket/{id}', [App\Http\Controllers\API\SKD\API_SkdController::class,'detailDataPaket']);
});


