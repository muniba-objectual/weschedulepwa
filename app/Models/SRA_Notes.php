<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SRA_Notes extends Model
{
    protected $table = "SRA_Notes";

    protected $fillable = [
        'id',
        'fk_ChildID',
        'fk_UserID',
        'entry_notes',
        'DateOfApprovedSRA'

    ];
    use HasFactory;
}
