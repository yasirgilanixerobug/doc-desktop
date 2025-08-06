<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadPatientDocumentRequest;
use App\Models\Appointment;
use App\Models\Insurance;
use App\Models\GuestUser;
use App\Models\User;
use App\Models\ProviderLocation;
use App\Models\Status;
use App\Services\AppointmentService;
use App\Services\ClinicService;
use App\Services\LocationAvailabilityService;
use App\Services\LocationService;
use App\Traits\PrepareAppointmentData;
use App\Traits\TempSignedRoute;
use App\Traits\Fileable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use stdClass;
use Illuminate\Support\Carbon;

class FrontendController extends Controller
{
    use TempSignedRoute, PrepareAppointmentData, Fileable;

    public $clinicService;
    public $locationAvailabilityService;
    public $locationService;

    public function __construct(
        Request $request,
        LocationAvailabilityService $locationAvailabilityService,
        LocationService $locationService )
    {
        $subDomain = $request->subdomain;
        $this->locationAvailabilityService = $locationAvailabilityService;
       
        $this->clinicService = new ClinicService($subDomain, $locationAvailabilityService);
        $this->locationService = $locationService;
        get_date_default_timezone();
        // if (request()->ip() == '127.0.0.1')
        // {
        //     //$ip = "189.240.194.147"; //$_SERVER['REMOTE_ADDR'];
        //     date_default_timezone_set('Asia/Karachi');
        // } else {
        //     $ip = $_SERVER['REMOTE_ADDR'];
        //     $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
        //     $ipInfo = json_decode($ipInfo);
        //     $timezone = $ipInfo->timezone;
        //     date_default_timezone_set($timezone);
            
        // }

        
    }

    /**
     * @return Application|Factory|View
     */
    public function home()
    {
        $date = date('Y-m-d');
        $clinicLocations = $this->clinicService->getClinicLocations();
        $providersViaLocation = $this->clinicService->getClinicProvidersViaLocation('', $date);
        $clinicCurrentLocation = $clinicLocations[0] ?? [];
        //$locationBusinessHours = $this->clinicService->getLocationBusinessHours($clinicCurrentLocation->id);
        //$weekDays = $this->locationService->weekDays();

        $providers = $this->clinicService->makeProviderResponse($providersViaLocation, $date, $clinicCurrentLocation->per_appointment_min);

        return view(
            'clinic.frontend.home',
            compact('providers','clinicLocations', 'clinicCurrentLocation')
        );
    }

    /**
     * @return Application|Factory|View
     */
    public function about()
    {
        $clinic = $this->clinicService->getClinic();
        $weekDays = $this->locationService->weekDays();
        $clinicLocation = ($clinic->locations[0]) ?? [];
        $locationBusinessHours = $this->clinicService->getLocationBusinessHours($clinicLocation->id);

        return view('clinic.frontend.about',
            compact('clinic', 'locationBusinessHours', 'weekDays', 'clinicLocation')
        );
    }

    /**
     * @return Application|Factory|View
     */
    public function review()
    {
        $clinic = $this->clinicService->getClinic();
        $weekDays = $this->locationService->weekDays();

        $clinicLocation = ($clinic->locations[0]) ?? [];
        $locationBusinessHours = $this->clinicService->getLocationBusinessHours($clinicLocation->id);

        return view(
            'clinic.frontend.review',
            compact( 'clinic', 'weekDays', 'locationBusinessHours', 'clinicLocation')
        );
    }

    /**
     * @return Application|Factory|View
     */
    public function provider()
    {
        $providers = $this->clinicService->getClinicProviders();
        //$clinic = $this->clinicService->getClinic();
        //$weekDays = $this->locationService->weekDays();
        //$clinicLocation = ($clinic->locations[0]) ?? [];
        //$locationBusinessHours = $this->clinicService->getLocationBusinessHours($clinicLocation->id);
//        return view(
//            'clinic.frontend.provider',
//            compact('providers', 'clinic', 'weekDays', 'locationBusinessHours', 'clinicLocation')
//        );

        return view(
            'clinic.frontend.provider',
            compact('providers')
        );
    }

    /**
     * @return Application|Factory|View
     */
    function location()
    {
        $locations = $this->clinicService->getClinicLocations();
        return view(
            'clinic.frontend.location',
            compact('locations')
        );
    }

