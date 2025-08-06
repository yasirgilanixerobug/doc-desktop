<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
     * https://uibakery.io/regex-library/phone-number-php
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:50|regex:/^[a-zA-Z0-9\s]*$/',
            'per_appointment_min' => ['required','int','regex:/(10|15|30|60)/'],
            'state' => 'required|min:2|max:20|regex:/^[a-zA-Z\s]*$/',
            'city' => 'required|min:2|max:30|regex:/^[a-zA-Z\s]*$/',
            'address' => 'required|string|min:3|max:200',
            'phone' => 'nullable|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'fax' => 'nullable|min:12|max:13|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'email' => 'nullable|email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'google_review_url' => 'nullable|max:250',
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
            'per_appointment_min.regex' => 'Appointment Mint 10,15,30, or 60 only',
            'phone.regex' => '3456789123 10 digits without country code',
            'phone.min' => 'at least 10 digits without country code',
            'phone.max' => 'not greater than 10 digits without country code',
            'fax.regex' => '3456789123 10 digits',
            'google_review_url.max' => 'max character lenght 250'
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
            'fax' => ($this->fax) ? '+1'.$this->fax : ' ',
        ]);
    }
}
