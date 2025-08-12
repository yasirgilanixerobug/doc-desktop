<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Api\V2010\Account\MessageInstance;
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
     * @return array
     */
    public function checkBalance(): array
    {
        // Twilio API endpoint for account balance
        $apiUrl = "https://api.twilio.com/2010-04-01/Accounts/{$this->TWILIO_SID}/Balance.json";

        // Make a GET request to retrieve account balance
        $response = Http::withBasicAuth($this->TWILIO_SID, $this->TWILIO_TOKEN)->get($apiUrl);

        // Check if the request was successful (HTTP status code 200)
        if ($response->successful()) {
            // Parse the JSON response
            $balanceData = $response->json();
            $balance = $balanceData['balance'];
            $message = "Your Twilio balance is : $ {$balance}";

            if($balance == 0) {
                $class = 'bg-danger';
            }elseif($balance > 0 && $balance < 4) {
                $class = 'bg-warning';
            }else{
                $class = 'bg-info';        
            }

            return [  // return array of message & balance
                'message' => $message,
                'balance' => $balance,
                'class' => $class
            ];

        } else {
            return [  // return array of message & balance
                'message' => "Failed to retrieve Twilio balance. Status code: {$response->status()}, Error message: Something Wrong",
                'balance' => null,
                'class' => 'bg-gray'
            ];
        }
    }

    /**
     * @param $number
     * @param $message
     * @throws TwilioException
     */
    function sendMessage ($number, $message)
    {
        return $this->client->messages->create($number,
            ['from' => $this->TWILIO_FROM, 'body' => $message]
        );
    }
}
