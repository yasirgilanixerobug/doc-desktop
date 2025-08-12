<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    private $authService;

    public function __construct(
        AuthService $authService) {
        $this->authService = $authService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function all(Request $request): JsonResponse
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

        $clinicId = $this->authService->getClinicId($request->company_id);

        $locations = Location::select('id', 'name', 'state', 'city', 'address')
            ->where('clinic_id', $clinicId)
            ->get();

        if (count($locations) > 0)
        {
            $response = [
                'status' => 200,
                'message' => 'Locations Found Successfully',
                'data' => $locations
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Location Not Found',
                'data' => []
            ];
        }

        return response()->json($response, 200);
    }
}
