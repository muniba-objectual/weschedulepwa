<div class="card">
    <div class="card-body">
        @if($errors->has('commentable_type'))
            <div class="alert alert-danger" role="alert">
                {{ $errors->first('commentable_type') }}
            </div>
        @endif
        @if($errors->has('commentable_id'))
            <div class="alert alert-danger" role="alert">
                {{ $errors->first('commentable_id') }}
            </div>
        @endif
        <form id="myform" method="POST" action="{{ route('comments.store') }}">
            @csrf
            @honeypot
            <input type="hidden" name="commentable_type" value="\{{ get_class($model) }}" />
            <input type="hidden" name="commentable_id" value="{{ $model->getKey() }}" />

            {{-- Guest commenting --}}
            @if(isset($guest_commenting) and $guest_commenting == true)
                <div class="form-group">
                    <label for="message">@lang('comments::comments.enter_your_name_here')</label>
                    <input type="text" class="form-control @if($errors->has('guest_name')) is-invalid @endif" name="guest_name" />
                    @error('guest_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="message">@lang('comments::comments.enter_your_email_here')</label>
                    <input type="email" class="form-control @if($errors->has('guest_email')) is-invalid @endif" name="guest_email" />
                    @error('guest_email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif

            <div class="form-group">
                <label for="message">@lang('comments::comments.enter_your_message_here')</label>
                <textarea class="form-control @if($errors->has('message')) is-invalid @endif" name="message" id="message" rows="3"></textarea>
                <div class="invalid-feedback">
                    @lang('comments::comments.your_message_is_required')
                </div>
                <small class="form-text text-muted">@lang('comments::comments.markdown_cheatsheet', ['url' => 'https://help.github.com/articles/basic-writing-and-formatting-syntax'])</small>
            </div>
{{--            <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">@lang('comments::comments.submit')</button>--}}
                        <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">Post Comment</button>
            <button type="button" id="fileupload" class="btn btn-sm btn-outline-success text-uppercase">Upload Image</button>
            <label for="fileupload2" class="custom-file-upload">
                Add Photos
            </label>
            <input type="file" name="photos[]" id="fileupload2" data-url="{{route('myshifts.edit')}}" multiple="" class="form-control" >

        </form>
    </div>
</div>
<br />

<script>
    $('#fileupload2').fileupload({
        dataType: 'json',
        formData: {
            type: 'AddPhoto',
            ChildID: '{{$myshift->get_child->id}}',
            UserID: '{{$myshift->get_user->id}}',
            _token: '{{csrf_token()}}'
        },

        add: function (e, data) {
            $('#loading').text('Uploading...');
           //     console.log (data);

            data.submit();
        },
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                console.log (file);

                // $('<p/>').html(file.name + ' (' + file.size + ' KB)').appendTo($('#files_list'));
                if ($('#file_ids').val() != '') {
                    $('#file_ids').val($('#file_ids').val() + ',');
                }
                //   $('#file_ids').val($('#file_ids').val() + file.fileID);
                document.getElementById('message').value = "![Sample Image]" + "(/storage/activities_photos/" + file.substring(25)  + ")";
            document.getElementById('myform').submit();

            });
            // $('#loading').text('');

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });




            Toast.fire({
                type: 'success',
                //title: 'We-Schedule.ca | Shift Form updated successfully.<br /> (' + data.success + "|" + data.message + ')',
                title: 'We-Schedule.ca | Image Upload(s) has been added successfully.',
                icon: 'success',
                timerProgressBar: true,


            })
        }
    });
</script>
