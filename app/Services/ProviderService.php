<?php

namespace App\Services;

use App\Models\User;
use App\Models\Status;
use App\Models\ProviderLocation;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProviderService
{
    private $fileService;

    public function __construct(FileService $fileService)
    {
       $this->fileService = $fileService;
    }

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
            $this->addUserInClinic($clinicStaff, $authClinicId);

            //assign owner role to clinic user
            $this->assignRoleToUser($clinicStaff, 'provider');

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

        $image = $this->uploadImage($request);

        //User Detail
        UserDetail::create([
            'first_name' => isset($request['first_name']) ? $request['first_name'] : null,
            'last_name' => isset($request['last_name']) ? $request['last_name'] : null,
            'phone' => $request['phone'],
            'user_id' => $clinicStaff->id,
            'home' => $request['home'] ?? null,
            'office' => $request['office'] ?? null,
            'fax' => $request['fax'] ?? null,
            'about' => $request['about'] ?? null,
            'gender_id' => $request['gender_id'] ?? null,
            'image' => $image ?? null,
            'state' => $request['state'] ?? null,
            'city' => $request['city'] ?? null,
            'address' => $request['address'] ?? null,
        ]);

        //Add Provider Location
        ProviderLocation::create([
            'provider_id' => $clinicStaff->id,
            'location_id' => $request['location_id'],
            'status_id' => Status::ACTIVE
        ]);

        return $clinicStaff;
    }

    /**
     * @param User $staff
     * @param int $clinicId
     */
    public function addUserInClinic(User $staff, int $clinicId)
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

        $userModel = UserDetail::where('user_id', $clinicStaff->id)->first();
        $image = $this->uploadImage($request, $userModel);

        //User Detail
        $userModel->update([
            'first_name' => isset($request['first_name']) ? $request['first_name'] : null,
            'last_name' => isset($request['last_name']) ? $request['last_name'] : null,
            'phone' => $request['phone'],
            'home' => $request['home'] ?? null,
            'office' => $request['office'] ?? null,
            'fax' => $request['fax'] ?? null,
            'about' => $request['about'] ?? null,
            'gender_id' => $request['gender_id'] ?? null,
            'image' => $image ?? null,
            'state' => $request['state'] ?? null,
            'city' => $request['city'] ?? null,
            'address' => $request['address'] ?? null,
        ]);

        return $clinicStaff;
    }

    /**
     * @param array $request
     * @param null $model
     * @return string|null
     */
    public function uploadImage(array $request, $model = null)
    {
        $publicPath = '/upload/provider/';
        if (isset($request['image']) && $request['image'])
        {
            $file = $request['image'];
            $imagePath = $this->fileService ->uploadImage($publicPath, $file);

        } else {
            $imagePath = $model->image ?? null;
        }

        return $imagePath;
    }
}
