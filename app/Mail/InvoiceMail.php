<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pembayaran;

    public function __construct($pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Invoice - ' . $this->pembayaran->reservation->reservation_code,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invoice',
            with: ['pembayaran' => $this->pembayaran],
        );
    }
}