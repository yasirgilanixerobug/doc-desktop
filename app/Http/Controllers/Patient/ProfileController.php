<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\PatientProfileUpdateRequest;
use App\Models\Gender;
use App\Models\User;
use App\Models\Insurance;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\Fileable;

class ProfileController extends Controller
{
    use Fileable;

    /**
     * @return Application|Factory|View
     */
    public function profile()
    {
        $authUser = Auth::user();
        $userDetail = Auth::user()->userDetail;
        $genders = Gender::all();
        $insurance = Auth::user()->insurance;    
        return view('patient.profile', compact('authUser','userDetail', 'genders', 'insurance'));
    }

    /**
     * @param PatientProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(PatientProfileUpdateRequest $request)
    {
        $authUser = Auth::user();
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
            $match = ['userable_type' => User::class, 'userable_id' => Auth::user()->id];
            $insuranceData = array_merge($attachUploadFilePaths['for_db'], $match);
            Insurance::updateOrCreate($match, $insuranceData);
        }

        return back()->with('success','Profile Update Successfully!');
    }

    /**
     * @param ChangePasswordRequest $request
     * @return RedirectResponse
     */
    public function changePassword(ChangePasswordRequest $request): RedirectResponse
    {
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        } else {
            return redirect()->back()->with('error','old password is not match');
        }

        return redirect()->back()->with('success','Password Change Successfully!');
    }
}
