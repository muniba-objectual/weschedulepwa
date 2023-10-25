@include('media-library::livewire.partials.collection.fields')

<div class="media-library-field">


    <label class="media-library-label">Picture of</label>
{{--
    <select class="media-library-input"  >
        <option @if ($mediaItem->customProperties['room'] == "") selected @endif value="">Please Select...</option>
        <option @if ($mediaItem->customProperties['room'] == "house_front") selected @endif value="house_front">Front of the House</option>
        <option @if ($mediaItem->customProperties['room'] == "back_yard") selected @endif value="back_yard">Back Yard</option>
        <option @if ($mediaItem->customProperties['room'] == "bedroom") selected @endif value="bedroom">Bedroom</option>
    </select>
--}}


{{--    Custom Field: {{ $mediaItem->livewireCustomPropertyAttributes('room') }}--}}

    <input
        class="media-library-input"
        type="text"
        {{ $mediaItem->livewireCustomPropertyAttributes('room') }}
    />


    {{--
    {{dd($mediaItem->customProperties['room'])}}
    --}}

    @error($mediaItem->customPropertyErrorName('room'))
    <span class="media-library-text-error">
       {{ $message }}
    </span>
    @enderror
</div>
