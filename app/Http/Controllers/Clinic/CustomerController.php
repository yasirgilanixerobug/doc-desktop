<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAppointmentRequest;
use App\Http\Requests\GuestUserRequest;
use App\Models\AppBookingChannel;
use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\GuestUser;
use App\Models\Location;
use App\Models\ProviderLocation;
use App\Models\Status;
use App\Services\AppointmentService;
use App\Services\LocationAvailabilityService;
use App\Traits\MyAuthData;
use App\Traits\PrepareAppointmentData;
use App\Traits\TempSignedRoute;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use MyAuthData, TempSignedRoute, PrepareAppointmentData;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->setAuthDataGlobaly();
            return $next($request);
        });
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $searchParam = (isset($request->q)) ? $request->q  : '';
        $authClinicId = $this->authUser->clinic_id;
        $roleNotOwner = $this->getAuth['isRoleOwner'] != true;

        $locations = Location::where('clinic_id', $authClinicId)
            ->when($roleNotOwner, function($q){
                $q->whereIn('id', $this->authUserLocationId );
            })->get();

        $guestUsers = GuestUser::where(['clinic_id' => $authClinicId])
            ->filter($searchParam)
            ->with([
                'clinic',
            ])
            ->orderBy('id', 'DESC')->paginate(10);

        return view('clinic.customer.index', compact('guestUsers', 'locations'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('clinic.customer.create');
    }

    /**
     * @param GuestUserRequest $request
     * @return RedirectResponse
     */
    public function store(GuestUserRequest $request): RedirectResponse
    {
        $requestValidated = $request->validated();
        $requestValidated = array_merge($requestValidated, ['clinic_id' => $this->authUser->clinic_id]);
        GuestUser::create($requestValidated);
        return redirect()->route('clinic.customer.index')->with('success', 'Create Successfully');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $model = GuestUser::where('id', $id)->with(['clinic'])->first();
        return view('clinic.customer.show', compact('model'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $model = GuestUser::where('id', $id)->first();
        return view('clinic.customer.edit', compact('model'));
    }

    /**
     * @param GuestUserRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(GuestUserRequest $request, $id): RedirectResponse
    {
        $requestValidated = $request->validated();
        GuestUser::where('id', $id)->update($requestValidated);
        return redirect()->route('clinic.customer.index')->with('success', 'Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param AddAppointmentRequest $request
     * @param AppointmentService $appointmentService
     * @return JsonResponse
     */
    public function addAppointment(
        AddAppointmentRequest $request,
        AppointmentService $appointmentService): JsonResponse
    {
        $requestValidated = $request->validated();
        $clinic = $this->authUser->clinic;

        $startTime = $requestValidated['start_time'];
        $date = $requestValidated['date'];
        $locationId = $requestValidated['location_id'];
        $providerId = $requestValidated['provider_id'];

        $guestUser = GuestUser::find($request->customer_id);

        $patient = $this->makeSTDPatient([
            'name' => $guestUser->name,
            'dob' =>    $guestUser->dob,
            'email' =>    $guestUser->email,
            'phone' =>    $guestUser->phone,
            'address' =>    $guestUser->fullAddress,
        ]);

        $appointmentData = array_merge($requestValidated, [
            'userable_type' => 'App\Models\GuestUser',
            'userable_id' => $request->customer_id,
            'app_booking_channel_id' => AppBookingChannel::WEBSITE,
            'appointment_status_id' => AppointmentStatus::PENDING_APPROVAL['id'],
            'clinic_id' => $this->authUser->clinic_id,
        ]);

        $providerLocation = ProviderLocation::where(['location_id' => $locationId, 'provider_id' => $providerId, 'status_id' => Status::ACTIVE])
            ->with(['location', 'provider.userDetail'])
            ->first();

        if($providerLocation === null)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'provider not available on this location',
            ]);
        }

        $staffReceptionist = $appointmentService->getLocationReceptionistList($locationId);
        $appointment = Appointment::create($appointmentData);

        $insUploadExpireLink = $this->getTempSignedRoute(
            $clinic->sub_domain,
            $patient->email,
            $appointment->id);

        //make appointment record
        $patientAppointment = $this->makeSTDPatientAppointment(
            $appointment->start_time,
            $appointment->date,
            'Pending',
            [],
            $insUploadExpireLink,
        );

        $sendTo = $this->messageSendTo(['patient', 'provider', 'staff', 'owner']);

        //send message sms and email
        $appointmentData = $appointmentService->sendMessages(
            $sendTo,
            $clinic, $providerLocation->location, $staffReceptionist, $providerLocation->provider,
            $patient, $patientAppointment
        );

        $patientMessage = " {$patient->name} your appointment is schedule with {$providerLocation->provider->name} at {$startTime} , {$date}, Location {$providerLocation->location->fullAddress}, and appointment status is pending, \n Thank you for trusting {$clinic->name}.";

        return response()->json([
            'status' => 'success',
            'message' => $patientMessage,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function locationProvider(Request $request): JsonResponse
    {
        if ($request->location_id === '')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Please select location first',
                'data' => []
            ]);
        }

        $providers = ProviderLocation::select(['id', 'location_id', 'provider_id'])
            ->where(['location_id' => $request->location_id, 'status_id' => Status::ACTIVE ])
            ->whereHas('provider', function($q){
                $q->where('deleted_at', null);
            })
            ->with([
                'provider' => function($q) {
                    $q->select('id', 'name');
                }
            ])
            ->get()
            ->map(function ($result) {
                return [
                    'id' => $result->provider->id,
                    'name' => $result->provider->name,
                ];
            })->toArray();

        return response()->json([
            'status' => empty($providers) ? 'error' : 'success',
            'message' => empty($providers) ? 'No Provider Found' : 'success',
            'data' => $providers
        ]);
    }

    /**
     * @param Request $request
     * @param LocationAvailabilityService $locationAvailabilityService
     * @return JsonResponse
     * @throws \Exception
     */
    public function providerAvailability(Request $request,  LocationAvailabilityService $locationAvailabilityService): JsonResponse
    {
        //date_default_timezone_set($request->time_zone);
        $providerId = $request->provider_id;
        $locationId = $request->location_id;
        $requestDate = $request->date;
        $providerAvailability = [];

        if ($providerId === '' && $locationId === '')
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Please select provider and location first',
                'data' => []
            ]);
        }

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
                $providerAvailability = $dayTimeSlot;
            }
        }

        return response()->json([
            'status' => empty($providerAvailability) ? 'error' : 'success',
            'message' => empty($providerAvailability) ? 'Provider Not Available' : 'success',
            'data' => $providerAvailability,
        ]);
    }
}
