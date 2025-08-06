<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Clinic\FrontendController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\ReviewFollowUpController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

// Route::get('/', function () {

//     $requestHost = request()->getHttpHost();
    
//     if($requestHost === '127.0.0.1:8000' ||
//         $requestHost === 'doc.fivedocs.com')
//     {
//         return view('welcome');
//     } else {
//         $splitDomain = explode(".", $requestHost);
//         return redirect()->action([FrontendController::class, 'home'], [
//             'subdomain' => $splitDomain[0],
//             'lang' => 'en'
//         ]);
//     }

// })->name('welcome');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

//AUTH
Route::group(['middleware' => ['guest']], function() {

    //SOCIAL LOGIN
    Route::get('/login/{social}', [AuthController::class, 'socialLogin'])->where('social','facebook|google|apple');
    Route::get('/login/{social}/callback', [AuthController::class, 'handleProviderCallback'])->where('social','facebook|google|apple');

    //Clinic
    Route::group(['as' => 'auth.', 'prefix' => 'clinic'], function () {
        //Clinic LOGIN
        Route::get('/login', [AuthController::class, 'loginForm'])->name('clinicLoginForm');
        Route::post('/login', [AuthController::class, 'login'])->name('clinicLogin');

        //Clinic REGISTER
        Route::get('/registration/blocked-yes-it-is/{name?}/{email?}', [AuthController::class, 'clinicRegisterForm'])->name('clinicRegisterForm');
        Route::post('/registration/blocked-yes-it-is', [AuthController::class, 'clinicRegister'])->name('clinicRegister');

        //Patient LOGIN
        Route::get('/patient-login', [AuthController::class, 'loginForm'])->name('patientLoginForm');
        Route::post('/patient-login', [AuthController::class, 'login'])->name('patientLogin');

        //Patient REGISTER
        Route::get('/patient-registration', [AuthController::class, 'patientRegisterForm'])->name('patientRegisterForm');
        Route::post('/patient-registration', [AuthController::class, 'patientRegister'])->name('patientRegister');
    });

    Route::get('/forgot-password', [ForgotController::class, 'passwordRequest'])->name('password.request');
    Route::post('/send-reset-link', [ForgotController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password-form/{token}', [ForgotController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotController::class, 'resetPassword'])->name('password.update');
});

Route::group(['as' => 'reviewFollowUp.', 'prefix' => 'review-follow-up'], function () {
    Route::get('/{slug}', [ReviewFollowUpController::class, 'checkForm'])->name('checkForm');
});

Route::group(['as' => 'contactUs.', 'prefix' => 'contact-us'], function () {
    Route::get('/form', [ContactController::class, 'form'])->name('form');
    Route::post('/form', [ContactController::class, 'store'])->name('store');
    Route::get('/thank-you', [ContactController::class, 'thankYou'])->name('thankYou');
});

//Route for privacy-policy
Route::view('/privacy-policy', 'privacy-policy')->name('privacyPolicy');

//Route for change-log
Route::view('/change-log', 'change-log')->name('changeLog');

//Route for terms-and-conditions
Route::view('/terms-and-conditions', 'terms-and-conditions')->name('termsAndConditions');

Route::get('clear', function () {
    Artisan::call('migrate:fresh');
});
