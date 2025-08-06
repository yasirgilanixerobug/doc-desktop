<?php

namespace App\Jobs;

use App\Services\SmsService;
use App\Services\TwilioService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $twilioService;
    public $smsService;
    public $appointmentData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appointmentData)
    {
        $this->appointmentData = $appointmentData;
        $this->twilioService = new TwilioService();
        $this->smsService = new SmsService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->smsService->appointmentMessage($this->appointmentData);
    }
}
