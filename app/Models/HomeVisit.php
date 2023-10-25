<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property int $fk_UserID
 * @property int $fk_HomeID
 * @property string $fk_ChildID
 * @property string $notes
 * @property bool $privacy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeVisit[] whereChild(int $childId)
 *
 */
class HomeVisit extends Authenticatable
{

    protected $table = "home_visits";

    use HasApiTokens, HasFactory, Notifiable;

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
        'privacy' //boolean (if true, will be used for privacy notes report; if false, will be used for support notes)

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

    public function getChildIds(): \Illuminate\Support\Collection
    {
        return collect(json_decode($this->fk_ChildID, true))->pluck('id');
    }

    public function scopeWhereChild($query, int $childId){
        return $query->whereRaw( \DB::raw("JSON_CONTAINS(JSON_EXTRACT(fk_ChildID, '$[*].id'), '".$childId."')") );
    }

}


