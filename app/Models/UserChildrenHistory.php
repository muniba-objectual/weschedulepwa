<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @property float salary

 * Timestamps
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon expired_at
 *
 * Relations
 * @property int child_id
 * @property Child child
 * @property int user_id
 * @property User user
 *
 * @property int assigned_by
 * @property User assignedBy
 *
 * @property int unassigned_by
 * @property User unassignedBy
 */
class UserChildrenHistory extends Model
{
    use HasFactory;

    protected $table = 'users_children_history';

    protected $fillable = [
        'child_id',
        'user_id',
        'salary',
        'assigned_by',
        'unassigned_by',
        'expired_at'
    ];

    protected $dates = [
        'expired_at',
        'updated_at',
        'created_at',
    ];


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function child(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Child::class);
    }

    public function assignedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function unAssignedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'unassigned_by');
    }


    /**
     * Scope forChild(Child|int $childId)
    */
    public function scopeForChild($query, Child|int $childId): Builder
    {
        return $query->where('child_id', $childId instanceof Child ? $childId->id:$childId);
    }


    /**
     * Get all salaries for all users for all children, includes the current active salary rate also.
     * @param bool $grouped If set true, the collection will group by user_id then child_id.
     * @param bool $oldestSalariesFirst
     * @return Collection
     */
    public static function GetAllSalariesWithHistory(bool $grouped = false) : Collection{
        $collection =
            self::query()
                ->selectRaw('IF(ISNULL(expired_at), now(), expired_at) as expired_at') //assume the latest salary is expired at current time.
                ->addSelect([ 'child_id', 'user_id', 'salary', 'created_at'])
                ->orderByExpiration()//oldest salaries on top, nulls first
                ->get();

        if($grouped){ //if grouping needed, group it, for easy array access.
            $collection = $collection
                ->groupBy('user_id')->map(function ($groupedChildren){
                    return $groupedChildren->groupBy('child_id');
                });
        }

        return $collection;
    }


    /**
     * Get the salary assigned for a `user` for a given `child` between a given time period
     * If the function is often being called (eg: in loops) pass the data set to avoid repetitive DB fetches.
     * @param int $userId user ID of the salary owner
     * @param int $childId
     * @param String|Carbon $shitStart
     * @param String|Carbon $shiftEnd
     * @param Collection|null $salaryCollection
     * @return float|null salary
     */
    public static function getSalaryForShift(int $userId, int $childId, Carbon|string $shitStart, Carbon|string $shiftEnd, Collection $salaryCollection =  null): ?float {

        $dataset = ($salaryCollection??self::GetAllSalariesWithHistory())->get($userId)->get($childId);

        $salaryRecord = null;
        foreach ($dataset as $salaryInstance){

            if(
                (
                    (!$salaryInstance->expired_at) || //allow null
                    ($salaryInstance->expired_at && $shitStart < $salaryInstance->expired_at) //if not null $shitStart < expired_at
                ) && (
                    (!$salaryInstance->created_at) || //allow null
                    ($salaryInstance->created_at && $salaryInstance->created_at <= $shitStart) //if not null created_at <= $shitStart
                )
            ){
                $salaryRecord = $salaryInstance;
            }
        }

        return $salaryRecord->salary??null; //might be null if no records have been ever created
    }

    public static function pushASalaryVersion(Child $child, User $user, float $salary){
        //close last history record
        self::query()
            ->where([
                'child_id'  => $child->id,
                'user_id'   => $user->id
            ])
            ->whereNull('expired_at')
            ->first()
            ?->fill([
                'unassigned_by' => auth()->id(),
                'expired_at'    => now(),
            ])
            ->save();

        //push active salary-instance to history table
        self::create([
            'child_id'      => $child->id,
            'user_id'       => $user->id,
            'salary'        => $salary,
            'assigned_by'   => auth()->id(),
        ]);
    }

    public static function deactivateLastSalary(Child $child, User $user){
        //close last history record
        self::query()
            ->where([
                'child_id'  => $child->id,
                'user_id'   => $user->id
            ])
            ->whereNull('expired_at')
            ->first()
            ?->fill([
                'unassigned_by' => auth()->id(),
                'expired_at'    => now(),
            ])
            ->save();
    }

    public function scopeOrderByExpiration(Builder $query): Builder
    {
        return $query->orderByRaw("-expired_at");
    }
}
