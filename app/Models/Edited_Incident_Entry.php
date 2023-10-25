<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Edited_Incident_Entry extends Model implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    public $table = "edited_incident_entries";


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $primaryKey = 'id';

    protected $fillable = [
        'fk_ChildID',
        'fk_UserID',
        'fk_IncidentEntryID',

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

        'approvedBy', //list of user ids which approved this revision

        //overrides
        'override_name_of_child',
        'override_date_of_birth',
        'override_date_of_placement',
        'override_foster_home',
        'override_placing_agency'
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
    'approvedBy' => 'array'

    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('Sent_IRs')
            ->singleFile();


    }


    public function get_child()
    {
        return $this->belongsTo(Child::class, "fk_ChildID", "id");
    }

    public function get_user()
    {
        return $this->belongsTo(User::class, "fk_UserID", "id");
    }



}


