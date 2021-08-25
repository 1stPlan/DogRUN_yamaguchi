<?php

namespace App\Mail\Event;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class RemindEventStartForParticipant extends Mailable
{
    use Queueable, SerializesModels;

    public $event; // イベント情報
    public $user;  // ユーザー情報

    /**
     * Create a new message instance.
     *
     * @param mixed $event
     * @param mixed $user
     *
     */

    public function __construct($event, $user) {
        $this->event = $event;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: '【DogRun】参加予定イベントについてのお知らせ',
            from: new Address(config('mail.from.address'), config('mail.from.name')),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.participant',
            with: [
                'event' => $this->event,
                'user' => $this->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
