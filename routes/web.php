<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PassengerController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/login',[AdminController::class,'login']);
Route::post('/login',[AdminController::class,'loggedin']);

Route::group(['middleware' => 'admin.auth'], function() {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('/logout',[AdminController::class,'logout']);

    Route::get('/dashboard/admins',[AdminController::class,'index']);
    Route::get('/dashboard/admins/register',[AdminController::class,'register']);
    Route::post('/dashboard/admins/register',[AdminController::class,'store']);
    Route::get('/dashboard/admins/{id}',[AdminController::class,'show']);
    Route::put('/dashboard/admins/{id}',[AdminController::class,'update']);
    Route::get('/dashboard/admins/{id}/newpassword',[AdminController::class,'showPassword']);
    Route::put('/dashboard/admins/{id}/newpassword',[AdminController::class,'updatePassword']);

    Route::get('/dashboard/passengers',[PassengerController::class,'index']);
    Route::get('/dashboard/passengers/register',[PassengerController::class,'new']);
    Route::post('/dashboard/passengers/register',[PassengerController::class,'store']);
    Route::get('/dashboard/passengers/{id}/view',[PassengerController::class,'view']);

    Route::get('/dashboard/drivers', [DriverController::class,'index']);
    Route::get('/dashboard/drivers/register', [DriverController::class,'register']);
    Route::post('/dashboard/drivers/register', [DriverController::class,'store']);
    Route::delete('/dashboard/drivers/{id}', [DriverController::class,'destroy']);
    Route::get('/dashboard/drivers/{id}', [DriverController::class,'show']);
    Route::put('/dashboard/drivers/{id}', [DriverController::class,'update']);
    Route::get('/dashboard/drivers/{id}/view', [DriverController::class,'view']);

    Route::get('/dashboard/schedules', [ScheduleController::class,'index']);
    Route::get('/dashboard/schedules/new', [ScheduleController::class,'new']);
    Route::post('/dashboard/schedules/new', [ScheduleController::class,'store']);
    Route::get('/dashboard/schedules/{id}', [ScheduleController::class,'show']);
    Route::put('/dashboard/schedules/{id}', [ScheduleController::class,'update']);
    Route::delete('/dashboard/schedules/{id}', [ScheduleController::class,'destroy']);

    Route::post('/dashboard/slots', [SlotController::class,'store']);
    Route::delete('/dashboard/slots/{id}', [SlotController::class,'destroy']);

    Route::get('/dashboard/discounts', [CardController::class,'index']);
    Route::get('/dashboard/discounts/new', [CardController::class,'new']);
    Route::post('/dashboard/discounts/new', [CardController::class,'store']);
    Route::get('/dashboard/discounts/{id}', [CardController::class,'show']);
    Route::put('/dashboard/discounts/{id}', [CardController::class,'update']);
    Route::delete('/dashboard/discounts/{id}', [CardController::class,'destroy']);

    Route::get('/dashboard/passengers/{id}/discounts',[DiscountController::class,'view']);
    Route::post('/dashboard/passengers/discounts',[DiscountController::class,'store']);
    Route::post('/dashboard/passengers/discounts/status',[DiscountController::class,'status']);

    Route::get('/dashboard/passengers/{id}/topup',[TopupController::class,'topup']);
    Route::post('/dashboard/passengers/topup',[TopupController::class,'store']);
});
