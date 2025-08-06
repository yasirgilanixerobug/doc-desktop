<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Twilio Logo
    |--------------------------------------------------------------------------
    */
    'twilio_sid'       => env('TWILIO_SID', 'AC24e13d8ed398c0f91b24645c2e68facf'),
    'twilio_token'       => env('TWILIO_TOKEN', '30b5bdc3fb839066a69d8b2d1456892f'),
    'twilio_from'       => env('TWILIO_FROM', '+19705949283'),

    /*
    |--------------------------------------------------------------------------
    | App Placeholder Images
    |--------------------------------------------------------------------------
    */
    'staff_male_placeholder'       => env('STAFF_MALE_PLACEHOLDER', '/upload/placeholder/staff_male.png'),
    'staff_female_placeholder'       => env('STAFF_FEMALE_PLACEHOLDER', '/upload/placeholder/staff_female.png'),
    'location_placeholder'       => env('LOCATION_PLACEHOLDER', '/upload/placeholder/location.png'),
    'provider_male_placeholder'       => env('PROVIDER_MALE_PLACEHOLDER', '/upload/placeholder/provider_male.png'),
    'provider_female_placeholder'       => env('PROVIDER_FEMALE_PLACEHOLDER', '/upload/placeholder/provider_female.png'),

];
