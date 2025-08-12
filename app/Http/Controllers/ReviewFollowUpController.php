<?php

namespace App\Http\Controllers;

use App\Models\RequestReview;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReviewFollowUpController extends Controller
{
    /**
     * @param Request $request
     * @return false|Application|Factory|View
     */
    public function checkForm(Request $request)
    {
        $reviewFollowUpSlug = $request->slug;
        $reviewFollowUp = RequestReview::where(['slug' => $reviewFollowUpSlug])
            //->whereIn('sms_status', [1,2])
            ->with(['clinic'])
            ->first();

        if (!$reviewFollowUp) {
            echo "Link Not Found";
            return false;
        }

        $reviewUrl = $reviewFollowUp->review_url;
        return view('review-follow-up.check-form', compact('reviewUrl', 'reviewFollowUp'));
    }
}
