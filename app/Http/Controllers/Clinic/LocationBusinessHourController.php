<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\LocationBusinessHour;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LocationBusinessHourController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    function create(Request $request)
    {
        $locationId = $request->location_id;
        $location = Location::find($locationId);

        $findLocation = LocationBusinessHour::where('location_id', $locationId)->first();
        $locationName = $location->name;

        if ($findLocation != null)
        {
            return redirect()->back()->with('message','Business Location already created');
        }

        $hourMint = [];
        $hours = ['12','01','02','03','04','05','06','07','08','09','10','11'];
        foreach (['am','pm'] as $key => $dayHalf)
        {
            foreach ($hours as $hourKey => $hour)
            {
                for ($mint = 0; $mint < 60; $mint++)
                {
                    $mintValue = ($mint >= 10) ? $mint : '0'.$mint;
                    $hourMint[] = [
                        $hour.':'.$mintValue.' '.$dayHalf,
                    ];
                    $mint = $mint + 4;
                }
            }
        }

        $dayTime = Arr::flatten($hourMint);
        return view('clinic.location-business-hour.create', compact('locationId', 'dayTime', 'locationName'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    function store(Request $request)
    {
        $requestLocationAvailability = $request->only('locationAvailability')['locationAvailability'];
        $insertLocationAvailability = [];
        foreach ($requestLocationAvailability as $key => $locationAvailability)
        {
            $dayKey = $key;
            if (isset($locationAvailability['day']))
            {
                $insert[] = [
                    'location_id' => $request->location_id,
                    'day_of_week' => $dayKey,
                    'start_time' => $locationAvailability['start_time'],
                    'end_time' => $locationAvailability['end_time'],
                    'is_available' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($insert))
        {
            LocationBusinessHour::insert($insert);
        }

        return redirect()->route('clinic.location.index')->with('success', 'Create Location Business Hours Successfully');
    }


    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    function edit(Request $request)
    {
        $locationId = $request->location_id;
        $locationBusinessHours = LocationBusinessHour::where('location_id', $locationId)->with(['location'])->get()->toArray();

        $hourMint = [];
        $hours = ['12','01','02','03','04','05','06','07','08','09','10','11'];
        foreach (['am','pm'] as $key => $dayHalf)
        {
            foreach ($hours as $hourKey => $hour)
            {
                for ($mint = 0; $mint < 60; $mint++)
                {
                    $mintValue = ($mint >= 10) ? $mint : '0'.$mint;
                    $hourMint[] = [
                        $hour.':'.$mintValue.' '.$dayHalf,
                    ];
                    $mint = $mint + 4;
                }
            }
        }

        $dayTime = Arr::flatten($hourMint);

        //location
        $locationDayWorkingTime = [];
        foreach ($locationBusinessHours as $key => $locationAvailability)
        {
            $locationDayWorkingTime[$locationAvailability['day_of_week']] = [
                'start_time' => $locationAvailability['start_time'],
                'end_time' => $locationAvailability['end_time'],
                'is_available' => $locationAvailability['is_available'],
            ];
        }

        return view('clinic.location-business-hour.edit', compact('locationDayWorkingTime','locationBusinessHours','locationId', 'dayTime'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    function update(Request $request)
    {
        $requestLocationAvailability = $request->only('locationAvailability')['locationAvailability'];
        $locationId = $request->location_id;
        $locationBusinessHour = LocationBusinessHour::where('location_id', $locationId)->get();
        $locationBusinessHours = $locationBusinessHour->mapWithKeys(function ($item) {
            return [$item['id'] => $item['day_of_week']];
        });
        $providerLocationAvailabilitiesArray  = $locationBusinessHours->all();

        foreach ($requestLocationAvailability as $key => $locationAvailability)
        {
            $dayKey = $key;

            $record = [
                'location_id' => $locationId,
                'day_of_week' => $dayKey,
                'start_time' => $locationAvailability['start_time'],
                'end_time' => $locationAvailability['end_time'],
            ];

            if (isset($locationAvailability['day']))
            {
                if (in_array($dayKey, $providerLocationAvailabilitiesArray))
                {
                    $providerLocationAvailabilityId = array_search($dayKey, $providerLocationAvailabilitiesArray);
                    $record = array_merge($record, ['is_available' => 1]);
                    LocationBusinessHour::where([
                        'id' => $providerLocationAvailabilityId,
                        'location_id' => $locationId,
                    ])
                        ->update($record);

                } else {
                    $record = array_merge($record, ['is_available' => 1]);
                    LocationBusinessHour::create($record);
                }

            } else {
                if (in_array($dayKey, $providerLocationAvailabilitiesArray))
                {
                    $providerLocationAvailabilityId = array_search($dayKey, $providerLocationAvailabilitiesArray);
                    $record = array_merge($record, ['is_available' => 0]);
                    LocationBusinessHour::where([
                        'id' => $providerLocationAvailabilityId,
                        'location_id' => $locationId,
                    ])
                        ->update($record);
                }
            }
        }

        return redirect()->route('clinic.location.index')->with('success', 'Update Location Business Hours Successfully');;
    }
}
