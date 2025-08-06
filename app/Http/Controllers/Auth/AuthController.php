<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ClinicRegisterRequest;
use App\Http\Requests\PatientRegisterRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Schema;

class AuthController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function clinicRegisterForm(Request $request)
    {
        $name = (isset($request->name)) ? $request->name : null;
        $email = (isset($request->email)) ? $request->email : null;

        return view('app.auth.register', compact('name', 'email'));
    }

    /**
     * @param ClinicRegisterRequest $request
     * @param AuthService $auth
     * @return RedirectResponse
     */
    public function clinicRegister(ClinicRegisterRequest $request, AuthService $auth): RedirectResponse
    {
        $requestData = $request->validated();
        if ($auth->registerClinic($requestData))
        {
            $credential = $request->only('email', 'password');

            if(Auth::attempt($credential))
            {
                //$mainDomain = str_replace('://', '://clinic.', config('app.url'));
                //return redirect($mainDomain.'/clinic/dashboard');
                return redirect()->route('clinic.calendar');
            }
        }

        return back()->withErrors([
            'name' => 'Something wrong.',
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function patientRegisterForm(Request $request)
    {
        $name = (isset($request->name)) ? $request->name : null;
        $email = (isset($request->email)) ? $request->email : null;

        return view('app.auth.patient-register', compact('name', 'email'));
    }

    public function patientRegister(PatientRegisterRequest $request, AuthService $auth): RedirectResponse
    {
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();

        $requestData = $request->validated();
        $isRegister = $auth->registerPatient($requestData);
        if ($isRegister['response'])
        {
            $credential = $request->only('email', 'password');

            if(Auth::attempt($credential))
            {
                if ($route != 'auth.patientRegisterForm') {
                    return redirect()->away($url);
                }
                //$mainDomain = str_replace('://', '://clinic.', config('app.url'));
                //return redirect($mainDomain.'/clinic/dashboard');
                return redirect()->route('patient.dashboard');
            }
        }

        return back()->withErrors([
            'name' => $isRegister['data'],
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function loginForm()
    {
        $requestRouteName = request()->route()->getName();
        $isAppointmentRoute = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();

        if ($requestRouteName === 'auth.patientLoginForm') {
            $loginFor = 'Patient';
            $signupRoute = route('auth.patientRegisterForm');
        } else {
            $loginFor = 'Clinic';
            $signupRoute = route('auth.clinicRegisterForm');
        }

        $isAppointmentRoute = ($isAppointmentRoute == 'clinicFrontend.appointmentForm') ? url()->previous() : null;

        return view('app.auth.login', compact('loginFor', 'signupRoute', 'isAppointmentRoute'));
    }

    /**
     * @param LoginRequest $request
     * @param AuthService $auth
     * @return RedirectResponse
     */
    public function login(LoginRequest $request, AuthService $auth): RedirectResponse
    {
       
        $credentials = $request->only('email', 'password');
        
        $url = url()->previous();
        $route = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();

        if($route == 'auth.clinicLoginForm') {
            $roles = [Role::OWNER, Role::RECEPTIONIST];
        } else {
            $roles = [Role::PATIENT];
        }

        if ($auth->login($credentials, $roles))
        {
            if (in_array(Role::PATIENT, $roles)) {
                if ($route != 'auth.patientLoginForm') {
                    return redirect()->away($url);
                }
                return redirect()->route('patient.dashboard');
            }

            //$mainDomain = str_replace('://', '://clinic.'.config('app.url'), config('app.url'));
            //return redirect()->route($mainDomain);
            return redirect()->route('clinic.calendar');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * @param $social
     * @return mixed
     */
    public function socialLogin($social)
    {
        return Socialite::driver($social)->stateless()->redirect();
    }

    /**
     * @param $social
     * @return RedirectResponse
     */
    public function handleProviderCallback($social): RedirectResponse
    {
        $userSocial = Socialite::driver($social)->stateless()->user();
        $user = User::where(['email' => $userSocial->getEmail()])->first();

        if ($user) {
            Auth::login($user);
            //$mainDomain = str_replace('://', '://clinic.'.config('app.url'), config('app.url'));
            //return redirect()->route($mainDomain);
            return redirect()->route('clinic.dashboard');
        } else {
            return redirect()->route('auth.clinicRegisterForm', ['name' => $userSocial->getName(), 'email' => $userSocial->getEmail()]);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            Auth::logout();
        }

        Cache::flush();
        //$mainDomain = str_replace('://', '://'.config('app.url'), config('app.url'));
        //return redirect()->to($mainDomain);

        return redirect()->route('welcome');
    }
}
