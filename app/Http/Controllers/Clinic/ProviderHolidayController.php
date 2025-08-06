<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderHolidayRequest;
use App\Models\ProviderHoliday;
use Illuminate\Http\RedirectResponse;

class ProviderHolidayController extends Controller
{
    /**
     * @param ProviderHolidayRequest $request
     * @return RedirectResponse
     */
    public function add(ProviderHolidayRequest $request)
    {
        $providerId = $request->provider;
        $requestData = $request->validated();

        ProviderHoliday::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'provider_id' => $request->provider,
        ]);

        return redirect()->route('clinic.provider.index')->with(['successfully' => 'holiday added successfully']);
    }

    public function remove($id)
    {
        $providerHoliday = ProviderHoliday::find($id)->delete();
        return redirect()->back()->with('success', 'Provider Holiday Removed Successfully');
    }
}
