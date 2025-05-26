<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $hotel;

    public function __construct($invoice, $hotel)
    {
        $this->invoice = $invoice;
        $this->hotel = $hotel;
    }

    public function build()
    {
        Log::info('Email sent to: ' . $this->invoice->email);
        return $this->subject('Invoice - ' . $this->invoice->invoice_number)
                    ->view('emails.invoice')   
                    ->with([
                        'invoice' => $this->invoice,
                        'hotelEmail' => $this->hotel,
                    ]);
    }
}
