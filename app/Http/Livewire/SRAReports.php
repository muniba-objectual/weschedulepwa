<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SRA_Reports;
use Auth;
use App\Models\User;
use App\Model\Child;
class SRAReports extends Component
{

 public $user;
 public $child;
public $entry;
public $entries;

    protected $listeners = [
        'saveReport' => 'saveReport',
        'loadReport' => 'loadReport',
        'deleteReport' => 'deleteReport'
    ];

    protected $rules = [
        'entry.report_title' => 'required',
        'entry.fk_UserID' => 'required',
        'entry.fk_ChildID' => 'required',
        'entry.report_html' => 'required'
    ];


   public function saveReport($userID, $childID, $title, $html) {
       if ($title) {
           $this->entry->report_title = $title;
       }

       if ($userID) {
           $this->entry->fk_UserID = $userID;
       }

       if ($childID) {
           $this->entry->fk_ChildID = $childID;
       }

       if ($html) {
           $this->entry->report_html = $html;
       }

       $this->submit();
   }
    public function submit()
    {

        $validatedData = $this->validate();

        $this->entry->save();
        $this->entry = new SRA_Reports;

    }

    public function loadReport($id) {
       $this->entry = SRA_Reports::where('id','=',$id)->first();
        $this->dispatchBrowserEvent('reportLoaded', ['report' => $this->entry->report_html]);

    }

    public function deleteReport($id) {
        $this->entry = SRA_Reports::where('id','=',$id)->first();
        $this->entry->delete();
        $this->dispatchBrowserEvent('reportDeleted');

    }
    public function mount() {
       $this->entry = new SRA_Reports;
    }
    public function render()
    {
        $this->entries = SRA_Reports::where('fk_ChildID','=',$this->child->id)->get();
        return view('livewire.s-r-a-reports');
    }
}
