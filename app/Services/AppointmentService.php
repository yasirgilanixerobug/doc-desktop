<?php

namespace App\Services;


use App\Jobs\SendMailJob;
use App\Jobs\SendSmsJob;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Location;
use App\Models\ProviderLocation;
use App\Models\Role;
use App\Models\StaffLocation;
use App\Models\Status;
use App\Models\User;
use App\Models\GuestUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use stdClass;

class AppointmentService
{
    public $locationAvailabilityService;
    public $locationService;

    public function __construct(LocationAvailabilityService $locationAvailabilityService, LocationService $locationService) {
        $this->locationAvailabilityService = $locationAvailabilityService;
        $this->locationService = $locationService;
    }

    /**
     * @param $subdomain
     * @return mixed
     */
    public function getClinicBySubdomain($subdomain)
    {

        $clinic = Clinic::where('sub_domain',$subdomain)->with([
            'owner.userDetail',
            'configuration'
        ])->first();

        if($clinic == null)
        {
            abort(404, 'Not Found');
        }

        return $clinic;
    }

    /**
     * @param $providerLocationId
     * @return mixed
     */
    public function getProviderLocation($providerLocationId)
    {
        return ProviderLocation::where('id', $providerLocationId)
            ->with([
                'location',
                'provider.userDetail',
            ])
            ->first();
    }

    /**
     * @param $clinicId
     * @param $locationId
     * @param $providerId
     * @param $date
     * @param $startTime
     * @param $subdomain
     * @return mixed
     */
    public function checkAppointmentAlreadyExists($clinicId, $locationId, $providerId, $date, $startTime, $subdomain)
    {

        $appointment = Appointment::where([
            'clinic_id' => $clinicId,
            'location_id' => $locationId,
            'provider_id' => $providerId,
            'start_time' => $startTime
        ])->whereDate('date', $date)->first();

        if ($appointment !== null)
        {
            return redirect()->route('clinicFrontend.home', ['subdomain' => $subdomain, 'lang' => 'en'])->with('error', "This Slot Is Booked Already Try Other, Refresh The Page");
        }

        return $appointment;
    }

    /**
     * @param $appointmentId
     * @return mixed
     */
    public function getAppointment($appointmentId)
    {
        $appointment = Appointment::where(['id' => $appointmentId])
            ->with([
                'userable', 'location', 'provider', 'status',
                'clinic' => function ($q){
                    $q->with([
                        'owner.userDetail',
                        'configuration'
                    ]);
                }])
            ->first();

        if (!$appointment)
        {
            abort(404);
        }

        return $appointment;
    }


    public function guestUserFindOrCreate($requestDataForGuestUser, $userType, $customerId, $clinicId)
    {
        if ($userType === 'user_established' && $customerId !== '' && $customerId !== null) {
            //$user = GuestUser::where('id', $customerId)->first();
            $user = User::where('id', $customerId)->first();
        }

        if($userType === 'user_guest') {
            $requestDataForGuestUser = array_merge($requestDataForGuestUser, ['clinic_id' => $clinicId ]);
            $user = GuestUser::create($requestDataForGuestUser);
        }

        return $user;
    }

    /**
     * @param $locationId
     * @return array
     */
    public function getLocationReceptionistList($locationId): array
    {
        $staffReceptionist = StaffLocation::where([
            'location_id' => $locationId,
        ])->with([
            'staff' => function($q){
                $q->whereHas(
                    'roles', function($q) {
                    $q->where('id', Role::RECEPTIONIST);
                })->with('userDetail');
            }
        ])->get();

        $locationStaffReceptionists = [];
        if(count($staffReceptionist) > 0)
        {
            foreach ($staffReceptionist as $key => $location) {
                if ($location->staff) {
                    $locationStaffReceptionists[] = [
                        'name' => $location->staff->name,
                        'email' => $location->staff->email,
                        'phone' => '+1'.$location->staff->userDetail->phone,
                    ];
                }
            }
        }
        
        return $locationStaffReceptionists;
    }

