<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensesVerifiers extends Model
{
    use HasFactory;

    const SUPER_USER_ROLES_ALLOWED = [
        '10.0'
    ];

    const USER_ROLES_SKIPPED = [
        '0.0'
    ];

    protected $fillable = [
        'verifier_user_id',     //person to verify
        'expense_user_id',      //the expense owner
        'assigned_by_user_id',  //person to elect the verifier
    ];

    public function verifier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'verifier_user_id');
    }

    public function expenseOwner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'expense_user_id');
    }

    public function assigner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by_user_id');
    }

    public static function hasAdminPrivileges(): bool
    {
       return in_array(auth()->user()->user_type, ExpensesVerifiers::SUPER_USER_ROLES_ALLOWED);

    }
}
