<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailAfterAcceptingRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $fee;
    public $link;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($message, $fee, $link, $user)
    {
        $this->message = $message;
        $this->fee = $fee;
        $this->link = $link;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('QR Information')
            ->view('mail.accept')
            ->with([
                'message', $this->message,
                'fee', $this->fee,
                'link', $this->link,
                'user', $this->user,
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
