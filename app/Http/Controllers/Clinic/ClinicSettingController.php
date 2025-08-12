<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClinicProfileRequest;
use App\Http\Requests\OwnerProfileRequest;
use App\Models\Clinic;
use App\Models\ClinicConfiguration;
use App\Models\Gender;
use App\Models\User;
use App\Models\UserDetail;
use App\Services\FileService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClinicSettingController extends Controller
{
    protected $authUser;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->authUser = Auth::user();
            return $next($request);
        });
    }

    /**
     * @return Application|Factory|View
     */
    public function profile()
    {
        $genders = Gender::all();
        $clinic = Clinic::where('id', $this->authUser->clinic_id)
            ->with([
                'status',
                'owner.userDetail',
                'locations',
                'providers.userDetail',
                'staffs.userDetail',
                'configuration'
            ])
            ->first();

        return view('clinic.setting.profile', compact('clinic', 'genders'));
    }

    /**
     * @param ClinicProfileRequest $request
     * @param FileService $fileService
     * @return RedirectResponse
     */
    public function changeClinicProfile(ClinicProfileRequest $request, FileService $fileService): RedirectResponse
    {
        $clinicId = $request->clinic_id;
        $clinic = Clinic::find($clinicId);
        $requestClinicData = $request->except(['sub_domain','_token', '_method']);

        $publicPath = '/upload/clinic/';
        if ($request->logo)
        {
            $file = $request->logo;
            $logoPath = $fileService->uploadImage($publicPath, $file);

        } else {
            $logoPath = $clinic->logo;
        }

        if ($request->favicon)
        {
            $file = $request->favicon;
            $faviconPath = $fileService->uploadImage($publicPath, $file);
        } else {
            $faviconPath = $clinic->favicon;
        }

        $clinicData = array_merge($requestClinicData, [
            'sub_domain' => Str::slug($request->sub_domain, '-'),
            'logo' => $logoPath,
            'favicon' => $faviconPath,
        ]);

        ClinicConfiguration::updateOrCreate(
            ['clinic_id' => $clinic->id],
            [
                'clinic_id' => $clinic->id,
                'background_color' => isset($request['background_color']) ? $request['background_color'] : '#273c75',
                'color' => isset($request['color']) ? $request['color'] : '#273c75',
            ]
        );

        $clinic->update($clinicData);

        /* Store $imageName name in DATABASE from HERE */

        return back()->with('success','You have successfully update profile.');
    }

    /**
     * @param OwnerProfileRequest $request
     * @param FileService $fileService
     * @return RedirectResponse
     */
    public function changeOwnerProfile(OwnerProfileRequest $request, FileService $fileService): RedirectResponse
    {
        $ownerId = $request->owner_id;
        $owner = User::find($ownerId);

        $ownerUser = $request->only(['name', 'email']);
        $requestConfiguration = $request->only(['is_send_sms', 'is_send_email']);
        $ownerUserDetail = $request->except(['name', 'email', '_token', '_method','is_send_sms', 'is_send_email']);

        $publicPath = '/upload/clinic/owner/';
        if ($request->image)
        {
            $file = $request->image;
            $imagePath = $fileService->uploadImage($publicPath, $file);

        } else {
            $imagePath = $owner->image;
        }

        $ownerUserDetail = array_merge($ownerUserDetail, ['image' => $imagePath]);

        $owner->update($ownerUser);
        UserDetail::where('user_id', $owner->id)->update($ownerUserDetail);

        ClinicConfiguration::updateOrCreate(
            ['clinic_id' => $this->authUser->clinic_id],
            [
                'clinic_id' => $this->authUser->clinic_id,
                'is_send_sms' => isset($requestConfiguration['is_send_sms']) ? 1 : 0,
                'is_send_email' => isset($requestConfiguration['is_send_email']) ? 1 : 0,
            ]
        );

        /* Store $imageName name in DATABASE from HERE */

        return back()->with('success','You have successfully update owner profile.');
    }

    /**
     * @return Application|Factory|View
     */
    public function changePasswordForm ()
    {
        return view('clinic.setting.change-password');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function changePassword (Request $request): RedirectResponse
    {
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        } else {
            return redirect()->back()->withErrors('old password is not match');
        }
        return redirect()->back()->with('success','Update successfully!');
    }
}
