<div class="dob-input form-group">
    <label>{!! $label !!}</label>
    <x-adminlte-date-range class="{{ $class }}" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="{{ $model }}" name="{{ $name }}" igroup-size="{{ $igroupSize??'sm' }}" :config="{{ $config }}" />
</div>
