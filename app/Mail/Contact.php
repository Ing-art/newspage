<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public $message; // message info

    /**
     * Create a new message instance.
     */
    public function __construct($message)
    {
        //Create a new message instance
        $this->message = $message;
        dd($message); //FIXME
    }

/*     public function build(){
        return $this->from($this->message->email)
                    ->subject('Message received: '.$this->message->subject)
                    ->with('Madworld News')
                    ->view('emails.contact');
    } */

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->message->subject,
        );


    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with: ['body' => $this->message->msg,],
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
