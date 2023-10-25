<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $form_id
 * @property bool $has_secondary_learning_form
 * @property int $secondary_form_id
 * @property string $secondary_foster_parent_full_name
 * @property string $secondary_foster_parent_date_of_birth
 * @property string $secondary_foster_parent_email
 * @property string $secondary_foster_parent_telephone
 * @property string $secondary_foster_parent_relationship_to_primary
 * @property bool $is_draft
 * @property bool $is_secondary_draft
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\TempFormData $form
 * @property-read \App\Models\TempFormData $secondaryForm
 * @property-read \App\Models\User $user
 */
class FosterParentForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'form_id',
        'has_secondary_learning_form',
        'secondary_form_id',
        'has_secondary_learning_form',
        'secondary_foster_parent_full_name',
        'secondary_foster_parent_date_of_birth',
        'secondary_foster_parent_email',
        'secondary_foster_parent_telephone',
        'secondary_foster_parent_relationship_to_primary',
        'is_draft',
        'is_secondary_draft',
    ];

    //Foster User
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function form(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TempFormData::class);
    }

    public function secondaryForm(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TempFormData::class);
    }

    /**
     * Use the mapping to create a new version.
     *  This will copy the existing form to a new form and return the new form.
     *  Also, the mapping will auto update to the new form's ID
     *  And the a backup of the mapping will me made for history.
     */
    public function createAVersion(bool $forSecondary = false): TempFormData
    {

        if( $forSecondary) {
            //this action was triggered for the secondary foster parent
            $newForm = $this->secondaryForm->makeCopy();
            $newForm->save();                                                   //save the cloned form data

            FosterParentLearningHistory::create([                               //save the existing mapping record to history
                'is_secondary'  => true,
                'form_id'       => $this->secondary_form_id,
                'user_id'       => $this->user_id,
            ]);
            $this->secondary_form_id = $newForm->id;                            //attach the new form to this mapping


        }else{
            //this action was triggered for the primary foster parent
            $newForm = $this->form->makeCopy();
            $newForm->save();                                                   //save the cloned form data

            FosterParentLearningHistory::create([                               //save the existing mapping record to history
                'is_secondary'  => false,
                'form_id'       => $this->form_id,
                'user_id'       => $this->user_id,
            ]);
            $this->form_id = $newForm->id;                                      //attach the new form to this mapping
        }


        $this->save();                                                          //save the updated mapping
        return $newForm;                                                        //return the new form
    }


    protected $attributes = [
        'has_secondary_learning_form' => false,
        'is_draft' => false,
        'is_secondary_draft' => false,
    ];

    public  $casts = [
        'has_secondary_learning_form' => 'boolean',
    ];
}
