<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\LoginAPIController;
use App\Http\Controllers\API\DriverAPIController;
use App\Http\Controllers\API\TripAPIController;
use App\Http\Controllers\API\PassengerTripAPIController;
use App\Http\Controllers\API\PassengerAPIController;

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
Route::post('/register',[PassengerAPIController::class,'register']);

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/available',[TripAPIController::class,'available']);

    Route::post('/logout',[LoginAPIController::class,'logout']);

    /* test api access token if still valid */
    Route::get('/testtoken',[LoginAPIController::class,'testtoken']);

    /* Get schedules slots of driver by id */
    Route::get('/schedules/{id}',[DriverAPIController::class,'schedules']);

    /* Generate trip */
    Route::post('/trips',[TripAPIController::class,'store']);
    Route::get('/trips/{id}',[TripAPIController::class,'show']);
    Route::put('/trips/{id}/drop',[TripAPIController::class,'drop']);
    Route::put('/trips/{id}/cancel',[TripAPIController::class,'cancel']);

    Route::get('/trips/{id}/active',[TripAPIController::class,'active']);
    Route::post('/trips/{id}/end',[TripAPIController::class,'end']); //driver_id
    Route::post('/trips/{id}/drive',[TripAPIController::class,'drive']); //driver_id

    Route::get('/checkin/{passenger_id}/info/{trip_id}',[PassengerTripAPIController::class,'checkinInfo']);
    Route::get('/checkin/{trip_id}/validation',[PassengerTripAPIController::class,'validation']);
    Route::get('/active/{id}/trip',[PassengerTripAPIController::class,'activeTrip']);
    Route::post('/checkin',[PassengerTripAPIController::class,'store']);
    Route::get('/passengers/{id}',[PassengerAPIController::class,'show']);
    Route::put('/passengers/{id}',[PassengerAPIController::class,'update']);

    Route::get('/balance/{id}',[PassengerAPIController::class,'balance']);

    Route::put('/changepassword',[LoginAPIController::class,'changePassword']);

});
