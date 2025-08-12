<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProviderListingRequest;
use App\Traits\MyAuthData;
use App\Models\ProviderListing;
use App\Models\Location;
use App\Models\Status;
use App\Models\Role;
use App\Models\User;
use App\Models\ProviderLocation;

class ProviderListingController extends Controller
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
     * Show the Provider Listing Index
     *
     * @return \Illuminate\Http\Response
    */
    public function index ()
    {
        $locations = Location::where('clinic_id', $this->authUser->clinic_id)
            ->with(['clinic'])
            ->latest('id')
            ->paginate(10, ['*'], 'locations-page'); // Use 'locations-page' for the paginator to avoid conflicts with other paginations on this page.

        $providerListings = ProviderListing::where('clinic_id', $this->authUser->clinic_id)
            ->with(['provider.userDetail', 'location', 'status'])
            ->latest('id')
            ->paginate(10, ['*'], 'doctors-page'); // Use 'doctors-page' for the paginator to avoid conflicts with other paginations on this page.  

        return view('clinic.review-request.provider-listings.index', compact('locations','providerListings'));
    }

    public function getLocations(Request $request)
    {
        $authUserClinicId = Auth::user()->clinic_id;
        $providerId = $request->provider_id;

        
        $providerLocationListingIds = ProviderListing::where([
            'clinic_id' => $authUserClinicId, 
            'status_id' => Status::ACTIVE,
            'provider_id' => $providerId
        ])
        ->get()
        ->pluck('location_id');

        $providerRemainingLocations = ProviderLocation::where(['status_id' => Status::ACTIVE, 'provider_id' => $providerId])
        ->whereNotIn('location_id', $providerLocationListingIds) // Exclude these locations
        ->with(['location'])
        ->get();
        
        
        return response()->json($providerRemainingLocations);
    }


    /**
     * Show the form for creating a new provider listing
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $authUserClinicId = Auth::user()->clinic_id;
        $providers = User::where(['clinic_id' => $authUserClinicId])
            ->whereHas('roles', function($q){
                $q->whereIn('id', [Role::PROVIDER]);
            })->latest('id')->get();

        
        return view('clinic.review-request.provider-listings.create',compact('providers'));
    }

    /**
     * Store a newly created provider listing in storage.
     *
     * @param ProviderListingRequest $request
     * @return RedirectResponse
    */
    public function store(ProviderListingRequest $request)
    {
        $providerListingRequestData = [
            'clinic_id' => Auth::user()->clinic_id,
            'provider_id' => $request->provider_id,
            'location_id' => $request->location_id,
            'status_id' => Status::ACTIVE,
            'google_review_url' => $request->google_review_url
        ];

        ProviderListing::create($providerListingRequestData);
        return redirect()->back()->with('success', 'Provider Listing Created Successfully');
    }

    /**
     * Show the form for editing the specified provider listing
     *
     * @param int $providerListingId
     * @return \Illuminate\Http\Response
     */
    public function edit($providerListingId)
    {
        $providerListing = ProviderListing::where(['id' => $providerListingId])->with(['location'])->first();
        
        return view('clinic.review-request.provider-listings.edit', compact(['providerListing']));    
    }

    /**
     * Update the specified provider listing in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $providerListingId
     * @return \Illuminate\Http\RedirectResponse
    */
    public function update(ProviderListingRequest $request, $providerListingId)
    {
        $providerListingRequestData = [
            'location_id' => $request->location_id,
            'google_review_url' => $request->google_review_url
        ];

        $providerListing = ProviderListing::where([
            'id' => $providerListingId
        ])->first();

        $providerListing->update($providerListingRequestData);
        return redirect()->back()->with('success', 'Provider Listing Updated Successfully');
    }

    /**
     * Remove the specified provider listing from storage.
     *
     * @param  int  $providerListingId
     * @return \Illuminate\Http\RedirectResponse
    */
    public function destroy($providerListingId)
    {
        $providerListing = ProviderListing::where([
            'id' => $providerListingId
        ])->first()->delete();
        
        return redirect()->back()->with('success', 'Provider Listing Deleted Successfully');
    }
}
