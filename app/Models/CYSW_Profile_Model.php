<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CYSW_Profile_Model extends Model
{
    use HasFactory;
    public $table = "CYSW_Profile";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */


    protected $fillable = [
        'fk_UserID',
        'title',
        'preferred_name',
        'legal_name',
        'SIN',

        'address',
        'cellular',


        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'resume_attachment',
        'reference_1_name',
        'reference_1_phone',
        'reference_1_email',
        'reference_1_attachment',

        'reference_2_name',
        'reference_2_phone',
        'reference_2_email',
        'reference_2_attachment',

        'reference_3_name',
        'reference_3_phone',
        'reference_3_email',
        'reference_3_attachment',

        'diploma_certificate_1_attachment',
        'diploma_certificate_2_attachment',
        'diploma_certificate_3_attachment',
        'diploma_certificate_4_attachment',
        'diploma_certificate_5_attachment',

        'criminal_reference_1_attachment',
        'criminal_reference_2_attachment',

        'carpe_diem_confidentiality_attachment',
        'carpe_diem_release_information_attachment',
        'child_welfare_check_attachment',
        'covid19_proof_of_vaccination',
        'vaccination_status',

        'bank_name',
        'transit',
        'institution',
        'account_number',
        'banking_attachment',

        'photo_id_2_front_attachment',
        'photo_id_2_back_attachment',


        'drivers_licence_front_attachment',
        'drivers_license_back_attachment',

        'auto_insurance_front_attachment',
        'auto_insurance_back_attachment',
        'auto_year',
        'auto_make',
        'auto_model',
        'auto_liability',

        'admin_notes',
        'admin_salary',



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

    public function get_user_type()
    {
        return $this->hasOne(User_Type::class, "id", "user_type");
    }

    public static function getUser($id)
    {
        $user = User::findorfail($id);
        return $user;
    }
    public function getFullNameAttribute()
    {
        // return "{$this->first_name} {$this->last_name}";
    }

}





