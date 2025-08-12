<?php

namespace App\Services;

use App\Models\Clinic;
use App\Models\Location;
use App\Models\LocationBusinessHour;
use App\Models\ProviderHoliday;
use App\Models\ProviderLocation;
use App\Models\StaffLocation;
use App\Models\Status;
use App\Models\User;
use Carbon\CarbonPeriod;

class ClinicService
{
    public $subDomain;
    public $clinic;
    public $locationAvailabilityService;

    public function __construct($subDomain, $locationAvailabilityService) {
        $this->subDomain = $subDomain;
        $this->locationAvailabilityService = $locationAvailabilityService;
        $this->isValidSubDomain();
        $this->clinic = Clinic::where('sub_domain', $this->subDomain)->first();
    }

    /**
     * @return mixed
     */
    public function getClinicId ()
    {
        if ($this->clinic == null)
        {
            abort(404, 'No Clinic Found');
        }

        return $this->clinic->id;
    }

    /**
     * @return mixed
     */
    public function getClinic ()
    {
        if ($this->clinic == null)
        {
            abort(404, 'No Clinic Found');
        }

        return $this->clinic;

    }

    /**
     * @return mixed
     */
    public function getLocationProviders ($locationId)
    {
        return ProviderLocation::where(['location_id' => $locationId, 'status_id' => Status::ACTIVE])
            ->with(['location','provider.userDetail'])
            ->get();
    }

    /**
     * @return mixed
     */
    public function getClinicLocations ()
    {
        $clinicId = $this->getClinicId();
        return Location::where('clinic_id', $clinicId)->get();
    }

    /**
     * @param string $locationId
     * @return mixed
     */
    public function getClinicLocationById (string $locationId = '')
    {
        $clinicId = $this->getClinicId();

        return Location::where(['clinic_id' => $clinicId, 'id' => $locationId])->first();
    }

    /**
     * @return mixed
     */
    public function getClinicLocationWithDefault ($locationId = '')
    {
        if ($locationId == '')
        {
            $clinicLocations = $this->getClinicLocations();
            if (count($clinicLocations) > 0)
            {
                $clinicLocation = $clinicLocations[0]->id;

            } else {

                abort(404, 'No Location Found');
            }

        } else {
            $location = $this->getClinicLocationById($locationId);

            if ($location == null)
            {
                abort(404, 'Invalid Location');
            }

            $clinicLocation = $location->id;
        }

        return $clinicLocation;
    }

    /**
     * @param string $locationId
     * @param string $date
     * @return array
     */
    public function getClinicProvidersViaLocation (string $locationId = '', string $date = '')
    {
        $clinicId = $this->clinic->id;
        $clinicLocationIdWithDefault = $this->getClinicLocationWithDefault($locationId);
        $clinicLocationId = $clinicLocationIdWithDefault;
        $timestamp = strtotime($date);
        $day = date('w', $timestamp);

        return User::where('clinic_id', $clinicId)->whereHas('roles', function($q){
            $q->where('name', 'provider');
        })->with([
            'userDetail',
            'providerLocation' => function ($q) use($clinicLocationId, $day) {
                $q->where(['location_id' => $clinicLocationId, 'status_id' => Status::ACTIVE])->with([
                    'providerLocationAvailability' => function ($location) use($day) {
                        $location->where([
                            'day_of_week' => $day,
                            //'is_available' => 1,
                        ]);
                    }
                ]);
            },
            'providerAppointments' => function ($q) use ($clinicLocationId, $date){
                $q->where([
                    'location_id' => $clinicLocationId,
                ])->whereDate('date', $date);
            }
        ])->get();
    }

    /**
     * @return mixed
     */
    public function getClinicProviders ()
    {
        $clinicId = $this->getClinicId();
        return User::where('clinic_id', $clinicId)->whereHas('roles', function($q){
            $q->where('name', 'provider');
        })->with(['userDetail', 'roles'])->get();
    }

    /**
     * @return mixed
     */
    public function getProviderProfile ($providerId)
    {
        $clinicId = $this->getClinicId();
        return User::where(['clinic_id' => $clinicId, 'id' => $providerId])->whereHas('roles', function($q){
            $q->where('name', 'provider');
        })->with([
            'userDetail',
            'providerLocation' => function($q){
                $q->where('status_id', Status::ACTIVE)->with([
                    'location',
                ]);
            },
        ])->first();
    }

    /**
     * @return mixed
     */
    public function getLocationBusinessHours ($locationId)
    {
        return LocationBusinessHour::select([
            'id', 'location_id', 'day_of_week', 'start_time', 'end_time', 'is_available'
        ])
            ->where(['location_id' => $locationId, 'is_available' => 1])->get();
    }


    public function isValidSubDomain()
    {
        if ($this->subDomain == null || $this->subDomain == '')
        {
            abort(404, 'Invalid Sub Domain');
        }
    }

    /**
     * @param $providersViaLocation
     * @param $date
     * @param $perAppointmentMin
     * @return array
     */
    public function makeProviderResponse($providersViaLocation, $date, $perAppointmentMin): array
    {
        $providers = [];
        $appointments = [];
        $dayTimeSlot = [];
        foreach ( $providersViaLocation as $key => $provider )
        {
            $holidays = $this->locationAvailabilityService->getProviderHoliday($provider);
            foreach ( $provider->providerLocation as $keyLocation => $location )
            {
                $locationProviders = [
                    'provider' => [
                        'id' => $provider->id,
                        'clinic_id' => $provider->clinic_id,
                        'name' => $provider->name,
                    ],
                    'userDetail' => [
                        'image' => $provider->userDetail->image,
                        'about' => $provider->userDetail->about,
                        'phone' => $provider->userDetail->phone,
                    ],
                    'providerLocation' => [
                        'id' => $location->id,
                        'location_id' => $location->location_id,
                        'provider_id' => $location->provider_id,
                    ],
                ];

                if (count($location->providerLocationAvailability) > 0)
                {
                    foreach ( $location->providerLocationAvailability as $keyLocationAvailable => $availability  )
                    {
                        $startTime = $availability->start_time;
                        $endTime = $availability->end_time;
                        $interval = $perAppointmentMin ??  '15';
                        if($availability->is_available)
                        {
                            $appointments =  $provider->providerAppointments ? $provider->providerAppointments->pluck('start_time')->toArray() : [];
                            $dayTimeSlot = $this->locationAvailabilityService->getAvailableTimeSlot($interval, $startTime, $endTime, $date, $appointments, $holidays);

                            $providerSlots = [
                                'providerLocationAvailability' =>  [
                                    'id' => $availability->id,
                                    'provider_location_id' => $availability->id,
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
        }

        return $providers;
    }
}
