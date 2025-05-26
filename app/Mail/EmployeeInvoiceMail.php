<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmployeeInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $empData;


    public function __construct($empData)
    {
        $this->empData = $empData;
    }

    public function build()
    {
        return $this->subject('Your Task Invoice Generated')
            ->markdown('emails.employee_invoice');
    }
}
