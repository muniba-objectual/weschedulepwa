<?php

namespace App\Http\Livewire\Forms\CaseManage\Temp;

use App\Models\DocumentShare;
use App\Models\TempFormData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class EmailLinkSharing extends Component
{

    use LivewireAlert;
    use WithFileUploads;

    public $emailTo         = '';
    public $emailSubject    = 'New Email';
    public $emailMessage    = '';

    public $password;
    public $formattedExpireDate;

    protected $listeners    = [
        'addEmailAddress',
        'setSubject',
        'initEmailConf',
    ];
    public $documentShareId;
    public $classReference;
    public $formId;


    public function sendEmail()
    {
        if ($this->emailTo && $this->emailSubject && $this->emailMessage) {
            $emailAddresses = array_map('trim', explode(',', $this->emailTo));

            $this->updateDocumentShare();

            try {
                //apply to(s)
                $mailInstance = Mail::to($emailAddresses);

                //apply CC(s) if exists
                $preAdmissionCCs = array_filter(array_map('trim', explode(',', config('app.pre-admisions-cc', ''))));
                if( count($preAdmissionCCs) ){
                    $mailInstance = $mailInstance->cc($preAdmissionCCs);
                }

                //send email
                $mailInstance = $mailInstance->send(new \App\Mail\DocumentForms($this->emailSubject, $this->emailMessage));


                /**
                 * @var DocumentShare $documentShare
                 * @var TempFormData $form
                 */

                //mark as sent in DocumentShare
                $documentShare = DocumentShare::find($this->documentShareId);
                $documentShare->email_sent_at = now();
                $documentShare->email = $emailAddresses;
                $documentShare->save();


                //save the shareIDs to form, as cache for faster reading.
                $form = TempFormData::findOrFail($this->formId);
                $form->pushVal('document_share_ids', $documentShare->id)->save();


                //if there is any after action to do after sending the email, then do it.
                $className = $this->classReference;
                if (method_exists($className, 'afterEmailSent')) {
                    $className::afterEmailSent($documentShare, $form);
                }

            } catch (\Exception $e) {
                $this->alert('error', 'Error sending email: ' . $e->getMessage(), [
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return;
            }

            $this->alert('success', 'Email Sent Successfully', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
            $this->dispatchBrowserEvent('hideSpinner');
        }
    }

    public function setSubject(string $subject): void
    {
        $this->emailSubject = $subject;
    }

    public function initEmailConf(DocumentShare $documentShare, int $formId, $classReference): void
    {
        $this->classReference       = $classReference;
        $this->documentShareId      = $documentShare->id;
        $this->formId               = $formId;
        $this->password             = $documentShare->password;
        $this->emailTo              = implode(',', $documentShare->email);
        $this->formattedExpireDate  = $documentShare->link_expire_at->format('Y-m-d H:i');
        $this->emailMessage         = $documentShare->download_html;
    }

    public function updateDocumentShare(): void
    {
        /** @var $ds DocumentShare */
        $ds = DocumentShare::query()->findOrFail($this->documentShareId);
        $ds->password       = $this->password;
        $ds->link_expire_at = Carbon::parse($this->formattedExpireDate);
        $ds->download_html  = $this->emailMessage;
        $ds->save();


        // Call the form email build function
        $className = $this->classReference;
        $className::writeEmailBody($ds);
        $ds->save();
        $this->emailMessage = $ds->download_html;
    }

    public function updated(){
        $this->updateDocumentShare();
    }


    public function addEmailAddress(string $newEmail): void
    {
        $existingEmails = array_map('trim', explode(',', $this->emailTo));

        // Remove any empty elements from the existing emails array
        $existingEmails = array_filter($existingEmails);

        if (!in_array($newEmail, $existingEmails)) {
            $existingEmails[] = $newEmail;
        }

        $this->emailTo = implode(',', $existingEmails);
    }

    public function render()
    {
        return view('livewire.forms.case-manage.temp.email-link-sharing');
    }
}