    /**
     * @return Application|Factory|View
     */
    function calendar(Request $request)
    {
        $providerLocationId = decrypt($request->provider_location_id);
        $providerLocation = ProviderLocation::where(['id' => $providerLocationId, 'status_id' => 1])
        ->with('location','provider')
        ->first();

        $date =  date('Y-m-d');
        $timestamp = strtotime($date);
        $day = date('w', $timestamp);

        $providerLocation = ProviderLocation::where(['id' => $providerLocationId, 'status_id' => Status::ACTIVE])->with([
            'provider.providerAppointments',
            'location',
            'providerLocationAvailability' => function($ava) use($day){
                $ava->where('is_available', 1)->whereIn(
                    'day_of_week', [$day]
                );
            }
        ])->first();

        $providerId = $providerLocation->provider_id;
        $locationId = $providerLocation->location_id;
        $holidays = $this->locationAvailabilityService->getProviderHoliday($providerLocation->provider);

        $providerAvailabilityDayOfWeeks = $providerLocation->providerLocationAvailability ? $providerLocation->providerLocationAvailability()
            ->where(['is_available' => 1])
            //->whereNotIn('day_of_week', $holidays)
            ->pluck('day_of_week')->toArray()
            : [];

        $disableWeekDays = $this->locationService->providerDisableWeekDays($providerAvailabilityDayOfWeeks);
        
        $appointmentLocation = "Appointment in ". $providerLocation->location->name;
        $appointmentWith = " with ". isset($providerLocation->provider) ? $providerLocation->provider->name : 'N\A';
        return view('clinic.frontend.calendar', compact('appointmentLocation', 'holidays', 'disableWeekDays','appointmentWith', 'providerId', 'locationId', 'providerLocationId'));
    }

