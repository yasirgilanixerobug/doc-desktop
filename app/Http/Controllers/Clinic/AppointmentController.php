<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Models\AppBookingChannel;
use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\Insurance;
use App\Models\Clinic;
use App\Models\ProviderLocation;
use App\Services\LocationService;
use App\Services\AppointmentService;
use App\Traits\PrepareAppointmentData;
use App\Traits\TempSignedRoute;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Traits\Fileable;

class AppointmentController extends Controller
{
    use TempSignedRoute, PrepareAppointmentData, Fileable;

    /**
     * @param Request $request
     * @param LocationService $locationService
     * @return Application|Factory|View|RedirectResponse
     */
    public function appointmentForm(Request $request, LocationService $locationService)
    {
        $authUser = Auth::user();
        $encryptedAppointmentString = $request->appointment;
        $decAppointment = decrypt($encryptedAppointmentString);
        $explodeAppointment = explode('|', $decAppointment);
        $providerLocationId = $explodeAppointment[0];
        $startTime = $explodeAppointment[1];
        $date = $explodeAppointment[2];
        $subdomain = $explodeAppointment[3];

        $providerLocation = ProviderLocation::where('id',$providerLocationId)->with([
            'location.businessHour',
        ])->first();

        if($providerLocation == null)
        {
            abort(404, 'Not Found');
        }

        $locationId = $providerLocation->location_id;
        $providerId = $providerLocation->provider_id;

        $clinicCurrentLocation = $providerLocation->location;
        $locationBusinessHours = $providerLocation->location->businessHour;
        $weekDays = $locationService->weekDays();

        $appointmentDate = date('d M', strtotime($date));
        $clinic = Clinic::where('sub_domain', $subdomain)
            ->with([
                'locations' => function($q) use($locationId){
                    $q->where('id', $locationId )->first();
                },
                'providers' => function($q) use($providerId){
                    $q->where('id', $providerId )->first();
                },
            ])
            ->first();

        if($clinic == null)
        {
            abort(404, 'Not Found');
        }

        $appointment = Appointment::where([
            'clinic_id' => $clinic->id,
            'location_id' => $providerLocation->location_id,
            'provider_id' => $providerLocation->provider_id,
            'start_time' => $startTime
        ])->whereDate('date', $date)->first();

        if ($appointment != null)
        {
            return back()->with('error', "This Slot Is Booked Already Try Other, Refresh The Page");
        }

        $appointmentLocation = $clinic->locations[0]->name;
        $appointmentProvider = $clinic->providers[0]->name;
        $appointmentLocation = "Appointment in $appointmentLocation";
        $appointmentWith = " with $appointmentProvider, on $appointmentDate, $startTime";

        return view('clinic.frontend.appointment',
            compact('authUser','encryptedAppointmentString', 'appointmentLocation','appointmentWith', 'clinicCurrentLocation', 'locationBusinessHours', 'weekDays','providerLocationId'));
    }

    /**
     * @param AppointmentRequest $request
     * @param AppointmentService $appointmentService
     * @return RedirectResponse
     */
    public function appointment(AppointmentRequest $request, AppointmentService $appointmentService): RedirectResponse
    {
        $decAppointment = decrypt($request->appointment);
        $explodeAppointment = explode('|', $decAppointment);
        $providerLocationId = $explodeAppointment[0];
        $startTime = $explodeAppointment[1];
        $date = $explodeAppointment[2];
        $subdomain = $explodeAppointment[3];

        //get clinic with configuration
        $clinic = $appointmentService->getClinicBySubdomain($subdomain);

        //get provider of a location
        $providerLocation = $appointmentService->getProviderLocation($providerLocationId);

        //check appointment already exists
        $appointmentService->checkAppointmentAlreadyExists($clinic->id, $providerLocation->location_id, $providerLocation->provider_id, $date, $startTime, $subdomain);

        //get all receptionist of a location
        $staffReceptionist = $appointmentService->getLocationReceptionistList($providerLocation->location_id);

        $appointmentData =  [
            'clinic_id' => $clinic->id,
            'location_id' => $providerLocation->location_id,
            'provider_id' => $providerLocation->provider_id,
            'start_time' => $startTime,
            'date' => $date,
            'app_booking_channel_id' => AppBookingChannel::WEBSITE,
            'appointment_status_id' => AppointmentStatus::PENDING_APPROVAL['id'],
            'comment' => $request->comment,
            'other_name' => $request->other_name,
        ];

        $requestDataForGuestUser = $request->only('first_name', 'last_name', 'email', 'phone', 'state', 'city', 'address', 'zip_code','dob');
        $user = (Auth::user()) ? Auth::user() : $appointmentService->guestUserFindOrCreate($requestDataForGuestUser, $request->appointment_form_type, $request->customer_id, $clinic->id);

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

            $insUploadExpireLink = $this->getTempSignedRoute($subdomain, $patient->email, $appointment->id);
        }

        //make appointment record
        $patientAppointment = $this->makeSTDPatientAppointment(
            $appointment->start_time,
            $appointment->date,
            AppointmentStatus::PENDING_APPROVAL['name'],
            isset($attachUploadFilePathsToEmail) ? $attachUploadFilePathsToEmail : [],
            $insUploadExpireLink,
            $appointment->comment,
        );

        $sendTo = $this->messageSendTo(['patient', 'provider', 'staff', 'owner']);
        //send message sms and email
        $appointmentData = $appointmentService->sendMessages(
            $sendTo,
            $clinic, $providerLocation->location, $staffReceptionist, $providerLocation->provider,
            $patient, $patientAppointment
        );

        $userAppointmentRecord = array_merge($requestDataForGuestUser, ['id' => Crypt::encryptString($user->id)]);

        return redirect()->route('clinicFrontend.thankYou', ['subdomain' => $clinic->sub_domain])
            ->with(['data' => $appointmentData, 'guest_user' => $userAppointmentRecord]);
    }
}
