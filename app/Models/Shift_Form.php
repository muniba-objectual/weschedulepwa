<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Shift_Form extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table = "shift_forms";


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $primaryKey = 'id';

    protected $fillable = [
        'fk_ShiftID',
        'datetime',
        'mood_upon_arrival',
        'interaction_with_staff',
        'general_observations',
        'dietary_notes',
        'SRA_enabled',
        'SRA_datetime',
        'SRA_activities',
        'SRA_total_hours_worked'

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


