<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAppointmentRequest extends FormRequest
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
            'location_id' => 'required',
            'provider_id' => 'required',
            'start_time' => 'required',
            'date' => 'required',
            'comment' => 'nullable'
        ];
    }

    public function prepareForValidation()
    {
        $formData =  [];
        parse_str($this->form_data, $formData);

        $this->merge([
            'location_id' => $formData['location_id'],
            'provider_id' => $formData['provider_id'],
            'start_time' => $formData['start_time'],
            'date' => $formData['date'],
            'comment' => $formData['comment'],
        ]);
    }
}
