<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\GuestUser;
use App\Models\User;
use App\Models\Clinic;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function dashboard(Request $request)
    {
        $authUser = Auth::user();
        //$authUser = GuestUser::find(1);
        //$pastAppointment = isset($authUser->pastAppointment) ? $authUser->pastAppointment : null;
        //$upComingAppointment = isset($authUser->upComingAppointment) ? $authUser->upComingAppointment : null;

        if ($request->type === 'past')
        {
            $appointments = $authUser->pastAppointments()->with(['clinic', 'provider.userDetail', 'status', 'location'])->latest()->take(5)->get();
        } else {
            $appointments = $authUser->upComingAppointment()->with(['clinic', 'provider.userDetail', 'status', 'location'])->latest()->take(5)->get();
        }

        return view('patient.dashboard', compact('appointments'));
    }

    public function appointments(Request $request)
    {
        $authUser = Auth::user();
        //$authUser = GuestUser::find(1);

        if ($request->appointment_type === 'past')
        {
            $appointments = $authUser->pastAppointments()->with(['clinic', 'provider.userDetail', 'status', 'location'])->get();
        } else {
            $appointments = $authUser->upComingAppointment()->with(['clinic', 'provider.userDetail', 'status', 'location'])->get();
        }

        return view('patient.appointments', compact('appointments'));
    }

    /**
     * @return Application|Factory|View
     */
    public function clinics()
    {
        $authUser = Auth::user();
        //$authUser = GuestUser::find(1);
        $clinics = $authUser->patientAppointments()
            ->select(DB::raw('DISTINCT(appointments.clinic_id)'))
            //->groupBy(['clinic_id', 'userable_type', 'userable_id' ])
            ->with('clinic')
            ->get();

        $clinics = $clinics->map(function ($appointment) {

            return [
                'id' => $appointment->clinic->id,
                'name' => $appointment->clinic->name,
                'sub_domain' => $appointment->clinic->sub_domain,
                'logo' => $appointment->clinic->brandLogo,
                'about' => $appointment->clinic->about,
            ];

        });

        return view('patient.clinics', compact('clinics'));
    }

    /**
     * @return Application|Factory|View
     */
    public function allPractices()
    {
        $clinics = Clinic::where([ 'status_id' => 1 ])->get();
        $clinics = $clinics->map(function ($clinic) {
            return [
                'id' => $clinic->id,
                'name' => $clinic->name,
                'sub_domain' => $clinic->sub_domain,
                'logo' => $clinic->brandLogo,
                'about' => $clinic->about,
            ];
        });
        
        return view('patient.clinics', compact('clinics'));
    }

    /**
     * @return Application|Factory|View
     */
    public function providers()
    {
        $authUser = Auth::user();
        //$authUser = GuestUser::find(1);
        $providers = $authUser->patientAppointments()
            ->select(DB::raw('DISTINCT(appointments.clinic_id)'), 'provider_id')
            //->groupBy(['clinic_id', 'userable_type', 'userable_id' ])
            ->with('provider.userDetail', 'clinic')
            ->get();

        $providers = collect($providers)->map(function ($appointment) {
            return [
                'id' => $appointment->provider->id,
                'name' => ($appointment->provider->userDetail->first_name != null)
                    ? $appointment->provider->userDetail->first_name.' '.$appointment->provider->userDetail->last_name
                    : $appointment->provider->name,
                'email' => $appointment->provider->email,
                'phone' => $appointment->provider->userDetail->phone,
                'image' => $appointment->provider->userDetail->image,
                'about' => $appointment->provider->userDetail->about,
                'clinic_sub_domain' => $appointment->clinic->sub_domain,
            ];

        });

        return view('patient.providers', compact('providers'));
    }
}
