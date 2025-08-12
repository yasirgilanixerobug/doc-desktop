<?php

namespace App\Console\Commands;

use App\Models\RequestReview;
use App\Services\SmsService;
use Exception;
use Illuminate\Console\Command;

class SendMessageForReview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:message-for-review';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command send all pending messages to patient for review';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $requestReviews = RequestReview::where(['sms_status' => RequestReview::NOT_SEND])
            ->with('clinic')
            ->limit(50)
            ->get()
            ->toArray();

        try {
            $sendService = new SmsService();
            $sendService->sendReviewMessages($requestReviews);
        } catch (Exception $e) {
            info("Error: ". $e->getMessage());
        }

    }
}
