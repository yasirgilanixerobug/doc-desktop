<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailJob;
use App\Jobs\SendSmsJob;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\GuestUser;
use App\Models\ProviderLocation;
use App\Models\StaffLocation;
use App\Models\ROle;
use App\Models\AppBookingChannel;
use App\Models\AppointmentStatus;
use App\Services\AuthService;
use App\Services\AppointmentService;
use App\Traits\TempSignedRoute;
use App\Traits\PrepareAppointmentData;
use App\Traits\Fileable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\Insurance;
use App\Services\LocationAvailabilityService;
use App\Services\LocationService;

class AppointmentController extends Controller
{
    use TempSignedRoute, PrepareAppointmentData, Fileable;

    private $authService;

    public function __construct(
        AuthService $authService) {
        $this->authService = $authService;
    }

    public function appointment(
        Request $request,
        AppointmentService $appointmentService)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3|max:25|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|min:3|max:25|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'email' => 'required|email',
            'dob' => 'required|date|date_format:Y-m-d|before:today',
            'state' => 'nullable|min:2|max:20',
            'city' => 'nullable|min:2|max:30',
            'address' => 'nullable|string|min:3|max:200',
            'zip_code' => 'nullable|regex:/^(?:(\d{5})(?:[ \-](\d{4}))?)$/i',
            'comment' => 'nullable|string|min:3|max:200',
            'other_name' => 'nullable|min:3|max:50|regex:/^[a-zA-Z\s]+$/',
            'ins_front' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ins_back' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ins_document' => 'nullable|mimes:pdf,doc,docx|max:5120',

            'company_id' => 'required',
            'provider_location_id' => 'required',
            'start_time' => 'required',
            'date' => 'required',
            'appointment_form_type' => 'required',
            'customer_id' => 'required_if:appointment_form_type,==,user_established',
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
        $providerLocationId = $request->provider_location_id;
        $date = $request->date;
        $startTime = $request->start_time;

        $clinic = Clinic::where('id', $clinicId)->with([
            'owner.userDetail',
            'configuration'
        ])->first();

