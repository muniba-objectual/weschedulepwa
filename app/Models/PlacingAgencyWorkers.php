<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int fk_PlacingAgencyID
 * @property string type
 * @property string name
 * @property string email
 * @property string telephone
 * @property string notes
 */
class PlacingAgencyWorkers extends Model
{
    use HasFactory;
    protected $table = "placing_agencies_workers";

    const WORKER_TYPE__FINANCE_WORKER = 'Finance Worker';
    const WORKER_TYPE__CHILDREN_SERVICE_WORKER = 'Children Service Worker';
    const WORKER_TYPE__FAMILY_SERVICE_WORKER = 'Family Service Worker';
    const WORKER_TYPE__PLACEMENT_WORKER = 'Placement Worker';

    const WORKER_TYPES = [
        self::WORKER_TYPE__FINANCE_WORKER => 'Finance Worker',
        self::WORKER_TYPE__CHILDREN_SERVICE_WORKER => 'Children Service Worker',
        self::WORKER_TYPE__FAMILY_SERVICE_WORKER => 'Family Service Worker',
        self::WORKER_TYPE__PLACEMENT_WORKER => 'Placement Worker',
    ];


    protected $fillable = [
        'fk_PlacingAgencyID',
        'type',
        'name',
        'email',
        'telephone',
        'notes'
    ];

}
