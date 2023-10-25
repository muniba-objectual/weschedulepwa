

<div>
    <style>
        input[type="file"] {
            display: none;
        }

        .custom-file-upload_AW {
            background-color: blue;
            color: white;
            padding: 2px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            border-radius: 0rem;
            cursor: pointer;
            margin-top: 1px;
            width: 10px;
        }

        .custom-send {
            background-color: red;
            color: white;
            padding: 2px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            border-radius: 0rem;
            cursor: pointer;
            margin-top: 1px;

        }

        .offcanvas-bottom {
            height: 62% !important;
        }

        .icon-inner, .ionicon, svg {
            display: block;
            height: 111%;
            width: 100%;
        }


        .chatFooter {
            min-height: 56px;
            background: #FFF;
            border-top: 1px solid #E1E1E1;
            position: relative;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-left: 14px;
            padding-right: 14px;
            padding-bottom: env(safe-area-inset-bottom);
            display: block;
        }


    </style>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


    <!-- chat footer -->
    <div>
        <form wire:ignore wire:submit.prevent="submitMessage" enctype="multipart/form-data">
            <input wire:model="photo" type="file"  name="photo" id="photo" class="form-control" style="visibility: hidden; display:none;">

            <div class="input-group-append">


                <button type="button" onclick="javascript:document.getElementById('photo').click();" class="btn btn-icon btn-primary rounded mr-1">
                    <ion-icon name="add"></ion-icon>
                </button>


                <input wire:model="message" type="text" id="inputAddMessage" name="inputAddMessage" class="form-control mr-1"
                       placeholder="Type a message...">


                <button type="submit" class="btn btn-icon btn-primary rounded">
                    <ion-icon name="send"></ion-icon>
                </button>
            </div>


        </form>
        <hr>
    </div>
    <!-- * chat footer -->

    <!-- chat footer -->

    <!-- * chat footer -->
    <div class="section full mt-2 mb-2">




        @if (count($activities_data) >= 0)
            @foreach ($activities_data as $activity)
                <div wire:poll.visible class="pb-1 pt-2">
                    <div class="mb-2">
                        <img height="50px" class="rounded-circle z-depth-2" src="/img/ws_icon.jpg"
                             alt="user image">
                        <span class="username">&nbsp;
                                                                            <a href="#">{{$activity->causer->name}}</a>
                        </span>
                        <span
                            class="description">Posted {{ $diff = Carbon\Carbon::parse($activity->updated_at)->diffForHumans(Carbon\Carbon::now()) }}</span>
                    </div>
                    <!-- /.user-block -->
                    <p>

                    @if ($activity->event == "Photo")
                        <div class="col">
                            <a href="/storage/activities_photos/{{substr($activity->description,25)}}"><img
                                    height="300px"
                                    src="/storage/activities_photos/{{substr($activity->description,25)}}"/></a>
                        </div>
                        @endif
                        @if ($activity->event == "Message")
                        {{$activity->description}}
                        @endif
                        </p>

                </div>
                <hr>
            @endforeach

        @else
            No activities
        @endif

        <br/>
        <!-- /.post -->
        <div class="d-flex justify-content-center">
            {!! $activities_data->links() !!}
        </div>
        <!-- /.post -->
    </div>
    <script>
        window.addEventListener('SuccessMessage', event=> {
            //$("#frmAddMedication").trigger('reset');

            $("#toast-success-message").text(event.detail.alertText);
            toastbox('toast-success', 3000)
        });

        window.addEventListener('livewire-upload-finish', event=> {
            //alert ('upload finished');


        });

    </script>
</div>