        if($clinic == null)
        {
            $response = [
                'status' => 404,
                'message' => 'Clinic Not Found',
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        //get provider of a location
        $providerLocation = $appointmentService->getProviderLocation($providerLocationId);

        //check appointment already exists
        $appointment = $appointmentService->checkAppointmentAlreadyExists($clinic->id, $providerLocation->location_id, $providerLocation->provider_id, $date, $startTime, $clinic->sub_domain);

        if ($appointment != null)
        {
            $response = [
                'status' => 404,
                'message' => 'This Slot Is Booked Already Try Other, Refresh The Page',
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        //get all receptionist of a location
        $staffReceptionist = $appointmentService->getLocationReceptionistList($providerLocation->location_id);

        $appointmentData =  [
            'clinic_id' => $clinic->id,
            'location_id' => $providerLocation->location_id,
            'provider_id' => $providerLocation->provider_id,
            'start_time' => $startTime,
            'date' => $date,
            'app_booking_channel_id' => AppBookingChannel::APP,
            'appointment_status_id' => AppointmentStatus::PENDING_APPROVAL['id'],
            'comment' => $request->comment,
            'other_name' => $request->other_name,
        ];

        $requestDataForGuestUser = $request->only('first_name', 'last_name', 'email', 'phone', 'state', 'city', 'address', 'zip_code','dob');
        $user = (Auth::user()) ? Auth::user() : $appointmentService->guestUserFindOrCreate($requestDataForGuestUser, $request->appointment_form_type, $request->customer_id, $clinic->id);
        info($user);
        //make patient appointment object
        $patient = $this->makeSTDPatient([
            'name' => $requestDataForGuestUser['first_name'].' '. $requestDataForGuestUser['last_name'],
            'dob' =>    $requestDataForGuestUser['dob'],
            'email' =>    $requestDataForGuestUser['email'],
            'phone' =>    $requestDataForGuestUser['phone'],
            'address' =>    $requestDataForGuestUser['address'].', '.$requestDataForGuestUser['city'].', '.$requestDataForGuestUser['state']. ', '.$requestDataForGuestUser['zip_code'],
        ]);

        //upload insurance document
        $attachUploadFilePaths = [];
        $insUploadExpireLink = null;
        
        if (Auth::user() && $user->insurance) {

            if ($request->hasfile('ins_front') || $request->hasfile('ins_back') || $request->hasfile('ins_document')) {

                $requestIns = $request->only('ins_front', 'ins_back', 'ins_document');
                $attachUploadFilePaths = $this->storeInsuranceDoc($requestIns);
                Insurance::where('id', $user->insurance->id)->update($attachUploadFilePaths['for_db']);
            }
            
            $userInsurance = $user->insurance;
            $userInsuranceId = $userInsurance->id;
            $attachUploadFilePathsToEmail = [
                'ins_front' => $userInsurance->ins_front_full_path,
                'ins_back' => $userInsurance->ins_back_full_path,
                'ins_document' => $userInsurance->ins_document_full_path,
            ];
        }

        if (Auth::user() && $user->insurance == null && ($request->hasfile('ins_front') || $request->hasfile('ins_back') || $request->hasfile('ins_document'))) {

            if ($request->hasfile('ins_front') || $request->hasfile('ins_back') || $request->hasfile('ins_document')) {
                $requestIns = $request->only('ins_front', 'ins_back', 'ins_document');

                $attachUploadFilePaths = $this->storeInsuranceDoc($requestIns);
                //$attachUploadFilePaths = $appointmentService->storePatientAppointmentDoc($requestIns);
                Insurance::where('id',  $user->insurance->id)->update($attachUploadFilePaths['for_db']);
            }

            $userInsurance = $user->insurance;
            $userInsuranceId = $userInsurance->id;
            $attachUploadFilePathsToEmail = [
                'ins_front' => $userInsurance->ins_front_full_path,
                'ins_back' => $userInsurance->ins_back_full_path,
                'ins_document' => $userInsurance->ins_document_full_path,
            ];
        }

        if (!Auth::user() && ($request->hasfile('ins_front') || $request->hasfile('ins_back') || $request->hasfile('ins_document'))) {
            //check this function
            $requestIns = $request->only('ins_front', 'ins_back', 'ins_document');
            $attachUploadFilePaths = $this->storeInsuranceDoc($requestIns, $user->id);
            $insuranceData = array_merge($attachUploadFilePaths['for_db'], [
                'userable_type' => 'App\Models\GuestUser',
                'userable_id' => $user->id,
            ]);
            $insurance = Insurance::create($insuranceData);
            $userInsuranceId = $insurance->id;
            $attachUploadFilePathsToEmail = $attachUploadFilePaths['for_email'];
            // $attachUploadFilePathsToEmail = [
            //     'ins_front' => isset($attachUploadFilePaths['ins_front']) ? $attachUploadFilePaths['ins_front']  : null,
            //     'ins_back' => isset($attachUploadFilePaths['ins_back']) ? $attachUploadFilePaths['ins_back']  : null,
            //     'ins_document' => isset($attachUploadFilePaths['ins_document']) ? $attachUploadFilePaths['ins_document']  : null,
            // ];
        }

        $appointmentData = array_merge($appointmentData, [
            'userable_type' => (Auth::user()) ? 'App\Models\User' : 'App\Models\GuestUser',
            'userable_id' => $user->id,
            'insurance_id' => isset($userInsuranceId) ? $userInsuranceId : null,
        ]);

        //create appointment
        $appointment = Appointment::create($appointmentData); 
        if(!Auth::user() && (!$request->hasfile('ins_front') && !$request->hasfile('ins_back') && !$request->hasfile('ins_document'))) {

            $insUploadExpireLink = $this->getTempSignedRoute($clinic->sub_domain, $patient->email, $appointment->id);
        }

        //make appointment record
        $patientAppointment = $this->makeSTDPatientAppointment(
            $appointment->start_time,
            $appointment->date,
            AppointmentStatus::PENDING_APPROVAL['name'],
            isset($attachUploadFilePathsToEmail) ? $attachUploadFilePathsToEmail : [],
            $insUploadExpireLink,
        );

        $sendTo = $this->messageSendTo(['patient', 'provider', 'staff', 'owner']);

        //send message sms and email
        $appointmentData = $appointmentService->sendMessages(
            $sendTo,
            $clinic, $providerLocation->location, $staffReceptionist, $providerLocation->provider,
            $patient, $patientAppointment
        );

        $userAppointmentRecord = array_merge($requestDataForGuestUser, ['id' => Crypt::encryptString($user->id)]);
        $userAppointmentRecord = json_encode($userAppointmentRecord);

        $response = [
            'status' => 200,
            'message' => 'Appointment Added Successfully',
            'data' => [],
        ];

        return response()->json($response, 200);
    }

    public function changeAppointment(Request $request,
        LocationService $locationService,
        LocationAvailabilityService $locationAvailabilityService,
        AppointmentService $appointmentService) {

        $appointmentId = $request->appointment_id;
        $appointment = Appointment::where('id', $appointmentId)->with([
            'userable',
            'clinic',
            'provider',
            'location',
            'status',
        ])->first();

        $date = isset($request->date) ? date('Y-m-d', strtotime($request->date)) : $appointment->date;
        $appointmentStartTime = $request->appointment_start_time ?? $appointment->start_time;

        $holidays = $locationAvailabilityService->getProviderHoliday($appointment->provider);
        $providerLocation = ProviderLocation::where(['provider_id' => $appointment->provider_id, 'location_id' => $appointment->location_id])
            ->with([
                'providerLocationAvailability'
            ])->first();

        $providerAvailabilityDayOfWeeks = $providerLocation->providerLocationAvailability ? $providerLocation->providerLocationAvailability()
            ->where(['is_available' => 1])
            //->whereNotIn('day_of_week', $holidays)
            ->pluck('day_of_week')->toArray()
            : [];

        $changeDate = strtotime($date);
        $dateWeekDay = date('w', $changeDate);
        $disableWeekDays = $locationService->providerDisableWeekDays($providerAvailabilityDayOfWeeks);

        if (date('Y-m-d') > $date)
        {
            if (in_array($appointment->appointment_status_id, [
                    AppointmentStatus::COMPLETE['id'],
                    AppointmentStatus::CANCELLED_BY_PROVIDER['id'],
                    AppointmentStatus::NO_SHOW['id'],
                    AppointmentStatus::CANCELLED_BY_PATIENT['id'],
                ]))
            {
                return response()->json([
                    'status' => 404,
                    'message' => 'You can not change appointment after date or status Complete, Cancel by provider or patient and No show',
                    'data' => [],
                ]);
            }

            return response()->json([
                'status' => 404,
                'message' => 'You can not schedule appointment in past days',
                'data' => [],
            ]);
        }

        if (date('Y-m-d') > $appointment->date && in_array($appointment->appointment_status_id, [
                AppointmentStatus::COMPLETE['id'],
                AppointmentStatus::CANCELLED_BY_PROVIDER['id'],
                AppointmentStatus::NO_SHOW['id'],
                AppointmentStatus::CANCELLED_BY_PATIENT['id'],
            ]))
        {
            return response()->json([
                'status' => 404,
                'message' => 'This appointment is done you can not change it',
                'data' => [],
            ]);
        }

        if (in_array($date, $holidays) || in_array($dateWeekDay, $disableWeekDays))
        {
            return response()->json([
                'status' => 404,
                'message' => 'provider not available',
                'data' => [],
            ]);
        }

        //get patient STD object
        $patient = $this->makeSTDPatient([
            'name' => $appointment->userable->name,
            'dob' =>    $appointment->userable->dob,
            'email' =>    $appointment->userable->email,
            'phone' =>    $appointment->userable->phone,
            'address' =>    $appointment->userable->fullAddress,
        ]);

        //get patient Appointment STD object
        $patientAppointmentData = $this->makeSTDPatientAppointment(
            $appointmentStartTime,
            $date,
            $appointment->status->name,
            [],
            null
        );

        $sendTo = $this->messageSendTo(['patient', 'staff']);

        //send appointment sms and email
        $appointmentService->sendMessages(
            $sendTo,
            $appointment->clinic,
            $appointment->location,
            [],
            $appointment->provider,
            $patient,
            $patientAppointmentData
        );

        $appointment->update([
            'date' => $date,
            'start_time' => $appointmentStartTime
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'appointment change successfully',
            'data' => [],
        ]);

    }
}
