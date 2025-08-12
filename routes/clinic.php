<?php


use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Clinic\AppointmentController;
use App\Http\Controllers\Clinic\AppointmentSettingController;
use App\Http\Controllers\Clinic\AssignLocationController;
use App\Http\Controllers\Clinic\ClinicController;
use App\Http\Controllers\Clinic\ClinicSettingController;
use App\Http\Controllers\Clinic\CustomerController;
use App\Http\Controllers\Clinic\FrontendController;
use App\Http\Controllers\Clinic\LocationAvailabilityController;
use App\Http\Controllers\Clinic\LocationBusinessHourController;
use App\Http\Controllers\Clinic\LocationController;
use App\Http\Controllers\Clinic\ProviderController;
use App\Http\Controllers\Clinic\ProviderHolidayController;
use App\Http\Controllers\Clinic\ReportingController;
use App\Http\Controllers\Clinic\ReviewRequestController;
use App\Http\Controllers\Clinic\StaffController;
use App\Http\Controllers\Clinic\ProviderListingController;
use App\Http\Controllers\InsuranceDocDownload;
use Illuminate\Support\Facades\Route;


//Clinic
    Route::middleware(['auth'])->group(function () {
        Route::group(['as' => 'clinic.', 'prefix' => 'clinic'], function() {
            // Route name will be users.comments.show
            Route::get('/activity-viewer', [ClinicController::class, 'activityViewer'])->name('activityViewer');
            Route::get('/dashboard', [ClinicController::class, 'dashboard'])->name('dashboard');
            Route::get('/calendar/{provider_id?}', [ClinicController::class, 'calendar'])->name('calendar');
            Route::get('/pending-appointment', [ClinicController::class, 'pendingAppointment'])->name('pendingAppointment');
            Route::get('/profile', [ClinicSettingController::class, 'profile'])->name('profile');
            Route::put('/change-clinic-profile/{clinic_id}', [ClinicSettingController::class, 'changeClinicProfile'])->name('changeClinicProfile');
            Route::put('/change-owner-profile/{owner_id}', [ClinicSettingController::class, 'changeOwnerProfile'])->name('changeOwnerProfile');
            Route::get('/change-password', [ClinicSettingController::class, 'changePasswordForm'])->name('changePasswordForm');
            Route::post('/change-password', [ClinicSettingController::class, 'changePassword'])->name('changePassword');

            //Location
            Route::resource('location', LocationController::class);
            Route::group(['as' => 'locationBusinessHour.', 'prefix' => 'location-business-hour'], function() {
                // Route name will be users.comments.show
                Route::get('/business-hour/{location_id}', [LocationBusinessHourController::class, 'create'])->name('create');
                Route::post('/business-hour', [LocationBusinessHourController::class, 'store'])->name('store');

                Route::get('/update-business-hour/{location_id}', [LocationBusinessHourController::class, 'edit'])->name('edit');
                Route::put('/update-business-hour', [LocationBusinessHourController::class, 'update'])->name('update');
            });

            //Google Review
            Route::prefix('review-request')->name('reviewRequest.')->group(function () {
                Route::get('index/{location?}', [ReviewRequestController::class, 'index'])->name('index');
                Route::get('bulk-import', [ReviewRequestController::class, 'bulkImport'])->name('bulkImport');
                Route::post('import', [ReviewRequestController::class, 'import'])->name('import');
                Route::get('export-format', [ReviewRequestController::class, 'exportFormat'])->name('exportFormat');
                Route::get('send-message', [ReviewRequestController::class, 'sendMessageForm'])->name('sendMessageForm');
                Route::post('send-message', [ReviewRequestController::class, 'sendMessage'])->name('sendMessage');

                Route::get('/single-request', [ReviewRequestController::class, 'singleRequest'])->name('singleRequest');
                Route::post('/single-request', [ReviewRequestController::class, 'storeSingleRequest'])->name('storeSingleRequest');
                
                Route::prefix('provider-listing')->name('providerListing.')->group(function () {
                    Route::get('index', [ProviderListingController::class, 'index'])->name('index');
                    Route::get('create',[ProviderListingController::class, 'create'])->name('create');
                    Route::post('store',[ProviderListingController::class, 'store'])->name('store');
                    Route::get('edit/{provider_listing}',[ProviderListingController::class, 'edit'])->name('edit');
                    Route::put('update/{provider_listing}',[ProviderListingController::class, 'update'])->name('update');
                    Route::get('destroy/{provider_listing}',[ProviderListingController::class, 'destroy'])->name('destroy');
                    Route::get('get-locations', [ProviderListingController::class, 'getLocations'])->name('getLocations');
                });
            });

            //Reporting
            Route::group(['as' => 'reporting.', 'prefix' => 'reporting'], function() {
                // Route name will be clinic.reporting
                Route::match(['GET', 'POST'], '/', [ReportingController::class, 'index'])->name('index');
                Route::get('export', [ReportingController::class, 'export'])->name('export');
            });

            //Import Reporting
            Route::controller(ReportingController::class)->group(function () {
                Route::group(['as' => 'reporting.', 'prefix' => 'reporting'], function() {
                    // Route name will be clinic.reporting
                    Route::get('/', 'index')->name('index');
                    Route::put('/export', 'index')->name('export');
                    Route::match(['GET'],'/data', 'data')->name('data');
                });
            });

            //Provider Holiday
            Route::group(['as' => 'providerHoliday.', 'prefix' => 'provider-holiday'], function() {
                // Route name will be users.comments.show
                Route::post('/add/{provider}', [ProviderHolidayController::class, 'add'])->name('add');
                Route::get('/remove/{provider_holiday}', [ProviderHolidayController::class, 'remove'])->name('remove');
            });

            //Appointment Setting
            Route::group(['as' => 'appointmentSetting.', 'prefix' => 'appointment-setting'], function() {
                // Route name will be users.comments.show
                Route::get('/appointment-detail/{appointment_id}', [AppointmentSettingController::class, 'detail'])->name('detail');
                Route::post('/change-status/{appointment_id}/{status_id}', [AppointmentSettingController::class, 'changeStatus'])->name('changeStatus');
                Route::get('/edit/{appointment_id}', [AppointmentSettingController::class, 'edit'])->name('edit');
                Route::patch('/update/{appointment_id}', [AppointmentSettingController::class, 'update'])->name('update');
                Route::POST('/available-time-slots-by-date/{appointment_id}', [AppointmentSettingController::class, 'getAvailableTimeSlotsByDate'])->name('getAvailableTimeSlotsByDate');
            });

            //Staff
            Route::group(['as' => 'staff.', 'prefix' => 'staff'], function() {
                // Route name will be users.comments.show
                Route::get('/profile', [StaffController::class, 'profile'])->name('profile');
                Route::get('/trashed', [StaffController::class, 'trashed'])->name('trashed');
                Route::post('/restore/{staff}', [StaffController::class, 'restore'])->name('restore');
            });
            Route::resource('staff', StaffController::class);


            //Customer
            Route::group(['as' => 'customer.', 'prefix' => 'customer'], function() {
                // Route name will be users.comments.show
                Route::post('/add-appointment', [CustomerController::class, 'addAppointment'])->name('addAppointment');
                Route::post('api/location-provider', [CustomerController::class, 'locationProvider'])->name('locationProvider');
                Route::post('api/provider-availability', [CustomerController::class, 'providerAvailability'])->name('providerAvailability');
            });
            Route::resource('customer', CustomerController::class);

            //Provider
            Route::group(['as' => 'provider.', 'prefix' => 'provider'], function() {
                Route::get('/trashed', [ProviderController::class, 'trashed'])->name('trashed');
                Route::post('/restore/{provider}', [ProviderController::class, 'restore'])->name('restore');
            });
            Route::resource('provider', ProviderController::class);
            Route::group(['as' => 'assignLocation.', 'prefix' => 'assign-location'], function() {
                // Route name will be clinic.assignLocation
                Route::get('/assign-location-to-provider/{provider}', [AssignLocationController::class, 'toProvider'])->name('toProvider');
                Route::post('/assign-location-store-or-update', [AssignLocationController::class, 'storeOrUpdate'])->name('storeOrUpdate');
            });

            //Location Availability
            Route::group(['as' => 'locationAvailability.', 'prefix' => 'location-availability'], function() {
                // Route name will be clinic.assignLocation
                Route::get('/set-location-availability/{provider_location_id}', [LocationAvailabilityController::class, 'create'])->name('create');
                Route::post('/set-location-availability', [LocationAvailabilityController::class, 'store'])->name('store');

                Route::get('/update-location-availability/{provider_location_id}', [LocationAvailabilityController::class, 'edit'])->name('edit');
                Route::put('/update-location-availability', [LocationAvailabilityController::class, 'update'])->name('update');
            });

            //single action controller insurance download
            Route::get('ins-download/', InsuranceDocDownload::class)->name('insDownload');

        });

        //Auth
        Route::group(['as' => 'auth.', 'prefix' => 'auth'], function() {
            // Route name will be users.comments.show
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        });
    });

    //Clinic Frontend
    //subdomain wildcard on server
    //https://www.namecheap.com/support/knowledgebase/article.aspx/597/2237/how-can-i-set-up-a-catchall-wildcard-subdomain
    //https://www.namecheap.com/support/knowledgebase/article.aspx/9191/29/how-to-create-a-wildcard-subdomain-in-cpanel
    Route::domain('{subdomain}.'.config('app.short_url'))->group(function () {
        Route::group(['as' => 'clinicFrontend.'], function() {
            Route::get('/{lang?}', [FrontendController::class, 'home'])->name('home')->defaults('lang', "en")->where('lang', 'en');
            Route::post('/find-customer', [FrontendController::class, 'findCustomer'])->name('findCustomer');
            Route::get('/about', [FrontendController::class, 'about'])->name('about');
            Route::get('/review', [FrontendController::class, 'review'])->name('review');
            Route::get('/provider', [FrontendController::class, 'provider'])->name('provider');
            Route::get('/provider-profile/{provider}', [FrontendController::class, 'providerProfile'])->name('providerProfile');
            Route::get('/location', [FrontendController::class, 'location'])->name('location');
            Route::get('/location-providers/{location}', [FrontendController::class, 'locationProviders'])->name('locationProviders');

            Route::get('/appointment/{appointment}', [AppointmentController::class, 'appointmentForm'])->name('appointmentForm');
            Route::post('/appointment', [AppointmentController::class, 'appointment'])->name('appointment');
            Route::get('/thank-you', [FrontendController::class, 'thankYou'])->name('thankYou');
            Route::get('/patient-appointment-document/{appointment_id}/{token}', [FrontendController::class, 'patientAppointmentDocument'])->name('patientAppointmentDocument');
            Route::patch('/upload-patient-appointment-document/{appointment_id}', [FrontendController::class, 'uploadPatientAppointmentDocument'])->name('uploadPatientAppointmentDocument');

            Route::post('/get-providers-by-location', [FrontendController::class, 'getProvidersByLocation'])->name('getProvidersByLocation');
            Route::post('/get-available-time-slots-of-provider', [FrontendController::class, 'getAvailableTimeSlotsOfProvider'])->name('getAvailableTimeSlotsOfProvider');
            Route::post('/get-available-time-slots-by-date', [FrontendController::class, 'getAvailableTimeSlotsByDate'])->name('getAvailableTimeSlotsByDate');

            //step routes
            Route::get('/calendar/{provider_location_id}', [FrontendController::class, 'calendar'])->name('calendar');
            Route::post('/get-weekly-available-slots', [FrontendController::class, 'getWeeklyAvailableSlots'])->name('getWeeklyAvailableSlots');
            });
    });

