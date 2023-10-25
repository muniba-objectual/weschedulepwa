<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CreditCard
 *
 * @property int $id
 * @property string $card_number
 * @property string $cardholder_name
 * @property int $expiration_month
 * @property int $expiration_year
 * @property string $cvv
 * @property string $billing_zip
 * @property string $card_brand
 * @property string $card_type
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property string $qb_account_type
 * @property string $qb_account_id
 *
 * @property-read \App\Models\User $user
 * @property-read string $last_four_digits
 * @property-read string $friendly_identifier
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard whereBillingZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard whereCardBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard whereCardholderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard whereCvv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard whereExpirationMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard whereExpirationYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CreditCard whereUserId($value)
 */
class CreditCard extends Model
{
    protected $fillable = [
        'card_number',
        'cardholder_name',
        'expiration_month',
        'expiration_year',
        'cvv',
        'billing_zip',
        'card_brand',
        'card_type',
        'user_id',
        'qb_account_id',
        'qb_account_type',
    ];

    protected $appends = ['last_four_digits', 'friendly_identifier'];

    //compliance regulations
     public function getLastFourDigitsAttribute()
     {
         return substr($this->attributes['card_number'], -4);
     }

     public function getFriendlyIdentifierAttribute(){
         $last4 = substr($this->attributes['card_number'], -4);
         return "Company {$this->card_type} Card ****{$last4}";
     }

     //compliance regulations
    public function setCardNumberAttribute($value)
    {
        $this->attributes['card_number'] = substr($value, -4);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
