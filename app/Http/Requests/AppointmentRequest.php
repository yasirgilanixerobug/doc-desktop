<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AppointmentRequest extends FormRequest
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
            'first_name' => 'required|max:25|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|max:25|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'email' => 'required|email',
            'dob' => 'required|date|before:' . Carbon::now()->subYears(14)->toDateString(),
            'state' => 'nullable|min:2|max:20',
            'city' => 'nullable|min:2|max:30',
            'address' => 'nullable|string|min:3|max:200',
            'zip_code' => 'nullable|regex:/^(?:(\d{5})(?:[ \-](\d{4}))?)$/i',
            'comment' => 'nullable|string|min:3|max:200',
            'other_name' => 'nullable|min:3|max:50|regex:/^[a-zA-Z\s]+$/',
            'appointment' => 'required',
            'ins_front' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ins_back' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ins_document' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'termsConditions' => 'required|in:1',
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
            'dob.before' => 'age must be atleast 14 years',
            'termsConditions.required' => 'You must be agree to the Terms & Conditions to proceed'
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
