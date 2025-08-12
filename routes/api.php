<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AppointmentController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\LocationController;
use App\Http\Controllers\Api\v1\ProviderController;
use App\Http\Controllers\Api\v1\PatientController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

$middleware = ['api'];
if (\Request::header('Authorization')) {
    $middleware = array_merge(['auth:api']);
    Route::group(['prefix' => 'v1', 'middleware' => $middleware], function () {
        Route::post('/appointment' , [ AppointmentController::class, 'appointment']);
    });
} else {
    Route::prefix( 'v1' )->group( function () {
        Route::post('/appointment' , [ AppointmentController::class, 'appointment']);
    });
}

Route::middleware('auth:api')->prefix( 'v1' )->group( function () {
    Route::prefix( '/patient' )->group( function () {
        Route::post('/dashboard' , [ PatientController::class, 'dashboard']);
        Route::post('/profile' , [ PatientController::class, 'profile']);
        Route::post('/change-password' , [ PatientController::class, 'changePassword']);
        Route::post('/profile-edit' , [ PatientController::class, 'profileEdit']);
    });

    Route::prefix( '/appointment' )->group( function () {
        Route::post('/change' , [ AppointmentController::class, 'changeAppointment']);
    });

    Route::prefix( '/auth' )->group( function () {
        Route::post('/logout' , [ AuthController::class, 'logout']);
    });
});


Route::prefix( 'v1' )->group( function () {
    Route::prefix( '/company' )->group( function () {
        Route::post('/key' , [ AuthController::class, 'key']);
    });

    Route::prefix( '/location' )->group( function () {
        Route::post('/all' , [ LocationController::class, 'all']);
    });

    Route::prefix( '/provider' )->group( function () {
        Route::post('/profile' , [ ProviderController::class, 'profile']);
        Route::post('/all' , [ ProviderController::class, 'all']);
        Route::post('/by-location' , [ ProviderController::class, 'byLocation']);
        Route::post('/weekly-available-slots' , [ ProviderController::class, 'weeklyAvailableSlots']);
        Route::post('/available-slot-by-date' , [ ProviderController::class, 'availableSlotByDate']);
    });

    Route::prefix( '/auth' )->group( function () {
        Route::post('/login' , [ AuthController::class, 'login']);
        Route::post('/signup' , [ AuthController::class, 'signup']);
        Route::post('/forgot-password' , [ AuthController::class, 'forgotPassword']);
    });

    //Route::post('/appointment' , [ AppointmentController::class, 'appointment']);
    //Route::post('/appointment/change' , [ AppointmentController::class, 'changeAppointment']);
    // Route::post('/patient/dashboard' , [ PatientController::class, 'dashboard']);
    // Route::post('/patient/profile' , [ PatientController::class, 'profile']);
    // Route::post('/patient/change-password' , [ PatientController::class, 'changePassword']);
   //Route::post('/patient/profile-edit' , [ PatientController::class, 'profileEdit']);
});