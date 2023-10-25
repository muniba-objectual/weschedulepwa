<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Comments\Models\Concerns\HasComments;

class OnCall extends Model
{

    protected $table = "oncall";

    use HasComments;


    /*
 * This string will be used in notifications on what a new comment
 * was made.
 */
    public function commentableName(): string
    {
        //
    }

    /*
     * This URL will be used in notifications to let the user know
     * where the comment itself can be read.
     */
    public function commentUrl(): string
    {

    }


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'fk_UserID',
        'fk_HomeID',
        'fk_ChildID',
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

    //get home is actually returning the Home (User) in Case Manage
    public function getHome() {
        return $this->hasOne(User::class,"id","fk_HomeID");
    }

    public function getChild() {
        return $this->hasOne(Child::class,"id","fk_ChildID");

    }

    /**
     * The user that belong to the OnCall (used for Seen/Unseen functoin).
     */
    public function users()
    {
//        return $this->belongsToMany('App\Models\User')
        return $this->belongsToMany(User::class,'oncall_user','oncall_id','user_id')

                        ->as('seen_unseen')
              ->withTimestamps();
    }

}


