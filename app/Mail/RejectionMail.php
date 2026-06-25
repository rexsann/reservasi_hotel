<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RejectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pembayaran;
    public $alasan;

    public function __construct($pembayaran, $alasan = null)
    {
        $this->pembayaran = $pembayaran;
        $this->alasan     = $alasan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembayaran Ditolak - ' . $this->pembayaran->reservation->reservation_code,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.rejection',
            with: [
                'pembayaran' => $this->pembayaran,
                'alasan'     => $this->alasan,
            ],
        );
    }
}