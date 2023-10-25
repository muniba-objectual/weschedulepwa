<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarpeDiem_Contracts extends Model
{
    protected $table = "CarpeDiem_Contracts";

    protected $fillable = [
        'id',
        'fk_ChildID',
        'fk_UserID',
        'contract_attachment',
        'active'

    ];
    use HasFactory;
}
