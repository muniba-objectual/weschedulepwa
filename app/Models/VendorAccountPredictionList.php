<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VendorAccountPredictionList
 * @property int $id
 * @property int $vendor_id
 * @property string alternative_vendor_name
 * @property bool is_verified
 * @property bool hits
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read QBVendor $vendor
 *
 * @package App\Models
 */

class VendorAccountPredictionList extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vendor_account_prediction_list';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vendor_id',
        'alternative_vendor_name',
        'is_verified',
        'hits',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'vendor_id'     => 'string', // Assuming it can be either string or integer
        'is_verified'   => 'boolean',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    protected $attributes = [
        'is_verified' => false,
    ];

    public function vendor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(QBVendor::class, 'vendor_id');
    }

    public static function getBestVendor(string $billVendorName): ?static
    {
        return static::query()
            ->where('alternative_vendor_name', trim($billVendorName))
            ->orderByDesc('hits') // Order by hits in descending order
            ->orderByDesc('updated_at')
            ->first();
    }
}
