<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $child_id
 * @property int $form_id
 * @property string $version
 * @property string|null $previous_version_id
 * @property int $form_stage
 * @property \Carbon\Carbon|null $deactivated_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @property-read bool $is_latest
 * @property-read ChildSafetyForm $form
 */
class ChildSafetyPlanVersion extends Model
{
    protected $table = 'child_safety_plans';

    protected $fillable = [
        'child_id',
        'form_id',
        'version',
        'previous_version_id',
        'form_stage', //0 => assessment ongoing , 1 => assessment submitted, 2 => review submitted
        'deactivated_at',
    ];

    public $attributes = [
        'version' => '1.0',
        'form_stage' => 0,
    ];

    protected $casts = [
        'version' => 'string',
        'previous_version_id' => 'string',
    ];

    protected $appends = [
        'is_latest'
    ];

    /**
     * Get the previous version of the safety plan for the same child.
     */
    public function previousVersion()
    {
        return $this->hasOne(self::class, 'id', 'previous_version_id')->where('child_id', $this->child_id);
    }

    public function form(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ChildSafetyForm::class, 'form_id');
    }

    private function createNewRevision($form_stage): self
    {
        //clone the relationship
        $newRevision = $this->replicate();
        $newRevision->version = $this->generateNextVersion($this->version); //TODO::ashain, not working properly, (commented ont he front end)
        $newRevision->previous_version_id = $this->id;

        $newRevision->deactivated_at = null;
        $newRevision->form_stage = $form_stage;
        $newRevision->timestamps = true;
        $newRevision->save();

        $this->deactivated_at = now();
        $this->save();

        //replicate the form & attach to the new relationship
        $clonedForm = $this->form->replicate();
        $clonedForm->save();

        $newRevision->form_id = $clonedForm->id;
        $newRevision->save();

//        $newRevision->form()->associate($clonedForm);

        return $newRevision;
    }


    public function createACloneForReviewPurpose(): self
    {
        return $this->createNewRevision(1);
    }

    public function createACloneForAnotherReviewPurpose(): self{
        return $this->createNewRevision(1);
    }

    public function createACloneForNewAssessmentPurpose(): self{
//        throw_unless($this->is_latest, 'You can only initiate a new assignment from the latest version.');
        return $this->createNewRevision(0);
    }

    public static function generateNextVersion(string $currentVersion): string
    {
        $versionParts = explode('.', $currentVersion);
        $major = (int) $versionParts[0];
        $minor = count($versionParts) > 1 ? (int) $versionParts[1] : 0;
        $minor++;

        return $major . '.' . $minor;
    }

    public static function generateNextMajorVersion(string $currentVersion): string
    {
        $versionParts = explode('.', $currentVersion);
        $major = (int) $versionParts[0];
        $major++;

        return $major . '.' . 0;
    }

    public function getIsLatestAttribute(): bool
    {
        return is_null($this->deactivated_at);
    }

}
