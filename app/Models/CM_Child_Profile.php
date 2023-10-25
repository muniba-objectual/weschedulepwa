<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CM_Child_Profile
 *
 * @package App\Models
 * @property int $fk_ChildID
 * @property string $legal_name
 * @property string $preferred_name
 * @property string $pronoun
 * @property string $gender
 * @property string $date_of_birth
 * @property string $health_card_number
 * @property string $green_shield_number
 * @property string $date_admitted_carpediem
 * @property string $date_admitted_fosterhome
 * @property string $date_readmitted_carpediem
 * @property string $legal_status
 * @property string $discharge_date
 * @property int $is_sibling_group
 * @property string $school_info
 * @property string $created_at
 * @property string $updated_at
 * @mixin \Eloquent
 */
class CM_Child_Profile extends Model
{

    public $table = "cm_child_profile";


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'fk_ChildID',
        'legal_name',
        'preferred_name', //Used for We-Schedule
        'pronoun',
        'gender',
        'date_of_birth',
        'health_card_number',
        'green_shield_number',
        'date_admitted_carpediem',
        'date_admitted_fosterhome',
        'date_readmitted_carpediem',
        'legal_status',
        'discharge_date',
        'is_sibling_group',
        'school_info'




    ];

    protected $dateFormat = 'd/m/Y';


    protected $guarded = [

    ];


    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];


    public function guardName(){
        return "web";
    }
}


