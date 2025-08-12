<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PatientProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:100|regex:/^[a-zA-Z\s]*$/',
            'first_name' => 'required|min:3|max:50|regex:/^[a-zA-Z\s]*$/',
            'last_name' => 'required|min:3|max:50|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'gender_id' => 'required|int',
            'about' => 'nullable|string|min:30|max:250',
            'dob' => 'required|date|date_format:Y-m-d|before:today',
            //'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1000',
            'state' => 'nullable|min:2|max:20|regex:/^[a-zA-Z\s]*$/',
            'city' => 'nullable|min:2|max:30|regex:/^[a-zA-Z\s]*$/',
            'address' => 'nullable|string|min:3|max:200',
            'phone' => 'required|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ins_front' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ins_back' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ins_document' => 'nullable|mimes:pdf,doc,docx|max:5120',
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
            'dob' => date('Y-m-d', strtotime($this->dob)),
            'name' => isset($this->name) ? $this->name : $this->first_name. ' '. $this->last_name,
        ]);
    }
}
