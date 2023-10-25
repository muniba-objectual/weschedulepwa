

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

    <!--
                       <div class="container-fluid">
                           <form>
                           <div class="row">
                               <div class="col-1">
                                      <a href="#" class="btn btn-icon btn-secondary rounded" data-bs-toggle="offcanvas"
                                              data-bs-target="#actionSheetAdd">
                                               <ion-icon name="add"></ion-icon>
                                           </a>
                               </div>
                               <div class="col-10">
                                   <div class="form-group boxed">
                                       <div class="input-wrapper">
                                           <input type="text" class="form-control" placeholder="Type a message...">
                                           <i class="clear-input">
                                               <ion-icon name="close-circle"></ion-icon>
                                           </i>
                                       </div>
                                   </div>

                               </div>
                               <div class="col-1">
                                   <button type="button" class="btn btn-icon btn-primary rounded">
                                       <ion-icon name="send"></ion-icon>
                                   </button>
                               </div>
                           </div>
                           </form>
                       </div>
   -->
    <!-- chat footer -->
    <div class="chatFooter mb-0 pb-1 mt-2 pt-1">
        <form wire:ignore wire:submit.prevent="submitMessage" enctype="multipart/form-data">
            <input wire:model="photo" type="file"  name="photo" id="photo" class="form-control" style="visibility: hidden; display:none;">

            <a  href="#"  onclick="javascript:document.getElementById('photo').click();" class="btn btn-icon btn-secondary rounded">
                <ion-icon name="add"></ion-icon>
            </a>





        <div class="form-group boxed">

                    <input wire:model="message" type="text" id="inputAddMessage" name="inputAddMessage" class="form-control"
                           placeholder="Type a message...">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>

            <button type="submit" class="btn btn-icon btn-primary rounded">
                <ion-icon name="send"></ion-icon>
            </button>
        </form>
    </div>
    <!-- * chat footer -->
    <!-- Add Action Sheet -->
    <div class="offcanvas offcanvas-bottom action-sheet inset" tabindex="-1" id="actionSheetAdd">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Share</h5>
        </div>
        <div class="offcanvas-body">
            <ul class="action-button-list">
                <li>
                    <a href="#" class="btn btn-list" data-bs-dismiss="offcanvas">
                        <span>
                            <ion-icon name="camera-outline"></ion-icon>
                            Take a photo
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="btn btn-list" data-bs-dismiss="offcanvas">
                        <span>
                            <ion-icon name="videocam-outline"></ion-icon>
                            Video
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="btn btn-list" data-bs-dismiss="offcanvas">
                        <span>
                            <ion-icon name="image-outline"></ion-icon>
                            Upload from Gallery
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="btn btn-list" data-bs-dismiss="offcanvas">
                        <span>
                            <ion-icon name="document-outline"></ion-icon>
                            Documents
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="btn btn-list" data-bs-dismiss="offcanvas">
                        <span>
                            <ion-icon name="musical-notes-outline"></ion-icon>
                            Sound file
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- * Add Action Sheet -->

    <!-- chat footer -->

    <!-- * chat footer -->
    <div class="section full mt-2 mb-2">




        @if (count($activities_data) >= 0)

        @foreach ($activities_data as $activity)
                <div wire:poll.visible class="wide-block pb-1 pt-2">
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
                        <div class="col-md-4">
                            <a href="/storage/activities_photos/{{substr($activity->description,25)}}"><img
                                    width="50%"
                                    src="/storage/activities_photos/{{substr($activity->description,25)}}"/></a>
                        </div>
                        @endif
                        @if ($activity->event == "Message")
                        {{$activity->description}}
                        @endif
                        </p>

                </div>
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





