<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuickbooksSetting
 *
 * @package App
 *
 * @property string $name
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class QuickbooksSetting extends Model
{
    const key_cardPaymentMethodReference    = 'cardPaymentMethodReference';
    const key_cashPaymentMethodReference    = 'cashPaymentMethodReference';
    const key_dynamicTaxRateReference       = 'dynamicTaxRateReference';
    const key_lineItemTaxCodeReference      = 'lineItemTaxCodeReference';
    const key_currencyId                    = 'currencyId';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'name';

    /**
     * Indicates if the primary key is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'value'
    ];
}
