<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'type',

    ];

    public function get_users() {
        return $this->belongsTo(User::class,'id','user_type');
    }
}
