<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SRA_Reports extends Model
{
    use HasFactory;

    protected $table = "SRA_Reports";

    protected $fillable = [
        'id',
        'report_title',
        'fk_ChildID',
        'fk_UserID',
        'report_html'

    ];
}
