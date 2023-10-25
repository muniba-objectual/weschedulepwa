<div wire:poll.visible>
    FOSTER PARENT APPLICANTS
    <div class="row gx-4 gx-lg-5 row-cols-6 row-cols-md-6 row-cols-xl-6 justify-content-center">
        @foreach ($users as $user)
            @if ($user->user_type == "2.3")
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
                            <div class="card-text text-black-50">
                                <div class="button mt-2 d-flex flex-row align-items-center"> <button onclick="javascript:window.location='/users/{{$user->id}}'" class="btn btn-sm btn-primary w-100">Profile</button> </div>
                                <div class="button mt-2 d-flex flex-row align-items-center"> <button onclick="javascript:window.location='users/' + '{{$user->id}}' + '/viewFosterParentApplicationForm'" class="btn btn-sm btn-primary w-100">Application Form</button> </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
