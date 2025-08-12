<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderRequest;
use App\Models\Gender;
use App\Models\StaffLocation;
use App\Models\Role;
use App\Models\User;
use App\Services\ProviderService;
use App\Traits\MyAuthData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProviderController extends Controller
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
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $searchParam = (isset($request->q)) ? $request->q  : '';
        $roleNotOwner = $this->getAuth['isRoleOwner'] != true;

        $models = User::filterRecord($searchParam)
            ->where('clinic_id', $this->authUser->clinic_id)
            ->when($roleNotOwner, function($q) {
                $q->whereHas('providerLocation', function($q) {
                    $q->whereHas('location', function ($qa) {
                        $qa->whereIn('id', $this->authUserLocationId);
                    });
                });
            })
            ->whereHas('roles', function($q){
                $q->whereIn('id', [Role::PROVIDER]);
            })
            ->with([
                'roles',
                'userDetail',
                'providerLocation.location'
            ])
            ->orderBy('id', 'desc')->paginate(10);

        return view('clinic.provider.index', compact('models'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $genders = Gender::all();
        $staffLocations = StaffLocation::where([
            'staff_id' => $this->authUser->id
        ])->with(['location'])->get();
        
        return view('clinic.provider.create', compact('genders', 'staffLocations'));
    }

    /**
     * @param ProviderRequest $request
     * @param ProviderService $providerService
     * @return RedirectResponse
     */
    public function store(ProviderRequest $request, ProviderService $providerService)
    {
        $requestValidated = $request->validated();
        $requestValidated['location_id'] = $request->location_id ?? null;
        
        $provider = $providerService->register($requestValidated);
        return redirect()->route('clinic.provider.index')->with('success', 'Create Provider Successfully');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        //Staff Model
        $model = User::where('id', $id)
            ->with([
                'status',
                'userDetail',
                'providerLocation.location',
                'providerHoliday' => function($q){
                    $q->whereYear('start_date', date('Y'));
                },
            ])
            ->first();

        return view('clinic.provider.show', compact('model'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $model = User::find($id);
        $genders = Gender::all();
        return view('clinic.provider.edit', compact('model', 'genders'));
    }

    /**
     * @param ProviderRequest $request
     * @param $id
     * @param ProviderService $providerService
     * @return RedirectResponse
     */
    public function update(ProviderRequest $request, $id, ProviderService $providerService)
    {
        $requestValidated = $request->validated();
        $model = User::find($id);
        $staff = $providerService->update($requestValidated, $model);
        return redirect()->route('clinic.provider.index')->with('success', 'Update Provider Successfully');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        User::where('id', $id)->delete();
        return redirect()->route('clinic.provider.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function trashed()
    {
        $roleNotOwner = $this->getAuth['isRoleOwner'] != true;

        $users = User::where('clinic_id', $this->authUser->clinic_id)
            ->onlyTrashed()
            ->whereHas('roles', function($q){
                $q->whereIn('id', [Role::PROVIDER]);
            })
            ->when($roleNotOwner, function($q){
                $q->whereHas('providerLocation', function($q) {
                    $q->whereHas('location', function ($qa) {
                        $qa->whereIn('id', $this->authUserLocationId);
                    });
                });
            })
            ->with(['userDetail', 'roles', 'providerLocation.location'])->get();

        return view('clinic.provider.trashed', compact('users'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function restore($id): RedirectResponse
    {
        User::withTrashed()->where('id', $id)->restore();
        return redirect()->route('clinic.provider.index');
    }
}
