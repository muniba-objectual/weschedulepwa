<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExpensePayout
 *
 * @property int $id
 * @property float $amount
 * @property string $currency
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property int $paid_by_user_id
 * @property int $paid_to_user_id
 * @property int|null $account_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read \App\Models\User $paidByUser
 * @property-read \App\Models\User $paidToUser
 * @property-read \App\Models\Account|null $account
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Expenses[] $expenses
 * @property-read int|null $expenses_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpensePayout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpensePayout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpensePayout query()
// * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpensePayout whereAccountId($value) //future provisions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpensePayout whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpensePayout whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpensePayout whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpensePayout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpensePayout wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpensePayout wherePaidByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpensePayout wherePaidToUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpensePayout whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpensePayout whereUpdatedAt($value)
 */
class ExpensePayout extends Model
{
    const STATUS__PENDING = 'pending';
    const STATUS__PAID = 'paid';
    const STATUS__PAYMENT_FAILED = 'payment failed';

    protected $fillable = [
        'amount',
        'currency',
        'status',
        'paid_at',
        'paid_by_user_id',
        'paid_to_user_id',
//        'account_id', //future provisions
    ];

    protected $dates = [
        'paid_at'
    ];

    public function expenses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Expenses::class);
    }

    public function paidByUser(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by_user_id');
    }

    public function paidToUser(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_to_user_id');
    }

    //future provisions
//    public function account()
//    {
//        return $this->belongsTo(Account::class);
//    }

    public function isPaid(): bool{
        return $this->status == self::STATUS__PAID;
    }
}
