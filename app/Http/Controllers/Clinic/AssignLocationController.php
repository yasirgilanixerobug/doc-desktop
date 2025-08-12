<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignLocationRequest;
use App\Models\Location;
use App\Models\ProviderLocation;
use App\Models\Status;
use App\Models\User;
use App\Models\StaffLocation;
use App\Traits\MyAuthData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AssignLocationController extends Controller
{
    use MyAuthData;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->setAuthDataGlobaly();
            return $next($request);
        });
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function toProvider($id)
    {
        $providerId = $id;
        $roleNotOwner = $this->getAuth['isRoleOwner'] != true;
        $authClinicId  = $this->authUser->clinic_id;
        $clinicLocations = Location::where('clinic_id', $authClinicId)
            ->when($roleNotOwner, function($q){
                $q->whereIn('id', $this->authUserLocationId);
            })
            ->get();

        $provider = User::where('id', $providerId)
            ->with(['providerLocation'])
            ->first();

        $providerLocations = $provider->providerLocation ?? [];
        $providerLocationIds = count($providerLocations) > 0 ? $providerLocations->pluck('id')->toArray() : [];
        $activeLocation = [];

        foreach ($providerLocations as $key => $location)
        {
            $activeLocation[$location->location_id] = [
                'provider_location_id' => $location->id,
                'status_id' => $location->status_id,
            ];
        }

        $staffLocationIds = StaffLocation::where([
            'staff_id' => $this->authUser->id
        ])->pluck('location_id');

        $assignLocations = ProviderLocation::where(['provider_id' => $providerId, 'status_id' => Status::ACTIVE])
            ->when($roleNotOwner, function($q){
                $q->whereIn('location_id', $this->authUserLocationId);
            })
            ->with([
                'location',
                'providerLocationAvailability',
            ])->get();

        return view('clinic.assign-location.to-provider', compact(
            'clinicLocations',
            'provider',
            'providerLocationIds',
            'activeLocation',
            'staffLocationIds',
            'assignLocations',
        ));
    }

    /**
     * @param AssignLocationRequest $request
     * @return JsonResponse
     */
    public function storeOrUpdate(AssignLocationRequest $request): JsonResponse
    {
        $authClinicId  = Auth::user()->clinic_id;
        $providerId  = $request->provider_id;
        $locationId  = $request->location_id;
        $isLocationCheck  = $request->is_location_check;

        //check location exits in provider locations
        $findProviderLocation = ProviderLocation::where(['provider_id' => $providerId, 'location_id' => $locationId])->first();

        if (isset($findProviderLocation->provider_id))
        {
            $status = $isLocationCheck;
            if ($isLocationCheck === 'true')
            {
                $data = [
                    'status_id' => Status::ACTIVE,
                ];
                $message = 'Location active successfully';
            } else {
                $data = [
                    'status_id' => Status::TEMPORARY_BLOCK,
                ];
                $message = 'Location block successfully';
            }
            ProviderLocation::where(['provider_id' => $providerId, 'location_id' => $locationId])->update($data);

        } else {
            $status = $isLocationCheck;
            $data = [
                'provider_id' => $providerId,
                'location_id' => $locationId,
                'status_id' => Status::ACTIVE,
            ];

            ProviderLocation::create($data);
            $message = 'Location assign successfully';
        }

        return response()->json([
            'status' => $status,
            'message' => $message ?? 'Something wrong please try gain',
        ]);
    }
}
