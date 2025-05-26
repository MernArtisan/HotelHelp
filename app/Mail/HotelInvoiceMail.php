<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HotelInvoiceMail extends Mailable
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
        return $this->subject('Hotel Invoice: ' . $this->invoice->invoice_number)
            ->markdown('emails.hotel_invoice');
    }
}
