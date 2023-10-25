<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Activity_Photo extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table = "activity_photos";


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $primaryKey = 'id';

    protected $fillable = [
        'photo',
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

    public function get_child()
    {
        return $this->belongsTo(Child::class, "id", "fk_ChildID");
    }

    public function get_user()
    {
        return $this->belongsTo(User::class, "fk_UserID", "id");
    }

    public function get_child_related_activities() {
        return $this->belongsTo(Child::class, "id", "fk_ChildID");
    }

    public function get_user_related_activities() {
        return $this->belongsTo(User::class, "id", "id");
    }

    public function getPostTimeRelative() {
        return Carbon::createFromTimeStamp(strtotime($this->updated_at))->diffForHumans(Carbon::now());
    }
}


