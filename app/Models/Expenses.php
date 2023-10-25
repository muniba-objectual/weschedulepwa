<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property int $fk_UserID
 * @property string|\Carbon\Carbon $datetime
 * @property string $description
 * @property string|null $attachment
 * @property string $category
 * @property int category_id
 * @property float $subtotal
 * @property float $HST
 * @property float $total
 * @property array|null $line_items
 * @property string|null $source
 * @property string|null $notes
 * @property string|null $linkTo //model to link to
 * @property int|null $linkToID // model id
 * @property int|null $verified_by
 * @property Carbon|null $verified_at
 * @property string|null $payment_type
 * @property string|null $last_four_digits
 * @property int|null $expense_payout_id
 * @property bool|null $is_tampered
 * @property bool|null $is_override_totals
 * @property int|null $vendor_id
 * @property string|null $vendor_name
 * @property bool $vendor_was_predicted
 * @property string|null qb_bill_id
 * @property string|null qb_payment_id
 * @property string|null qb_attachment_id
 * @property bool qb_purchase_is_sandbox
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection|User[] $allowedVerifiers
 * @property \App\Models\User $verifiedBy
 * @property-read string $monthyear
 * @property-read User $getUser
 * @property-read Child $getChild
 * @property-read CreditCard creditCard
 * @property \App\Models\ExpensePayout $expensePayout
 *
 * @property-read bool $is_verified
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Expenses limitToThisMonth()
 */

class Expenses extends Model implements HasMedia
{
    use SoftDeletes, HasFactory, InteractsWithMedia;
    protected $table = "expenses";

    const SOURCE_TYPE__WE_SCHEDULE = 'we-schedule';

    protected $appends = [
        'monthyear', 'is_verified', 'transaction_code',
    ];

    const PAYMENT_METHOD__UNSPECIFIED = 'unspecified';
    const PAYMENT_METHOD__COMPANY_CREDIT_CARD = 'coppany-credit-card';
    private bool $isSingleCategory;


    public function getDatetimeAttribute(){
        return $this->created_at;
    }//TODO::ashain, critical- fix the bug later


    public function getMonthYearAttribute() {
//        if (!isset($this->attributes['datetime'])) {
        if (!isset($this->attributes['created_at'])) {//TODO::ashain, critical- fix the bug later
            return \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('M-Y');
        } else {
//            return \Carbon\Carbon::parse($this->attributes['datetime'])->format('M-Y');
            return $this->created_at->format('M-Y');//TODO::ashain, critical- fix the bug later
        }
    }

    public function updateAutoCorrection(float $editingExpenseHst = null, float $editingExpenseTotal = null, float $editingExpenseSubTotal = null): self
    {
        //HST adjustment
        $this->HST = is_null($editingExpenseHst)?$this->HST:$editingExpenseHst;
        $this->total = is_null($editingExpenseTotal)?$this->total:$editingExpenseTotal;
        $this->subtotal = is_null($editingExpenseSubTotal)?$this->subtotal:$editingExpenseSubTotal;
        $this->is_override_totals = true;
        $this->save();
        return $this;
    }

    protected $fillable = [
        'id',
        'fk_UserID',
        'datetime',
        'description',
        'attachment',
        'category',
        'category_id',
        'subtotal',
        'HST',
        'total',
        'line_items',
        'notes',
        'source',
        'linkTo', //model to link to
        'linkToID', // model id
        'verified_by',
        'verified_at',
        'payment_type',
        'last_four_digits',
        'expense_payout_id',
        'is_tampered',
        'is_override_totals',
        'vendor_id',
        'vendor_name',
        'vendor_was_predicted',
        'qb_bill_id',
        'qb_payment_id',
        'qb_attachment_id',
        'qb_purchase_is_sandbox',
    ];

    protected $casts = [
        'is_tampered'               => 'boolean',
        'is_override_totals'        => 'boolean',
        'datetime'                  => 'datetime',
        'qb_purchase_is_sandbox'    => 'boolean',
        'vendor_was_predicted'      => 'boolean',
    ];


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('Expenses');
    }

    public function getUser() {
        return $this->belongsTo(User::class,'fk_UserID','id')->orderBy('name');
    }


    public function getChild() {
        return $this->belongsTo(Child::class,'linkToID','id')->orderBy('initials');
    }

    public function multiChild() {
        return $this->belongsToMany(Child::class,'expense_children','expense_id', 'child_id')
            ->withTimestamps()
            ->orderBy('initials');
    }


    public function expensePayout(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ExpensePayout::class);
    }


    public function isPaidOut(): bool{
        return $this->expensePayout->isPaid();
    }


    public function getIsVerifiedAttribute(){
        return (bool) $this->verified_at;
    }

    /**
     * Define a one-to-many relationship with the User model through the ExpensesVerifiers model.
     * This expense can be verified by a set of allowed users.
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function allowedVerifiers(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(User::class, ExpensesVerifiers::class)->withTimestamps();
    }

    public function verifiedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function isReadyOnly(): bool {
        return $this->verified_at || $this->isPaid();
    }

    public function isPaid(): bool {
        return $this->expense_payout_id && $this->expensePayout->isPaid();
    }

    public function isSingleCategory(): bool {
        return true;
        $this->isSingleCategory = $this->isSingleCategory ?? collect(json_decode( $this->line_items ))->groupBy('category')->count() == 1;
        return $this->isSingleCategory;
    }

    public function scopeLimitToThisMonth($query){
        return $query->where('datetime', '>=', Carbon::now()->startOfMonth());
    }

    /**
     * Update line items.
     * This will automatically update final totals
    */
    public function updateLineItems(array $lineItems, bool $autoSave = true): static
    {
        $writingContent = [];
        $subTotal = 0.00;

        foreach ($lineItems as $lineItem){
            $lineItem = (object) $lineItem;
            $writingContent[] = (object) [
                "qty" => $lineItem->qty,
                "item"=> $lineItem->item,
                "price"=> $lineItem->price,
                "total"=> $lineItem->total,
                "category"=> trim($lineItem->category) == '' ? null : $lineItem->category,
            ];
            $subTotal += (float)$lineItem->total;
        }

        $this->subtotal = $subTotal;
        $this->total = $subTotal + $this->HST;
        $this->line_items = json_encode($writingContent);

        if($autoSave){
            $this->save();
        }

        return $this;
    }

    public function getTransactionCode(){//TODO:: remove this
    }

    public function getTransactionCodeAttribute(){//TODO:: remove this
        return $this->getTransactionCode();
    }

    public function creditCard(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CreditCard::class, 'card_number', 'last_four_digits');
    }

    public function getQuickBooksLink(): ?string{
        if($this->qb_payment_id){
            $sandboxDomainIfNeeded = $this->qb_purchase_is_sandbox ? 'sandbox.':'';
            return "https://app.{$sandboxDomainIfNeeded}qbo.intuit.com/app/expense?txnId={$this->qb_payment_id}";
        }
        return null;
    }

    public function qbVendor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(QBVendor::class, 'vendor_id', 'Id');
    }

}
