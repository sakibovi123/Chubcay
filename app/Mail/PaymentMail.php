<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $package;
    public $user;
    public $link;

    /**
     * Create a new message instance.
     */
    public function __construct($package, $user, $link)
    {
        $this->package = $package;
        $this->user = $user;
        $this->link = $link;
    }

    
    public function build()
    {
        return $this->subject('QR Information')
            ->view('mail.payment')
            ->with([
                'package' => $this->package,
                'user' => $this->user,
                'link' => $this->link
            ]);

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
