<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\Clinic;
use App\Models\Location;
use App\Models\User;
use App\Services\TwilioService;
use App\Traits\MyAuthData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class ClinicController extends Controller
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
     * In view viewPendingAppointment data pass from PendingAppointmentComposer from laravel view composer
     */
    public function dashboard(TwilioService $twilioService)
    {
        $authClinicId = $this->authUser->clinic_id;
        $roleNotOwner = $this->getAuth['isRoleOwner'] != true;
        $locationId = $this->getAuth['staffLocationId'];
        $locationProviderList = [];
        $locationAppointmentsOfProvider = [];
        $twilioPayment = $twilioService->checkBalance();
        
        //clinic query cunt
        $clinic = Clinic::where(['id' => $authClinicId])
            ->withCount([
                'locations as locations_count' => function($q) use($roleNotOwner) {
                    $q->when($roleNotOwner, function($q){
                        $q->whereIn('id', $this->getAuth['staffLocationId']);
                    });
                },
                'providers as providers_count' => function ($q) use($roleNotOwner) {
                    $q->when($roleNotOwner, function($q){
                        $q->whereRelation('providerLocation', 'location_id', '=', $this->getAuth['staffLocationId']);
                    });
                },
                'staffs as staffs_count' => function ($q) use($roleNotOwner) {
                    $q->when($roleNotOwner, function($q) {
                        $q->whereRelation('staffLocation', 'location_id', '=', $this->getAuth['staffLocationId']);
                    });
                },
            ])->first();

        //count total appointments each location provider
        if ($roleNotOwner)
        {
            $providerAppointments = Appointment::select('provider_id',  DB::raw('count(*) as count'))->where(['clinic_id' => $authClinicId, 'location_id' => $locationId])
                ->whereYear('date', date('Y'))
                ->whereHas('provider', function($q){
                    $q->whereNull('deleted_at');
                })
                ->with('provider')
                ->groupBy('provider_id')
                ->get();
            $locationProviderList = $providerAppointments->pluck('provider.name')->toArray();
            $locationAppointmentsOfProvider = $providerAppointments->pluck('count')->toArray();
        }

        //location Appointment vivas query
        $locationAppointments = Location::select(['id','name'])
            ->when($roleNotOwner, function($q) use($locationId){
                $q->whereIn('id', $locationId);
            })
            ->where(['clinic_id' => $authClinicId])
            ->withCount('appointments')->get();
        $clinicLocations = $locationAppointments->pluck('name')->toArray();
        $totalLocationAppointments = $locationAppointments->pluck('appointments_count')->toArray();
        $totalAppointments = array_sum($totalLocationAppointments);

        //make sub domain
        $clinicSubDomain = $clinic->sub_domain;
        $mainSiteUrl = config('app.short_url');
        $visitSite = 'https://'.$clinicSubDomain.'.'.$mainSiteUrl;

        return view('clinic.dashboard', compact(
            'clinic',
            'clinicSubDomain',
            'clinicLocations',
            'totalLocationAppointments',
            'visitSite',
            'locationAppointmentsOfProvider',
            'locationProviderList',
            'twilioPayment',
            'totalAppointments'
        ));
    }

    /**
     * @return Application|Factory|View
     */
    public function calendar(Request $request)
    {
        $authClinicId = $this->authUser->clinic_id;
        $roleNotOwner = $this->getAuth['isRoleOwner'] != true;
        $hasStaffLocationId = ($roleNotOwner) ? $this->getAuth['staffLocationId'] : null;
        $nextMonthDateFrame = Carbon::now()->addDays(60)->toDateString();
        $preMonthDateFrame = Carbon::now()->addDays(-60)->toDateString();

        $providers = User::where('clinic_id', $authClinicId)
            ->when($roleNotOwner, function ($q) use($hasStaffLocationId) {
                $q->whereHas('providerLocation', function($q) use($hasStaffLocationId){
                    $q->whereIn('location_id', $hasStaffLocationId);
                });
            })
            ->whereHas('roles', function($q){
                $q->where('id', 3);
            })
            ->with(['roles'])
            ->select(['id', 'name'])->get();


        $appointmentStatus = AppointmentStatus::whereIn('id', [
            AppointmentStatus::PENDING_APPROVAL['id'],
            AppointmentStatus::COMPLETE['id'],
            AppointmentStatus::CANCELLED_BY_PROVIDER['id'],
            AppointmentStatus::NO_SHOW['id'],
            AppointmentStatus::CONFIRMED['id'],
        ])
            ->select(['id', 'name'])
            ->get()
            ->map(function(AppointmentStatus $status){
                switch ($status->id)
                {
                    case AppointmentStatus::COMPLETE['id']:
                        $color = 'text-success';
                        break;
                    case AppointmentStatus::CANCELLED_BY_PROVIDER['id']:
                        $color = 'text-warning';
                        break;
                    case AppointmentStatus::NO_SHOW['id']:
                        $color = 'text-danger';
                        break;
                    case AppointmentStatus::CONFIRMED['id']:
                        $color = 'text-blue';
                        break;

                    default:
                        $color = 'text-gray';
                }

                return [
                    'id' => $status->id,
                    'name' => $status->name,
                    'color' => $color,
                ];
        });

        $clinicAppointments =  Appointment::where(['clinic_id' => $authClinicId ])
            ->when($roleNotOwner, function ($q) use($hasStaffLocationId) {
                return $q->whereIn('location_id', $hasStaffLocationId);
            })
            ->when((isset($request->provider_id) && $request->provider_id != null), function ($q) use($request) {
                return $q->where(['provider_id' => $request->provider_id]);
            })
            ->whereBetween('date', [$preMonthDateFrame, $nextMonthDateFrame])
            ->withWhereHas('provider', function($q){
                $q->where('deleted_at', null);
            })
            //->whereRelation('provider', 'deleted_at', '=', null)
            ->with([
                'userable',
                'location',
                'provider',
            ])->get();

        $appointments = [];
        foreach ($clinicAppointments as $key => $appointment)
        {
            $providerName = $appointment->provider->shortName;
            $locationName = $appointment->location->name;
            $patientName = ($appointment->userable) ? $appointment->userable->shortName : 'N/A';
            $appointmentClassId = "appointment-$appointment->id";

            $time = strtotime($appointment->start_time);
            $time = date('h:i:s', $time);
            $startTime = $appointment->date.'T'.$time;

            switch ($appointment->appointment_status_id) {
                case AppointmentStatus::COMPLETE['id']:
                    $color = '#28a745';
                    break;
                case AppointmentStatus::CANCELLED_BY_PROVIDER['id']:
                    $color = '#ffc107';
                    break;
                case AppointmentStatus::NO_SHOW['id']:
                    $color = '#dc3545';
                    break;
                case AppointmentStatus::CONFIRMED['id']:
                    $color = '#042BFB';
                    break;
                default:
                    $color = '#acacac';
                    break;
            }

            $title = $patientName. ' with '. $providerName;
            //$title = ($request->provider_id == null) ? $providerName : $patientName;
            $appointments[] = [
                'id' => $appointment->id,
                'classNames' => $appointmentClassId,
                //'title' => $appointment->start_time,
                'title' => $title,
                'description' => "appointment at $appointment->start_time for provider $providerName at location $locationName from patient $patientName",
                'start' => $startTime,
                //'end' => $endTime,
                'allDay' => false,
                'url' => 'https://www.google.com/',
                'color' => $color
            ];
        }

        return view('clinic.calendar', compact('appointments', 'providers', 'appointmentStatus'));
    }

    /**
     * @return Application|Factory|View
     * In view viewPendingAppointment data pass from PendingAppointmentComposer from laravel view composer
     */
    public function pendingAppointment(Request $request)
    {
        $searchParam = (isset($request->q)) ? $request->q  : '';
        $authClinicId = $this->authUser->clinic_id;
        $roleNotOwner = $this->getAuth['isRoleOwner'] != true;
        $locationId = $this->getAuth['staffLocationId'];
        $appointments = Appointment::where(['clinic_id' => $authClinicId, 'appointment_status_id' => AppointmentStatus::PENDING_APPROVAL['id']])
            ->filter($searchParam)
            ->when($roleNotOwner, function($q) use($locationId){
                $q->whereIn('location_id', $locationId);
            })
            ->with([
                'userable',
                'location',
                'provider',
            ])
            ->orderBy('date', 'DESC')->paginate(10);

        return view('clinic.pending-appointment', compact('appointments'));
    }


    /**
     * @return Application|Factory|View
     * In view viewPendingAppointment data pass from PendingAppointmentComposer from laravel view composer
     */
    public function activityViewer(Request $request)
    {
        $searchParam = (isset($request->q)) ? $request->q  : '';
        $authClinicId = $this->authUser->clinic_id;

        $activities =  Activity::where(['properties->attributes->clinic_id' => $authClinicId])
            ->where('log_name', 'LIKE', "%{$searchParam}%")
            //->where('properties->attributes->clinic_id', 'LIKE', "%{$searchParam}%")
            ->with(['subject', 'causer'])
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return view('clinic.activity-viewer', compact('activities'));
    }
}
