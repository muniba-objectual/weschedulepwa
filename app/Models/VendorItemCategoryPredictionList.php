<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VendorItemCategoryPredictionList
 *
 * @property int $id
 * @property int $vendor_id
 * @property int $category_id
 * @property bool $hits
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read \App\Models\QBVendor $vendor
 * @property-read \App\Models\ExpenseCategory $itemCategory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|VendorItemCategoryPredictionList getBestCategoriesInOrder(string $vendorId)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorItemCategoryPredictionList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VendorItemCategoryPredictionList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VendorItemCategoryPredictionList query()
 * @method static \Illuminate\Database\Eloquent\Builder|VendorItemCategoryPredictionList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorItemCategoryPredictionList whereHits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorItemCategoryPredictionList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorItemCategoryPredictionList whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorItemCategoryPredictionList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorItemCategoryPredictionList whereVendorId($value)
 */

class VendorItemCategoryPredictionList extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vendor_item_category_prediction_list';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vendor_id',
        'category_id',
        'hits',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'vendor_id' => 'string', // Assuming it can be either string or integer
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function vendor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(QBVendor::class, 'vendor_id');
    }


    public function itemCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public static function scopeGetBestCategoriesInOrder($query, string $vendorId): ?array
    {
        return $query
            ->whereVendorId($vendorId)
            ->orderByDesc('hits') // Order by hits in descending order
            ->orderByDesc('updated_at')
            ->get();
    }
}
