<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\Incident_Entry;
use Illuminate\Support\Facades\Storage;

class SendIR_Mail extends Mailable
{
    use Queueable, SerializesModels;

    public $IR;
    public $pdf;

    public $subject;
    public $messageContent;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($IRid, $subject, $messageContent)
    {
//        $this->IR = $IR;
        $incident = Incident_Entry::with('EditedRevisions')->where('id','=',$IRid)->first();
        $this->subject = $subject;
        $this->messageContent = $messageContent;

        $this->pdf = Pdf::loadView('saveIR_Report',compact('incident'));

//        return $pdf->download('test.pdf');
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('noreply@casemanage.ca', 'CaseManage.ca - No Reply'),
            subject: $this->subject,
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
            view: 'emails.sendIR_Template'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
//        return [];

        //save PDF temporarily
        Storage::put('public/tmp/IR_Report/IR_Report.pdf', $this->pdf->output());


       return [
            Attachment::fromData(fn () => $this->pdf->output(), 'IR_Report.pdf')
            ->withMime('application/pdf'),
            ];
    }
}
