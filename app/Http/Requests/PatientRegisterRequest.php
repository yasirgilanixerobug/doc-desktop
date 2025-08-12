<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use App\Rules\ReCaptcha;

class PatientRegisterRequest extends FormRequest
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
            'first_name' => 'required|min:3|max:25|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|min:3|max:25|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'email' => 'required|email',
            'dob' => 'required|date|date_format:Y-m-d|before:today',
            'state' => 'nullable|min:2|max:20',
            'city' => 'nullable|min:2|max:30',
            'address' => 'nullable|string|min:3|max:200',
            'zip_code' => 'nullable|regex:/^(?:(\d{5})(?:[ \-](\d{4}))?)$/i',
            'password' => 'required|min:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
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
            'ins_front.mimes' => 'only jpeg,png,jpg,webp',
            'ins_back.mimes' => 'only jpeg,png,jpg,webp',
            'ins_document.mimes' => 'only pdf,doc,docx',
            'dob.date_format' => 'Date of Birth Format is m/d/Y'
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
            'phone' => '+1'.$this->phone,
            'dob' => date('Y-m-d', strtotime($this->dob)),
        ]);
    }


    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (isset(request()->appointment_form_type)) {
                if (!Session::has('appointment_form_type') || Session::has('appointment_form_type'))
                {
                    Session::put('appointment_form_type', request()->appointment_form_type);
                }
            }

//            if (!$validator->failedRules) {
//                if (Session::has('appointment_form_type')) {
//                    Session::forget('appointment_form_type');
//                }
//            }
        });
    }
}
