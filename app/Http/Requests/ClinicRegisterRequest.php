<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ReCaptcha;

class ClinicRegisterRequest extends FormRequest
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
            'business_name' => 'required|min:3|max:30|regex:/^[a-zA-Z\s]*$/|unique:clinics,name',
            'name' => 'required|min:3|max:50|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|email',
            'phone' => 'required|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'password' => 'required|min:8',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'phone.regex' => '3456789123 10 digits without country code',
            'phone.min' => 'at least 10 digits without country code',
            'phone.max' => 'not greater than 10 digits without country code',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => ($this->phone) ? '+1'.$this->phone : ' ',
        ]);
    }
}
