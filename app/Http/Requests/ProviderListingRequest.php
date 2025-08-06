<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ProviderListing;

class ProviderListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $providerListingId = $this->route('provider_listing');
        $providerId = request()->isMethod('post') 
            ? $this->provider_id
            : ProviderListing::where('id', $providerListingId)->value('provider_id');
        
        return [
            'provider_id' => request()->isMethod('post') ? 'required' : '',
            'location_id' => request()->isMethod('put') ? 'required|unique:provider_listings,location_id,
            '.$providerListingId.',id,provider_id,'.$providerId.',deleted_at,NULL' : 
                'required|unique:provider_listings,location_id,NULL,id,provider_id,' 
                . $providerId . ',deleted_at,NULL',
            'google_review_url' => 'required|min:12|max:250',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'provider_id.required' => 'Provider is required.',
            'location_id.required' => 'Location is required.',
            'location_id.unique' => 'This provider already has a listing for this location.',
        ];
    }
}
