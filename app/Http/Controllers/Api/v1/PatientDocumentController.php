<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

class PatientDocumentController extends Controller
{
    use TempSignedRoute, PrepareAppointmentData, Fileable;

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
