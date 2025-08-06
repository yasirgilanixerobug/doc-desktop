<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Models\Location;
use App\Models\User;
use App\Services\StaffService;
use App\Traits\MyAuthData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Role as RoleModel;

class StaffController extends Controller
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
            ->whereHas('roles', function($q){
                $q->whereIn('id', [RoleModel::RECEPTIONIST]);
            })
            ->when($roleNotOwner, function ($q){
                $q->whereHas('staffLocation', function($q) {
                    $q->whereHas('location', function ($qa) {
                        $qa->whereIn('id', $this->authUserLocationId);
                    });
                });
            })
            ->with(['roles','userDetail','staffLocation.location'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('clinic.staff.index', compact('models'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $roles = Role::whereIn('id', [RoleModel::RECEPTIONIST])->get();
        $locations = Location::where('clinic_id', $this->authUser->clinic_id)->get();
        return view('clinic.staff.create', compact('roles', 'locations'));
    }

    /**
     * @param StaffRequest $request
     * @param StaffService $staffService
     * @return RedirectResponse
     */
    public function store(StaffRequest $request, StaffService $staffService)
    {
        $requestValidated = $request->validated();
        $staff = $staffService->register($requestValidated);
        return redirect()->route('clinic.staff.index')->with('success', 'Create Staff Successfully');;
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
                'staffLocations.location',
            ])
            ->first();

        return view('clinic.staff.show', compact('model'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $model = User::where('id', $id)->with(['userDetail','staffLocation'])->first();
        $roles = Role::whereIn('id', [RoleModel::RECEPTIONIST])->get();
        $locations = Location::where('clinic_id', $this->authUser->clinic_id)->get();
        return view('clinic.staff.edit', compact('model', 'roles', 'locations'));
    }

    /**
     * @param StaffRequest $request
     * @param $id
     * @param StaffService $staffService
     * @return RedirectResponse
     */
    public function update(StaffRequest $request, $id, StaffService $staffService)
    {
        $requestValidated = $request->validated();
        $model = User::find($id);
        $staff = $staffService->update($requestValidated, $model);

        return redirect()->route('clinic.staff.index')->with('success', 'Update Staff Successfully');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        User::where('id', $id)->delete();
        return redirect()->route('clinic.staff.index');
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
                $q->whereIn('id', [RoleModel::RECEPTIONIST]);
            })
            ->when($roleNotOwner, function ($q){
                $q->whereHas('staffLocation', function($q) {
                    $q->whereHas('location', function ($qa) {
                        $qa->whereIn('id', $this->authUserLocationId);
                    });
                });
            })->with(['userDetail', 'roles', 'staffLocation.location'])->get();


        return view('clinic.staff.trashed', compact('users'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function restore($id): RedirectResponse
    {
        User::withTrashed()->where('id', $id)->restore();
        return redirect()->route('clinic.staff.index');
    }
}
