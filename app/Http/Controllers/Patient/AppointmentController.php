<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\ProviderLocation;
use App\Models\Status;
use App\Services\AppointmentService;
use App\Services\LocationAvailabilityService;
use App\Services\LocationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
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

        $providerLocation = ProviderLocation::where(
            ['location_id' => $locationId, 'provider_id' => $providerId ,'status_id' => Status::ACTIVE])
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
}