    /**
     * @return Application|Factory|View
     */
    function getWeeklyAvailableSlots(Request $request)
    {
        $providerLocationId = $request->provider_location_id;

        if ($request->date === null)
        {
            $dateFrom = Carbon::today()->toDateString();
            $dateTo = Carbon::today()->addDays(3)->toDateString();

        } else {
            $dateFrom = date('Y-m-d', strtotime($request->date));
            $date = Carbon::createFromFormat('Y-m-d', $dateFrom);
            $dateTo = $date->addDays(3)->toDateString();
        }

        $providerLocation = ProviderLocation::where(['id' => $providerLocationId, 'status_id' => 1])
        ->with('location','provider')
        ->first();

        $providerId = $providerLocation->provider_id;
        $locationId = $providerLocation->location_id;

        $datesFromTo = $this->locationAvailabilityService->getDatesFromRange($dateFrom, $dateTo);
        $provider = User::where(['id' => $providerId])
            ->with([
                'userDetail',
                'providerAppointments',
                'providerLocation.providerLocationAvailability',
                'providerHoliday' => function($q) use($dateFrom, $dateTo){
                    $q->whereBetween('end_date', [$dateFrom, $dateTo]);
                }
            ])
            ->first();

        if ($provider)
        {
            $providers = [];
            $appointments = [];
            $dayTimeSlot = [];

            $holidays = $this->locationAvailabilityService->getApiProviderHoliday($provider->providerHoliday);
            $providerLocation = ($provider->providerLocation[0]) ?? [];

            if ( $providerLocation )
            {
                $providerActiveWeekDays = $provider->providerLocation[0]->providerLocationAvailability->pluck('day_of_week')->toArray();

                $locationProviders = [
                    'id' => $provider->id,
                    'clinic_id' => $provider->clinic_id,
                    'name' => $provider->name,
                    'userDetail' => [
                        'image' => $provider->userDetail->image,
                        'about' => $provider->userDetail->about,
                        'phone' => $provider->userDetail->phone,
                    ],
                    'providerLocation' => [
                        'id' => $providerLocation->id,
                        'location_id' => $providerLocation->location_id,
                        'provider_id' => $providerLocation->provider_id,
                    ],
                ];

                if (count($providerLocation->providerLocationAvailability) > 0)
                {
                    foreach ($datesFromTo as $dateKey => $date)
                    {
                        $appointments =  $provider->providerAppointments()
                        ->where(['location_id' => $locationId])
                        ->whereDate('date', $date)->pluck('start_time')->toArray();
                        $weekDate = strtotime($date);
                        $dateWeekDay = date('w', $weekDate);

                        $bookedAppointmentsSlots[$date] = [
                            'appointments' => $appointments,
                            'dateWeekDay' => $dateWeekDay,
                        ];
                    }

                    foreach ( $providerLocation->providerLocationAvailability as $keyLocationAvailable => $availability  )
                    {
                        $startTime = $availability->start_time;
                        $endTime = $availability->end_time;
                        $interval = $perAppointmentMin ??  '15';
                        
                        if($availability->is_available)
                        {
                            $dayTimeSlot = [];

                            foreach ($bookedAppointmentsSlots as $dateKey => $appointmentDate)
                            {
                                if (in_array($appointmentDate['dateWeekDay'], $providerActiveWeekDays))
                                {
                                    $dayTimeSlot[$dateKey] = $this->locationAvailabilityService->getAvailableTimeSlotApi($interval, $startTime, $endTime, $dateKey, $appointmentDate['appointments'], $holidays);
                                } else {
                                    $dayTimeSlot[$dateKey] = [];
                                }
                            }

                            
                            $providerSlots = [
                                'providerLocationAvailability' =>  [
                                    'id' => $availability->id,
                                    'provider_location_id' => $availability->provider_location_id,
                                    'day_of_week' => $availability->day_of_week,
                                    'start_time' => $availability->start_time,
                                    'end_time' => $availability->end_time,
                                    'is_available' => $availability->is_available,
                                    'available_time_slot' => $dayTimeSlot,
                                ],
                            ];

                        } else {
                            $providerSlots = [
                                'providerLocationAvailability' => [],
                            ];
                        }
                    }

                } else {

                    $providerSlots = [
                        'providerLocationAvailability' => [],
                    ];
                }

                $providers[] = array_merge($locationProviders, $providerSlots);
            }

            $response = [
                'status' => 200,
                'message' => 'Provider Available Slots',
                'data' => $providers
            ];

        } else {
            $response = [
                'status' => 404,
                'message' => 'Provider available slots Not Found',
                'data' => []
            ];
        }

        $returnHTML = view('clinic.frontend.weekly-available-time-slots')->with('providers', $providers)->render();

        return response()->json([
            'status' => count($providers) > 0 ? 'success' : 'error',
            'html' => $returnHTML,
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    function locationProviders(Request $request)
    {
        $locationId = decrypt($request->location);
        $providerLocations = $this->clinicService->getLocationProviders($locationId);

        return view(
            'clinic.frontend.location-providers',
            compact('providerLocations')
        );
    }

    /**
     * @return Application|Factory|View
     */
    public function providerProfile(Request $request)
    {
        $providerId = decrypt($request->provider);
        $provider = $this->clinicService->getProviderProfile($providerId);
        //$clinic = $this->clinicService->getClinic();
        //$weekDays = $this->locationService->weekDays();

        //$clinicLocation = ($clinic->locations[0]) ?? [];
        //$locationBusinessHours = $this->clinicService->getLocationBusinessHours($clinicLocation->id);

        return view(
            'clinic.frontend.profile',
            compact('provider')
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getProvidersByLocation(Request $request): JsonResponse
    {
        $locationId = $request->location_id;
        $location = $this->clinicService->getClinicLocationById($locationId);
        $date = date('Y-m-d');
        $providersViaLocation = $this->clinicService->getClinicProvidersViaLocation($locationId, $date);
        //$locationBusinessHours = $this->clinicService->getLocationBusinessHours($locationId);
        //$weekDays = $this->locationService->weekDays();

        $providers = $this->clinicService->makeProviderResponse($providersViaLocation, $date, $location->per_appointment_min);
        $returnHTML = view('clinic.frontend.provider-by-location')->with('providers', $providers)->render();

//        $sideMenu = view("components.side-menu")
//            ->with([
//                "businessHours" => $locationBusinessHours,
//                "weekDays" => $weekDays,
//                "fullAddress" => $location->fullAddress ?? 'N\A',
//                "phone" => $location->phone ?? 'N\A',
//            ])
//            ->render();

        return response()->json([
            'status' => count($providers) > 0 ? 'success' : 'error',
            'html' => $returnHTML,
            //'sideMenu' => $sideMenu,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function getAvailableTimeSlotsOfProvider(Request $request): JsonResponse
    {
        $providerLocationId = $request->provider_location_id;
        $btnType = $request->btn_type;
        $providerAvailability = [];

        $todayDate = date("Y-m-d");
        $today = strtotime(now());
        $todayWeekDay = date('w', $today);

        $tomorrowDate = date("Y-m-d", strtotime("+1 day"));
        $tomorrow = strtotime(date("Y-m-d", strtotime("+1 day")));
        $tomorrowWeekDay = date('w', $tomorrow);

        $thirdDate = date("Y-m-d", strtotime("+2 day"));
        $thirdDay = strtotime(date("Y-m-d", strtotime("+2 day")));
        $thirdWeekDay = date('w', $thirdDay);

        $providerLocation = ProviderLocation::where(['id' => $providerLocationId, 'status_id' => Status::ACTIVE])->with([
            'provider.providerAppointments',
            'location',
            'providerLocationAvailability' => function($ava) use($todayWeekDay, $tomorrowWeekDay, $thirdWeekDay){
                $ava->where('is_available', 1)->whereIn(
                    'day_of_week', [$todayWeekDay, $tomorrowWeekDay, $thirdWeekDay]
                );
            }
        ])->first();

        $holidays = $this->locationAvailabilityService->getProviderHoliday($providerLocation->provider);

        $locationId = $providerLocation->location_id;
        $providerId = $providerLocation->provider_id;

        $providerAvailabilityDayOfWeeks = $providerLocation->providerLocationAvailability ? $providerLocation->providerLocationAvailability()
            ->where(['is_available' => 1])
            //->whereNotIn('day_of_week', $holidays)
            ->pluck('day_of_week')->toArray()
            : [];
        $disableWeekDays = $this->locationService->providerDisableWeekDays($providerAvailabilityDayOfWeeks);

        $name = $providerLocation->provider->name.' ('.$providerLocation->location->name.')';

        foreach ( $providerLocation->providerLocationAvailability as $key => $availability  )
        {
            $startTime = $availability->start_time;
            $endTime = $availability->end_time;
            $interval = $providerLocation->location->per_appointment_min ??  '15';

            if ($availability->day_of_week == $todayWeekDay)
            {
                $appointments =  $providerLocation->provider->providerAppointments ? $providerLocation->provider->providerAppointments()
                    ->where(['location_id' => $locationId, 'provider_id' => $providerId])
                    ->whereDate('date', $todayDate)
                    ->pluck('start_time')->toArray() : [];

                $dayTimeSlot = $this->locationAvailabilityService->getAvailableTimeSlot($interval, $startTime, $endTime, $todayDate, $appointments, $holidays);
                $providerAvailability['today'] = [
                        'id' => $availability->id,
                        'provider_location_id' => $providerLocationId,
                        'day_of_week' => $availability->day_of_week,
                        'start_time' => $availability->start_time,
                        'end_time' => $availability->end_time,
                        'is_available' => $availability->is_available,
                        'available_time_slot' => $dayTimeSlot,
                ];
            } else if($availability->day_of_week == $tomorrowWeekDay) {

                $appointments =  $providerLocation->provider->providerAppointments ? $providerLocation->provider->providerAppointments()
                    ->where(['location_id' => $locationId, 'provider_id' => $providerId])
                    ->whereDate('date', $tomorrowDate)->pluck('start_time')->toArray() : [];

                $dayTimeSlot = $this->locationAvailabilityService->getAvailableTimeSlot($interval, $startTime, $endTime, $tomorrowDate, $appointments, $holidays);
                $providerAvailability['tomorrow'] = [
                    'id' => $availability->id,
                    'provider_location_id' => $providerLocationId,
                    'day_of_week' => $availability->day_of_week,
                    'start_time' => $availability->start_time,
                    'end_time' => $availability->end_time,
                    'is_available' => $availability->is_available,
                    'available_time_slot' => $dayTimeSlot,
                ];
            } else {
                $appointments =  $providerLocation->provider->providerAppointments ? $providerLocation->provider->providerAppointments()
                    ->where(['location_id' => $locationId, 'provider_id' => $providerId])
                    ->whereDate('date', $thirdDate)->pluck('start_time')->toArray() : [];

                $dayTimeSlot = $this->locationAvailabilityService->getAvailableTimeSlot($interval, $startTime, $endTime, $thirdDate, $appointments, $holidays);
                $providerAvailability['thirdDay'] = [
                        'id' => $availability->id,
                        'provider_location_id' => $providerLocationId,
                        'day_of_week' => $availability->day_of_week,
                        'start_time' => $availability->start_time,
                        'end_time' => $availability->end_time,
                        'is_available' => $availability->is_available,
                        'available_time_slot' => $dayTimeSlot,
                ];
            }
        }

        $returnHTML = view('clinic.frontend.location-availability')->with([
            'locationId' => $locationId,
            'providerId' => $providerId,
            'btnType' => $btnType,
            'providerAvailability' => $providerAvailability,
            'disableWeekDays' => $disableWeekDays,
            'name'=>  $name,
            'holidays'=>  $holidays,
        ])->render();

        return response()->json([
            'status' => count($providerAvailability) > 0 ? 'success' : 'error',
            'html' => $returnHTML,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function getAvailableTimeSlotsByDate(Request $request): JsonResponse
    {
        $providerId = $request->provider_id;
        $locationId = $request->location_id;
        $requestDate = $request->date;
        $providerAvailability = [];

        $date = date("Y-m-d", strtotime($requestDate));
        $dateTimeString = strtotime(date("Y-m-d", strtotime($requestDate)));
        $dateWeekDay = date('w', $dateTimeString);
        
        $providerLocation = ProviderLocation::where(['location_id' => $locationId, 'provider_id' => $providerId ,'status_id' => Status::ACTIVE])
            ->with([
                'provider.providerAppointments',
                'location',
                'providerLocationAvailability' => function($ava) use($dateWeekDay){
                    $ava->where(['is_available' => 1, 'day_of_week' => $dateWeekDay]);
                }
            ])
            ->first();
            
        $holidays = $this->locationAvailabilityService->getProviderHoliday($providerLocation->provider);
        
        foreach ( $providerLocation->providerLocationAvailability as $key => $availability  )
        {
            $startTime = $availability->start_time;
            $endTime = $availability->end_time;
            $interval = $providerLocation->location->per_appointment_min ??  '15';
            if ($availability->day_of_week == $dateWeekDay)
            {
                $appointments =  $providerLocation->provider->providerAppointments ? $providerLocation->provider->providerAppointments()
                    ->where(['location_id' => $locationId, 'provider_id' => $providerId])
                    ->whereDate('date', $date)
                    ->pluck('start_time')->toArray() : [];

                $dayTimeSlot = $this->locationAvailabilityService->getAvailableTimeSlot($interval, $startTime, $endTime, $date, $appointments);
                
                $providerAvailability['date'] = [
                    'id' => $availability->id,
                    'provider_location_id' => $providerLocation->id,
                    'day_of_week' => $availability->day_of_week,
                    'start_time' => $availability->start_time,
                    'end_time' => $availability->end_time,
                    'is_available' => in_array($date, $holidays) ? 0 : $availability->is_available,
                    'available_time_slot' => $dayTimeSlot,
                ];
            }
        }

        $returnHTML = view('clinic.frontend.location-availability-by-date')->with([
            'locationId' => $locationId,
            'providerId' => $providerId,
            'providerAvailability' => $providerAvailability,
        ])->render();

        return response()->json([
            'status' => count($providerAvailability) > 0 ? 'success' : 'error'  ,
            'html' => $returnHTML,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findCustomer(Request $request): JsonResponse
    {
        $subDomain = $request->subdomain;
        $userAppointmentRecord = [];
        $localStorageUserId = Crypt::decryptString($request->guest_id);
        $checkCookieAllow = Cookie::get('laravel_cookie_consent');

        if ($checkCookieAllow === null)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Allow cookie to get your old record according to phone number',
                'data' => $userAppointmentRecord,
            ]);
        }

        $userFound = GuestUser::where('id', $localStorageUserId)->first();
        if ($userFound)
        {
            $userAppointmentRecord = $userFound->toArray();
            $userAppointmentRecord = array_merge($userAppointmentRecord, ['guest_id' => Crypt::encryptString($userFound['id'])]);
        }

        return response()->json([
            'status' => empty($userAppointmentRecord) ? 'error' : 'success',
            'message' => empty($userAppointmentRecord) ? 'Patient Not Found' : 'Record Found',
            'data' => $userAppointmentRecord,
        ]);
    }

    /**
     * @return Application|Factory|View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function thankYou()
    {
        $appointmentData = session()->get('data');
        $guestUser = session()->get('guest_user');
        return view('clinic.frontend.thank-you', compact('appointmentData', 'guestUser'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function patientAppointmentDocument(Request $request)
    {
        //check url has valid signature
        $this->hasValidSignature($request->hasValidSignature());

        $appointmentId = decrypt($request->appointment_id);
        $token = $request->token;

        $appointment = Appointment::where(['id' => $appointmentId])
            ->with(['clinic', 'userable', 'location', 'provider'])
            ->first();

        //check token in database if not then abort 404 else return passwordRests table object
        $findToken = $this->checkToken($appointment->userable->email, $token);

        $appPatientName = $appointment->userable->name;
        $appLocationName = $appointment->location->name;
        $appProviderName = $appointment->provider->name;
        $appDate = date(config('app.default_date_format_string'), strtotime($appointment->date));
        $appStartTime = $appointment->start_time;
        $appFor = "Appointment in $appLocationName with $appProviderName, on $appDate, $appStartTime";

        return view('clinic.frontend.patient-appointment-document',
            compact('appointment', 'appFor', 'appPatientName', 'token'));
    }


    /**
     * @param UploadPatientDocumentRequest $request
     * @param AppointmentService $appointmentService
     * @return RedirectResponse
     */
    public function uploadPatientAppointmentDocument(UploadPatientDocumentRequest $request, AppointmentService $appointmentService): RedirectResponse
    {

        $appointmentId = decrypt($request->appointment_id);
        $token = $request->token;

        //get appointment
        $appointment = $appointmentService->getAppointment($appointmentId);

        //check token in database if not then abort 404 else return passwordRests table object
        $findToken = $this->checkToken($appointment->userable->email, $token);

        //clinic with configuration, and owner with details
        $clinic = $appointment->clinic;
        $location = $appointment->location;
        $provider = $appointment->provider;

        //get all Receptionist of a location
        $locationStaffReceptionist = $appointmentService->getLocationReceptionistList($appointment->location_id);

        //store patient appointment documents
        $requestIns = $request->only('ins_front', 'ins_back', 'ins_document');
        //$storedPatientAppointmentDoc = $appointmentService->storePatientAppointmentDoc($requestIns, $appointment->userable->id);
        $storedPatientAppointmentDoc = $this->storeInsuranceDoc($requestIns);
        
        // $attachUploadFilePathsToEmail = [
        //     'ins_front' => public_path().'/'.$userInsurance->ins_front,
        //     'ins_back' => public_path().'/'.$userInsurance->ins_back,
        //     'ins_document' => public_path().'/'.$userInsurance->ins_document,
        // ];

        $insuranceData =  array_merge($storedPatientAppointmentDoc['for_db'], [
            'userable_type' => 'App\Models\GuestUser',
            'userable_id' => $appointment->userable->id,
        ]);
        
        $insurance = Insurance::create($insuranceData);
        Appointment::where(['id' => $appointmentId])->update(['insurance_id' => $insurance->id ]);
        //make patient appointment object
        $patient = $this->makeSTDPatient([
            'name' => $appointment->userable->name,
            'dob' =>    $appointment->userable->dob,
            'email' =>    $appointment->userable->email,
            'phone' =>    $appointment->userable->phone,
            'address' =>    $appointment->userable->fullAddres,
        ]);

        //make appointment object
        $patientAppointment = $this->makeSTDPatientAppointment(
            $appointment->start_time,
            $appointment->date,
            $appointment->status->name,
            $storedPatientAppointmentDoc['for_email'],
            null,
        );

        //send appointment email and sms
        $sendTo = $this->messageSendTo(['patient', 'staff']);
        $appointmentService->sendMessages(
            $sendTo, $clinic, $location , $locationStaffReceptionist ,
            $provider, $patient, $patientAppointment);

        //remove token from database
        $this->deleteToken($appointment->userable->email, $token);

        //return to home page
        return redirect()->route('clinicFrontend.home', ['subdomain' => $clinic->sub_domain, 'lang' => 'en' ])->with(['success' => 'Document Send To Clinic']);
    }
}
