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

    public const DEFAULT_SUBJECT = "We've received your enquiry";

    public const DEFAULT_BODY = "We've received your enquiry and our team will contact you shortly. Here's what you sent:";

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
        $subject = SiteSetting::where('key', 'auto_reply_subject')->value('value');
        $subject = filled($subject) ? $subject : self::DEFAULT_SUBJECT;

        return new Envelope(
            subject: $this->replacePlaceholders($subject),
        );
    }

    /**
     * Replace {name}, {service} and {company} in admin-authored text.
     */
    private function replacePlaceholders(string $text): string
    {
        $brandName = SiteSetting::where('key', 'site_name')->value('value')
            ?: config('app.name', 'MEP Solutions');

        return str_replace(
            ['{name}', '{service}', '{company}'],
            [$this->lead->name, $this->lead->service ?: 'General enquiry', $brandName],
            $text
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $brandName = SiteSetting::where('key', 'site_name')->value('value')
            ?: config('app.name', 'MEP Solutions');

        // Admin-editable body with placeholder support; blank falls back to default copy.
        $body = SiteSetting::where('key', 'auto_reply_body')->value('value');
        $body = $this->replacePlaceholders(filled($body) ? $body : self::DEFAULT_BODY);

        return new Content(
            view: 'emails.lead-acknowledgement',
            with: ['brandName' => $brandName, 'body' => $body],
        );
    }
}
