<?php

namespace App\Mail;

use App\Models\Attachment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class TemplateMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $mailData = array(); 
    /**
     * Create a new message instance.
     */
    public function __construct($mailData = array())
    {
       $this->mailData = $mailData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $fromEmail  = $this->mailData['from_email'] ?? null;
        $fromName   = $this->mailData['from_name'] ?? null;
        $from = $fromEmail ? new Address($fromEmail, $fromName) : null;
        
        $cc = $this->mailData['cc'] ?? null;
        $bcc = $this->mailData['bcc'] ?? null;
        $reply_to =  $this->mailData['reply_to'] ?? null;

        return new Envelope(
            subject: $this->mailData['subject'],
            from: $from,  
            replyTo: $reply_to,
            cc: $cc,
            bcc: $bcc,
        );
    }
    /**
     * Get the message headers.
     */
    public function headers(): Headers
    {
        return new Headers(
            text: [
                'X-SES-CONFIGURATION-SET' => env('EMAIL_CONFIG_SET','eSheet'),
            ],
        );
    }
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.template',
            with: [
                'content' => $this->mailData['content']
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        if(!empty($this->mailData['attachments'])){
            foreach($this->mailData['attachments'] as $attachment){
                $attachments[] = Attachment::fromPath($attachment['path'])
                ->as($attachment['name']);
            }
            return $attachments;
        }
        return [];
    }
}
