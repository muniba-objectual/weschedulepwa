<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string form
 * @property string raw_data
 *
 * @property ?Child childAsAPreAdmission
*/
class TempFormData extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'temp_form_data';
    protected $cacheData = null;

    const FOSTER_PARENT_LEARNING = 'foster-parent-learning';
    const SAFETY_PLAN = 'safety-plan';
    const PRE_ADMISSIONS = 'pre-admissions';
    const PRELIMINARY_ASSESSMENT = 'preliminary-assessment';
    const AGREEMENT_AND_AUTHORIZATION = 'agreement-and-authorization-to-provide-services-to-a-child-in-a-children-residence';
    const AUTHORIZATION_FOR_SUPERVISED_ACTIVITIES = 'authorization-for-supervised-activities';
    const APPROVAL_TO_ADMINISTER_ALL_MEDICATION = 'approval-to-administer-all-medication';


    const formTypes = [
        1 => self::FOSTER_PARENT_LEARNING,
        2 => self::SAFETY_PLAN,
        3 => self::PRE_ADMISSIONS,
        4 => self::PRELIMINARY_ASSESSMENT,
        5 => self::AGREEMENT_AND_AUTHORIZATION,
        6 => self::AUTHORIZATION_FOR_SUPERVISED_ACTIVITIES,
        7 => self::APPROVAL_TO_ADMINISTER_ALL_MEDICATION,
    ];

    protected $fillable = [
        'raw_data', 'form'
    ];

    protected $attributes = [
        'raw_data' => '{}'
    ];

    public static function translateTypeToIndex(string $typeConstant): bool|int
    {
        return array_search($typeConstant, self::formTypes);
    }

    public function makeCopy(array $except = [])
    {
        $newInstance = $this->replicate();

        // Remove any specified attributes from the copied instance
        $newInstance->setHidden($except);

        // You can modify any other attributes of the copied instance here if needed
        return $newInstance;
    }

    public function getVal(string $property, mixed $default = null): mixed{
        if(is_null($this->cacheData)){
            $this->cacheData = json_decode($this->raw_data, true);
        }
        return \Arr::get($this->cacheData, $property, $default);
    }

    public function setVal(string $property, mixed $value): static{
        return $this->setValueToRawData('set', $property, $value);
    }

    private function setValueToRawData($mode, string $property, mixed $value): static{
        if(is_null($this->cacheData)){
            $this->cacheData = json_decode($this->raw_data, true);
        }

        if($mode == 'set'){
            \Illuminate\Support\Arr::set($this->cacheData, $property, $value);
        }

        if($mode == 'push'){
            $values = \Illuminate\Support\Arr::get($this->cacheData, $property, []);
            $values[] = $value;
            \Illuminate\Support\Arr::set($this->cacheData, $property, $values);
        }

        $this->raw_data = json_encode($this->cacheData, true);
        return $this;
    }

    public function pushVal(string $property, mixed $value): static{
        return $this->setValueToRawData('push', $property, $value);
    }

    public function childAsAPreAdmission()
    {
        return $this->hasOne(Child::class, 'pre_admissions_form_id');
    }
}
