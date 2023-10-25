<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * @property string title
 * @property Carbon start
 * @property Carbon end
 * @property int fk_UserID
 * @property string status
 * @property int fk_ChildID
 * @property Carbon actual_shift_start
 * @property Carbon actual_shift_end
 * @property int fk_ShiftFormID
 * @property string published_status
 * @property int|bool validated
 * @property string exception_pastEventModified
 * @property int|bool signed_in
 * @property int|bool exceptionReason
 * @property Carbon created_at
 * @property Carbon updated_at
*/



class Shift extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable, LogsActivity;


    protected $fillable = [
        'title', 'start', 'end', 'fk_UserID', 'status', 'fk_ChildID', 'fk_ShiftFormID' ,
        'published_status', 'validated', 'exception_pastEventModified', 'signed_in', 'exceptionReason'
    ];

    protected $with = ['get_user', 'get_child'];

    //Add extra attribute (not needed as it adds to the query)
   // protected $attributes = ['textColor'];

    //Make it available in the json response
    protected $appends = ['textColor'];



    protected function getTitleAttribute($value)
    {
            //When displaying the title of a shift on the calendar, override the title with the current name of the child

        return $this->get_child()->first()->initials ?? $value;


    }


    public function get_user()
    {
        return $this->hasOne(User::class, "id", "fk_UserID");
    }

    public function get_child()
    {
        return $this->hasOne(Child::class, "id", "fk_ChildID");
    }

    public function get_shiftform()
    {
        return $this->hasOne(Shift_Form::class, "id", "fk_ShiftFormID");
    }

    public function get_SRA_shiftform()
    {
        return $this->hasOne(SRA_Shift_Form::class, "id", "fk_ShiftFormID");
    }

    public function get_medicationentries() {
        return $this->hasMany(Medication_Entry::class, 'fk_ShiftID');

    }

    public function get_incidententries() {
        return $this->hasMany(Incident_Entry::class, 'fk_ShiftID');

    }
    public function getShiftTimeRelative()
    {

        return Carbon::createFromTimeStamp(strtotime($this->start))->diffForHumans();
    }

    public function calculateShiftHours()
    {
        return Carbon::createFromTimeStamp(strtotime($this->start))->diffInHours(Carbon::createFromTimeStamp(strtotime($this->end)));
    }

    public function calculateActiveShiftHours()
    {

        $dt = Carbon::createFromTimeStamp(strtotime($this->actual_shift_start))->diffInMinutes(Carbon::now());
    $hours = intdiv($dt, 60).' hours, '. ($dt % 60) . " mins";
    return $hours;
    }

    public function calculateActualShiftHours()
    {
        return Carbon::createFromTimeStamp(strtotime($this->actual_shift_start))->diff(Carbon::createFromTimeStamp(strtotime($this->actual_shift_end)))->format('%H:%I');
    }

    public function get_child_related_activities() {
        return $this->hasManyThrough(Activity_Entry::class, Child::class,"id","fk_ChildID");
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            //->logOnly(['name', 'text']);
        ->logFillable();
        // Chain fluent methods for configuration options
    }

    public function getTextColorAttribute($value) {

       // dump($this->attributes);

        if ($this->published_status == "Draft") {
            return $this->attributes['textColor'] = 'black';
        } else {
            return $this->attributes['textColor'] = 'white';
        }
    }

    public function getUsernameAttribute($value) {

        // dump($this->attributes);

       // $tmpUser = User::where('id','=',$this->fk_UserID)->first();

       // return $this->attributes['username'] = $tmpUser->name;

    }
}
