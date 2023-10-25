<?php

namespace App\Http\Livewire;

use App\Models\Shift;
use App\Models\Shift_Form;
use App\Models\User;
use Livewire\Component;
use Auth;
use \Carbon\Carbon;
use Illuminate\Support\Collection;
use DateTime;
class SRA extends Component
{
    public $child;

    public $SRA_Form_entries;
    public Shift_Form $SRA_entry;
    public $original_shift_ID;
    public $html_template;
    public $selectedSRA = [];
    public $key = "";

    public $SRA_Notes;
    protected $listeners = [
        'viewSRA' => 'viewSRA',
        'generate' => 'generate',
        'generateAll' => 'generateAll',
        'saveDateOfApprovedSRA' => 'saveDateOfApprovedSRA'
    ];

    protected $rules = [
        'SRA_entry.interaction_with_staff' => 'required',
        'child.DateOfApprovedSRA' => 'nullable'
        ];

    public function updatedSelectAll($value)
    {
        if ($value) {
                $this->selectedSRA = $value;
        } else {
            $this->selectedSRA = [];
        }
    }



    public function saveDateOfApprovedSRA($newDate) {
        if ($newDate) {
            $this->child->DateOfApprovedSRA = \Carbon\Carbon::parse($newDate)->format('Y-m-d');
            $this->child->save();
            $this->dispatchBrowserEvent('DateSaved');
        }


        }


    public function submit()
    {

        $validatedData = $this->validate();
        if ($this->SRA_entry->exists) {
            //shift form already exists
            $this->SRA_entry->save();;
        } else {
            //brand new shift form
            $this->SRA_entry->save();;
            $tmpShift = Shift::where('id','=',$this->original_shift_ID)->first();
            $tmpShift->fk_ShiftFormID = $this->SRA_entry->id;
            $tmpShift->save();
        }

        //$this->emitTo('s-r-a-generate','cartRefresh');

        $this->dispatchBrowserEvent('closeSRAModal');

        //Reset Model
        $this->SRA_entry = new Shift_Form();

        //$tmpSRA_form_entries = Shift::where('fk_ChildID','=',$this->child->id)->where('fk_ShiftFormID','!=','')->orderBy('start','ASC')->get();
        $tmpSRA_form_entries = Shift::where('fk_ChildID','=',$this->child->id)->orderBy('start','ASC')->get();
        $SRA_Form_entries = array();
        foreach ($tmpSRA_form_entries as $key=>$shift_entry) {
            $tmp = Shift_Form::find($shift_entry->fk_ShiftFormID);

            $SRA_Form_entries[$key] = $shift_entry;
            $SRA_Form_entries[$key]['shift_form'] = $tmp;
            //$SRA_Form_entries[$key] = $tmp;
            $SRA_Form_entries[$key]['user'] = User::where("id","=",$shift_entry->fk_UserID)->first()->name;
            }

        $this->SRA_Form_entries = $SRA_Form_entries;
       // $this->emit('generate');
        //return redirect()->back();
    }

    public function render()
    {
        return view('livewire.s-r-a');
    }

    public function viewSRA($id) {
        //$record = Medication_Entry::findOrFail($id);
        $this->original_shift_ID = $id;
        $this->SRA_entry = Shift_Form::findOrNew(Shift::where('id','=',$id)->get()->first()->fk_ShiftFormID);
        //Shift_Form::findOrFail($id);
        $this->dispatchBrowserEvent('viewSRAModal');

    }

