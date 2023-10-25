<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ISA_Notes extends Model
{
    protected $table = "ISA_Notes";

    protected $fillable = [
        'id',
        'fk_ChildID',
        'fk_UserID',
        'entry_notes',
        'DateOfApprovedISA'

    ];
    use HasFactory;
}
