<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignLocationRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'provider_id' => 'required|int',
            'location_id' => 'required|int',
            'is_location_check' => 'required',
        ];
    }
}
