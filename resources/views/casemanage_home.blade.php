@extends('adminlte::page')

@section('title', 'Case Manage')

@section('content_header')
    @livewireStyles
    @php
        $detect = new \Detection\MobileDetect;
    @endphp
    @if($detect->isMobile())
        {{--        @if((new \Jenssegers\Agent\Agent())->isMobile())--}}
        <script>
            //alert ('mobile detected');
            window.location.href = "/mobileCM";
        </script>
    @endif

    {{--    @if (Auth::user()->id == "44")--}}
    {{--        Fix for *some Case Managers (Zoe Stewart) not getting auto-redirected to /mobileCM when on the mobile--}}
    {{--        <script>--}}
    {{--            //alert ('mobile detected');--}}
    {{--            window.location.href = "/mobileCM";--}}
    {{--        </script>--}}
    {{--    @endif--}}
    <script>
        $userID = {{$user->id}};


    </script>


@stop

@section('content')
    <div class="text-end">
        @if(session('impersonated_by'))
            <a href="{{ route('users.leave-impersonate') }}" class="btn btn-success me-2">Leave Impersonation</a>
        @endif
    </div>
    <section class="mx-2 pb-3">

        <ul class="nav nav-pills" id="myTabMD" role="tablist">
            @if (auth()->user()->user_type == "2.3")
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link active" id="FPA-tab-md" data-toggle="tab" href="#FPA-md" role="tab" aria-controls="FPA-md" aria-selected="true">2.3 - Foster Parent Applicant</a>
                </li>
            @endif


            @if (auth()->user()->user_type == "5.1")

                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link active" id="profile-tab-md" data-toggle="tab" href="#admin_assistant" role="tab" aria-controls="charlene" aria-selected="false">5.1 -
                        {{auth()->user()->name}}</a>
                </li>


            @endif

        </ul>

        <div class="tab-content card pt-5" id="myTabContentMD">

            @if (
                in_array(auth()->user()->user_type, [ "5.0", "5.1", "5.2", "4.0", "4.1", "4.2", "4.4" ]) ||
                in_array(auth()->user()->id, [1, 2, 3]) ||
                in_array(auth()->user()->email, ['adesilva@acuitytech.ca']) //TODO::no need to push to production
            )

                <div class="tab-pane fade show active" id="admin_assistant" role="tabpanel" aria-labelledby="charlene">
                    <section class="content">
                        <div class="container-fluid">
                            <!-- Small boxes (Stat box) -->

                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-yellow">
                                        <div class="inner">
                                            <h5>Foster Parents</h5>
                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div><br />

                                        <a href="{{route('casemanage_showFosterParentDashboard')}}" class="small-box-footer">Manage Foster Parents <i class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-gradient-fuchsia">
                                        <div class="inner">
                                            <h5>Children</h5>

                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div><br />

                                        <a href="{{route('casemanage_showChildrenDashboard')}}" class="small-box-footer">Manage Children <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h5>Staff</h5>

                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div><br />

                                        <a href="{{route('casemanage_showStaffDashboard')}}" class="small-box-footer">Manage Staff <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h5>Placing Agencies</h5>

                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div><br />

                                        <a href="{{route('casemanage_showPlacingAgenciesDashboard')}}" class="small-box-footer">Manage Placing Agencies <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="row">

                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-gradient-lightblue">
                                        <div class="inner">
                                            <h5>Global Sandwich Board</h5>

                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-bell"></i>
                                        </div><br />

                                        <a href="#" class="small-box-footer">View Global Sandwich Board <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-gradient-purple">
                                        <div class="inner">
                                            <h5>Reports</h5>

                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div><br />

                                        <a href="/reports" class="small-box-footer">View Reports <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-blue">
                                        <div class="inner">
                                            <h5>We-Schedule.ca</h5>


                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-link"></i>
                                        </div><br />

                                        <a href="https://we-schedule.ca" target="_blank" class="small-box-footer">Open We-Schedule.ca <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-red">
                                        <div class="inner">
                                            <h5>Mobile Apps</h5>

                                            <!-- We need to include our modal using livewire, or our
                                            html markup we will not be loaded -->
                                            @livewireScripts

                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-home"></i>
                                        </div><br />

                                        <a href="/mobileCM" class="small-box-footer">View Mobile Apps <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>
                                </div>

                            </div>
                            @if (auth()->user()->user_type == "10.0" || auth()->user()->user_type == "4.2" || auth()->user()->user_type == "5.1" )
                                <div class="row">
                                    <div class="col-lg-3 col-6">
                                        <div class="small-box bg-gradient-olive">
                                            <div class="inner">
                                                <h5>Forms</h5>



                                            </div>

                                            <div class="icon">
                                                <i class="fas fa-clipboard-list"></i>
                                            </div><br />

                                            <a href="/CaseManage/showFormsDashboard" class="small-box-footer">View Forms <i
                                                    class="fas fa-arrow-circle-right"></i></a>

                                        </div>
                                    </div>
                                </div>
                            @endif


                        </div>
                        <!-- /.row -->
                        <!-- Main row -->

                        {{--                    <ul>Desktop Apps--}}
                        {{--                    <li><a href="{{route('HomeVisitDesktop')}}" class="mt-2">Home Visit</a></li>--}}
                        {{--                    <li><a href="{{route('OnCallDesktop')}}" class="mt-2">On-Call</a></li>--}}
                        {{--                    <li><a href="{{route('OnCallCYSWDesktop')}}" class="mt-2">On-Call CYSW</a></li>--}}

                        {{--                    </ul>--}}



                    </section>

                    @livewire('dashboard-elements.lists.case-manage.child-profiles')
                    @livewire('dashboard-elements.lists.case-manage.foster-parent-profiles')


                </div>
            @endif

            @if (auth()->user()->user_type == "3.1" )

                <div class="tab-pane fade show active" id="admin_assistant" role="tabpanel" aria-labelledby="charlene">
                    <section class="content">
                        <div class="container-fluid">
                            <!-- Small boxes (Stat box) -->

                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-yellow">
                                        <div class="inner">
                                            <h5>Foster Parents</h5>


                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div><br />

                                        <a href="{{route('casemanage_showFosterParentDashboard')}}" class="small-box-footer">Manage Foster Parents <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-gradient-fuchsia">
                                        <div class="inner">
                                            <h5>Children</h5>

                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div><br />

                                        <a href="{{route('casemanage_showChildrenDashboard')}}" class="small-box-footer">Manage Children <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>





                            </div>
                            <!-- ./col -->
                            <div class="row">


                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-gradient-purple">
                                        <div class="inner">
                                            <h5>Reports</h5>

                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div><br />

                                        <a href="/reports" class="small-box-footer">View Reports <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>

                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-red">
                                        <div class="inner">
                                            <h5>Mobile Apps</h5>

                                            <!-- We need to include our modal using livewire, or our
                                            html markup we will not be loaded -->
                                            @livewireScripts

                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-home"></i>
                                        </div><br />

                                        <a href="/mobileCM" class="small-box-footer">View Mobile Apps <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- /.row -->
                        <!-- Main row -->

                        {{--                    <ul>Desktop Apps--}}
                        {{--                    <li><a href="{{route('HomeVisitDesktop')}}" class="mt-2">Home Visit</a></li>--}}
                        {{--                    <li><a href="{{route('OnCallDesktop')}}" class="mt-2">On-Call</a></li>--}}
                        {{--                    <li><a href="{{route('OnCallCYSWDesktop')}}" class="mt-2">On-Call CYSW</a></li>--}}

                        {{--                    </ul>--}}



                    </section>

                    @livewire('dashboard-elements.lists.case-manage.child-profiles')
                    @livewire('dashboard-elements.lists.case-manage.foster-parent-profiles')


                </div>
            @endif

            @if (auth()->user()->user_type == "3.2")
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-gradient-purple">
                                <div class="inner">
                                    <h5>Reports</h5>

                                </div>

                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div><br />

                                <a href="/reports" class="small-box-footer">View Reports <i
                                        class="fas fa-arrow-circle-right"></i></a>

                            </div>

                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h5>Mobile Apps</h5>

                                    <!-- We need to include our modal using livewire, or our
                                    html markup we will not be loaded -->
                                    @livewireScripts

                                </div>

                                <div class="icon">
                                    <i class="fas fa-home"></i>
                                </div><br />

                                <a href="/mobileCM" class="small-box-footer">View Mobile Apps <i
                                        class="fas fa-arrow-circle-right"></i></a>

                            </div>
                        </div>
                    </div>
                </div>
            @endif


            @if (auth()->user()->user_type == "7" )

                <div class="tab-pane fade show active" id="admin_assistant" role="tabpanel" aria-labelledby="charlene">
                    <section class="content">
                        <div class="container-fluid">
                            <!-- Small boxes (Stat box) -->


                            <!-- ./col -->
                            <div class="row">

                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-gradient-purple">
                                        <div class="inner">
                                            <h5>Reports</h5>
                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div><br />

                                        <a href="/reports" class="small-box-footer">View Reports <i class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>


                            </div>

                        </div>
                        <!-- /.row -->
                        <!-- Main row -->

                    </section>

                    @livewire('dashboard-elements.lists.case-manage.child-profiles')
                    @livewire('dashboard-elements.lists.case-manage.foster-parent-profiles')


                </div>
            @endif


            @if (auth()->user()->user_type == "3.4" || auth()->user()->user_type == "3.3")

                <div class="tab-pane fade show active" id="admin_assistant" role="tabpanel" aria-labelledby="charlene">
                    <section class="content">
                        <div class="container-fluid">
                            <!-- Small boxes (Stat box) -->

                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-yellow">
                                        <div class="inner">
                                            <h5>Foster Parents</h5>
                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div><br />

                                        <a href="{{route('casemanage_showFosterParentDashboard')}}" class="small-box-footer">Manage Foster Parents <i class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-gradient-fuchsia">
                                        <div class="inner">
                                            <h5>Children</h5>
                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div><br />

                                        <a href="{{route('casemanage_showChildrenDashboard')}}" class="small-box-footer">Manage Children <i class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>

                            </div>
                            <!-- ./col -->
                            <div class="row">

                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-gradient-lightblue">
                                        <div class="inner">
                                            <h5>Global Sandwich Board</h5>

                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-bell"></i>
                                        </div><br />

                                        <a href="#" class="small-box-footer">View Global Sandwich Board <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-blue">
                                        <div class="inner">
                                            <h5>We-Schedule.ca</h5>


                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-link"></i>
                                        </div><br />

                                        <a href="https://we-schedule.ca" target="_blank" class="small-box-footer">Open We-Schedule.ca <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-red">
                                        <div class="inner">
                                            <h5>Mobile Apps</h5>

                                            <!-- We need to include our modal using livewire, or our
                                            html markup we will not be loaded -->
                                            @livewireScripts

                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-home"></i>
                                        </div><br />

                                        <a href="/mobileCM" class="small-box-footer">View Mobile Apps <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-gradient-purple">
                                        <div class="inner">
                                            <h5>Reports</h5>

                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div><br />

                                        <a href="/reports" class="small-box-footer">View Reports <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>                                        </div>

                            </div>

                        </div>
                        <!-- /.row -->
                        <!-- Main row -->

                    </section>


                </div>


                @livewire('dashboard-elements.lists.case-manage.child-profiles')
                @livewire('dashboard-elements.lists.case-manage.foster-parent-profiles')

            @endif

            @if (auth()->user()->user_type == "2.3")

                <div class="tab-pane fade show active" id="admin_assistant" role="tabpanel" aria-labelledby="charlene">
                    <section class="content">
                        <div class="container-fluid">
                            <!-- Small boxes (Stat box) -->

                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-yellow">
                                        <div class="inner">
                                            <h5>Foster Parent Applicant</h5>


                                        </div>

                                        <div class="icon">
                                            <i class="fas fa-clipboard-list"></i>
                                        </div><br />


                                        <a href="javascript:window.location='/CaseManage/users/' + '{{$user->id}}' + '/viewFosterParentApplicationForm'" class="small-box-footer">View Application Form <i
                                                class="fas fa-arrow-circle-right"></i></a>

                                    </div>

                                </div>
                            </div>


                            @endif


                        </div>
                    </section>


                    <style>

                        .child-small {
                            font-size: 0.7rem;
                        }

                        .card {

                            border: none;
                            border-radius: 10px;
                            background-color: #fff
                        }



                    </style>

        {{--
                @if ($user->user_type == 2 | $user->user_type == 3 | $user->user_type == 4)
                    <!-- Child Profiles -->
                    <div class="container-fluid mt-3 mb-3 ">
                        CHILD PROFILES <span class="float-right"><input type="checkbox" checked data-toggle="toggle" data-on="Active" data-off="Deactivated" data-onstyle="success" data-offstyle="danger" data-size="xs"></span>


                        <div class="row gx-4 gx-lg-5 row-cols-6 row-cols-md-6 row-cols-xl-6 mt-2 justify-content-center">
                            @foreach ($children as $child)
                                <div class="col-xl-2 col-md-2 mb-4">
                                    <div class="card border-0 shadow">

                                        <img src="https://images.unsplash.com/photo-1516240562813-7d658edb7239?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" class="card-img-top" alt="...">
                                        @if ($child->SRA) <span class="badge bg-success mt-0">SRA</span> @else <span class="badge mt-0">&nbsp;</span>@endif
                                        <div class="card-body text-center">
                                            <h6 class="mb-0 text-center @php
                                        if (strlen($child->initials) >15)
                                            echo "child-small ";
                                    @endphp">                      <br />{{$child->initials}}</h6>
                                            <div class="card-text text-black-50">                                            <div class="button mt-2 d-flex flex-row align-items-center"> <button onclick="viewChildProfile('{{$child->id}}')" class="btn btn-sm btn-primary w-100">Profile</button> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                    <!-- *Child Profiles -->


                    <!-- CYSW Profiles -->
                    <div class="container-fluid">
                        <div class="row justify-content-md">

                            <div class="container-fluid mt-2 mb-3">
                                CYSW PROFILES <span class="float-right"><input type="checkbox" checked data-toggle="toggle" data-on="Active" data-off="Deactivated" data-onstyle="success" data-offstyle="danger" data-size="xs"></span>

                                <div class="row gx-4 gx-lg-5 row-cols-6 row-cols-md-6 row-cols-xl-6 mt-2 justify-content-center">
                                    @foreach ($users as $user)
                                        <div class="col-xl-2 col-md-2 mb-4">
                                            <div class="card border-0 shadow">
                                                @if (!$user->profile_pic)


                                                    <img height="150px" src="/img/default-avatar.png" alt="avatar" class="card-img-top" />
                                                @else

                                                    <img height="150px" src="/storage/profile_pic/{{substr($user->profile_pic,20)}}" alt="avatar" class="card-img-top imaged rounded mr-2">
                                                @endif
                                                @if ($user->getSignedInShift)
                                                    <span class="badge bg-success mt-0">Signed In</span>
                                                @else
                                                    <span class="badge bg-red mt-0">Offline</span>

                                                @endif
                                                <div class="card-body text-center">
                                                    <h6 class="mb-0 text-center @php
                                        if (strlen($user->name) >25)
                                            echo "child-small ";
                                    @endphp">                      <br />{{$user->name}}</h6>
                                                    <div class="card-text text-black-50">                                            <div class="button mt-2 d-flex flex-row align-items-center"> <button onclick="viewUserProfile('{{$user->id}}')" class="btn btn-sm btn-primary w-100">Profile</button> </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                            </div>




                        </div>
                        <!-- *CYSW Profiles -->


                    </div>
            </div>
            @endif
        --}}
    </section>


    <script>

        $(document).ready(function() {
            const otherDate = new Date("04 August 2023"); // Carpe Diem 24th Anniversary
            const RPACDate = new Date("03 August 2023"); //RPAC Message
            const todayDate = new Date(); // Current or today's date

// Check if the other date matches today's date
            if (
                RPACDate.getDate() === todayDate.getDate() &&
                RPACDate.getMonth() === todayDate.getMonth() &&
                RPACDate.getYear() === todayDate.getYear()
            ) {

                @if ($user->id == "2")
                Swal.fire({
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    },
                    imageUrl: 'img/RPAC.png',
                    // imageHeight: 200,
                    imageWidth: 800,
                    width: '800',
                    height: '300',
                    title: 'What is RPAC?',
                    html: "<b>RPAC</b> is an abbreviation for <b>R</b>esidential <b>P</b>lacement <b>A</b>dvisory <b>C</b>ommittee that is a mandated review as outlined in the Child, Youth and Family Services Act. <br /><br /><b>RPAC</b> has a role to review the appropriateness of a child’s residential placement. Reviews include the child’s point of view, the parent/guardian’s point of view and key service providers involved. Reviews must occur for each child and youth who moves into a residential program licensed for ten or more individuals when the placement will be more than three months. Additionally, any child/youth living in either foster care or a group home of any size can ask for a review. <br /><br /><i>It’s your right!</i>",
                    background: '#fff',
                    position: 'center',
                    backdrop: true,
                    imageAlt: 'RPAC',
                    // confirmButtonText: "Thank you for being you!",
                    showCancelButton: true,

                    confirmButtonText:
                        '<i class="fa fa-thumbs-up"></i> Great!',
                    cancelButtonText:
                        '<i class="fa fa-info"></i> More Info!',

                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Great!',
                            'By clicking OK, you acknowledge that you have read and understand the meaning of RPAC. <br /><br />If you have any questions regarding RPAC please contact <b>Blair Lewis</b> @ 416-459-1999 immediately.',
                            'success'
                        )
                    } else {
                        Swal.fire(
                            'Imagine a Foster Parent just clicked "OK"',
                            'The <b>"RPAC reviewed badge"</b> would automatically appear on their <b>Learning Plan</b> as well as <b>AR</b> and <b>Timeline</b>, with a date and time stamp. <br /><br />Take a moment and imagine all the other information we could review virtually with our <b>Foster Parents</b> and <b>Staff</b> . . . <br /><br />  Welcome to CaseManage.ca, ' + "<br /><i>We're just getting started</i>",
                            'info'
                        )
                    }


                });
                @endif
            }

            function viewChildProfile($id) {
                window.location.href = "/children/" + $id;
            }

            function viewUserProfile($id) {
                window.location.href = "/users/" + $id;
            }
        });
    </script>
    </div>
    </div>

    </section>
@stop
