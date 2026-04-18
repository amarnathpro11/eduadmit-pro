<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadCommunicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;
    public $customMessage;

    /**
     * Create a new message instance.
     */
    public function __construct($lead, $customMessage = null)
    {
        $this->lead = $lead;
        $this->customMessage = $customMessage ?? "We are excited to help you with your admission process for " . ($lead->course->name ?? 'our courses') . ".";
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Follow-up regarding your inquiry - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.lead_communication',
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

