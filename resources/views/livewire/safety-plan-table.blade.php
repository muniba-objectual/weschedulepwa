<div>


    <div class="row">
        <div class="col-md-3 mb-4">

            @unless($versions->count())
                <a href="#" id="btn_create_new_safety_assessment" onclick="confirmCreateSafetyAssessment(event)" class="btn btn-primary btn-sm">Create New Safety Assessment</a>
            @endunless

            <script>
                function confirmCreateSafetyAssessment(event) {
                    var confirmed = confirm("Are you sure you want to create a new safety assessment?");

                    if (confirmed) {
                        Livewire.emit('createSafetyAssessment');
                    } else {
                        event.preventDefault();
                    }
                }
            </script>
        </div>
    </div>

    @if( $versions->count() )
        <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Date Created</th>
{{--            <th>Date Updated</th>--}}
{{--            <th></th>
            <th>Version</th>--}}
            <th>Description</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
            /** @var \App\Models\ChildSafetyForm $version */
            $firstLoop = true;
        ?>
        @foreach($versions->sortByDesc('created_at') as $version)
            <tr>
                <td>{{ $version->created_at->format('M jS Y') }}</td>
{{--                <td>{{ $version->updated_at->format('M jS Y') }}</td>--}}
{{--                <td>--}}
{{--                    @if($version->is_a_new_plan)--}}
{{--                        *--}}
{{--                    @endif--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    {{ $version->version }}--}}
{{--                </td>--}}
                <td>
{{--                    ( {{$version->form_stage}} )--}}

                    @if($version->form_stage == 0)
                        NEW Safety Assessment/Plan

                    @elseif($version->form_stage == 1)
                        @if($version->is_latest)
                            &nbsp;&nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> To Be Reviewed
                        @else
                            NEW Safety Assessment/Plan
                        @endif

                    @elseif($version->form_stage == 2)
                        &nbsp;&nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> Reviewed
                    @endif

                    @if($version->is_latest)
{{--                            &nbsp; &nbsp; * (latest)--}}
                    @endif
                </td>
                <td>
                    <a href="/TestFormBuilder/2/{{ $version->form_id }}/?PDF=true&back-text=Child {{$childName}} Asessment View&back-url={{urlencode("/children/{$saftyPlanChildId}#safety_forms")}}" class="btn btn-primary">View PDF</a>
                    @if($firstLoop)
                        <a href="#" wire:click="createACloneForReviewPurpose({{ $version->id }})" class="btn btn-primary">Review</a>
                        <a href="#" wire:click="createACloneForNewAssessmentPurpose({{ $version->id }})" class="btn btn-primary">New</a>
                        <?php $firstLoop = false;?>
                    @endif
                    <a href="#" wire:click="onEmail({{$version->form_id}})" class="btn btn-success">Email</a>
                    @if( auth()->user()->get_user_type->type == '10.0' )
                        <a href="#" wire:click="deleteForm({{ $version->id }})" class="btn btn-danger">Delete</a>
                    @endif
                </td>

{{--                <td>--}}
{{--                    @if($version->form_stage == 0)--}}
{{--                        <a href="/TestFormBuilder/2/{{ $version->form_id }}/?back-text=Child {{$childName}} Asessment&back-url={{urlencode("/children/{$saftyPlanChildId}#safety_forms")}}" class="btn btn-primary">Edit</a>--}}


{{--                    @elseif($version->form_stage == 1)--}}

{{--                        --}}{{--V2 Logic--}}
{{--                        @if($version->is_latest)--}}
{{--                            <a href="/TestFormBuilder/2/{{ $version->form_id }}/?back-text=Child {{$childName}} Asessment View&back-url={{urlencode("/children/{$saftyPlanChildId}#safety_forms")}}" class="btn btn-primary">View</a>--}}
{{--                            <a href="#" wire:click="createACloneForReviewPurpose({{ $version->id }})" class="btn btn-primary">Review</a>--}}
{{--                        @else--}}
{{--                            <a href="/TestFormBuilder/2/{{ $version->form_id }}/?back-text=Child {{$childName}} Asessment View&back-url={{urlencode("/children/{$saftyPlanChildId}#safety_forms")}}" class="btn btn-primary">View</a>--}}
{{--                        @endif--}}

{{--                            --}}{{--V1 Logic--}}
{{--                        <a href="/TestFormBuilder/2/{{ $version->form_id }}/?back-text=Child {{$childName}} Asessment View&back-url={{urlencode("/children/{$saftyPlanChildId}#safety_forms")}}" class="btn btn-primary">View</a>--}}
{{--                        <a href="#" wire:click="createACloneForReviewPurpose({{ $version->id }})" class="btn btn-primary">Review</a>--}}




{{--                    @elseif($version->form_stage == 2)--}}

{{--                        --}}{{--V2 Logic--}}
{{--                        @if($version->is_latest)--}}
{{--                            <a href="/TestFormBuilder/2/{{ $version->form_id }}/?back-text=Child {{$childName}} Asessment View&back-url={{urlencode("/children/{$saftyPlanChildId}#safety_forms")}}" class="btn btn-primary">View</a>--}}
{{--                            <a href="#" wire:click="createACloneForAnotherReviewPurpose({{ $version->id }})" class="btn btn-primary">Review</a>--}}
{{--                        @else--}}
{{--                            <a href="/TestFormBuilder/2/{{ $version->form_id }}/?back-text=Child {{$childName}} Asessment View&back-url={{urlencode("/children/{$saftyPlanChildId}#safety_forms")}}" class="btn btn-primary">View</a>--}}
{{--                        @endif--}}

{{--                        --}}{{--V1 Logic--}}
{{--                        <a href="/TestFormBuilder/2/{{ $version->form_id }}/?back-text=Child {{$childName}} Asessment View&back-url={{urlencode("/children/{$saftyPlanChildId}#safety_forms")}}" class="btn btn-primary">View</a>--}}
{{--                        <a href="#" wire:click="createACloneForAnotherReviewPurpose({{ $version->id }})" class="btn btn-primary">Review</a>--}}

{{--                    @endif--}}


{{--                    &nbsp;--}}
{{--                    @if($version->is_latest)--}}
{{--                        <a href="#" wire:click="createACloneForNewAssessmentPurpose({{ $version->id }})" class="btn btn-primary">New</a>--}}
{{--                    @endif--}}
{{--                </td>--}}

            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
    @livewire('forms.case-manage.temp.email-link-sharing')

</div>
