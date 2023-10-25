<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarpeDiem_Notes extends Model
{
    protected $table = "CarpeDiem_Notes";

    protected $fillable = [
        'id',
        'fk_ChildID',
        'fk_UserID',
        'entry_notes',
        'DateOfApprovedCarpeDiem'

    ];
    use HasFactory;
}
