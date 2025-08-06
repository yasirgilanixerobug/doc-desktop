<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Services\AuthService;
use App\Traits\Fileable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Rules\StartsWith;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\SendForgotLinkRequest;



class AuthController extends Controller
{
    use Fileable;

    public $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function key(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        $clinicCompanyId = $request->company_id;

        $clinic = Clinic::select('id', 'name', 'sub_domain', 'logo', 'favicon', 'about')
            ->where('id', $clinicCompanyId)
            ->with('configuration')
            ->first();

        if ($clinic)
        {
            $response = [
                'status' => 200,
                'message' => 'Clinic Record Found',
                'data' => [
                    'key' => $this->authService->setClinicId($clinic->id),
                    'name' => $clinic->name,
                    'sub_domain' => $clinic->sub_domain,
                    'about' => $clinic->about,
                    'logo' => $clinic->brandLogo,
                    'favicon' => $clinic->favicon,
                    'configuration' => $clinic->configuration
                ],
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Clinic Record Not Found',
                'data' => [],
            ];
        }

        return response()->json($response, 200);
    }

    public function signup(Request $request){

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:3|max:25|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|min:3|max:25|regex:/^[a-zA-Z\s]+$/',
            'phone' => [
                'required',
                'min:10',
                'max:10',
                'regex:/^\+?[1-9][0-9]{7,13}\S$/',
                new StartsWith('+1'),
                // Rule::startsWith('+1'),
            ],
            'email' => 'required|email',
            'dob' => 'required|date|date_format:Y-m-d|before:today',
            'state' => 'nullable|min:2|max:20',
            'city' => 'nullable|min:2|max:30',
            'address' => 'nullable|string|min:3|max:200',
            'zip_code' => 'nullable|regex:/^(?:(\d{5})(?:[ \-](\d{4}))?)$/i',
            'password' => 'required|min:8', 

            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        $isRegister = $this->authService->registerPatient($request->all());
        if ($isRegister['response'] === false) {
            $response = [
                'status' => 404,
                'message' => 'Something Wrong',
                'data' => $isRegister['data']
            ];

            return response($response, 200);
        }
        
        if ($isRegister['response'])
        {
            //isRegistr data is $user data
            $token = $isRegister['data']->createToken('patient_access_token')->accessToken;
            
            $response = [
                'status' => 200,
                'message' => 'Patient Register successfully',
                'data' => [
                    'user' => $isRegister['data'],
                    'token' => $token
                ]
            ];

            return response($response, 200);
        }

        $response = [
            'status' => 404,
            'message' => 'Something Wrong',
            'data' => []
        ];

        return response($response, 200);
    }

    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required|min:8'   
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        //Check email
        $user = $this->authService->getPatient($request->email);
        
        //Check Password
        if(!$user || !Hash::check($request->password, $user->password) ){
            return response([
                'status' => 401,
                'message'=>'Invalid Credentials',
                'data' => [],
            ], 200);
        }

        if (Auth::attempt($request->only('email', 'password')))
        {
            $user = Auth::user();
            $token = $user->createToken('patient_access_token')->accessToken;
        }

        $response= [
            'status' => 200,
            'message'=> 'User',
            'data' => [
                'user' => $user,
                'token'=> $token
            ],
        ];

        return response($response, 200);
    }

    public function forgotPassword(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        $status === Password::RESET_LINK_SENT
            ? $message = 'Password Reset Link Send To Your Email'
            : $message = 'Somthing Wrong';

        $response = [
            'status' => 200,
            'message'=> $message,
            'data' => [],
        ];

        return response($response, 200);
    }

    public function logout(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',  
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        $token = $request->user()->token();
        $token->revoke();

        $response = [
            'status' => 200,
            'message'=> 'You have been successfully logged out!',
            'data' => [],
        ];

        return response($response, 200);
    }
}
