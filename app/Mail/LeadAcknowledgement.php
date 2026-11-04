<?php

namespace App\Mail;

use App\Models\Lead;
use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadAcknowledgement extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Lead $lead)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "We've received your enquiry",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $brandName = SiteSetting::where('key', 'site_name')->value('value')
            ?: config('app.name', 'MEP Solutions');

        return new Content(
            view: 'emails.lead-acknowledgement',
            with: ['brandName' => $brandName],
        );
    }
}
