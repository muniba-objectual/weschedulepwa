<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SRA_Shift_Form_Compilations extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table = "SRA_shift_form_compilations";


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $primaryKey = 'id';

    protected $fillable = [
        'fk_UserID',
        'fk_ChildID',
        'month',
        'date_of_approved_SRA',
        'entry_body'

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

    public function get_shift()
    {
        return $this->belongsTo(Shift::class, "id", "fk_ShiftFormID");
    }
}


