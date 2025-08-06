<?php

namespace App\Services\New;

class MessageService {

    /**
     * @return string[]
     */
    function getAppointmentMessage(array $appointmentData): array
    {
        $patientName = $appointmentData['patient_name'];
        $providerName = $appointmentData['provider_name'];
        $time = $appointmentData['appointment_time'];
        $date = date('d M Y', strtotime($appointmentData['appointment_date']));
        $locationAddress = $appointmentData['location_address'];
        $clinic = $appointmentData['clinic'];
        $appointmentStatus = $appointmentData['appointment_status'];

        $message = "\n When: $date , $time ".
            "\n Where: $locationAddress".
            "\n Status: $appointmentStatus \n";

        $patientMessage = "Hi $patientName,\n Your appointment has been booked with $clinic \n Provider Name: $providerName". $message;
        $providerMessage = "Hi $providerName, \n You have an appointment with $patientName at $clinic". $message;
        $staffMessage = "$clinic, has a new appointment schedule with $providerName \n Patient Name: $patientName". $message;

        return [
            'staff_message' => $staffMessage,
            'provider_message' => $providerMessage,
            'patient_message' => $patientMessage,
            'owner_message' => $staffMessage,
        ];
    }

    /**
     * @return string[]
     */
    function getRequestReviewMessage(array $data): array
    {
        $patientName = $data['patient'];
        $providerName = $data['provider'];
        $date = date('d M Y', strtotime($data['appointment_date']));
        $locationName = $data['location'];
        $clinic = $data['clinic']['name'];
        $reviewUrl = url('review-request.form', ['slug' => $data['slug']]);

        $patientMessage = "Thank you for choosing $clinic as your health care. Please let us know how was your experience with $providerName on $date at $locationName \n.
here is the link where you can add review \n $reviewUrl";

        return [
            'patient_message' => $patientMessage,
        ];
    }

    /**
     * @param $mails
     * @return array
     */
    public function mailSendTo($mails): array
    {
        return  [$mails['provider_email'],$mails['patient_email'], $mails['clinic_owner_email']];
    }

    /**
     * @param $numbers
     * @return array
     */
    public function smsSendTo($numbers): array
    {
        return  [$numbers['provider_phone'],$numbers['patient_phone'], $numbers['clinic_owner_phone']];
    }

    /**
     * @param $mails
     * @return array
     */
    public function reviewMailSendTo($mails): array
    {
        return  [$mails['patient_email']];
    }

    /**
     * @param $patientPhone
     * @return array
     */
    public function reviewSmsSendTo($patientPhone): array
    {
        return  $patientPhone;
    }
}
