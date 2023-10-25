<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Placements
 *
 * @property int $id
 * @property int $fk_ChildID
 * @property int $fk_FosterUserID
 * @property string $type
 * @property string $from_date
 * @property string|null $to_date
 * @property-read \App\Models\User $getFosterHomeUser
 * @property-read \App\Models\Child $child
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Placements newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Placements newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Placements query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Placements whereFkChildID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Placements whereFkFosterUserID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Placements whereFromDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Placements whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Placements whereToEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Placements whereType($value)
 * @mixin Model
 */
class Placements extends Model
{

    protected $table = "placements";

    //Allowed `type` values
    const TYPE__PERMANENT   = 'permanent';
    const TYPE__RELIEF      = 'relief';


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'fk_ChildID',
        'fk_FosterUserID',
        'type',
        'from_date',
        'to_date'

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

    public function getFosterHomeUser() {
        return $this->hasOne(User::class,'id','fk_FosterUserID');
    }

    public function child() {
        return $this->hasOne(Child::class,'id','fk_ChildID');
    }


}


