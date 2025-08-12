<?php

namespace App\View\Composers;

use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ClinicComposer
{
    /**
     * @var mixed
     */
    protected $subDomain;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->subDomain = $request->subdomain;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $clinicComposer = Cache::remember($this->subDomain, '60', function () {
            return Clinic::where( 'sub_domain',$this->subDomain )->with('configuration')->first();
        });

        $view->with('clinicComposer', $clinicComposer);
    }
}
