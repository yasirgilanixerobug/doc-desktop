<?php

namespace App\Http\Controllers\Clinic;

use App\Exports\AppointmentExport;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\Location;
use App\Traits\MyAuthData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;

class ReportingController extends Controller
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
        $authClinicId = $this->authUser->clinic_id;
        $roleNotOwner = $this->getAuth['isRoleOwner'] != true;
        $locationId = $this->getAuth['staffLocationId'];
        $requestAppointmentStatusId = $request->appointment_status_id;
        $requestLocationId = $request->location_id;
        $requestQ = $request->q;

        if ($request->has('daterange') && $request->daterange != null)
        {
            $dates = explode('-',$request->daterange);
            $from = date('Y-m-d', strtotime($dates[0]));
            $to = date('Y-m-d', strtotime($dates[1]));
        } else {
            $from = date('Y-m-d');
            $to = date('Y-m-d', strtotime('+7 days'));
        }

        $statuses = AppointmentStatus::all();
        $locations = Location::where(['clinic_id' => $authClinicId])
            ->when($roleNotOwner, function($q) use($locationId){
                $q->whereIn('id',  $locationId);
            })->get();

        $appQuery = Appointment::query();
        $appQuery->where(['clinic_id' => $authClinicId])
            ->when(($request->has('appointment_status_id') && $requestAppointmentStatusId != null), function($q) use($requestAppointmentStatusId){
                $q->where('appointment_status_id',  $requestAppointmentStatusId);
            })
            ->when(($request->has('q') && $requestQ != null), function($q) use($requestQ){
                $q->filter($requestQ);
            });

        if ($request->has('location_id') && $requestLocationId != null)
        {
            // simple where here or another scope, whatever you like
            $appQuery->where('location_id', $requestLocationId);
        } else if ($this->getAuth['isRoleOwner'] != true){
            $appQuery->whereIn('location_id', $this->getAuth['staffLocationId']);
        }

        $appointments =  $appQuery->whereBetween('date', [$from, $to])
            ->with([
                'userable',
                'location',
                'provider',
                'status',
            ])
            ->orderBy('date', 'ASC')
            ->paginate(10);

        // set data
        $data = [
            "appointment_status_id" => $requestAppointmentStatusId,
            "location_id" => $requestLocationId,
            "date_from" => $from,
            "date_to" => $to,
            "query" => $requestQ,
        ];

        // storing $data to session
        Session::put('reporting', $data);

        return view('clinic.reporting.index',
            compact('appointments', 'locations', 'statuses', 'from', 'to'));
    }

    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function indexDatatable(): \Illuminate\View\View
    {
        $authClinicId = $this->authUser->clinic_id;
        $from = date('Y-m-d');
        $to = date('Y-m-d', strtotime('+7 days'));

        $locations = Location::where('clinic_id', $authClinicId)->get();
        $statuses = AppointmentStatus::all();

        return view('clinic.reporting.index',
            compact('locations', 'statuses', 'from', 'to'));
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function data(Request $request)
    {
        $searchParam = (isset($request->q)) ? $request->q  : '';
        $authClinicId = $this->authUser->clinic_id;

        $appQuery = Appointment::query();
        $appointments =  $appQuery->where(['clinic_id' => $authClinicId])
            ->with([
                'userable',
                'location',
                'provider',
                'status',
            ])
            ->orderBy('date', 'ASC');

        return Datatables::eloquent($appointments)
            ->editColumn('date', function ($data) {
                return date(config('app.default_date_format'), strtotime($data->date));
            })
            ->editColumn('userable.phone', function ($data) {
                return ($data->userable->phone != null || $data->userable->phone != '')  ? $data->userable->phone : 'N\A'; // human readable format
            })
            ->addColumn('location', function ($data) {
                return $data->location->name;
            })
            ->addColumn('provider', function ($data) {
                return $data->provider->name;
            })
            ->addColumn('status', function ($data) {
                return $data->status->name;
            })
            ->make(true);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|BinaryFileResponse
     */
    public function export(Request $request)
    {
        $sessionReportingData = $request->session()->get('reporting');
        $searchParam = (isset($sessionReportingData['query'])) ? $sessionReportingData['query']  : '';
        $authClinicId = $this->authUser->clinic_id;
        $requestAppointmentStatusId = $sessionReportingData['appointment_status_id'];
        $requestLocationId = $sessionReportingData['location_id'];
        $requestQ = $sessionReportingData['query'];
        $from = date('Y-m-d', strtotime($sessionReportingData['date_from']));
        $to = date('Y-m-d', strtotime($sessionReportingData['date_to']));

        $appQuery = Appointment::query();
        $appQuery->where(['clinic_id' => $authClinicId])
            ->when(($request->has('appointment_status_id') && $requestAppointmentStatusId != null), function($q) use($requestAppointmentStatusId){
                $q->where('appointment_status_id',  $requestAppointmentStatusId);
            })
            ->when(($requestQ != null), function($q) use($requestQ){
                $q->filter($requestQ);
            });

        if ($requestLocationId != null)
        {
            // simple where here or another scope, whatever you like
            $appQuery->where('location_id', $requestLocationId);
        } else if ($this->getAuth['isRoleOwner'] != true){
            $appQuery->whereIn('location_id', $this->getAuth['staffLocationId']);
        }

        $appointments =  $appQuery->whereBetween('date', [$from, $to])
            ->with([
                'userable',
                'location',
                'provider',
                'status',
            ])
            ->orderBy('date', 'ASC')
            ->get();

        if (count($appointments) === 0)
        {
            return back()->with('error', 'No Record Found For Export');
        }

        return Excel::download(new AppointmentExport($appointments), 'report.xlsx');
    }
}
