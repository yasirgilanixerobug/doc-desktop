<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): NewAppointmentMail
    {
        $date = $this->details['data']['appointment_date'];
        $time = $this->details['data']['appointment_time'];
        $attachDocument = $this->details['data']['ins_attach'];
        $patientName = $this->details['data']['patient_name'];
        $status = $this->details['data']['appointment_status'];
        $subject = 'Appointment ' . $status . ' for '. date('d M Y', strtotime($date)). ' '. $time .' with '. $patientName;
        $email = $this->subject($subject)
            ->view('emails.new-appointment');

        if ( $this->details['is'] === 'staff_message' || $this->details['is'] === 'patient_message') {
            foreach($attachDocument as $filePath){
                $email->attach($filePath);
            }
        }

        return $email;

    }
}
