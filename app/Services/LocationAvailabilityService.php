<?php

namespace App\Services;

use App\Models\ProviderHoliday;
use Carbon\CarbonPeriod;
use Nette\Utils\DateTime;
use DateInterval;
use DatePeriod;

class LocationAvailabilityService
{
    const IS_APPOINTMENT = 1;
    const NOT_APPOINTMENT  = 0;

    /**
     * @param $interval
     * @param $start_time
     * @param $end_time
     * @param $date
     * @param $appointments
     * @param array $holidays
     * @return array
     * @throws \Exception
     */
    function getAvailableTimeSlot($interval, $start_time, $end_time, $date, $appointments, $holidays = []): array
    {
        $start = new DateTime($start_time);
        $end = new DateTime($end_time);
        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');

        $currentDateTime = new DateTime();
        $currentDate = date('Y-m-d');
        $currentTime = $currentDateTime->format('H:i');

        $i=0;
        $time = [];

        if (!in_array($date, $holidays))
        {
            while(strtotime($startTime) <= strtotime($endTime))
            {
                $start = $startTime;
                $end = date('H:i',strtotime('+'.$interval.' minutes', strtotime($startTime)));
                $startTime = date('H:i',strtotime('+'.$interval.' minutes', strtotime($startTime)));
                $i++;

                if ($currentDate == $date)
                {
                    if($currentTime < $start)
                    {
                        $time = $this->makeTimeSlot($time, $date, $start, $end, $appointments, $i);
                    }
                } else {
                    $time = $this->makeTimeSlot($time, $date, $start, $end, $appointments, $i);
                }
            }
        }

        return $time;
    }

    /**
     * @param $time
     * @param $date
     * @param $start
     * @param $end
     * @param $appointments
     * @param $i
     * @return array
     */
    public function makeTimeSlot($time, $date, $start, $end, $appointments, $i): array
    {
        $time[$i]['date'] = $date;
        $time[$i]['start_time'] = date('h:i a', strtotime($start));
        $time[$i]['end_time'] = date('h:i a', strtotime($end));
        $timeSlotWithHalfDay = date('h:i a', strtotime($start));
        $time[$i]['isAppointment'] =  in_array($timeSlotWithHalfDay, $appointments) ? self::IS_APPOINTMENT : self::NOT_APPOINTMENT;

        return $time;
    }

    /**
     * @param $provider
     * @return array
     */
    public function getProviderHoliday($provider): array
    {
        $holidayDates = [];
        $providerHoliday = [];
        $currentDate = date("Y-m-d");
        if (isset($provider->id)) {
            $providerHoliday = ProviderHoliday::where('provider_id', $provider->id)
                ->whereDate('end_date', '>=' , $currentDate)
                ->get();
        }
        
        foreach ($providerHoliday as $keyHoliday => $holiday)
        {
            $period = CarbonPeriod::create($holiday->start_date, $holiday->end_date);

            // Iterate over the period
            foreach ($period as $date) {
                array_push($holidayDates, $date->format('Y-m-d'));
            }
        }

        return $holidayDates;
    }



    /**
     * @param $interval
     * @param $start_time
     * @param $end_time
     * @param $date
     * @param $appointments
     * @param array $holidays
     * @return array
     * @throws \Exception
     */
    function getAvailableTimeSlotApi($interval, $start_time, $end_time, $date, $appointments, $holidays = []): array
    {
        $start = new DateTime($start_time);
        $end = new DateTime($end_time);
        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');

        $currentDateTime = new DateTime();
        $currentDate = date('Y-m-d');
        $currentTime = $currentDateTime->format('H:i');

        $i=0;
        $time = [];

        if (!in_array($date, $holidays))
        {
            while(strtotime($startTime) <= strtotime($endTime))
            {
                $start = $startTime;
                $end = date('H:i',strtotime('+'.$interval.' minutes', strtotime($startTime)));
                $startTime = date('H:i',strtotime('+'.$interval.' minutes', strtotime($startTime)));
                $i++;

                if ($currentDate == $date)
                {
                    if($currentTime < $start)
                    {
                        $time = $this->makeTimeSlotApi($time, $date, $start, $end, $appointments, $i);
                    }
                } else {
                    $time = $this->makeTimeSlotApi($time, $date, $start, $end, $appointments, $i);
                }
            }
        }

        return $time;
    }

    /**
     * @param $time
     * @param $date
     * @param $start
     * @param $end
     * @param $appointments
     * @param $i
     * @return array
     */
    public function makeTimeSlotApi($time, $date, $start, $end, $appointments, $i): array
    {
        $timeSlotWithHalfDay = date('h:i a', strtotime($start));
        $time[] = [
            'date' => $date,
            'start_time' => date('h:i a', strtotime($start)),
            'end_time' => date('h:i a', strtotime($end)),
            'isAppointment' => in_array($timeSlotWithHalfDay, $appointments) ? 1 : 0,
        ];

        return $time;
    }


    /**
     * @param $providerHolidays
     * @return array
     */
    public function getApiProviderHoliday($providerHolidays): array
    {
        $holidayDates = [];
        foreach ($providerHolidays as $keyHoliday => $holiday)
        {
            $period = CarbonPeriod::create($holiday->start_date, $holiday->end_date);

            // Iterate over the period
            foreach ($period as $date) {
                array_push($holidayDates, $date->format('Y-m-d'));
            }
        }

        return $holidayDates;
    }

    /**
     * @param $start
     * @param $end
     * @param string $format
     * @return array
     * @throws \Exception
     */
    function getDatesFromRange($start, $end, $format = 'Y-m-d'): array
    {
        // Declare an empty array
        $array = [];

        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        // Use loop to store date into array
        foreach($period as $date) {
            $array[] = $date->format($format);
        }

        // Return the array elements
        return $array;
    }
}
