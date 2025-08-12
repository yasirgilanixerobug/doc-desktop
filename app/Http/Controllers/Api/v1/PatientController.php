<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\GuestUser;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Insurance;
use App\Services\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Traits\Fileable;

class PatientController extends Controller
{
    use Fileable;

    private $authService;

    public function __construct(
        AuthService $authService) {
        $this->authService = $authService;
    }

    /**
     * @return Application|Factory|View
     */
    public function dashboard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        $authUser = Auth::user();

        if (!Auth::check()) {
            return $response = [
                'status' => 404,
                'message' => 'User Not Found',
                'data' => [],
            ];
        }
        if ($request->type === 'past')
        {
            $appointments = $authUser->pastAppointments()->with(['clinic', 'provider.userDetail', 'status', 'location'])->latest()->take(5)->get();
        } else {
            $appointments = $authUser->upComingAppointment()->with(['clinic', 'provider.userDetail', 'status', 'location'])->latest()->take(5)->get();
        }

        return $response = [
            'status' => 200,
            'message' => 'Appointments',
            'data' => $appointments
        ];

        //return response()->json($response, 200);
    }

    /**
     * @return Application|Factory|View
     */
    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        $authUser = Auth::user();
        $authUser = User::whereId($authUser->id)->with(['userDetail', 'insurance'])->first();

        $response = [
            'status' => 200,
            'message' => 'User Profile',
            'data' => $authUser
        ];

        return response()->json($response, 200);
    }

        /**
     * @return Application|Factory|View
     */
    public function profileEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|min:3|max:100|regex:/^[a-zA-Z\s]*$/',
            'first_name' => 'required|min:3|max:50|regex:/^[a-zA-Z\s]*$/',
            'last_name' => 'required|min:3|max:50|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'gender_id' => 'required|int',
            'about' => 'nullable|string',
            'dob' => 'required|date|date_format:Y-m-d|before:today',
            //'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1000',
            'state' => 'nullable|min:2|max:20|regex:/^[a-zA-Z\s]*$/',
            'city' => 'nullable|min:2|max:30|regex:/^[a-zA-Z\s]*$/',
            'address' => 'nullable|string|min:3|max:200',
            'phone' => 'required|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ins_front' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ins_back' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ins_document' => 'nullable|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        $authUser = Auth::user();
        $authUserId = Auth::user()->id;

        //$authUser = User::whereId($request->user_id)->first();
        //$authUserId = $authUser->id;

        $request->dob = date('Y-m-d', strtotime($request->dob));
        $request->name = isset($request->name) ? $request->name : $request->first_name. ' '. $request->last_name;
        $request->phone = ($request->phone) ? '+1'.$request->phone : null;

        $userRequest = $request->only(['email','name']);
        $userDetailRequest = $request->only(['first_name','last_name', 'gender_id', 'dob', 'image', 'phone', 'address', 'city', 'state', 'zip_code']);

        if ($request->hasfile('image')) {
            $uploadFilePath =  $this->uploadImage('/upload/user/', $request->image);
            $userDetailRequest = array_merge($userDetailRequest, ['image' => $uploadFilePath]);
        }

        $authUser->update($userRequest);
        $authUser->userDetail()->update($userDetailRequest);

        if ($request->hasfile('ins_front') || $request->hasfile('ins_back') || $request->hasfile('ins_document')) {
            
            $requestIns = $request->only('ins_front', 'ins_back', 'ins_document');
            $attachUploadFilePaths = $this->storeInsuranceDoc($requestIns);
            $match = ['userable_type' => User::class, 'userable_id' => $authUserId];
            $insuranceData = array_merge($attachUploadFilePaths['for_db'], $match);
            Insurance::updateOrCreate($match, $insuranceData);
        }

        $response = [
            'status' => 200,
            'message' => 'Profile Update Successfully',
            'data' => []
        ];

        return response()->json($response, 200);
    }

    /**
     * @return Application|Factory|View
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'old_password' => 'required|min:8',
            'password' => 'required|min:8|confirmed',
            //'password_confirmation' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => 404,
                'message' => $validator->errors()->first(),
                'data' => [],
            ];

            return response()->json($response, 200);
        }

        $user = Auth::user();
        //$user = User::whereId($request->user_id)->first();
        
        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            $response = [
                'status' => 200,
                'message' => 'Password Change Successfully!',
                'data' => []
            ];

        } else {

            $response = [
                'status' => 404,
                'message' => 'old password is not match',
                'data' => []
            ];

        }

        return response()->json($response, 200);
    }
}
