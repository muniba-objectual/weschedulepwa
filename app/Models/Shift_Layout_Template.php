<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Shift_Layout_Template extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'fk_UserID',
        'fk_ChildID',
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

    public function get_child() {
        return $this->hasOne(Child::class, "id", "fk_ChildID");

    }


    public function get_home()
    {
        return $this->hasOne(Home::class, "id", "fk_HomeID");
    }

    public function get_user()
    {
        return $this->hasOne(User::class, "id", "fk_UserID");
    }



}


