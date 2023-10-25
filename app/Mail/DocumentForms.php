<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentForms extends Mailable
{
    use Queueable, SerializesModels;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailSubject, $emailMessage)
    {
        $this->subject = $emailSubject;
        $this->html($emailMessage);
        $this->from(new Address('noreply@casemanage.ca', 'CaseManage.ca - No Reply'));
    }
}
