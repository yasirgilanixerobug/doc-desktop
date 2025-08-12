<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SingleReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
//    public function authorize()
//    {
//        return false;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'location_id' => 'required',
            'provider' => 'required',
            'appointment_date' => 'required',
        ];
    }
}
