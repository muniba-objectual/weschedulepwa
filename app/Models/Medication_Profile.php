<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Medication_Profile extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table = "medication_profile";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $primaryKey = 'id';

    protected $fillable = [
        'fk_ChildID',
        'fk_UserID',
        'type',
        'dosage',

    ];


    protected $guarded = [

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];

    protected $appends = ['username'];

    public function getUsernameAttribute(){
        $username = \App\Models\User::where('id','=',$this->fk_UserID)->get()->first();
        if ($username) {
            return $username->name;
        } else {
            return "N/A";
        }


    }


    public function get_child()
    {
        return $this->belongsTo(Child::class, "fk_ChildID", "id");
    }


}