//for localhost use
    Route::group(['as' => 'clinicFrontend.'], function() {
        Route::get('/{subdomain}/{lang?}', [FrontendController::class, 'home'])->name('home')->defaults('lang', "en")->where('lang', 'en');
        Route::post('/{subdomain}/find-customer', [FrontendController::class, 'findCustomer'])->name('findCustomer')->defaults('subdomain', "new");
        Route::get('/{subdomain}/about', [FrontendController::class, 'about'])->name('about')->defaults('subdomain', "new");
        Route::get('/{subdomain}/review', [FrontendController::class, 'review'])->name('review')->defaults('subdomain', "new");
        Route::get('/{subdomain}/provider', [FrontendController::class, 'provider'])->name('provider')->defaults('subdomain', "new");
        Route::get('/{subdomain}/provider-profile/{provider}', [FrontendController::class, 'providerProfile'])->name('providerProfile')->defaults('subdomain', "new");
        Route::get('/{subdomain}/location', [FrontendController::class, 'location'])->name('location')->defaults('subdomain', "new");
        Route::get('/{subdomain}/location-providers/{location}', [FrontendController::class, 'locationProviders'])->name('locationProviders')->defaults('subdomain', "new");
        Route::get('/{subdomain}/appointment/{appointment}', [AppointmentController::class, 'appointmentForm'])->name('appointmentForm')->defaults('subdomain', "new");
        Route::post('/{subdomain}/appointment', [AppointmentController::class, 'appointment'])->name('appointment')->defaults('subdomain', "new");
        Route::get('/{subdomain}/thank-you', [FrontendController::class, 'thankYou'])->name('thankYou')->defaults('subdomain', "new");

        Route::get('/{subdomain}/patient-appointment-document/{appointment_id}/{token}', [FrontendController::class, 'patientAppointmentDocument'])->name('patientAppointmentDocument')->defaults('subdomain', "new");
        Route::patch('/{subdomain}/upload-patient-appointment-document/{appointment_id}', [FrontendController::class, 'uploadPatientAppointmentDocument'])->name('uploadPatientAppointmentDocument')->defaults('subdomain', "new");

        Route::post('/{subdomain}/get-providers-by-location', [FrontendController::class, 'getProvidersByLocation'])->name('getProvidersByLocation')->defaults('subdomain', "new");
        Route::post('/{subdomain}/get-available-time-slots-of-provider', [FrontendController::class, 'getAvailableTimeSlotsOfProvider'])->name('getAvailableTimeSlotsOfProvider')->defaults('subdomain', "new");
        Route::post('/{subdomain}/get-available-time-slots-by-date', [FrontendController::class, 'getAvailableTimeSlotsByDate'])->name('getAvailableTimeSlotsByDate')->defaults('subdomain', "new");

        //step routes
        Route::get('/{subdomain}/calendar/{provider_location_id}', [FrontendController::class, 'calendar'])->name('calendar');
        Route::post('/{subdomain}/get-weekly-available-slots', [FrontendController::class, 'getWeeklyAvailableSlots'])->name('getWeeklyAvailableSlots');
    });

