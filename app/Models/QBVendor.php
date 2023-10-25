<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class QBVendor
 * @property string $SyncToken
 * @property string $Id
 * @property string $DisplayName
 * @property string $AcctNum
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read VendorAccountPredictionList[]|Collection alternativeVendorNames
 *
 * @package App\Models
 */
class QBVendor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'qb_vendors';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'Id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'SyncToken',
        'Id',
        'AcctNum',
        'DisplayName',
    ];

    public static function getDuplicates(): \Illuminate\Support\Collection
    {
        return self::query()
            ->select('Id', 'AcctNum', 'DisplayName')
            ->whereIn('AcctNum', function ($query) {
                $query->select('AcctNum')
                    ->from('qb_vendors')
                    ->groupBy('AcctNum')
                    ->havingRaw('COUNT(AcctNum) > 1')
                    ->whereNotNull('AcctNum');
            })
            ->get();
    }


    public function alternativeVendorNames(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VendorAccountPredictionList::class, 'vendor_id');
    }
}
