<?php

namespace App\Models;

use App\Http\Controllers\Medication_Entries;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Spatie\Comments\Models\Concerns\HasComments;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


/**
 * @property int id
 * @property string initials
 * @property Carbon DOB
 * @property int fk_HomeID //Used for We-Schedule
 * @property string notes
 * @property string child_safety_plan
 * @property bool SRA
 * @property Carbon DateOfApprovedSRA
 * @property bool PFA
 * @property bool ISA
 * @property mixed DateOfApprovedIRA
 * @property Carbon DateOfApprovedPFA
 * @property bool CARPE_DIEM
 * @property bool inactive
 * @property bool WeSchedule
 * @property int fk_CASAgencyID // Case Manage - Assigned CAS
 * @property int fk_CASAgencyWorkerID // Case Manage - Assigned CAS Worker
 * @property int FosterHome_fk_UserID // Case Manage - Assigned Foster Home
 * @property string status
 * @property int pre_admissions_form_id
 * @property int preliminary_assessment_form_id
 * @property int agreement_and_authorization_form_id
 * @property int authorization_for_supervised_activities_form_id
 * @property int approval_to_administer_all_medication_form_id
 *
 * @property TempFormData safetyPlan
 * @property TempFormData[]|Collection allSafetyPlans
 * @property TempFormData preAdmissionForm
 *
 * @property HomeVisit[]|Collection privacyAndSupportNotes
 * @property CM_Child_Profile getCMProfile
 */
