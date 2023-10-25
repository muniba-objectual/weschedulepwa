<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleChat extends Model
{
    protected $table = "module_chat";

    protected $fillable = [
        'id',
        'fk_UserID',
        'model',
        'fk_ModelID',
        'note'



    ];
    use HasFactory;
}
