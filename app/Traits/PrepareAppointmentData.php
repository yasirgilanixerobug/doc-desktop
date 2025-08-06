<?php

namespace App\Traits;

use stdClass;

trait PrepareAppointmentData {

    /**
     * @param array $sendTo
     * @return bool[]|null[]
     */
    function messageSendTo(array $sendTo): array
    {
        return [
            'send_to_patient' => in_array("patient", $sendTo) ?? null,
            'send_to_provider' => in_array("provider", $sendTo) ?? null,
            'send_to_staff' => in_array("staff", $sendTo) ?? null,
            'send_to_owner' => in_array("owner", $sendTo) ?? null,
        ];
    }

    /**
     * @param array $patientData
     * @return stdClass
     */
    function makeSTDPatient(array $patientData): stdClass
    {
        // Instantiate stdClass object

        $patient = new stdClass;
        $patient->name = $patientData['name'];
        $patient->dob = $patientData['dob'];
        $patient->email = $patientData['email'];
        $patient->phone = $patientData['phone'];
        $patient->address = $patientData['address'];

        return $patient;
    }

    /**
     * @param string $startTime
     * @param string $date
     * @param string $status
     * @param array $attachUploadFilePaths
     * @param string|null $insUploadExpireLink
     * @return stdClass
     */
    function makeSTDPatientAppointment(string $startTime, string $date, string $status, array $attachUploadFilePaths,
                                       ?string $insUploadExpireLink, $appointmentComment): stdClass
    {
        // Instantiate stdClass object

        $patientAppointment = new stdClass; // Instantiate stdClass object
        $patientAppointment->start_time = $startTime;
        $patientAppointment->date = $date;
        $patientAppointment->status = $status;
        $patientAppointment->ins_attach = $attachUploadFilePaths;
        $patientAppointment->ins_upload_expire_link = $insUploadExpireLink;
        $patientAppointment->appointment_comment = $appointmentComment;

        return $patientAppointment;
    }
}
