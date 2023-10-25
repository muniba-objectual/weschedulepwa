<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FosterParentLearningHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'foster_parent_learning_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_secondary',
        'form_id',
        'user_id',
    ];

    public function form()
    {
        return $this->belongsTo(TempFormData::class, 'form_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
