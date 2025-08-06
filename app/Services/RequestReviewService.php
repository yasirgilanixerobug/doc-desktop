<?php

namespace App\Services;


use App\Models\RequestReview;
use Illuminate\Support\Facades\Auth;

class RequestReviewService {

    /**
     * @param $requestData
     * @return array
     */
    function patients($requestData): array
    {
        if (isset($requestData['provider']) && $requestData['provider'] != null) {
            $followUps = RequestReview::where([
                    'clinic_id' => Auth::user()->clinic_id, 
                    'provider' => $requestData['provider'], 
                    'sms_status' => 0
                ])
                ->with('clinic')
                ->distinct(['mobile_phone'])
                ->get()
            ->toArray();
            
            return $followUps;

        } elseif (isset($requestData['location']) && $requestData['location'] != null) {
            $followUps = RequestReview::where([
                    'clinic_id' => Auth::user()->clinic_id, 
                    'location' => $requestData['location'], 
                    'sms_status' => 0
                ])
                ->with('clinic')
                ->distinct(['mobile_phone'])
                ->get()
            ->toArray();

            return $followUps;

        } else
        {
            return $followUps = [];
        }
    }


    /**
     * @return string[]
     */
    function bulkFormatHeading (): array
    {
        return [
            'AppointmentTime',
            'Patient',
            'DOB',
            'MobilePhone',
            'SeenBy',
            'Facility',
        ];
    }
}
