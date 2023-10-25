<div class="textarea-input form-group">
    <x-adminlte-textarea class="{{ $class??'' }}" {{isset($name)?" name='{$name}'":""}}  {{isset($model)?" wire:model='{$model}'":""}} />
</div>
