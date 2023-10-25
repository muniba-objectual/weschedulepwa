<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FosterParentApplication_Notes extends Model
{
    protected $table = "foster_parent_application_notes";

    protected $fillable = [
        'id',
        'fk_UserID',
        'fk_foster_parent_applicationID',
        'section',
        'note'



    ];
    use HasFactory;
}
