<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Comments\Models\Concerns\HasComments;

class BankDepositDetails extends Model
{

    protected $table = "bank_deposits_details";

    use HasComments;


    /*
 * This string will be used in notifications on what a new comment
 * was made.
 */
    public function commentableName(): string
    {
        //
    }

    /*
     * This URL will be used in notifications to let the user know
     * where the comment itself can be read.
     */
    public function commentUrl(): string
    {

    }


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'fk_BankDepositID',
        'fk_UserID',
        'details'

    ];

    protected $guarded = [

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function getUser() {
        return $this->hasOne(User::class,"id","fk_UserID");
    }




}


