@extends('adminlte::page')


@section('title', 'Case-Manage.ca')

@section('content_header')
    @livewireStyles

    <!-- Bootstrap 5 -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- *Bootstrap 5 -->


    <!-- Include the overlay-component.css stylesheet -->
    <link rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-overlay-component.css') }}">

    <!-- Include the overlay-component.js script -->
    <script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>
    <!-- Alpine Plugins -->
    <script  src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <!-- Popperjs -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
            integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp"
            crossorigin="anonymous"></script>
    <!-- Tempus Dominus JavaScript -->
    <script src="/plugins/tempus-dominusv6/js/tempus-dominus.js" crossorigin="anonymous"></script>

    <!-- Tempus Dominus Styles -->
    <link href="/plugins/tempus-dominusv6/css/tempus-dominus.css" rel="stylesheet" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/media_library_styles.css') }}">


    <script>
        $(document).ready(function () {

            function isDate(value) {
                var re = /^(?=\d)(?:(?:31(?!.(?:0?[2469]|11))|(?:30|29)(?!.0?2)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\x20|$))|(?:2[0-8]|1\d|0?[1-9]))([-.\/])(?:1[012]|0?[1-9])\1(?:1[6-9]|[2-9]\d)?\d\d(?:(?=\x20\d)\x20|$))?(((0?[1-9]|1[012])(:[0-5]\d){0,2}(\x20[AP]M))|([01]\d|2[0-3])(:[0-5]\d){1,2})?$/;
                var flag = re.test(value);
                return flag;
            }

            Livewire.on('$refresh', () => {
                alert("Foster Parent Application Form Updated Successfully.")


            });


            /*     $('.DOB').datepicker({
                     format: 'yyyy-mm-dd',
                     autoclose: true,
                 });
     */


            $('#postal_code').inputmask( {mask: 'a9a 9a9', placeholder: '', "oncomplete": function(e) {
                    Livewire.emit('updatePostal', $('#postal_code').val());
                }
            });

                $('.DOB').inputmask( {alias: 'datetime', inputFormat: 'dd/mm/yyyy', placeholder: '', "oncomplete": function(e) {
                    console.log (e.currentTarget.value);
                    if (isDate(e.currentTarget.value)) {
                           updateDOB(e.currentTarget);
                       } else {
                           alert ('Date must be in dd/mm/yyyy format.');
                       }

                }
                    });

                $('#email').inputmask({alias: 'email', "oncomplete": function(e) {
                    Livewire.emit('updateEmail', $('#email').val());
                }, "onincomplete": function(e) {
                        Livewire.emit('updateEmail', $('#email').val());
                    }});

                $('.secondary_email').inputmask({alias: 'email', "oncomplete": function(e) {
                        Livewire.emit('updateSecondaryEmail', $(e.currentTarget).attr('key'),$(e.currentTarget).val());
                    }, "onincomplete": function(e) {
                        Livewire.emit('updateSecondaryEmail', $(e.currentTarget).attr('key'), $(e.currentTarget).val());
                    }});


                $('#telephone').inputmask("(999)999-9999",{"oncomplete": function(e) {
                        Livewire.emit('updateTelephone',$('#telephone').val());
                    }});

                $('.secondary_telephone').inputmask("(999)999-9999",{"oncomplete": function(e) {
                        Livewire.emit('updateSecondaryTelephone',$(e.currentTarget).attr('key'), $(e.currentTarget).val());
                    }});

            $('.additional_telephone').inputmask("(999)999-9999",{"oncomplete": function(e) {
                    Livewire.emit('updateAdditionalTelephone',$(e.currentTarget).attr('key'), $(e.currentTarget).val());
                }});



        });
        function updateDOB($elem) {
           // console.log ($elem);
           Livewire.emit('updateDOB', $($elem).attr('key'), $($elem).val());
        }


        //
        // window.addEventListener('enableDOBMasks', event => {
        //    //alert ('enable dob masks');
        //     $('.DOB').inputmask( {alias: 'datetime', inputFormat: 'dd/mm/yyyy', placeholder: 'dd/mm/yyyy', "oncomplete": function(e) {
        //             updateDOB(e.currentTarget);
        //         }
        //     });
        // });
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/fontawesome.min.css" integrity="sha512-R+xPS2VPCAFvLRy+I4PgbwkWjw1z5B5gNDYgJN5LfzV4gGNeRQyVrY7Uk59rX+c8tzz63j8DeZPLqmXvBxj8pA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    @if (Auth::user()->user_type > 5.0)
        <script>
            $userID = {{$userID}};
            $AuthUserID = {{Auth::user()->id}}
        </script>

        <div class="d-flex justify-content-start">
            <div class="col-8">
                <h1 class="m-0 text-dark">Foster Parent Application Form</h1>

            </div>
            <div class="col-2">
                <button type="button" class="btn btn-success btn-block" onclick="javascript:window.livewire.emit('modal.open', 'modals.case-manage.log-call-modal', {'userID':$userID,'AuthUserID':$AuthUserID}, {'size':'md'})"><i class="fa-solid fa-phone-flip"></i></b> Log Call</button>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-success btn-block" onclick="javascript:window.livewire.emit('modal.open', 'modals.case-manage.log-meeting-modal', {'userID':$userID,'AuthUserID':$AuthUserID}, {'size':'md'})"><i class="fa-solid fa-calendar"></i></b> Log Meeting</button>
            </div>
        </div>

        <div class="d-flex justify-content-center">

            <div class="progress  mb-0 mt-3" style="height: 40px; width: 98%" >
                <div id="totalComplete" wire:ignore class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
        </div>
    @else
        <h1 class="m-0 text-dark">Foster Parent Application Form</h1>
    @endif
    @unless (Auth::check())
        You are not signed in.
    @endunless


