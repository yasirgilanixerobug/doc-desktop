<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadPatientDocumentRequest extends FormRequest
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
            'ins_front' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ins_back' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'ins_document' => 'required|mimes:pdf,doc,docx|max:5120',
        ];
    }
}
