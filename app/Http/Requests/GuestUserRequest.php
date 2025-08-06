<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestUserRequest extends FormRequest
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
            'first_name' => 'required|min:3|max:50|regex:/^[a-zA-Z\s]*$/',
            'last_name' => 'required|min:3|max:50|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required',
            'phone' => 'required|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'office' => 'nullable|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'fax' => 'nullable|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'home' => 'nullable|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'state' => 'nullable',
            'city' => 'nullable',
            'address' => 'nullable',
            'zip_code' => 'nullable|regex:/^(?:(\d{5})(?:[ \-](\d{4}))?)$/i',
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
            'fax.regex' => '3456789123 10 digits without country code',
            'home.regex' => '3456789123 10 digits without country code',
            'office.regex' => '3456789123 10 digits without country code',
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
            'office' => ($this->office) ? '+1'.$this->office : ' ',
            'home' => ($this->home) ? '+1'.$this->home : ' ',
        ]);
    }
}
