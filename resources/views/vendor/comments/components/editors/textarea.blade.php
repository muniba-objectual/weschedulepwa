{{--@if((new \Jenssegers\Agent\Agent())->isMobile())--}}
    @php
        $detect = new \Detection\MobileDetect;
    @endphp
    @if($detect->isMobile())
    <style>
    .comments-textarea {
        width: 98% !important;
        max-height: 600px !important;
        overflow: auto !important;

    }

    .comments-placeholder {
        width: 98% !important;
        }
    </style>

@endif


    <input wire:model="photo" type="file"  name="photo" id="photo" class="form-control" style="visibility: hidden; display:none;">
    <div wire:loading wire:target="photo">
        Please wait: Uploading Media...
    </div>
<div wire:ignore id="commentBox" contenteditable="true" class="comments-textarea" >

</div>
{{--<textarea wire:model.debounce.2000ms="{{ $model }}" @isset($autofocus) autofocus @endisset class="comments-textarea"></textarea>--}}
{{--    <div id="previewImage"></div>--}}
    <button wire:ignore id="btnAddImage" type="button"  onclick="javascript:document.getElementById('photo').click();" class="comments-button" @php if ($model != "text") { echo 'style=display:none !important;'; } @endphp >Insert Image/Video</button>

<script>

    $( document ).ready(function() {


    });



</script>

    {{--<div x-data="{ content: @entangle('comment') }">
        <div x-on:blur="content = $event.target.innerHTML" contenteditable="true">{{ $model }}</div>
    </div>
--}}
{{--    <div width="200px" height="200px" contenteditable="true" wire:model="{{$model}}" class="comments-textarea"></div>--}}












{{--<div wire:ignore>

    <textarea wire:ignore class="summernote111"  wire:model.debounce.100ms="{{ $model }}"   placeholder="{{ $placeholder ?? '' }}"></textarea>

    <script>
    $(document).ready(function() {
        console.log('ready summernote');
        $('.summernote111').summernote(
            {
                callbacks: {
                    onChange: function (contents) {
                        //alert('blur');
                        console.log ("contents:");
                        console.log (contents);
                    //@this.set('editText', contents, true);


                        if ($(this).attr('wire:model.debounce.100ms') == "text") {
                        @this.set('text', contents);
                    }
                    if ($(this).attr('wire:model.debounce.100ms') == 'replyText') {
                        @this.set('replyText', contents);
                    }
                        if ($(this).attr('wire:model.debounce.100ms') == 'editText') {
                        @this.set('editText', contents);
                        }

                    },
                }

            });
    });
</script>
</div>--}}
