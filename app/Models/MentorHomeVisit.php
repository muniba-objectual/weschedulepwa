<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Comments\Models\Concerns\HasComments;

class MentorHomeVisit extends Model
{

    protected $table = "mentor_home_visits";

    use HasComments;


    /*
     * This string will be used in notifications on what a new comment
     * was made.
     */
    public function commentableName(): string {return '';} //TODO::ashain, follow up with michello on this return value


    /*
     * This URL will be used in notifications to let the user know
     * where the comment itself can be read.
     */
    public function commentUrl(): string {return '';} //TODO::ashain, follow up with michello on this return value


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'fk_UserID',
        'fk_HomeID',
        'notes',

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

    public function getUser() {
        return $this->hasOne(User::class,"id","fk_UserID");
    }

    public function getHome() {
        return $this->hasOne(MentorHome::class,"id","fk_HomeID");
    }

    /**
     * The user that belong to the MentorHomeVisit (used for Seen/Unseen functoin).
     */
    public function users()
    {
        return $this->belongsToMany(User::class,'mentor_home_visit_user','mentor_home_visit_id','user_id')

            ->as('seen_unseen')
            ->withTimestamps();
    }

}


