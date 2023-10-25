

<div class="col-md-3">

    <!-- Profile Image -->
    <div id="ShiftCardDetails" class="card card-primary card-outline" >
        <div class="card-body box-profile">
            <div class="card-tools">
                <!-- Collapse Button -->
                <!-- <button type="button" class="btn btn-tool" data-source="{{route('myshifts.getShiftCardDetails')}}" data-params="ShiftID={{$myshift->id}}" ><i>refresh</i></button> -->
            </div>
            <!-- /.card-tools -->
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="/img/ws_icon.jpg"
                     alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">{{$myshift->title}}</h3>
            <h3 class="profile-username text-center text-sm">{{$myshift->get_user->name}}</h3>

            <p class="text-muted text-center text-xs">{{$myshift->get_child->get_home->name}}</p>

            Shift Details
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Date</b> <a class="float-right">{{Str::before($myshift->start,' ')}}
                    </a>
                </li>
                <li class="list-group-item">
                    <b>Start Time</b> <a class="float-right">{{Str::after($myshift->start, ' ')}}</a>
                </li>
                <li class="list-group-item">
                    <b>End Time</b> <a class="float-right">{{Str::after($myshift->end, ' ')}}</a>
                </li>
                <li class="list-group-item">
                    <b>Scheduled Hours</b> <a
                        class="float-right">{{$myshift->calculateShiftHours()}}</a>
                </li>

                @if ($myshift->status == "Started" )  {{--//start time exists, so the user is signed in--}}
                <li class="list-group-item" >
                    <b>Time Elapsed</b> <a
                        class="float-right">
                        @livewire('shift-details.time-worked', ['myshift' => $myshift])
                        {{--$myshift->calculateActiveShiftHours()--}}</a>
                </li>
                @else
                    <li class="list-group-item">
                        <b>Time Worked</b> <a
                            class="float-right">{{$myshift->calculateActualShiftHours()}}</a>
                    </li>

                @endif
                <li class="list-group-item">
                    <b>Status</b> <a class="float-right">{{$myshift->status}}</a>
                </li>
            </ul>


            @if ($myshift->status == "Pending" && !$myshift->actual_shift_start)  {{--//start time exists, so the user is signed in--}}
            <a href="#" class="btn btn-primary btn-block" onclick=startShift("{{$myshift->id}}")><b>Start
                    Shift</b></a>

            @endif

            @if ($myshift->status == "Started" && $myshift->actual_shift_start)  {{--//start time exists, so the user is signed in--}}
            <a href="#" class="btn btn-primary btn-block" onclick=stopShift("{{$myshift->id}}")><b>End
                    Shift</b></a>
            @endif


        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->


</div>


