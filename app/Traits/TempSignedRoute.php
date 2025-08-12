<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

trait TempSignedRoute {

    /**
     * @param $subdomain
     * @param $patientEmail
     * @param $appointmentId
     * @return string
     */
    public function getTempSignedRoute($subdomain, $patientEmail, $appointmentId): string
    {
        $token = Str::random(60);

        $resetTable = DB::table('password_resets')
            ->insert([
                'email' => $patientEmail,
                'token' => $token,
                'created_at' => now(),
            ]);

        return URL::temporarySignedRoute(
            'clinicFrontend.patientAppointmentDocument',
            now()->addMinutes(120),
            ['subdomain' => $subdomain, 'appointment_id' => encrypt($appointmentId), 'token' => $token]
        );
    }

    /**
     * @param $hasValidSignature
     */
    public function hasValidSignature($hasValidSignature)
    {
        if (! $hasValidSignature) {
            abort(401, 'Token is expired if you not submit document then you can submit document to clinic latter');
        }
    }

    /**
     * @param $email
     * @param $token
     * @return Model|Builder|object|null
     */
    public function checkToken($email, $token)
    {
        //user Email
        $findToken = DB::table('password_resets')
            ->where(['email' => $email, 'token' => $token])->first();

        if (! $findToken) {
            abort(404, 'Token is expired you all ready submit document through this link');
        }

        return $findToken;
    }

    /**
     * @param $email
     * @param $token
     * @return void
     */
    public function deleteToken($email, $token)
    {
        //Delete Token
        DB::table('password_resets')
            ->where(['email' => $email, 'token' => $token])->delete();
    }
}
