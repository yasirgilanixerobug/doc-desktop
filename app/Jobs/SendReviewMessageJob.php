<?php

namespace App\Jobs;

use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Exceptions\TwilioException;

class SendReviewMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $requestData;
    private $followUpPatients;
    private $smsService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($requestData, $followUpPatients)
    {
        $this->requestData = $requestData;
        $this->followUpPatients = $followUpPatients;
        $this->smsService = new SmsService();
    }

    /**
     * @return void
     * @throws TwilioException
     */
    public function handle()
    {
        $this->smsService->sendReviewMessages($this->followUpPatients);
    }
}
