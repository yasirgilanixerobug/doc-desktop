<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Models\Location;
use App\Services\LocationService;
use App\Traits\MyAuthData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
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
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $searchParam = (isset($request->q)) ? $request->q  : '';
        $roleNotOwner = $this->authUserIsOwner != true;
        $locations = Location::filterRecord($searchParam)
            ->when($roleNotOwner, function($q) {
                $q->whereIn('id', $this->authUserLocationId);
            })
            ->where('clinic_id', $this->authUser->clinic_id)
            ->with(['clinic', 'businessHour'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('clinic.location.index', compact('locations'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('clinic.location.create');
    }

    /**
     * @param LocationRequest $request
     * @return RedirectResponse
     */
    public function store(LocationRequest $request)
    {
        $requestValidated = $request->validated();
        $requestLocation = array_merge($requestValidated, ['clinic_id' => $this->authUser->clinic_id]);
        $location = Location::create($requestLocation);

        return redirect()->route('clinic.location.index')->with('success', 'Create Location Successfully');
    }

    /**
     * @param $id
     * @param LocationService $locationService
     * @return Application|Factory|View
     */
    public function show($id, LocationService $locationService)
    {
        $model = Location::where(['id' => $id])
            ->with([
                //'locationProvider.provider.userDetail',
                'businessHour',
                'locationProvider' => function($q){
                    $q->whereHas(
                        'provider', function($pro) {
                        $pro->where('deleted_at', null)->with('userDetail');
                    });
                },
                'locationStaff' => function($q){
                    $q->whereHas(
                        'staff', function($pro) {
                        $pro->where('deleted_at', null)->with('userDetail');
                    });
                },
            ])
            ->first();

        $weekDays = $locationService->weekDays();
        return view('clinic.location.show', compact('model', 'weekDays'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $model = Location::find($id);
        return view('clinic.location.edit', compact('model'));
    }

    /**
     * @param LocationRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(LocationRequest $request, $id)
    {
        $requestValidated = $request->validated();
        $model = Location::find($id);
        $location = $model->update($requestValidated);

        return redirect()->route('clinic.location.index')->with('success', 'Update Location Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
