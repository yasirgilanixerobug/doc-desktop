<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
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
            'first_name' => 'required|max:50|regex:/^[a-zA-Z\s]*$/',
            'last_name' => 'required|max:50|regex:/^[a-zA-Z\s]*$/',
            'phone' => 'required|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'email' => request()->isMethod('put') ? 'required|email|unique:users,email,'.$this->user_id : 'required|email|unique:users,email',
            'about' => 'nullable|string',
            'home' => 'nullable|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'office' => 'nullable|min:12|max:12|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'fax' => 'nullable|min:12|max:13|regex:/^\\+?[1-9][0-9]{7,13}\S$/',
            'gender_id' => 'nullable|int',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2000',
            'state' => 'nullable|min:2|max:20|regex:/^[a-zA-Z\s]*$/',
            'city' => 'nullable|min:2|max:30|regex:/^[a-zA-Z\s]*$/',
            'address' => 'string|min:3|max:200|nullable',
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
            'fax.regex' => '3456789123 10 digits',
            'home.regex' => '3456789123 10 digits without country code',
            'office.regex' => '3456789123 10 digits without country code',
            'name.regex' => 'only contain alphabets and space',
            'state.regex' => 'only contain alphabets and space',
            'city.regex' => 'only contain alphabets and space',
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
            'fax' => ($this->fax) ? '+1'.$this->fax : ' ',
            'home' => ($this->home) ? '+1'.$this->home : ' ',
            'office' => ($this->office) ? '+1'.$this->office : ' ',
        ]);
    }
}