    public function generate()
    {

        if (!is_array($this->selectedSRA)) {
            $this->dispatchBrowserEvent('no_entries_selected');
            unset ($this->selectedSRA);

            return;

        }
        if (count($this->selectedSRA) <=0) {
            $this->dispatchBrowserEvent('no_entries_selected');
            unset ($this->selectedSRA);

            return;
        }
        if (strpos(json_encode($this->selectedSRA),"empty") !== false) {
            //selected entries contain an empty (red) entry
            $this->dispatchBrowserEvent('user_selected_empty_entry');
            unset ($this->selectedSRA);

        } else {
            //selected entries all contain data
            $child = $this->child;

            $html2 = '';
            rsort($this->selectedSRA);
            $selectedSRA_Sorted = [];
            $total_hours_sum = 0;

            foreach ($this->selectedSRA as $key=>$tmp) {
                if ($key == 0) {
                    //get date month index from first entry
                    $entry = Shift_Form::where('id', '=', Shift::where('id', '=', $tmp)->get()->first()->fk_ShiftFormID)->first();
                    $entry_OriginalShift = Shift::where('id', '=', $tmp)->get()->first();
                    $SD = Carbon::parse($entry_OriginalShift->start);
                    $this->key = $SD->format('M Y');
                }
                $entry = Shift_Form::where('id', '=', Shift::where('id', '=', $tmp)->get()->first()->fk_ShiftFormID)->first();
                $entry_OriginalShift = Shift::where('id', '=', $tmp)->get()->first();
                $SD = Carbon::parse($entry_OriginalShift->start);
                $ED = Carbon::parse($entry_OriginalShift->end);

                $total_hours = $SD->floatDiffInHours($ED);
                //round to nearest fourths (i.e. .00, .25, .50, .75)

                $total_hours_sum = floor(($total_hours_sum + $total_hours)*4)/4;
                $entry_user = User::where("id", "=", $entry_OriginalShift->fk_UserID)->first();

                if ($entry_user->signature) {
                    $sig = $entry_user->signature;
                } else {
                    $sig = "/img/blank.png";
                }
                //foreach ($this->SRA_Form_entries as $entry) {

                $selectedSRA_Sorted[$key]['entry'] = $entry;
                $selectedSRA_Sorted[$key]['entry_OriginalShift'] = $entry_OriginalShift;
                $selectedSRA_Sorted[$key]['SD'] = $SD;
                $selectedSRA_Sorted[$key]['ED'] = $ED;
                $selectedSRA_Sorted[$key]['total_hours'] = $total_hours;
                $selectedSRA_Sorted[$key]['entry_user'] = $entry_user;
                $selectedSRA_Sorted[$key]['sig'] = $sig;
                $selectedSRA_Sorted[$key]['startFormatted'] = strtotime($SD->format("Y-m-d"));
            }

            array_multisort(array_map(function($element) {
                return $element['startFormatted'];
            }, $selectedSRA_Sorted), SORT_ASC, $selectedSRA_Sorted);

            //dd($selectedSRA_Sorted);

            foreach ($selectedSRA_Sorted as $tmp) {
                //dd($tmp);
                $html2 .= '<tr>
<td width="104">
<p>' . Carbon::parse($tmp['entry_OriginalShift']['start'])->format('M d Y') . '</p>
</td>
<td width="396">

<p>' . $tmp['entry']['interaction_with_staff'] . '</p>
</td>
<td width="84" align="center">
<p>' . $tmp['total_hours'] . '</p>
</td>
<td width="162" align="center">
<p>' . $tmp['entry_user']['name'] . '</p>
</td>
<td width="198" align="center">
' . '<img src="' . $tmp['sig'] . '" />
</td>
</tr>

';
            }


            $html1 = '<div class="mceNonEditable"><p><img src="../img/SRA_header.jpg" width="923" height="120" /></p>
                    <p>&nbsp;</p>
                    <p style="text-align: center;"><strong>Special Rate Agreement Signature Sheet for Hours Worked</strong></p>
                    <p style="text-align: center;"><strong><u>Must Be Completed and Attached to All Invoices</u></strong></p>
                    <table width="924">
                    <tbody>
                    <tr>
                    <td width="123">
                    <p><strong>Month: </strong></p>
                    </td>
                    <td width="132"><p>' . $this->key . '

                    </td>
                    <td width="161">
                    <p><strong>Child/Youth&rsquo;s Name: <br />Preferred pronoun</strong></p>
                    </td>
                    <td width="508">
                    <p><strong>' . $child->initials . '</strong></p>
                    </td>
                    </tr>
                    <tr>
                    <td width="123">
                    <p>Date of Approved SRA :</p>
                    </td>
                    <td colspan="3" width="801">
                    <p><strong>' . \Carbon\Carbon::parse($child->DateOfApprovedSRA)->format('M d, Y') . '</strong></p>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                     <table width="924">
                    <thead>
                    <tr>
                    <td width="104">
                    <p><strong><em>Date</em></strong></p>
                    </td>
                    <td width="396">
                    <p><strong><em>Activities spent in 1-1 time (please detail by hour, where the 1-1 time was provided &amp; relatedness of activity to initial goal of SRA )</em></strong></p>
                    </td>
                    <td width="84">
                    <p><strong><em>Total # Hours</em></strong></p>
                    <p><strong><em>Worked</em></strong></p>
                    </td>
                    <td width="162">
                    <p><strong><em>Name 1-1 worker</em></strong></p>
                    <p><strong><em>(PLEASE PRINT)</em></strong></p>
                    </td>
                    <td width="198">
                    <p><strong><em>Staff Signature</em></strong></p>
                    </td>
                    </tr>
                    </thead>
                    <tbody>';



            $html3 = '
<tr><td colspan="2" align="center"><strong>Total Hours Worked</strong></td>
<td align="center"><strong>' . $total_hours_sum . '</strong></td>
</tr>
</tbody>
</table>
<p><b>Signature of person with authority to bind the Resource</b></p>
<img src="../img/owner_sig.png"  height="200" />
<br />
<b>Joint OACAS/ANCFSAO Residential Services Critical Issues Implementation</b>
</div>';

            $this->html_template = $html1 . $html2 . $html3;

            $this->dispatchBrowserEvent('updateTinyMCE', ['htmlContent' => $this->html_template]);
            unset ($this->selectedSRA);
        }
    }
    public function mount($child)
    {

        $this->html_template = "<div class='mceNonEditable'>Report has not been generated.</div>";
        $this->selectAll = false;
    }

}
