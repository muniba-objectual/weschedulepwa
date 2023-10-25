<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QbCachedData
 *
 * @package App
 *
 * @property string $id
 * @property string $type
 * @property string $sync_token
 * @property string $display_label
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class QbCachedData extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'type', 'sync_token', 'display_label', 'value',
    ];

}
