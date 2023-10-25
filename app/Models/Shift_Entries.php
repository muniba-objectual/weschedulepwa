<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift_Entries extends Model
{
    public $table = "shift_entries";

    use HasFactory;

    protected $fillable = [
        'fk_ShiftID', 'shift_start', 'shift_end', 'fk_ShiftFormID', 'fk_MedicationFormID'
    ];
}