    /**
     * @param $requestIns
     * @param $userId
     * @return array
     */
    public function storePatientAppointmentDoc($requestIns, $userId = ''): array
    {
        $userId = (Auth::user()) ? Auth::user()->id : $userId;
        $insPath  = 'upload/insurance/'.$userId.'/';
        $attachUploadFilePaths = [];

        if (isset($requestIns['ins_front'])) {
            $file = $requestIns['ins_front'];
            $name = time().rand(1,100).'.'.$file->extension();
            $file->move(public_path($insPath), $name);
            $name = public_path($insPath).$name;
            $attachUploadFilePaths = array_merge($attachUploadFilePaths, ['ins_front' => $name]);
            //array_push($attachUploadFilePaths, $name);
        }

        if (isset($requestIns['ins_back'])) {
            $file = $requestIns['ins_back'];
            $name = time().rand(1,100).'.'.$file->extension();
            $file->move(public_path($insPath), $name);
            $name = public_path($insPath).$name;
            $attachUploadFilePaths = array_merge($attachUploadFilePaths, ['ins_front' => $name]);
            //array_push($attachUploadFilePaths, $name);
        }

        if (isset($requestIns['ins_document'])) {
            $file = $requestIns['ins_document'];
            $name = time().rand(1,100).'.'.$file->extension();
            $file->move(public_path($insPath), $name);
            $name = public_path($insPath).$name;
            $attachUploadFilePaths = array_merge($attachUploadFilePaths, ['ins_front' => $name]);
            //array_push($attachUploadFilePaths, $name);
        }

        return $attachUploadFilePaths;
    }

    /**
     * @param array $sendTo
     * @param Clinic $clinic
     * @param Location $location
     * @param array $locationReceptionists
     * @param User $provider
     * @param stdClass $patient
     * @param stdClass $appointment
     * @return array
     */
    public function sendMessages(array $sendTo, Clinic $clinic, Location $location, array $locationReceptionists, User $provider, stdClass $patient, stdClass $appointment): array
    {
        // clinic Eloquent object with clinic.configuration and clinic.owner.detail
        // location Eloquent Object
        // provider Eloquent Object with userDetail
        // patient Eloquent or simple Object with userDetail
        // appointment Eloquent or simple object with status and insurance file
        // locationReceptionists array
        // sendTo stdClass object
        
        $appointmentData = [
            'clinic' => $clinic->name,
            'clinic_sub_domain' => $clinic->sub_domain,
            'clinic_owner_email' => ($sendTo['send_to_owner'] && isset($clinic->configuration) && $clinic->configuration->is_send_email) ? $clinic->owner->email : null,
            'clinic_owner_phone' => ($sendTo['send_to_owner'] && isset($clinic->configuration) && $clinic->configuration->is_send_sms) ? $clinic->owner->userDetail->phone : null,
            'clinic_logo' => $clinic->brandLogo,

            'location_name' => $location->name,
            'location_phone' => '+1'.$location->phone,
            'location_address' => $location->fullAddress,
            'location_staff_receptionists' => count($locationReceptionists) > 0 ? $locationReceptionists : [],

            'provider_name' => $provider->name,
            'provider_phone' => $sendTo['send_to_provider'] ? '+1'.$provider->userDetail->phone : null,
            'provider_email' => $sendTo['send_to_provider'] ? $provider->email : null,

            'patient_name' => $patient->name,
            'patient_dob' => $patient->dob,
            'patient_phone' => $patient->phone,
            'patient_email' => $sendTo['send_to_patient'] ? $patient->email : null,
            'patient_address' => $patient->address,

            'appointment_time' => $appointment->start_time,
            'appointment_date' => $appointment->date,
            'appointment_status' => $appointment->status,
            'appointment_comment' => $appointment->appointment_comment,

            'ins_attach' => $appointment->ins_attach,
            'ins_upload_expire_link' => $appointment->ins_upload_expire_link ?? null
        ];
        
        $sendMessageThread = new SendSmsJob($appointmentData);
        dispatch($sendMessageThread);
        $sendMailThread = new SendMailJob($appointmentData);
        dispatch($sendMailThread);

        return $appointmentData;
    }


    /**
     * @param $request
     * @return array
     * @throws \Exception
     */
    public function getAvailableTimeSlotsByDateOfAppointment($request): array
    {
        $appointmentId = $request['appointment_id'];
        $requestDate = isset($request['date']) ?? '';
        $appointment = Appointment::find($appointmentId);

        $providerId = $appointment->provider_id;
        $locationId = $appointment->location_id;
        $requestDate = isset($request['date']) ?? $appointment->date;
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

        $providerAvailabilityDayOfWeeks = $providerLocation->providerLocationAvailability ? $providerLocation->providerLocationAvailability()
            ->where(['is_available' => 1])
            ->pluck('day_of_week')->toArray() : [];

        $disableWeekDays = $this->locationService->providerDisableWeekDays($providerAvailabilityDayOfWeeks);
        $name = $providerLocation->provider->name.' ('.$providerLocation->location->name.')';

        foreach ( $providerLocation->providerLocationAvailability as $key => $availability  )
        {
            $startTime = $availability->start_time;
            $endTime = $availability->end_time;
            $interval = $clinicCurrentLocation->per_client_min ??  '15';
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
                    'is_available' => $availability->is_available,
                    'available_time_slot' => $dayTimeSlot,
                ];
            }
        }

        return [
            'name' => $name,
            'providerAvailability' => $providerAvailability,
            'disableWeekDays' => $disableWeekDays,
        ];
    }
}
