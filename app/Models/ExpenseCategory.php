<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExpenseCategory
 *
 * @property int $id
 * @property int $qb_account_number  //alias to $id
 * @property string $name
 * @property string $qb_account_id
 * @property string $qb_account_type
 * @property int $qb_sync_token
 * @property bool $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory readyToUse()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory whereQbAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory whereQbAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseCategory whereQbSyncToken($value)
 */
class ExpenseCategory extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $appends = [
        'qb_account_number'
    ];

    protected $fillable = [
        'id',
        'name',
        'qb_account_type',
        'qb_account_id',
        'qb_sync_token',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $attributes = [
      'is_active' => true,
    ];

    public function getQbAccountNumberAttribute(): int
    {
        return $this->id;
    }

    public static function scopeReadyToUse($query){
        return $query->whereIsActive(true)->orderBy('name');
    }
}