@stop

@section('content')
    @if ($updateValue ?? '')
        <script>

            $(document).ready(function () {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });


                Toast.fire({
                    type: 'success',
                    //title: 'We-Schedule.ca | Shift Form updated successfully.<br /> (' + data.success + "|" + data.message + ')',
                    title: 'We-Schedule.ca | User Profile has been updated successfully.',
                    icon: 'success',
                    timerProgressBar: true,


                })



            });

        </script>
    @endif

    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header p-0 pt-1">

                    </div>
                    <div class="card-body">

                                    @livewire('forms.case-manage.lv-foster-parent-application-form', ['userID' => $userID])


                            </div>

                        </div>


                <!-- /.card -->
            </div>

     {{--       <div class="col-5">
              --}}{{--  <livewire:comments :model="$FPAForm" />
--}}{{--


                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header mt-4 pb-0 mb-1 ">
                        <h6 class="mx-auto text-center">Personal Information - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'personal_information_notes', 'FPAForm' => $FPAForm, 'rows' => 10])
                    </div>
                </div>




                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-0 ">
                        <h6 class="mx-auto text-center">Family Composition - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'family_composition_notes', 'FPAForm' => $FPAForm, 'rows' => 12 ])
                    </div>
                </div>


                <div class="card card-secondary" style="margin-top: 17px !important; margin-bottom:18px !important;" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-3" style="padding-bottom:10px !important;">
                        <h6 class="mx-auto text-center" style="margin-bottom: 2px !important;">Description of Home and Community - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'description_of_home_community_notes', 'FPAForm' => $FPAForm, 'rows'=>28])
                    </div>
                </div>

                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-3" style="padding-top: 10px !important; margin-bottom:10px !important;">
                        <h6 class="mx-auto text-center">Physical Description/Personality - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'physical_description_personality_notes', 'FPAForm' => $FPAForm, 'rows' => 5])
                    </div>
                </div>

                <div class="card card-secondary" style="margin-top: 17px !important; margin-bottom: 0px !important;" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-3" style="padding-top: 14px !important; margin-bottom:10px !important;">
                        <h6 class="mx-auto text-center" style="margin-bottom: 2px !important;">Personal History of Each Applicant - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'personal_history_applicant_notes', 'FPAForm' => $FPAForm, 'rows' => 12])
                    </div>
                </div>

                <div class="card card-secondary" style="margin-top: 17px !important; margin-bottom: 0px !important;" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-3" style="padding-top: 14px !important; margin-bottom:10px !important;">
                        <h6 class="mx-auto text-center" style="margin-bottom: 2px !important;">Education/Employment History - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'education_and_employment_history_notes', 'FPAForm' => $FPAForm, 'rows' => 12 ])
                    </div>
                </div>






                        <div class="card-header p-0  " style="margin-top:-18px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Education/Employment History - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'education_and_employment_history_notes', 'FPAForm' => $FPAForm, 'rows' => 12 ])


                        </div>

                        <div class="card-header p-0  " style="margin-top:-17px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Relationship with Partner - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'relationship_with_partner_notes', 'FPAForm' => $FPAForm, 'rows' => 7 ])


                        </div>

                        <div class="card-header p-0  " style="margin-top:-23px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Previous Marriage/Relationship - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'previous_marriage_relationship_notes', 'FPAForm' => $FPAForm, 'rows'=>4 ])


                        </div>

                        <div class="card-header p-0  " style="margin-top:-23px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Management of Children/Parenting Style - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'management_of_children_parenting_style_notes', 'FPAForm' => $FPAForm ])


                        </div>

                        <div class="card-header p-0  " style="margin-top:19px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Communication - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'communication_notes', 'FPAForm' => $FPAForm ])


                        </div>

                        <div class="card-header p-0  " style="margin-top:19px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Problem Solving - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'problem_solving_notes', 'FPAForm' => $FPAForm ])


                        </div>

                        <div class="card-header p-0  " style="margin-top:19px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Current Family Functioning - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'current_family_functioning_notes', 'FPAForm' => $FPAForm ])


                        </div>

                        <div class="card-header p-0  " style="margin-top:19px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Cultural Issues - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'cultural_issues_notes', 'FPAForm' => $FPAForm ])


                        </div>

                        <div class="card-header p-0  " style="margin-top:19px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Religious Beliefs/Practices - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'religious_beliefs_practices_notes', 'FPAForm' => $FPAForm ])


                        </div>

                        <div class="card-header p-0  " style="margin-top:19px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Special Skills - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'special_skills_notes', 'FPAForm' => $FPAForm ])


                        </div>

                        <div class="card-header p-0  " style="margin-top:19px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Motiviation to Foster - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'motivation_to_foster_notes', 'FPAForm' => $FPAForm ])


                        </div>

                        <div class="card-header p-0  " style="margin-top:19px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Financial Profile - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'financial_profile_notes', 'FPAForm' => $FPAForm ])


                        </div>

                        <div class="card-header p-0  " style="margin-top:19px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Relief/Full-Time - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'relief_fulltime_notes', 'FPAForm' => $FPAForm ])


                        </div>

                        <div class="card-header p-0  " style="margin-top:19px !important; margin-bottom:10px !important">
                            <h6 class="ml-3 mr-3 mt-2 pt-1 mx-auto text-center">Strengths - Notes</h6>
                        </div>
                        <div class="card-body" style="margin-bottom:33px !important;">


                            @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'strengths_notes', 'FPAForm' => $FPAForm ])


                        </div>

                    </div>--}}




                    </div>

            </div>
               {{-- </div>--}}

    @livewire('modal-pro')

    @livewireScripts









@stop

