<?php

namespace App\Models;

use App\Http\Controllers\Medication_Entries;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravelista\Comments\Commentable;

use App\Models\Child;

class ChildNotification extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Commentable;

    public $table = "child_notifications_schedule";


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'notification_events',
        'notification_message',
        'notification_schedule',
        'notification_method',
        'notification_addresses',
        'fk_ChildID'
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
        return $this->hasOne(Child::class,"id","fk_ChildID");
    }


}


