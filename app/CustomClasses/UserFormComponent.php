<?php

namespace App\CustomClasses;

use App\Models\TempFormData;
/**
 * @property array $formData
 * @property int $formDataId
 * @method &getNode(string $keyPath)
 */
trait UserFormComponent
{
    public $formData = [];
    public $formDataId;
    public $autoSave = true;

    public $params;

    public $printMode;

    public $readOnlyForm = false;

    private function &getNode(string $keyPath){
        $keys = explode('.',$keyPath);
        $current = &$this->formData;
        foreach ($keys as $key) {
            $current = &$current[$key];
        }
        return $current;
    }

    private function getRowHeight($key, $additionalRows = 0, $min = 3)
    {
        $value = $this->getNode(str_replace("formData.", "", $key));
        return max(substr_count($value, "\n") + 1, $min);
    }

    public function addRow(string $keyPath): void
    {
        $current = &$this->getNode($keyPath);
        $current['row_count'] = ($current['row_count']??1)+1;
    }
    public function removeRow(string $keyPath): void
    {
        $current = &$this->getNode($keyPath);
        if(($current['row_count']??1) <= ($current['row_min']??0)){
            return;
        }
        $current['row_count'] = ($current['row_count']??1)-1;
    }

    public function removeNthRow(string $keyPath, int $rowIndex): void
    {
        $current = &$this->getNode($keyPath);

        $rowCount = (int)($current['row_count']??0);
        $new=[];
        for($i = 1; $i<=$rowCount; $i++){
            if($i<$rowIndex){
                $new[$i] = $current[$i];
            }elseif($i>$rowIndex){
                $new[$i-1] = $current[$i];
            }
        }

        $new['row_count'] = count($new);
        $this->formData[$keyPath] = $new;
    }

    public function __construct()
    {
        $this->listeners[] = 'signatureUpdated';
    }

    public function mount(TempFormData $tempFormData, bool $printMode = false, array $params = [])
    {
        $this->params = $params;
        $this->printMode = $printMode;
        abort_if($tempFormData->form != $this->getFormType(), 404, "Invalid form request.");
        $this->formDataId = $tempFormData->id;
        $this->formData = json_decode($tempFormData->raw_data, true);

        if (method_exists($this, 'afterMount')) {
            $this->afterMount(); //allow to inject additional commands if preferred by child/usage class.
        }
    }

    public function submit(): void
    {
        if(!$this->readOnlyForm){
            $editingUser = auth()->user();
            $this->formData['edited_by']['id'] = $editingUser->id;
            $this->formData['edited_by']['name'] = $editingUser->name;
            TempFormData::query()->findOrFail($this->formDataId)->fill(['raw_data' => json_encode($this->formData)])->save();
        }

        if (method_exists($this, 'afterSubmit')) {
            $this->afterSubmit(); //allow to inject additional commands if preferred by child/usage class.
        }
    }


    public function updated()
    {
        $this->dispatchBrowserEvent('livewire-model-updated');
        if($this->autoSave){
            $this->submit();//auto save on every change
        }
    }

    private function getFormType() : string{
        return \Illuminate\Support\Str::kebab(class_basename(static::class));
    }

    public function signatureUpdated($keyPath, $dataURL): void
    {
        $keyPath = str_replace('formData.', '', $keyPath);
        $this->formData[$keyPath] = $dataURL;
        $this->updated();
    }

    public function mapFillByForm(object &$model, array $mapping){
        foreach ($mapping as $modelPropertyName => $formDataColumnName){
            $model->$modelPropertyName = $this->formData[$formDataColumnName]??null;
        }
    }
}
