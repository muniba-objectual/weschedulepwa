<?php
    $xFieldHasCustomValues  = isset($xFieldOtherValue);
    $xFieldClass            = $xFieldClass??'';
?>

<div class="form-group">

    @if(isset($xFieldLabel))
        <label for="languages">{{$xFieldLabel}}</label>
    @endif

    <div class="input-group">

        <select id="{{$xFieldName}}" class="form-control select-input {!! $xFieldClass !!}" wire:model="formData.{{$xFieldName}}" name="{{$xFieldName}}">
            <option value="">Please select...</option>
            @foreach($xFieldOptions as $itemValue)
                <option value="{{$itemValue}}">{{$itemValue}}</option>
            @endforeach
        </select>

        @if( $xFieldHasCustomValues && strtolower(trim(($formData[$xFieldName]??''))) == $xFieldOtherValue )
            <input id="{{$xFieldName}}_custom_value"
                   class="form-control select-input {!! $xFieldClass !!}"
                   wire:model="formData.{{$xFieldName}}_custom_value"
                   name="{{$xFieldName}}_custom_value"
                   placeholder="{{ isset($xFieldLabel)?"Custom value for {$xFieldLabel}":"Custom Value" }}"
            >
        @endif

    </div>

</div>


