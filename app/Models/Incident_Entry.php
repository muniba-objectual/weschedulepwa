<?php

namespace App\Models;

use App\Http\Traits\ModalCanBeReplicated;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Incident_Entry extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use ModalCanBeReplicated;

    public $table = "incident_entries";


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $primaryKey = 'id';
//    protected $appends = ['who_was_notified'];
    protected $fillable = [
        'fk_ShiftID',
        'fk_ChildID',
        'legal_guardian_name',
        'incident_type',
        'serious_occurence',
        'level1_serious_occurence',
        'date_of_incident',
        'time_duration',
        'datetime_report_received',
        'location_of_incident',
        'antecedent_leading_to_incident',
        'description_of_incident',
        'action_taken',
        'who_was_notified',
        'physical_injuries',
        'property_damage',
        'comments',
        'type' //not used since we are filtering dynamically based on if the user has seen the IR or not.

    ];

//public function getWhoWasNotifiedAttribute($value) {
//
//        return json_decode($value);
//
//
//}
//
//    public function setWhoWasNotifiedAttribute($value) {
//
//        return json_encode($value);
//
//    }


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
        return $this->belongsTo(Shift::class, "id", "fk_ShiftID");
    }

    public function get_child()
    {
        return $this->belongsTo(Child::class, "fk_ChildID", "id");
    }

    /**
     * The user that belong to the IR (used for Seen/Unseen function).
     */
    public function users()
    {
//        return $this->belongsToMany('App\Models\User')
        return $this->belongsToMany(User::class,'ir_user','ir_id','user_id')

            ->as('seen_unseen')
            ->withTimestamps();
    }

    public function EditedRevisions() {
        return $this->belongsTo(Edited_Incident_Entry::class,"id","fk_IncidentEntryID");
    }

}


