<?php

namespace App\Services;

use App\Models\StaffLocation;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffService
{
    /**
     * @param array $request
     * @return false|mixed
     */
    public function register (array $request)
    {
        DB::beginTransaction();

        try {

            //Create User and user detail
            $clinicStaff = $this->create($request);

            //assign clinic to user
            $authClinicId = Auth::user()->clinic_id;
            $this->addStaffInClinic($clinicStaff, $authClinicId);

            //assign owner role to clinic user
            $this->assignRoleToUser($clinicStaff, $request['role']);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollback();
            return false;
            // something went wrong
        }

        return $clinicStaff;
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function create(array $request)
    {
        //User
        $clinicStaff = User::create([
            'name' => isset($request['name']) ? $request['name'] : $request['first_name']. ' '. $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make('12345678'),
            'status_id' => 1, // default active
        ]);

        //User Detail
        UserDetail::create([
            'first_name' => isset($request['first_name']) ? $request['first_name'] : null,
            'last_name' => isset($request['last_name']) ? $request['last_name'] : null,
            'phone' => $request['phone'],
            'user_id' => $clinicStaff->id,
        ]);

        //Assign Location To Staff
//        StaffLocation::create([
//            'location_id' => $request['location_id'],
//            'staff_id' => $clinicStaff->id,
//            'status_id' => 1,
//        ]);

        $staffLocations = [];
        foreach($request['location_id'] as $key => $locationId)
        {
            $staffLocations[] = [
                'location_id' => $locationId,
                'staff_id' => $clinicStaff->id,
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        StaffLocation::insert($staffLocations);

        return $clinicStaff;
    }

    /**
     * @param User $staff
     * @param int $clinicId
     */
    public function addStaffInClinic(User $staff, int $clinicId)
    {
        $staff->update([
            'clinic_id' => $clinicId
        ]);
    }

    /**
     * @param User $user
     * @param $role
     */
    public function assignRoleToUser(User $user, $role)
    {
        $user->assignRole($role);
    }

    /**
     * @param array $request
     * @param $clinicStaff
     * @return mixed
     */
    public function update(array $request, $clinicStaff)
    {
        //User
        $clinicStaff->update([
            'name' => isset($request['name']) ? $request['name'] : $request['first_name']. ' '. $request['last_name'],
            'email' => $request['email'],
        ]);

        //User Detail
        UserDetail::where('user_id', $clinicStaff->id)->update([
            'first_name' => isset($request['first_name']) ? $request['first_name'] : null,
            'last_name' => isset($request['last_name']) ? $request['last_name'] : null,
            'phone' => $request['phone'],
        ]);

        //Assign Staff Location
//        StaffLocation::where('staff_id', $clinicStaff->id)->update([
//            'location_id' => $request['location_id'],
//        ]);
        $staffLocationIds = StaffLocation::where('staff_id', $clinicStaff->id)->get()->pluck('location_id');
        $deleteLocations = array_diff($staffLocationIds->toArray(), $request['location_id']);
        $locations = StaffLocation::where('staff_id', $clinicStaff->id)->whereIn('location_id', $deleteLocations)->delete();

        foreach($request['location_id'] as $key => $locationId)
        {
            StaffLocation::updateOrCreate(
                ['staff_id' => $clinicStaff->id, 'location_id' => $locationId],
                [
                    'staff_id' => $clinicStaff->id,
                    'location_id' => $locationId,
                    'status_id' => 1,
                    'updated_at' => now(),
                ]
            );
        }

        $this->updateRole($clinicStaff, $request['role']);
        return $clinicStaff;
    }

    /**
     * @param User $user
     * @param $role
     */
    public function updateRole(User $user, $role)
    {
        $user->syncRoles($role);
    }
}
