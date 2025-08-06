<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\ProviderLocation;
use App\Models\User;
use App\Services\AuthService;
use App\Services\LocationAvailabilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ProviderController extends Controller
{
    private $authService;
    private $locationAvailabilityService;

    public function __construct(
        AuthService $authService,
        LocationAvailabilityService $locationAvailabilityService) {
        $this->authService = $authService;
        $this->locationAvailabilityService = $locationAvailabilityService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'provider_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        $clinicId = $this->authService->getClinicId($request->company_id);
        $providerId = $request->provider_id;

        $providerProfile = User::where(['clinic_id' => $clinicId, 'id' => $providerId])
            ->whereHas('roles', function($q) {
                $q->whereIn('id', [3]);
            })
            ->with([
                'userDetail',
                'providerLocation.location',
                'providerLocation' => function($q) {
                    $q->where('status_id', 1)->with('providerLocationAvailability');
                },
                'providerHoliday' => function($q){
                    $q->whereYear('start_date', now()->year);
                }
            ])
            ->first();

        if ($providerProfile)
        {
            $providerLocations = [];
            foreach ($providerProfile->providerLocation as $key => $providerLocation)
            {
                $locationAvailabilities = [];
                foreach($providerLocation->providerLocationAvailability as $locationAvailabilityKey =>  $locationAvailability)
                {
                    $locationAvailabilities[] = [
                        'id' => $locationAvailability->id,
                        'day_of_week' => $locationAvailability->day_of_week,
                        'start_time' => $locationAvailability->start_time,
                        'end_time' => $locationAvailability->end_time,
                        'is_available' => $locationAvailability->is_available,
                        'reason_of_unavailability' => $locationAvailability->reason_of_unavailability,
                    ];
                }

                $providerLocations[] = [
                    'id' => $providerLocation->location->id,
                    'name' => $providerLocation->location->name,
                    'state' => $providerLocation->location->state,
                    'city' => $providerLocation->location->city,
                    'address' => $providerLocation->location->address,
                    'image' => $providerLocation->location->image,
                    'availability' => $locationAvailabilities
                ];
            }

            $providerHolidays = [];
            foreach ($providerProfile->providerHoliday as $key => $providerHoliday)
            {
                $providerHolidays[] = [
                    'id' => $providerHoliday->id,
                    'start_date' => $providerHoliday->start_date,
                    'end_date' => $providerHoliday->end_date,
                    'description' => $providerHoliday->description,
                ];
            }

            $responseData = [
                'id' => $providerProfile->id,
                'name' => $providerProfile->name,
                'email' => $providerProfile->email,
                'user_detail' => [
                    'id' => $providerProfile->userDetail->id,
                    'gender_id' => $providerProfile->userDetail->gender_id,
                    'about' => $providerProfile->userDetail->about,
                    'image' => $providerProfile->userDetail->image,
                    'state' => $providerProfile->userDetail->state,
                    'city' => $providerProfile->userDetail->city,
                    'address' => $providerProfile->userDetail->address,
                    'phone' => $providerProfile->userDetail->phone,
                    'home' => $providerProfile->userDetail->home,
                    'office' => $providerProfile->userDetail->office,
                    'fax' => $providerProfile->userDetail->fax,
                ],
                'provider_location' => $providerLocations,
                'provider_holiday' => $providerHolidays
            ];

            $response = [
                'status' => 200,
                'message' => 'Providers Profile Found Successfully',
                'data' => $responseData
            ];

        } else {
            $response = [
                'status' => 404,
                'message' => 'Providers Profile Not Found',
                'data' => (object) []
            ];
        }

        return response()->json($response, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function all(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        $clinicId = $this->authService->getClinicId($request->company_id);

        $providers = User::select('id', 'name', 'email')
            ->where('clinic_id', $clinicId)
            ->whereHas('roles', function($q) {
                $q->whereIn('id', [3]);
            })
            ->with('userDetail')
            ->get();


        if (count($providers) > 0)
        {
            foreach ($providers as $key => $provider)
            {
                $providerData[] = [
                    'id' => $provider->id,
                    'name' => $provider->name,
                    'email' => $provider->email,
                    'gender_id' => $provider->userDetail->gender_id,
                    'about' => $provider->userDetail->about,
                    'image' => $provider->userDetail->image,
                    'phone' => $provider->userDetail->phone,
                    'home' => $provider->userDetail->home,
                    'office' => $provider->userDetail->office,
                    'fax' => $provider->userDetail->fax,
                ];
            }

            $response = [
                'status' => 200,
                'message' => 'Providers Found Successfully',
                'data' => $providerData
            ];

        } else {
            $response = [
                'status' => 404,
                'message' => 'Providers Not Found',
                'data' => []
            ];
        }

        return response()->json($response, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function byLocation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'location_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        $clinicId = $this->authService->getClinicId($request->company_id);
        $clinicLocationId = $request->location_id;

//        $providerByLocation =  User::where('clinic_id', $clinicId)
//            ->whereHas('roles', function($q){
//            $q->where('name', 'provider');
//        })->with([
//            'userDetail',
//            'providerLocation' => function ($q) use($clinicLocationId) {
//                $q->where(['location_id' => $clinicLocationId, 'status_id' => 1])
//                    ->with(['providerLocationAvailability']);
//            }
//        ])->get();


        $providerByLocation = ProviderLocation::where(['location_id' => $clinicLocationId])
            ->with([
                'provider.userDetail'
            ])
            ->get();

        if (count($providerByLocation) > 0)
        {
            $providerData = [];
            foreach ($providerByLocation as $key => $providerLocation)
            {
                
                if (isset($providerLocation->provider)) {
                    $providerData[] = [
                        'id' => $providerLocation->provider->id,
                        'name' => $providerLocation->provider->name,
                        'email' => $providerLocation->provider->email,
                        'gender_id' => $providerLocation->provider->userDetail->gender_id,
                        'about' => $providerLocation->provider->userDetail->about,
                        'image' => $providerLocation->provider->userDetail->image,
                        'phone' => $providerLocation->provider->userDetail->phone,
                        'home' => $providerLocation->provider->userDetail->home,
                        'office' => $providerLocation->provider->userDetail->office,
                        'fax' => $providerLocation->provider->userDetail->fax,
                    ];
                }
                
            }

            $response = [
                'status' => 200,
                'message' => 'Providers Found Successfully',
                'data' => $providerData
            ];

        } else {
            $response = [
                'status' => 404,
                'message' => 'Providers Not Found',
                'data' => []
            ];
        }

        return response()->json($response, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function weeklyAvailableSlots(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'provider_id' => 'required',
            'location_id' => 'required',
            'date' => 'nullable',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        if ($request->date === null)
        {
            $dateFrom = Carbon::today()->toDateString();
            $dateTo = Carbon::today()->addDays(4)->toDateString();

        } else {
            $dateFrom = date('Y-m-d', strtotime($request->date));
            $date = Carbon::createFromFormat('Y-m-d', $dateFrom);
            $dateTo = $date->addDays(4)->toDateString();
        }

        $clinicId = $this->authService->getClinicId($request->company_id);
        $providerId = $request->provider_id;
        $locationId = $request->location_id;

        $dateFromStrToTime = strtotime($dateFrom);
        $dateFromWeekDay = date('w', $dateFromStrToTime);
        $dateEndStrToTime = strtotime($dateTo);
        $dateEndWeekDay = date('w', $dateEndStrToTime);

        // Function call with passing the start date and end date
        $datesFromTo = $this->locationAvailabilityService->getDatesFromRange($dateFrom, $dateTo);
        
        $provider = User::where(['clinic_id' => $clinicId, 'id' => $providerId])
            ->with([
                'userDetail',
                'providerAppointments',
                //'providerLocation.providerLocationAvailability',
                'providerLocation' => function ($q) use($dateFromWeekDay, $dateEndWeekDay) {
                    $q->with(['providerLocationAvailability' => function ($q) use($dateFromWeekDay, $dateEndWeekDay) {
                        $q->where(['is_available' => 1]);
                        // $q->whereBetween('day_of_week', [$dateFromWeekDay, $dateEndWeekDay]);
                    }]);
                },
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
                    foreach ( $providerLocation->providerLocationAvailability as $keyLocationAvailable => $availability  )
                    {
                        $startTime = $availability->start_time;
                        $endTime = $availability->end_time;
                        $interval = $perAppointmentMin ??  '15';
                        
                        if($availability->is_available)
                        {
                            //$appointments =  $provider->providerAppointments ? $provider->providerAppointments->pluck('start_time')->toArray() : [];
                            $dayTimeSlot = [];

                            foreach ($datesFromTo as $dateKey => $date)
                            {
                                $weekDate = strtotime($date);
                                $dateWeekDay = date('w', $weekDate);

                                $appointments =  $provider->providerAppointments ? $provider->providerAppointments()
                                ->where(['location_id' => $locationId, 'provider_id' => $providerId])
                                ->whereDate('date', $date)
                                ->pluck('start_time')->toArray() : [];

                                if (in_array($dateWeekDay, $providerActiveWeekDays))
                                {
                                    $dayTimeSlot[$date] = $this->locationAvailabilityService->getAvailableTimeSlotApi($interval, $startTime, $endTime, $date, $appointments, $holidays);
                                } else {
                                    $dayTimeSlot[$date] = [];
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

        return response()->json($response, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function availableSlotByDate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'provider_id' => 'required',
            'location_id' => 'required',
            'date' => 'nullable',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        $date = date("Y-m-d", strtotime($request->date));
        $clinicId = $this->authService->getClinicId($request->company_id);
        $providerId = $request->provider_id;
        $locationId = $request->location_id;
        

        if ($request->date === null)
        {
            $date = Carbon::today()->toDateString();
        }

        $weekDate = strtotime($date);
        $dateWeekDay = date('w', $weekDate);

        $provider = User::where(['clinic_id' => $clinicId, 'id' => $providerId])
            ->with([
                'userDetail',
                'providerAppointments',
                //'providerLocation.providerLocationAvailability',
                'providerLocation' => function ($q) use($date, $dateWeekDay) {
                    $q->with(['providerLocationAvailability' => function ($q) use($date, $dateWeekDay) {
                        $q->where(['is_available' => 1, 'day_of_week' => $dateWeekDay]);
                    }]);
                },
                'providerHoliday' => function($q) use($date){
                    $q->whereDate('end_date' , $date);
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
                    foreach ( $providerLocation->providerLocationAvailability as $keyLocationAvailable => $availability  )
                    {
                        $startTime = $availability->start_time;
                        $endTime = $availability->end_time;
                        $interval = $perAppointmentMin ??  '15';
                        
                        if($availability->is_available && $availability->day_of_week == $dateWeekDay)
                        {
                            //$appointments =  $provider->providerAppointments ? $provider->providerAppointments->pluck('start_time')->toArray() : [];

                            $appointments =  $provider->providerAppointments ? $provider->providerAppointments()
                                ->where(['location_id' => $locationId, 'provider_id' => $providerId])
                                ->whereDate('date', $date)
                                ->pluck('start_time')->toArray() : [];

                            $dayTimeSlot = [];

                            if (in_array($dateWeekDay, $providerActiveWeekDays))
                            {
                                $dayTimeSlot[$date] = $this->locationAvailabilityService->getAvailableTimeSlotApi($interval, $startTime, $endTime, $date, $appointments, $holidays);
                            } else {
                                $dayTimeSlot[$date] = [];
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

        return response()->json($response, 200);
    }
}
