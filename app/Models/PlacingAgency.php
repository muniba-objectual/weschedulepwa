<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlacingAgency extends Model
{
    use HasFactory;
    protected $table = "placing_agencies";


    protected $fillable = [
        'name',
        'address',
        'city',
        'postal',
        'province',
        'telephone',
        'notes',

        'direct_deposit_ID',
        'finance_worker_name',
        'finance_worker_phone',
        'finance_worker_invoicing_email_address',

        'children_service_worker_name',
        'children_service_worker_email_address',
        'children_service_worker_phone',

        'family_service_worker_name',
        'family_service_worker_email_address',
        'family_service_worker_phone',

        'per_diem_rate',
        'ISA_PFA_rate',
        'outside_respite_rate',
        'holding_rate',
        'mileage_rate',
        'mileage_terms'

    ];

    public function getChildren(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Child::class,'fk_CASAgencyID','id')->orderBy('initials');
    }

    public function workers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PlacingAgencyWorkers::class, 'fk_PlacingAgencyID');
    }

}
