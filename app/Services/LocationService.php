<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LocationService
{
    /**
     * @return string[]
     */
    public function weekDays (): array
    {
        return [
            '1' => 'Mon',
            '2' => 'Tue',
            '3' => 'Wed',
            '4' => 'Thu',
            '5' => 'Fri',
            '6' => 'Sat',
            '0' => 'Sun',
        ];

    }

    /**
     * @param $providerAvailabilityDayOfWeeks
     * @return array
     */
    public function providerDisableWeekDays ($providerAvailabilityDayOfWeeks): array
    {
        $weekDays = $this->weekDays();
        $disableWeekDays = [];
        foreach ($weekDays as $key => $day)
        {
            if (!in_array($key,$providerAvailabilityDayOfWeeks))
            {
                $disableWeekDays[] = $key;
            }
        }
         return $disableWeekDays;
    }
}
