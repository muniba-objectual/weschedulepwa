<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $table = "notifications";

    protected $fillable = [
        'id',
        'fk_UserID',
        'model',
        'fk_ModelID',
        'active'



    ];
    use HasFactory;
}
