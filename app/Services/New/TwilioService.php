<?php

namespace App\Services\New;

use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
use Exception;

class TwilioService {

    private $client;

    function __construct()
    {
        $this->client = new Client(config('custom.twilio_sid'), config('custom.twilio_token'));
        $this->TWILIO_SID = config('custom.twilio_sid');
        $this->TWILIO_TOKEN = config('custom.twilio_token');
        $this->TWILIO_FROM = config('custom.twilio_from');
    }

    /**
     * @param $number
     * @param $message
     * @return bool
     * @throws TwilioException
     */
    function sendMessage ($number, $message): bool
    {
        $message = $this->client->messages->create($number,
            ['from' => $this->TWILIO_FROM, 'body' => $message]
        );

        //check message is false then return false, if message is true then return true
    }
}
