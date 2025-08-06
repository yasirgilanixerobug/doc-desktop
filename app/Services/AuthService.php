<?php

namespace App\Services;

use App\Models\Clinic;
use App\Models\ClinicConfiguration;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Models\UserDetail;
use App\Traits\Fileable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    use Fileable;

    /**
     * @param $companyId
     * @return string
     */
    public function setClinicId($companyId): string
    {
        return Crypt::encryptString($companyId);
    }

    /**
     * @param $companyId
     * @return string
     */
    public function getClinicId($companyId): string
    {
        return Crypt::decryptString($companyId);
    }

    /**
     * @param $companyId
     * @return string
     */
    public function getPatient($email)
    {
        $roles = [Role::PATIENT];
        return User::where('email', $email)->whereHas(
            'roles', function($q) use($roles) {
            $q->whereIn('id', $roles);
        })->with('userDetail')->first();
    }
    
    /**
     * @param $credentials
     * @param $roles
     * @return bool
     */
    public function login($credentials, $roles): bool
    {
        $user = User::where('email', $credentials['email'])->whereHas(
            'roles', function($q) use($roles) {
            $q->whereIn('id', $roles);
        })->first();
        
        if ($user !== null && Auth::attempt($credentials)) {
            return true;
            //return redirect()->intended('/home');
        }

        return false;
    }

    /**
     * @param array $request
     * @return false|mixed
     */
    public function registerPatient(array $request)
    {
        DB::beginTransaction();

        try {

            $user = User::where('email', $request['email'])->first();

            if (!$user) {
                $user = $this->createUser($request);

            } else {
                //check user role exists already
                if ($this->userHasRole($user, 'patient')) {
                    return ['response' => false, 'status' => 400, 'data' => 'This email is already register to a patient'];
                    //abort(400, 'You already register as a patient');
                }

                //update user detail and assign role
                $this->createOrUpdateUserDetail($request, $user);
            }

            //if not abort then assign role to user
            $this->assignRoleToUser($user, 'patient');

            DB::commit();
            return ['response' => true, 'status' => 200, 'data' => $user];
            //return $user;

        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollback();
            return ['response' => false, 'status' => 500, 'data' => 'something wrong'];
            //return false;
            // something went wrong
        }
    }

    /**
     * @param array $request
     * @return false|mixed
     */
    public function registerClinic (array $request)
    {
        DB::beginTransaction();

        try {

            $clinicOwner = User::where('email', $request['email'])->first();
            if ($clinicOwner) {
                if ($this->userHasRole($clinicOwner, 'owner')) {
                    abort(400, 'You already register as a owner');
                }
                //Create clinic with user owner
                $clinic = $this->createClinic($request, $clinicOwner->id);

                //add configuration of clinic
                $this->createConfiguration($clinic->id);
                //assign clinic to user
                $this->addUserInClinic($clinicOwner, $clinic->id);

                //assign owner role to clinic user
                $this->assignRoleToUser($clinicOwner, 'owner');

                if (!$this->userHasRole($clinicOwner, 'provider')) {
                    $this->assignRoleToUser($clinicOwner, 'provider');
                }

            } else {
                //Create User and user detail
                $clinicOwner = $this->createUser($request);
                //Create clinic with user owner
                $clinic = $this->createClinic($request, $clinicOwner->id);

                //add configuration of clinic
                $this->createConfiguration($clinic->id);

                //assign clinic to user
                $this->addUserInClinic($clinicOwner, $clinic->id);

                //assign owner role to clinic user
                $this->assignRoleToUser($clinicOwner, 'owner');

                if (!$this->userHasRole($clinicOwner, 'provider')) {
                    $this->assignRoleToUser($clinicOwner, 'provider');
                }
            }

            DB::commit();
            // all good
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollback();
            return false;
            // something went wrong
        }

        return $clinicOwner;
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function createUser(array $request)
    {
        //User
        $user = User::create([
            'name' => $request['name'] ?? $request['first_name'] . ' '. $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'status_id' => Status::ACTIVE, // default active
        ]);

        //User Detail
        $this->createOrUpdateUserDetail($request, $user);

        return $user;
    }

    /**
     * @param array $request
     * @param User $user
     * @return mixed
     */
    public function createOrUpdateUserDetail(array $request, User $user)
    {
        $matchThese = ['user_id' => $user->id];
        
        if (isset($request['image'])) {
           $uploadFilePath =  $this->uploadImage('/upload/user/', $request['image']);
        }

        return UserDetail::updateOrCreate($matchThese, [
            'first_name' => isset($request['first_name']) ? $request['first_name'] : null,
            'last_name' => isset($request['last_name']) ? $request['last_name'] : null,
            'phone' => $request['phone'] ?? null,
            'address' => $request['address'] ?? null,
            'city' => $request['city'] ?? null,
            'state' => $request['state'] ?? null,
            'dob' => $request['dob'] ?? null,
            'zip_code' => $request['zip_code'] ?? null,
            'user_id' => $user->id,
            'image' => isset($uploadFilePath) ? $uploadFilePath : null,
        ]);
    }

    /**
     * @param array $request
     * @param int $clinicOwnerId
     * @return mixed
     */
    public function createClinic(array $request, int $clinicOwnerId)
    {
        return Clinic::create([
            'name' => $request['business_name'],
            'owner_id' => $clinicOwnerId,
        ]);
    }


    /**
     * @param int $clinicId
     * @return mixed
     */
    public function createConfiguration(int $clinicId)
    {
        return ClinicConfiguration::create([
            'clinic_id' => $clinicId,
            'color' => '#273c75',
            'background_color' => '#273c75',
            'is_send_sms' => 0,
            'is_send_email' => 0,
        ]);
    }

    /**
     * @param User $user
     * @param int $clinicId
     */
    public function addUserInClinic(User $user, int $clinicId)
    {
        $user->update([
            'clinic_id' => $clinicId
        ]);
    }

    /**
     * @param User $user
     * @param $roleName
     * @return void
     */
    public function assignRoleToUser(User $user, $roleName)
    {
        $user->assignRole($roleName);
    }

    /**
     * @param User $user
     * @param $roleName
     * @return bool
     */
    public function userHasRole(User $user, $roleName): bool
    {
        if ($user->hasRole($roleName)) {
            return true;
        }

        return false;
    }
}
