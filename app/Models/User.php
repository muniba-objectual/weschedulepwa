<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
Use Carbon\Carbon;
use Spatie\Comments\Models\Concerns\Interfaces\CanComment;
use Spatie\Comments\Models\Concerns\InteractsWithComments;
use Spatie\Permission\Traits\HasRoles;
use Lab404\Impersonate\Models\Impersonate;

/**
 * @property int id
 * @property String name
 * @property String email
 * @property String address
 * @property String city
 * @property String province
 * @property String postal
 * @property String drivers_license
 * @property String notes
 * @property float user_type
 * @property String password
 * @property String profile_pic
 * @property String signature
 * @property int inactive
 * @property String calendarColor
 * @property Carbon email_verified_at
 * @property int fk_CaseManagerID
 *
 * @property-read String fullname
 * @property-read String mentionName
 *
 * @property Child[]|\Illuminate\Support\Collection getCaseManageChildren //forster_parent->children
 * @property Child[]|\Illuminate\Support\Collection getAssignedChildren //CYSW->children *
 * @property CreditCard[]|\Illuminate\Support\Collection creditCards
 * @property User getCaseManager
 *
 *
 * @property UserChildrenHistory[]|\Illuminate\Support\Collection usersChildrenHistory //salary history
 * @property HomeVisit[]|Collection privacyAndSupportNotes
 *
 */
