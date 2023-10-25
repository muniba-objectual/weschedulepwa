<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string form
 * @property string $raw_data;
 */
class ChildSafetyForm extends TempFormData
{
    protected $attributes = [
        'raw_data' => '{}',
        'form' => self::SAFETY_PLAN
    ];


    public function hasSubmittedAssessment(): bool
    {
        $jsonData = json_decode($this->raw_data, true);

        if (isset($jsonData['hasSubmittedAssessment'])) {
            return (bool) $jsonData['hasSubmittedAssessment'];
        }

        return false;
    }

    public function hasSubmittedReview(): bool
    {
        $jsonData = json_decode($this->raw_data, true);

        if (isset($jsonData['hasSubmittedReview'])) {
            return (bool) $jsonData['hasSubmittedReview'];
        }

        return false;
    }

    public function canSubmitAssessment(): bool
    {
        $jsonData = json_decode($this->raw_data, true);

        return isset($jsonData['is_child_behavior_and_safety_risky']) &&
            isset($jsonData['placer_recommends_safety_plan']);
    }

    public function needsASafetyPlan(): bool
    {
        $jsonData = json_decode($this->raw_data, true);

        $logic1 = $jsonData['is_child_behavior_and_safety_risky'] ?? null;
        $logic2 = $jsonData['placer_recommends_safety_plan'] ?? null;

        return !(!$logic1 && !$logic2);
    }

    public function setJsonData(string|int|float|null|array $value, string $key): static
    {
        if(is_array($value)){
            //TODO::implement
        }else{
            $jsonData = json_decode($this->raw_data, true);
            $jsonData[$key] = $value;
            $this->raw_data = json_encode($jsonData);
            return $this;
        }
    }
}
