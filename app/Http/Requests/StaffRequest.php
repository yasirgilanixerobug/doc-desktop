<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'name' => 'required|min:3|max:50|regex:/^[a-zA-Z\s]*$/',
            'first_name' => 'required|min:3|max:50|regex:/^[a-zA-Z\s]*$/',
            'last_name' => 'required|min:3|max:50|regex:/^[a-zA-Z\s]*$/',
            'phone' => 'required|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'role' => 'required',
            'location_id' => 'required',
            'email' => request()->isMethod('put') ? 'required|email|unique:users,email,'.$this->user_id : 'required|email|unique:users,email',
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
            'phone.max' => 'not greater than 12 digits without country code',
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
            'name' => isset($this->first_name) ? $this->first_name.' '.$this->last_name : $this->name,
            'phone' => ($this->phone) ? '+1'.$this->phone : ' ',
        ]);
    }
}
