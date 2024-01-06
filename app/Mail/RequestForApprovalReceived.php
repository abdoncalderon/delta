<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestForApprovalReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $needRequest;

    public $subject;

    public function __construct($needRequest)
    {
        $this->needRequest = $needRequest;
    }

    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('messages.requestForApprovalReceived'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.requestForApprovalReceived',
        );
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
