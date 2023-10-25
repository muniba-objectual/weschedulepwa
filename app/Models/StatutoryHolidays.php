<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatutoryHolidays extends Model
{
    use HasFactory;
    public $table = "statutory_holidays";

    protected $fillable = [
        'id',
        'date',
        'nameEn',
        'nameFr',
        'federal',
        'observedDate',

    ];

}
