<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ClinicProfileRequest extends FormRequest
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
            'name' => 'required|min:3|max:50|regex:/^[a-zA-Z\s]*$/|unique:clinics,name,'.$this->clinic_id,
            'sub_domain' => 'required|alpha_dash|min:3|max:50|unique:clinics,sub_domain,'.$this->clinic_id,
            'about' => 'nullable|string|min:30',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1000',
            'background_color' => 'nullable',
            'color' => 'nullable',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if ($validator->fails())
        {
            back()->with('error', 'Some Error Check Your Form');
        }
    }
}
