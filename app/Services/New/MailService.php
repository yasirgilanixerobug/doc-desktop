<?php

namespace App\Services\New;

use App\Mail\NewAppointmentMail;
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
                    'clinic_name' => $this->appointmentData['clinic'],
                    'title' => 'Your appointment with '.$this->appointmentData['clinic'],
                    'body' => $message,
                    'data' => $this->appointmentData,
                    'is' => $key
                ];

                if ($key === 'staff_message') {
                    foreach ($this->appointmentData['location_staff_receptionists'] as $receptionistKey => $receptionist) {
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
