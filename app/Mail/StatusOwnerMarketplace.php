<?php

namespace App\Mail;

use App\Models\OwnerMarketplace;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusOwnerMarketplace extends Mailable
{
    use Queueable, SerializesModels;

    public $ownerMarketplace;

    /**
     * Create a new message instance.
     */
    public function __construct(OwnerMarketplace $ownerMarketplace)
    {
        $this->$ownerMarketplace = $ownerMarketplace;
        $this->view('emails.owner_marketplace_status')
            ->with(['ownerMarketplace' => $this->ownerMarketplace]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Status Owner Marketplace',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.owner_status_marketplace',
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
