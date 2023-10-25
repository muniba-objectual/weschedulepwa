<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PFA_Notes extends Model
{
    protected $table = "PFA_Notes";

    protected $fillable = [
        'id',
        'fk_ChildID',
        'fk_UserID',
        'entry_notes',
        'DateOfApprovedPFA'

    ];
    use HasFactory;
}
