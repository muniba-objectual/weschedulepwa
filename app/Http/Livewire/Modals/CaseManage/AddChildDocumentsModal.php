<?php

namespace App\Http\Livewire\Modals\CaseManage;


use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Child;
use App\Models\ChildDocuments;
use WireElements\Pro\Components\Modal\Modal;
use Carbon\Carbon;
use Auth;

use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class AddChildDocumentsModal extends Modal
{
    use WithMedia;

     public $show;
     public $user;
    public $userID;
    public $childID;
    public $AuthUserID;

    public $size;

   public $type;
    public $date;
    public $renewal_date;
    public $recurring;

    public $mediaComponentNames = ['myUpload'];

    public $myUpload;

    protected $rules = [
        'date' => 'required',
        'description' => 'nullable',
        'myUpload' => 'required',
        'type' => 'required'


    ];

    protected $listeners = ['showModal' => 'showModal', 'updateDocument' => 'updateDocument'];

    public function updateDocument($value) {
        if ($value) {
            //convert date/time to Carbon
            $this->tmpDate = Carbon::parse($value)->toDateTimeString();
        }
        $this->date = $value;



    }
    public static function attributes(): array
    {
        return [
                // Set the modal size to 2xl, you can choose between:
                // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
                'size' => '7xl',

            ];
    }

    public function mount() {

    //$this->callDateTime = "";
    $this->description = "";
    $this->amount = "0.00";
    $this->date = Date('m/d/Y');
    }


    public function submit()
    {
        // Do Something With Your Modal


            $this->validate();
            $formSubmission = ChildDocuments::create([
                'type' => $this->type,
                'description' => $this->description,
                'date' => \Carbon\Carbon::parse($this->date)->toDateString(),
                'fk_ChildID' => $this->childID

            ]);

        $formSubmission
            ->addFromMediaLibraryRequest($this->myUpload)
            ->toMediaCollection($this->type);




        // Close Modal After Logic
        $this->close();


    }

    public function render()
    {
        return view('livewire.modals.case-manage.add-child-document-modal');
    }
}
