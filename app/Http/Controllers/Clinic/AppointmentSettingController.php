<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailJob;
use App\Jobs\SendSmsJob;
use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\ProviderLocation;
use App\Models\Status;
use App\Services\AppointmentService;
use App\Services\LocationAvailabilityService;
use App\Services\LocationService;
use App\Traits\PrepareAppointmentData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentSettingController extends Controller
{
    use PrepareAppointmentData;

    public function __construct()
    {
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
     * @param Request $request
     * @return Application|Factory|View
     */
    public function detail(Request $request)
    {
        $appointmentId = $request->appointment_id;

        $appointment =  Appointment::where('id', $appointmentId)
            ->whereHas('provider', function($q){
                $q->where('deleted_at', null)->with('userDetail');
            })
            ->with([
                'userable', 'clinic', 'location', 'status', 'insurance',
            ])
            ->first();
            
        if (!$appointment)
        {
            abort('404');
        }

        return view('clinic.appointment.detail', compact('appointment'));
    }

    /**
     * @param Request $request
     * @param LocationAvailabilityService $locationAvailabilityService
     * @param LocationService $locationService
     * @return JsonResponse
     * @throws \Exception
     */
    public function edit(
        Request $request,
        LocationAvailabilityService $locationAvailabilityService,
        LocationService $locationService): JsonResponse
    {
        $appointmentId = decrypt($request->appointment_id);
        $appointment = Appointment::find($appointmentId);
        if (!$appointment) {
            abort(404, 'Not Found');
        }

        $providerId = $appointment->provider_id;
        $locationId = $appointment->location_id;
        $requestDate = $appointment->date;
        $providerAvailability = [];

        $date = date("Y-m-d");
        $dateTimeString = strtotime(date("Y-m-d", strtotime($date)));
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

        $holidays = $locationAvailabilityService->getProviderHoliday($providerLocation->provider);

        $providerAvailabilityDayOfWeeks = $providerLocation->providerLocationAvailability ? $providerLocation->providerLocationAvailability()
            ->where(['is_available' => 1])
            ->pluck('day_of_week')->toArray() : [];

        $disableWeekDays = $locationService->providerDisableWeekDays($providerAvailabilityDayOfWeeks);
        $name = $providerLocation->provider->name.' ('.$providerLocation->location->name.')';

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

                $dayTimeSlot = $locationAvailabilityService->getAvailableTimeSlot($interval, $startTime, $endTime, $date, $appointments, $holidays);
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

        $returnHTML = view('clinic.appointment.edit')->with([
            'appointmentId' => $appointmentId,
            'providerAvailability' => $providerAvailability,
            'disableWeekDays' => $disableWeekDays,
            'name' => $name,
            'holidays'=>  $holidays,
        ])->render();

        return response()->json([
            'status' => count($providerAvailability) > 0 ? 'success' : 'error'  ,
            'html' => $returnHTML,
        ]);
    }

    /**
     * @param Request $request
     * @param LocationAvailabilityService $locationAvailabilityService
     * @param LocationService $locationService
     * @return JsonResponse
     * @throws \Exception
     */
    public function getAvailableTimeSlotsByDate(
        Request $request,
        LocationAvailabilityService $locationAvailabilityService,
        LocationService $locationService): JsonResponse
    {
        $appointmentId = $request->appointment_id;
        $appointment = Appointment::find($appointmentId);

        $providerId = $appointment->provider_id;
        $locationId = $appointment->location_id;
        $requestDate = isset($request->date) ? $request->date : $appointment->date;
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

                $dayTimeSlot = $locationAvailabilityService->getAvailableTimeSlot($interval, $startTime, $endTime, $date, $appointments);
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

        $returnHTML = view('clinic.appointment.time-slot')->with([
            'appointmentId' => $appointmentId,
            'providerAvailability' => $providerAvailability,
        ])->render();

        return response()->json([
            'status' => count($providerAvailability) > 0 ? 'success' : 'error'  ,
            'html' => $returnHTML,
        ]);
    }

    /**
     * @param Request $request
     * @param LocationService $locationService
     * @param LocationAvailabilityService $locationAvailabilityService
     * @param AppointmentService $appointmentService
     * @return JsonResponse
     */
    public function update(
        Request $request,
        LocationService $locationService,
        LocationAvailabilityService $locationAvailabilityService,
        AppointmentService $appointmentService
    ): JsonResponse
    {
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
                    'status' => 'error',
                    'message' => 'You can not change appointment after date or status Complete, Cancel by provider or patient and No show',
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'You can not schedule appointment in past days',
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
                'status' => 'error',
                'message' => 'This appointment is done you can not change it',
            ]);
        }

        if (in_array($date, $holidays) || in_array($dateWeekDay, $disableWeekDays))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'provider not available',
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
            null,
            $appointment->comment,
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
            'status' => 'success',
            'message' => 'appointment change successfully',
        ]);
    }

    /**
     * @param Request $request
     * @param AppointmentService $appointmentService
     * @return JsonResponse
     */
    public function changeStatus(Request $request, AppointmentService $appointmentService): JsonResponse
    {
        $appointmentId = decrypt($request->appointment_id);
        $statusId = $request->status_id;

        $status = AppointmentStatus::where('id',$statusId)->first();

        $appointment = Appointment::where('id', $appointmentId)
            ->with([
               'userable',
                'clinic',
                'provider',
                'location',
            ])
            ->first();

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
            $appointment->start_time,
            $appointment->date,
            $status->name,
            [],
            null,
            $appointment->comment,
        );

        $sendTo = $this->messageSendTo(['patient']);

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
            'appointment_status_id' => $statusId
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'appointment status '.$status->name.' change successfully',
        ]);
    }
}
