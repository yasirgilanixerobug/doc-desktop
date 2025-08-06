<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\ProviderLocation;
use App\Models\ProviderLocationAvailability;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LocationAvailabilityController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    function create(Request $request)
    {
        $providerLocationId = $request->provider_location_id;
        $providerLocation = ProviderLocation::where('id', $providerLocationId)
            ->with([
                'provider',
                'location.businessHour' => function($q){
                    $q->where('is_available', 1);
                },
            ])->first();

        $providerName = ($providerLocation->provider) ? $providerLocation->provider->name : "N\A";
        $locationName = ($providerLocation->location) ? $providerLocation->location->name : "N\A";

        $locationBusinessDays = $providerLocation->location->businessHour->pluck('day_of_week')->toArray();

        $findLocation = ProviderLocationAvailability::where('provider_location_id', $providerLocationId)->first();
        if ($findLocation != null)
        {
            return redirect()->back()->with('message','Location already created');
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
        return view('clinic.location-availability.create', compact('providerLocationId', 'dayTime', 'locationBusinessDays', 'locationName','providerName'));
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
                    'provider_location_id' => $request->provider_location_id,
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
            ProviderLocationAvailability::insert($insert);
        }

        return redirect()->route('clinic.provider.index')->with('success', 'Create Location Availability Successfully');
    }


    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    function edit(Request $request)
    {
        $providerLocationId = $request->provider_location_id;
        $providerLocationAvailability = ProviderLocationAvailability::where('provider_location_id', $providerLocationId)->get()->toArray();

        $providerLocation = ProviderLocation::where('id', $providerLocationId)
            ->with([
                'provider',
                'location.businessHour' => function($q){
                    $q->where('is_available', 1);
                },
            ])->first();
        $providerName = ($providerLocation->provider) ? $providerLocation->provider->name : "N\A";
        $locationName = ($providerLocation->location) ? $providerLocation->location->name : "N\A";

        $locationBusinessDays = $providerLocation->location->businessHour->pluck('day_of_week')->toArray();

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
        foreach ($providerLocationAvailability as $key => $locationAvailability)
        {
            $locationDayWorkingTime[$locationAvailability['day_of_week']] = [
                'start_time' => $locationAvailability['start_time'],
                'end_time' => $locationAvailability['end_time'],
                'is_available' => $locationAvailability['is_available'],
            ];
        }

        return view('clinic.location-availability.edit', compact('locationDayWorkingTime','providerLocationAvailability','providerLocationId', 'dayTime', 'locationBusinessDays', 'locationName','providerName'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    function update(Request $request)
    {
        $requestLocationAvailability = $request->only('locationAvailability')['locationAvailability'];
        $providerLocationId = $request->provider_location_id;
        $locationAvailabilities = ProviderLocationAvailability::where('provider_location_id', $providerLocationId)->get();
        $providerLocationAvailabilities = $locationAvailabilities->mapWithKeys(function ($item) {
            return [$item['id'] => $item['day_of_week']];
        });
        $providerLocationAvailabilitiesArray  = $providerLocationAvailabilities->all();

        foreach ($requestLocationAvailability as $key => $locationAvailability)
        {
            $dayKey = $key;

            $record = [
                'provider_location_id' => $request->provider_location_id,
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
                    ProviderLocationAvailability::where([
                        'id' => $providerLocationAvailabilityId,
                        'provider_location_id' => $request->provider_location_id,
                    ])
                        ->update($record);

                } else {
                    $record = array_merge($record, ['is_available' => 1]);
                    ProviderLocationAvailability::create($record);
                }

            } else {
                if (in_array($dayKey, $providerLocationAvailabilitiesArray))
                {
                    $providerLocationAvailabilityId = array_search($dayKey, $providerLocationAvailabilitiesArray);
                    $record = array_merge($record, ['is_available' => 0]);
                    ProviderLocationAvailability::where([
                        'id' => $providerLocationAvailabilityId,
                        'provider_location_id' => $request->provider_location_id,
                    ])
                        ->update($record);
                }
            }
        }

        return redirect()->route('clinic.provider.index')->with('success', 'Update Location Availability Successfully');
    }
}