class Child extends Model implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasComments, HasRoles, InteractsWithMedia;

    public $table = "children";

    const STATUSES = [
        self::STATUS__ACTIVE,
        self::STATUS__PENDING,
        self::STATUS__DISCHARGED
    ];

    const STATUS__ACTIVE        = 'Active';
    const STATUS__DISCHARGED    = 'Discharged';
    const STATUS__PENDING       = 'Pending';


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'initials',
        'DOB',
        'fk_HomeID', //Used for We-Schedule
        'notes',
        'child_safety_plan',
        'SRA',
        'DateOfApprovedSRA',
        'PFA',
        'ISA',
        'DateOfApprovedIRA',
        'DateOfApprovedPFA',
        'CARPE_DIEM',
        'inactive',
        'WeSchedule',
        'fk_CASAgencyID', // Case Manage - Assigned CAS
        'fk_CASAgencyWorkerID', // Case Manage - Assigned CAS Worker

        'FosterHome_fk_UserID', // Case Manage - Assigned Foster Home
        'status', // Case Manage - Default: Pending, Other Options: Admitted, Discharged
        'pre_admissions_form_id',
        'preliminary_assessment_form_id',
        'agreement_and_authorization_form_id',
        'authorization_for_supervised_activities_form_id',
        'approval_to_administer_all_medication_form_id',

    ];

    protected $appends = ['displayable_SRA', 'displayable_WeSchedule'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function getDisplayableSRAAttribute(){
        return $this->SRA?"YES":"NO";
    }

    public function getDisplayableWeScheduleAttribute(){
        return $this->WeSchedule?"YES":"NO";
    }
    protected $guarded = [

    ];


    /*
     * This string will be used in notifications on what a new comment
     * was made.
     */
    public function commentableName(): string
    {
        return auth()->user()->name;
    }

    /*
     * This URL will be used in notifications to let the user know
     * where the comment itself can be read.
     */
    public function commentUrl(): string
    {
       return "";
        // return 'myUrl';
    }

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

    public function get_home() {
        return $this->hasOne(Home::class,"id","fk_HomeID");
    }

    public function child() {
        return $this->belongsTo(Shift_Layout_Template::class,"fk_ChildID");
    }



    public function getShifts() {
        return $this->hasMany(Shift::class, 'fk_ChildID', 'id');
    }


    public function getStaff() {
        return $this->hasManyThrough(User::class, Shift::class, 'fk_ChildID', 'id', 'id', 'fk_UserID');
    }


    public function getCaseManageFosterHome() {
        return $this->belongsTo(User::class, 'FosterHome_fk_UserID');
    }

    public function get_activities() {
            return $this->hasMany(Activity_Entry::class, "fk_ChildID", "id")->orderBy('updated_at','desc');
    }

    public function get_activities_photos() {
        return $this->hasMany(Activity_Photo::class, "fk_ChildID", "id")->orderBy('updated_at','desc');

    }

    public function get_medicationentries() {
        return $this->hasMany(Medication_Entry::class, "fk_ChildID", "id")->orderBy('updated_at','desc');

    }

    public static function getChild($id) {
        $child = Child::findorfail($id);
        return $child;
    }

    public function getAssignedUser() {
        return $this->belongsToMany(User::class, 'users_children', 'children_id', 'users_id')->where('inactive','=','0')->withPivot(['salary', 'updated_by']);
    }

    //CaseManage
    public function getCaseManageAssignedHome() {
        //There is no association from a child to a case manager; only from the Home (User)
        //Child is to the Foster Home
        //Foster Home is to the staff
        return $this->belongsTo(User::class, 'FosterHome_fk_UserID','id');

    }


    public function getCASAgency() {

        return $this->belongsTo(PlacingAgency::class, 'fk_CASAgencyID','id');

    }

    public function getCASAgencyWorker() {
        return $this->belongsTo(PlacingAgencyWorkers::class, 'fk_CASAgencyWorkerID', 'id');
    }

    public function getCMProfile() {
            //Get Case Manage Child Profile
        return $this->belongsTo(CM_Child_Profile::class, 'id','fk_ChildID');

    }

    public function testComment() {
        $this->comment ('test');
    }

    public function guardName(){
        return "web";
    }

    public function hasPrivacyNoteForThisMonth(): bool {
        return $this
            ->privacyAndSupportNotes()
            ->where('privacy', 1)
            ->count() > 0;
    }

    public function hasSupportNoteForThisMonth(): bool {
        return $this
            ->privacyAndSupportNotes()
            ->where('privacy', 0)
            ->count() > 0;
    }

    public function privacyAndSupportNotes(): \Illuminate\Database\Eloquent\Collection
    {
        return HomeVisit::query()
            ->whereChild($this->id)
            ->where('created_at', '<=', now()->endOfMonth())
            ->where('created_at', '>=', now()->startOfMonth())
            ->get();
    }

    public function preAdmissionForm(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TempFormData::class, 'pre_admissions_form_id')->where(['form' => TempFormData::PRE_ADMISSIONS])
            ->withDefault(function ($tempFormData) {
                return $tempFormData->create([
                    'form' => TempFormData::PRE_ADMISSIONS
                ]);
            });
    }


    public function safetyPlan()
    {
        return $this->belongsToMany(ChildSafetyForm::class, 'child_safety_plans', 'child_id', 'form_id')
            ->wherePivotNull('deactivated_at');
    }

    /**
     * Override the relation to return a single instance instead of a collection
     * and also create a instance if dos not exist
     */
    public function getSafetyPlanAttribute($value)
    {
        $plan = $this->safetyPlan()->where('form', ChildSafetyForm::SAFETY_PLAN)->first(); //TODO::ashain, pick the latest vertion
        if ($plan) {
            return $plan;
        } else {
            return null; //do not automatically create a safety plan
        }
    }


    public function allSafetyPlans(bool $oldPlansOnly = false){
        if($oldPlansOnly){
            return $this->belongsToMany(ChildSafetyForm::class, 'child_safety_plans', 'child_id', 'form_id')
                ->wherePivotNotNull('deactivated_at')
                ->withPivot(['deactivated_at']);
        }
        return $this->belongsToMany(ChildSafetyForm::class, 'child_safety_plans', 'child_id', 'form_id')
            ->withPivot('deactivated_at');
    }

    public function getOrCreateFormId(string $formColumnReference): int{
        if(is_null($this->$formColumnReference)){
            $columnMap = [
                'pre_admissions_form_id' => TempFormData::PRE_ADMISSIONS,
                'preliminary_assessment_form_id' => TempFormData::PRELIMINARY_ASSESSMENT,
                'agreement_and_authorization_form_id' => TempFormData::AGREEMENT_AND_AUTHORIZATION,
                'authorization_for_supervised_activities_form_id' => TempFormData::AUTHORIZATION_FOR_SUPERVISED_ACTIVITIES,
                'approval_to_administer_all_medication_form_id' => TempFormData::APPROVAL_TO_ADMINISTER_ALL_MEDICATION,

            ];
            $tempFormData = TempFormData::create([
                'form' => $columnMap[$formColumnReference],
            ]);
            $this->$formColumnReference = $tempFormData->id;
            $this->save();
            return $tempFormData->id;
        }else{
            return $this->$formColumnReference;
        }
    }

    /**
     * @param Carbon|null $asOfDate
     * @return Placements|null
     *
     * if param {$asOfDate} is null, the place evaluation will be done based on today's date.
     *
     * if returned placement is null, this means the child is not currently in any placement.
     *
     */
    public function evaluateCurrentPlacementAsOfDate(Carbon $asOfDate = null): ?Placements{
        $asOfDate = $asOfDate??Carbon::today();

        return Placements::query()
            ->where('fk_ChildID', $this->id)
            ->where('from_date', '<=', $asOfDate)
            ->where(function (\Illuminate\Database\Eloquent\Builder $query) use ($asOfDate) {
                $query->whereNull('to_date')
                    ->orWhere('to_date', '>=', $asOfDate);
            })
            ->orderByDesc('from_date')
            ->first();
    }
}
