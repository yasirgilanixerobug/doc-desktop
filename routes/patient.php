<?php

use App\Http\Controllers\Patient\AppointmentController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\ProfileController;
use App\Http\Controllers\InsuranceDocDownload;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard/{type?}', [PatientController::class, 'dashboard'])->name('dashboard')->defaults('type', "upcoming");
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('changePassword');
Route::get('/clinics', [PatientController::class, 'clinics'])->name('clinics');
Route::get('/allPractices', [PatientController::class, 'allPractices'])->name('allPractices');
Route::get('/providers', [PatientController::class, 'providers'])->name('providers');
Route::get('/appointments/{appointment_type?}', [PatientController::class, 'appointments'])->name('appointments');

//single action controller insurance download
Route::get('ins-download/', InsuranceDocDownload::class)->name('insDownload');

//Route::get('/change-appointment/{appointment_id}', [AppointmentController::class, 'edit'])->name('appointmentEdit');
//Route::post('/change-appointment/{appointment_id}', [AppointmentController::class, 'changeAppointment'])->name('changeAppointment');
