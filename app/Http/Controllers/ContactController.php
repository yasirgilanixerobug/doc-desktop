<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\Location;
use App\Models\RequestReview;
use App\Models\StaffLocation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function form(Request $request)
    {
        return view('contact-us');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $reviewFollowUpId = decrypt($request->input('review_follow_up_id'));

        // Validate the form data
        $request->validate([
            'review_follow_up_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $reviewFollowUp = RequestReview::where(['id' => $reviewFollowUpId])
            ->with('clinic.owner')->first();
        $location = Location::where('name', $reviewFollowUp->location)->first();

        $ownerEmail = isset($reviewFollowUp->clinic->owner) ? $reviewFollowUp->clinic->owner->email : 'yasirgilani100@gmail.com';

        // Send email
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'review_follow_up' => $reviewFollowUp->toArray()
        ];

        $staffLocations = StaffLocation::where(['location_id' => $location->id  ])
            ->with('staff')
            ->get();

        $staffEmails = [];
        foreach ($staffLocations  as $key => $location)
        {
            $staffEmails[] = isset($location->staff) ? $location->staff->email : null;
        }

        $staffEmails = array_merge([$ownerEmail],$staffEmails);
        Mail::to($staffEmails)->send(new ContactFormMail($data));
        $reviewFollowUp->update(['sms_status' => RequestReview::COMPLAIN]);

        // Redirect back with a success message
        return redirect()->route('contactUs.thankYou');

        //return view('review-request.check-form', compact('reviewFollowUp'));
    }

    public function thankYou()
    {
        return view('thank-you');
    }
}
