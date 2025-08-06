<?php

namespace App\Services;

use App\Models\RequestReview;
use App\Services\MessageService;
use App\Services\TwilioService;
use Exception;
use Twilio\Exceptions\TwilioException;

class SmsService {

    private $messageService;
    private $twilioService;

    function __construct()
    {
        $this->messageService = new MessageService();
        $this->twilioService = new TwilioService();
    }

    /**
     * @param $appointmentData
     * @return bool
     */
    function appointmentMessage ($appointmentData): bool
    {
        $messages = $this->messageService->getAppointmentMessage($appointmentData);
        $sendTo = $this->messageService->smsSendTo($appointmentData);
        
        $i = 0;
        foreach ($messages as $key => $message)
        {
            try {
                if ($key === 'staff_message') {
                    foreach ($appointmentData['location_staff_receptionists'] as $receptionistKey => $receptionist) {
                        if (isset($receptionist['phone']) && $receptionist['phone'] != null)
                        {
                            $this->twilioService->sendMessage($receptionist['phone'],$message);
                        }
                    }
                } else {

                    if ($key === 'patient_message') {
                        if (isset($appointmentData['ins_upload_expire_link']) && $appointmentData['ins_upload_expire_link']) {
                            $message = $message. ' You can upload your insurance document here '. $appointmentData['ins_upload_expire_link'];
                        }
                    }

                    if ($sendTo[$i] != null)
                    {
                        $this->twilioService->sendMessage($sendTo[$i],$message);
                    }

                    $i++;
                }

            } catch (Exception $e) {

                info("Error: ". $e->getMessage());

                // Continue to the next message even if an error occurs
                continue;
            }
        }

        return true;
    }

    /**
     * @param array $appointments
     * @return bool
     * @throws TwilioException
     */
    function sendReviewMessages (array $appointments): bool
    {
        $reviewFollowUpIds = [];
        foreach ($appointments as $key => $data)
        {
            try {
                $message = $this->messageService->getRequestReviewMessage($data);
                $sendMessage = $this->twilioService->sendMessage('+1'.$data['mobile_phone'],$message);

                if ($sendMessage->status == "sent" || $sendMessage->status == "queued") {
                    $reviewFollowUpIds[] = $data['id'];
                }
            } catch (Exception $e) {
                // Log the error for debugging purposes
                info("Error: ". $e->getMessage());
                
                // Continue to the next message even if an error occurs
                continue;
            }
        }

        if (!empty($reviewFollowUpIds)) {
            RequestReview::whereIn('id', $reviewFollowUpIds)
                ->update(['sms_status' => RequestReview::SEND]);
        }

        return true;
    }
}
