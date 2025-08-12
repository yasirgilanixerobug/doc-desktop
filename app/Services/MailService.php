<?php

namespace App\Services;

use App\Mail\NewAppointmentMail;
use App\Services\MessageService;
use Exception;

class MailService {

    private $messageService;

    function __construct()
    {
        $this->messageService = new MessageService();
    }

    /**
     * @param $appointmentData
     * @return bool
     */
    function appointmentMessage ($appointmentData): bool
    {
        $messages = $this->messageService->getAppointmentMessage($appointmentData);
        $sendTo = $this->messageService->mailSendTo($appointmentData);

        $i = 0;
        foreach ($messages as $key => $message)
        {
            try {

                $details = [
                    'clinic_name' => $appointmentData['clinic'],
                    'title' => 'Your appointment with '.$appointmentData['clinic'],
                    'body' => $message,
                    'data' => $appointmentData,
                    'is' => $key
                ];

                if ($key === 'staff_message') {
                    foreach ($appointmentData['location_staff_receptionists'] as $receptionistKey => $receptionist) {
                        if (isset($receptionist['email']) && $receptionist['email'] != null)
                        {
                            \Mail::to($receptionist['email'])
                                ->send(new NewAppointmentMail($details));
                        }
                    }
                } else {

                    if ($sendTo[$i] != null)
                    {
                        \Mail::to($sendTo[$i])->send(new NewAppointmentMail($details));
                    }

                    $i++;
                }

            } catch (Exception $e) {

                info("Error: ". $e->getMessage());
            }
        }

        return true;
    }
}