class User  extends Authenticatable implements CanComment
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use InteractsWithComments;
    use Impersonate;



    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $appends = ['fullname', 'mentionName'];


    protected $fillable = [
        'name',
        'email',
        'address',
        'city',
        'province',
        'postal',
        'drivers_license',
        'notes',
        'user_type',
        'password',
        'profile_pic',
        'salary',
        'signature',
        'inactive',
        'calendarColor',
        'OnHold',

        //   'assigned_children'
    ];

    /**
     * Get the user's mention name.
     */
    public function getMentionNameAttribute()
    {
        return "@" . str_replace(' ','', $this->name);

    }

    protected $guarded = [
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
      //  'assigned_children'=>'array',
    ];

    public function creditCards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CreditCard::class);
    }

    public function getAssignedChildren() {
       return $this->belongsToMany(Child::class,'users_children', 'users_id', 'children_id')->where('inactive','=','0')->withPivot('salary');
    }

    public function get_user_type() {
        return $this->hasOne(User_Type::class,"type","user_type");
    }

    public static function getUser($id) {
        $user = User::findorfail($id);
        return $user;
    }

    public function getSignedInShift() {
       return $this->hasOne(Shift::class, 'fk_UserID', 'id')->where('signed_in',true)->whereDate('start','=',Carbon::today());
    }

    public function getAllPublishedShifts() {
        return $this->hasMany(Shift::class, 'fk_UserID', 'id')->where('published_status','Published')->orderBy('start','asc');
    }

    public function getAllValidatedShifts() {
        return $this->hasMany(Shift::class, 'fk_UserID', 'id')->where('validated','=','1')->orderBy('start','asc');
    }
    public function getUpcomingPublishedShifts() {
        return $this->hasMany(Shift::class, 'fk_UserID', 'id')->where('published_status','Published')->whereDate('start','>',Carbon::today())->orderBy('start','asc');
    }

    public function getPastPublishedShifts() {
        return $this->hasMany(Shift::class, 'fk_UserID', 'id')->where('published_status','Published')->whereDate('start','<',Carbon::today())->orderBy('start','asc');
    }

    public function getPastPublishedSignedInShifts() {
        return $this->hasMany(Shift::class, 'fk_UserID', 'id')->where('published_status','Published')->whereDate('start','<',Carbon::today())->where('signed_in','=','1')->orderBy('start','asc');
    }

    public function getTodaysPublishedShifts() {
        return $this->hasMany(Shift::class, 'fk_UserID', 'id')->where('published_status','Published')->whereDate('start', '=',Carbon::today())->orderBy('start','asc');
    }

    public function fosterParentLearningForm(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        $this->fosterGuard();
        return $this->hasOneThrough(
                TempFormData::class,
                FosterParentForm::class,
                'user_id', // Foreign key on FosterParentForm table
                'id', // Foreign key on TempFormData table
                'id', // Local key on User table
                'form_id' // Local key on FosterParentForm table
            )
            ->withDefault(function ($tempFormData, $user) {
                $fosterParentForm = $user->fosterParentLearningForm()->create([
                    'form' => TempFormData::FOSTER_PARENT_LEARNING
                ]);
                $relation = new FosterParentForm;
                    $relation->form_id = $fosterParentForm->id;
                    $relation->is_draft = true;
                    $relation->is_secondary_draft = true;
                    $relation->user_id = $user->id;
                    $relation->save();
                return $fosterParentForm;
            });
    }

    private function fosterGuard(): void
    {
        abort_if(!in_array($this->user_type, \App\CustomClasses\DynamicExpenseBuilder\ExpenseConfig::roleMapping()['foster-parent']), 500, "Only Foster Parents can have `Foster Parent Learning`.");
    }

    public function fosterParentLearningFormHistory(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        $this->fosterGuard();
        return $this->hasManyThrough(
            TempFormData::class,
            FosterParentLearningHistory::class,
            'user_id', // Foreign key on FosterParentForm table
            'id', // Foreign key on TempFormData table
            'id', // Local key on User table
            'form_id' // Local key on FosterParentForm table
        )->where('is_secondary',0);
    }

    public function fosterParentSecondaryLearningForm(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        $this->fosterGuard();
        return $this->hasOneThrough(
                TempFormData::class,
                FosterParentForm::class,
                'user_id', // Foreign key on FosterParentForm table
                'id', // Foreign key on TempFormData table
                'id', // Local key on User table
                'secondary_form_id' // Local key on FosterParentForm table
            )
            ->withDefault(function ($tempFormData, self $user) {
                $fosterParentForm = $user->fosterParentSecondaryLearningForm()->create([
                    'form' => TempFormData::FOSTER_PARENT_LEARNING,
                ]);

                //update the existing relation record with the new secondary form_id
                $user->fosterParentLearningForm()->update(['secondary_form_id' => $fosterParentForm->id]);

                return $fosterParentForm;
            });
    }

    public function fosterParentSecondaryLearningFormHistory(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        $this->fosterGuard();
        return $this->hasManyThrough(
            TempFormData::class,
            FosterParentLearningHistory::class,
            'user_id', // Foreign key on FosterParentForm table
            'id', // Foreign key on TempFormData table
            'id', // Local key on User table
            'form_id' // Local key on FosterParentForm table
        )->where('is_secondary',1);
    }

    public function getFosterParentFormPivot(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(FosterParentForm::class, 'user_id');
    }


    public function getFullNameAttribute()
    {
        //return "{$this->first_name} {$this->last_name}";
    }


    public function getCaseManager()
    {
        return $this->belongsTo(User::class, 'fk_CaseManagerID');
    }


    public function getStaffFromCaseManager()
    {
        return $this->hasMany(User::class, 'fk_CaseManagerID', 'id');
    }

    public function getCaseManageAssignedHomeCaseManager() {
        //There is no association from a child to a case manager; only from the Home (User)
        //Child is to the Foster Home
        //Foster Home is to the staff
        return $this->belongsTo(User::class, 'fk_CaseManagerID','id');

    }

    public function getCaseManageChildren() {
        //return $this->getCaseManageHome->belongsTo()
        return $this->hasMany(Child::class, 'FosterHome_fk_UserID');
    }

    /**
     * The oncall that belong to the User (used for Seen/Unseen function).
     */
    public function oncalls()
    {
        return $this->belongsToMany(OnCall::class,'oncall_user','user_id','oncall_id')
        ->as('seen_unseen')
            ->withTimestamps();
    }

    /**
     * The oncall that belong to the User (used for Seen/Unseen function).
     */
    public function mentorHomeVisits()
    {
        return $this->belongsToMany(MentorHomeVisit::class,'mentor_home_visit_user','user_id','mentor_home_visit_id')
            ->as('seen_unseen')
            ->withTimestamps();
    }

    /**
     * The IR that belong to the User (used for Seen/Unseen function).
     */
    public function IRs()
    {
        return $this->belongsToMany(Incident_Entry::class,'ir_user','user_id','ir_id')
            ->as('seen_unseen')
            ->withTimestamps();
    }


    public function usersChildrenHistory(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserChildrenHistory::class);
    }


    public function hasCompletedPrivacyNoteForThisMonth(): int {

        //actually visited child IDs
        $assignedChildIds = $this->getCaseManageChildren->pluck('id', 'id');
        $totalChildren = $assignedChildIds->count();
        if($totalChildren == 0){
            return -1;
        }

        /** @var HomeVisit[]|Collection $thisMonthSupportNotes */
        $thisMonthSupportNotes = $this->privacyAndSupportNotes->where('privacy', 1);

        foreach ($thisMonthSupportNotes as $note){
            foreach($note->getChildIds() as $noteChildId){
                $assignedChildIds->has($noteChildId) ? $assignedChildIds->forget($noteChildId) : null;
            }
        }

        return $assignedChildIds->count() == 0; //after crossing-out against home-visits
    }


    public function hasSupportNoteForThisMonth(): int {

        //actually visited child IDs
        $assignedChildIds = $this->getCaseManageChildren->pluck('id', 'id');
        $totalChildren = $assignedChildIds->count();
        if($totalChildren == 0){
            return -1;
        }

        /** @var HomeVisit[]|Collection $thisMonthSupportNotes */
        $thisMonthSupportNotes = $this->privacyAndSupportNotes->where('privacy', 0);

        return $thisMonthSupportNotes->count() > 0;

//        //check all children has support notes
//        foreach ($thisMonthSupportNotes as $note){
//            foreach($note->getChildIds() as $noteChildId){
//                $assignedChildIds->has($noteChildId) ? $assignedChildIds->forget($noteChildId) : null;
//            }
//        }
//
//        return $assignedChildIds->count() == 0;
    }


    public function privacyAndSupportNotes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(HomeVisit::class, 'fk_HomeID')
            ->where('created_at', '<=', now()->endOfMonth())
            ->where('created_at', '>=', now()->startOfMonth());
    }
}

