<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\LoginAPIController;
use App\Http\Controllers\API\DriverAPIController;
use App\Http\Controllers\API\TripAPIController;
use App\Http\Controllers\API\PassengerTripAPIController;

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

Route::post('/login',[LoginAPIController::class,'login']);

Route::middleware('auth:sanctum')->group( function () {

    /* test api access token if still valid */
    Route::get('/test',[LoginAPIController::class,'test']);

    /* Get schedules slots of driver by id */
    Route::get('/schedules/{id}',[DriverAPIController::class,'schedules']);
    
    /* Generate trip */
    Route::post('/trips',[TripAPIController::class,'store']);
    Route::post('/checkin',[PassengerTripAPIController::class,'store']);
});

