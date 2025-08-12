<?php

namespace App\View\Composers;

use App\Models\Appointment;
use App\Models\AppointmentStatus;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PendingAppointmentComposer
{
    /**
     * @var Appointment
     */
    protected $appointmentCount;
    protected $appointmentData;
    protected $authUser;
    protected $authClinicId;
    protected $authUserIsOwner;
    protected $authUserStaffLocationIds;
    protected $getAuth;

    public function __construct()
    {
        $appointmentCache = Cache::get('pending-appointment');
        $this->getAuth =  get_auth();
        $this->authUser =  $this->getAuth['user'];
        $this->authClinicId = $this->getAuth['clinicId'];
        $this->authUserIsOwner = $this->getAuth['isRoleOwner'];
        $this->authUserStaffLocationIds = $this->getAuth['staffLocationId'];

        $appointmentCount =  Appointment::where(['clinic_id' => $this->authClinicId, 'appointment_status_id' => AppointmentStatus::PENDING_APPROVAL['id']])
            ->when(!$this->authUserIsOwner, function($q) {
                $q->whereIn('location_id', $this->authUserStaffLocationIds);
            })
            ->count();

        if ($appointmentCache == null)
        {
            $appointmentCache = $this->getPendingAppointmentCache($this->authClinicId);
        }

        if ($appointmentCount != $appointmentCache['total_pending_appointment'])
        {
            Cache::forget('pending-appointment');
            $appointmentCache = $this->getPendingAppointmentCache($this->authClinicId);
        }

        $this->appointmentCount = $appointmentCache['total_pending_appointment'];
        $this->appointmentData = $appointmentCache['appointment_data'];

    }

    /**
     * @param $authClinicId
     * @return array
     */
    public function pendingAppointments($authClinicId): array
    {
        $appointmentQuery =  Appointment::where(['clinic_id' => $authClinicId, 'appointment_status_id' => AppointmentStatus::PENDING_APPROVAL['id']])
            //->whereDate('date', '>=' ,date('Y-m-d'))
//            ->whereHas('provider', function($query) {
//                $query->whereNull('deleted_at');
//            })
            ->withWhereHas('provider', function($q){
                $q->whereNull('deleted_at');
            })
            ->with([
                'userable',
                //'clinic',
                'location',
                'provider',
            ])
            ->orderBy('date', 'DESC');

        if ($this->authUserIsOwner != true)
        {
            $locationId = $this->authUserStaffLocationIds;
            $appointmentQuery->whereIn('location_id', $locationId);
        }

        return [
            'total_pending_appointment' => $appointmentQuery->count(),
            'appointment_data' => $appointmentQuery->limit(5)->get(),
        ];
    }

    /**
     * @param $authClinicId
     * @return mixed
     */
    public function getPendingAppointmentCache($authClinicId)
    {
        return Cache::remember('pending-appointment', '60', function () use($authClinicId) {
            return $this->pendingAppointments($authClinicId);
        });
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('viewPendingAppointmentCount', $this->appointmentCount)
            ->with('viewPendingAppointment', $this->appointmentData);
    }
}
