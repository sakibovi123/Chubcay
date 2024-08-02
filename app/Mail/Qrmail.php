<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Qrmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfLink;
    /**
     * Create a new message instance.
     */
    public function __construct($pdfLink)
    {
        $this->pdfLink = $pdfLink;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject('QR Information')
            ->view('mail.qr')
            // ->with('qrImage', $this->pdfLink)
            ->attach($this->pdfLink);
     }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
