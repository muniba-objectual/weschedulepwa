@if($printMode??false)
    <span class="signature-container">
        <canvas readonly disabled class='signature-pad' width={{$sigWidth??330}} height={{$sigHeight??200}}  style="{{$sigStyle??''}}"></canvas>
        <input type="hidden" wire:model="formData.{{$sigName}}" value="{{$formData[$sigName]??''}}">
    </span>
@else
    <span class="signature-container">
        <canvas class='signature-pad' width={{$sigWidth??330}} height={{$sigHeight??200}}  style="{{$sigStyle??'border:1px solid blue;'}}"></canvas>
        <input type="hidden" wire:model="formData.{{$sigName}}" value="{{$formData[$sigName]??''}}">
        <span class="hide-on-print"><button class="signature-clear" type="button"> Clear Signature </button></span>
    </span>
@endif
