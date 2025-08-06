<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use App\Rules\ReCaptcha;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ];
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
