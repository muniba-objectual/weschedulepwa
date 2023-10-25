<div class="form-group">
    <x-form-label :label="$label" :for="$attributes->get('id') ?: $id()" />

    <textarea
        @if($isWired())
            wire:model{!! $wireModifier() !!}="{{ $name }}"
        @endif

        name="{{ $name }}"

        @if($label && !$attributes->get('id'))
            id="{{ $id() }}"
        @endif

        {{--Set readonly for CYSW (user_type 1.0) --}}
        @if(Auth()->user()->user_type == '1.0')
            readonly
       @endif

        {!! $attributes->merge(['class' => 'form-control autoResize' . ($hasError($name) ? 'is-invalid' : '')]) !!}
    >@unless($isWired()){!! $value !!}@endunless</textarea>

    {!! $help ?? null !!}



    @if($hasErrorAndShow($name))
        <x-form-errors :name="$name" />
    @endif
</div>
