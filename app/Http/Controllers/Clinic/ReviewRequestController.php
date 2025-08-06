<?php

namespace App\Http\Controllers\Clinic;

use App\Exports\BulkFormatExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\SingleReviewRequest;
use App\Imports\RequestReviewImport;
use App\Jobs\SendReviewMessageJob;
use App\Models\Location;
use App\Models\RequestReview;
use App\Models\User;
use App\Models\Role;
use App\Models\ProviderListing;
use App\Services\RequestReviewService;
use App\Services\SmsService;
use App\Services\TwilioService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Twilio\Exceptions\TwilioException;
use App\Models\Status;

class ReviewRequestController extends Controller
{

    public function index(Request $request)
    {
        $requestLocation = $request->location;
        $reviews = RequestReview::where(['clinic_id' => Auth::user()->clinic_id])
            ->when(!empty($requestLocation), function($q) use($requestLocation) {
                $q->where(['location' => $requestLocation]);
            })
            ->orderBy('id', 'DESC')
            ->paginate(20);

        $locations = Location::where(['clinic_id' => Auth::user()->clinic_id])->get();
        return view('clinic.review-request.index', compact('reviews', 'locations'));
    }

    /**
     * @return Application|Factory|View
     */
    public function singleRequest()
    {
        $lastRecords = RequestReview::where('clinic_id', Auth::user()->clinic_id)
            ->select('location', \DB::raw('MAX(created_at) as latest_created_at'))
            ->groupBy('location')
            ->orderByDesc('latest_created_at')
            ->get();

        $providers = User::where(['clinic_id' => Auth::user()->clinic_id])
            ->whereHas("roles", function($q){
                $q->where("name", "provider");
            })
            ->get();

        $locations = Location::where(['clinic_id' => Auth::user()->clinic_id])->get();

        return view('clinic.review-request.single-request', compact('locations', 'lastRecords', 'providers'));
    }

    /**
     * @param SingleReviewRequest $request
     * @param RequestReviewService $reviewFollowUpService
     * @return RedirectResponse
     * @throws TwilioException
     */
    public function storeSingleRequest(SingleReviewRequest $request, RequestReviewService $reviewFollowUpService): RedirectResponse
    {

        $location = Location::where(['id' => $request->location_id, 'clinic_id' => Auth::user()->clinic_id])->first();
        $patientName = $request->first_name.'-'.$request->last_name;
        $time = Carbon::now();
        $slugTitle = $patientName.'-'.$time->getPreciseTimestamp(3);

        $reviewData = [
            'clinic_id' => Auth::user()->clinic_id,
            'slug' => $slugTitle,
            'patient' => $patientName,
            'mobile_phone' => $request->phone,
            'dob' => $request->dob,
            'appointment_date' => $request->appointment_date,
            'provider' => $request->provider,
            'location' => $location->name,
            'review_url' => $location->google_review_url,
            'sms_status' => RequestReview::NOT_SEND,
        ];

        $requestReview = RequestReview::create($reviewData);
        $requestReview = RequestReview::where('id', $requestReview->id)->with('clinic')->first()->toArray();

        if ($requestReview) {
            $sendService = new SmsService();
            $sendService->sendReviewMessages([$requestReview]);

            return redirect()->route('clinic.reviewRequest.sendMessageForm')->with('status', 'Messages In Queue To Send Patients');
        }

        return back()->with('success','Patient Request Review Schedule Successfully!');
    }

    /**
     * @return Application|Factory|View
     */
    public function bulkImport(TwilioService $twilioService)
    {
        $lastRecords = RequestReview::where('clinic_id', Auth::user()->clinic_id)
            ->select('location', \DB::raw('MAX(created_at) as latest_created_at'))
            ->groupBy('location')
            ->orderByDesc('latest_created_at')
            ->get();

        $locations = Location::where(['clinic_id' => Auth::user()->clinic_id])->get();
        $providersListing = ProviderListing::where(['clinic_id' => Auth::user()->clinic_id, 'status_id' => Status::ACTIVE])
            ->with(['provider', 'location'])
            ->get();

        return view('clinic.review-request.bulk-import', compact('locations', 'lastRecords', 'twilioService','providersListing'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function import(Request $request): RedirectResponse
    {
        // Get form type
        $formType = $request->input('form_type');
        $providerFile = $request->file('file');
        $file_name = $providerFile->getClientOriginalName();
        $providerFile->move(public_path('/upload/import-review-request-list'), $file_name);
        $file_path =  public_path()."/upload/import-review-request-list/" . $file_name;

        if ($formType === 'location') {
            $locationReviewUrl = $request->input('location_google_review_url');

            if($locationReviewUrl == '' || $locationReviewUrl == null)
            {
                return back()->with(['error' => 'Location google review URL is empty, first update it in location.']);
            }
            Excel::import(new RequestReviewImport(Auth::user()->clinic_id, $locationReviewUrl), $file_path);

        } elseif ($formType === 'provider') {
            $providerReviewUrl = $request->input('provider_google_review_url');

            if($providerReviewUrl == '' || $providerReviewUrl == null)
            {
                return back()->with(['error' => 'Provider google review URL is empty, first update it in provider listing.']);
            }
            Excel::import(new RequestReviewImport(Auth::user()->clinic_id, $providerReviewUrl), $file_path);

        } else {
            return back()->with(['Invalid form submission.']);
        }
    
        return back()->with('success', 'Patient Review Follow Up List added successfully!');
    }

    /**
     * @param RequestReviewService $reviewFollowUpService
     * @return BinaryFileResponse
     */
    public function exportFormat (RequestReviewService $reviewFollowUpService): BinaryFileResponse
    {
        $format = $reviewFollowUpService->bulkFormatHeading();
        return Excel::download(new BulkFormatExport($format), 'patient-review-request-format.xlsx');
    }

    /**
     * @return Application|Factory|View
     */
    public function sendMessageForm()
    {
        $lastRecords = RequestReview::where('clinic_id', Auth::user()->clinic_id)
            ->select('location', \DB::raw('MAX(created_at) as latest_created_at'))
            ->groupBy('location')
            ->orderByDesc('latest_created_at')
            ->get();
        $locations = Location::where(['clinic_id' => Auth::user()->clinic_id])->get();
        $totalReviewFollowUp = RequestReview::where(['sms_status' => 0, 'clinic_id' => Auth::user()->clinic_id])
            ->count();
        $providers = User::where(['clinic_id' => Auth::user()->clinic_id])
            ->whereHas('roles', function($q){
                $q->whereIn('id', [Role::PROVIDER]);
            })->get();
        return  view('clinic.review-request.send-message', compact('totalReviewFollowUp', 'locations', 'lastRecords','providers'));
    }

    /**
     * @param Request $request
     * @param RequestReviewService $reviewFollowUpService
     * @return RedirectResponse
     */
    public function sendMessage(Request $request, RequestReviewService $reviewFollowUpService): RedirectResponse
    {
        $followUpPatients = $reviewFollowUpService->patients($request->all());
        if ($followUpPatients) {
            $sendMessageThread = new SendReviewMessageJob($request->all(), $followUpPatients);
            dispatch($sendMessageThread);
            return redirect()->route('clinic.reviewRequest.sendMessageForm')->with('status', 'Messages In Queue To Send Patients');
        }

        return  redirect()->route('clinic.reviewRequest.sendMessageForm')->with('status', 'No record found');
    }
}
