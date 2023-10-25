@if($writable)
    @can('createComment', $model)
        <div class="comments-form">
            @if($showAvatars)
                <x-comments::avatar/>
            @endif
            <form class="comments-form-inner" wire:submit.prevent="comment">
                <x-dynamic-component
                    :component="\Spatie\LivewireComments\Support\Config::editor()"
                    model="text"
                    :placeholder="__('comments::comments.write_comment')"
                />

                <x-comments::button submit>
{{--                    {{ __('comments::comments.create_comment') }}--}}
                    Post
                </x-comments::button>
                @error('text')
                <p class="comments-error">
                   Error - You cannot post an empty comment or an image without any text.
                </p>
                @enderror
            </form>
        </div>
    @endcan
@endif
