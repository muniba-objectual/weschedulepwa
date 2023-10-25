<x-wire-elements-pro::bootstrap.modal on-submit="" :content-padding="true">
    @if ($userType == "child")
        <x-slot name="title">Child Profiles</x-slot>
    @elseif ($userType == "cysw")
        <x-slot name="title">CYSW Profiles</x-slot>
    @endif

    <div class="modal-dialog child-modal modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-end align-items-center">
                    <div class="input-group w-100 w-md-20 w-lg-20 mx-2">
                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <div class="form-check form-switch ps-0">
                        <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault" checked>
                    </div>
                </div>
                <div class="d-flex flex-wrap w-100">
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 card-width">
                        <img src="{{ asset('img/child-1.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            John Doe
                        </h6>
                        @if ($userType == "child")
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        @elseif ($userType == "cysw")
                            <a href="tel:555-555-5555" class="text-phone"><img src="./assets/img/phone-call.svg" class="phone-call" />
                                &nbsp;555-555-5555
                            </a>
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto ">Offline</span>
                        @endif
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 1 }})">VIEW PROFILE</button>
                        </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 card-width">
                        <img src="{{ asset('img/child-2.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            Emmily Watson
                        </h6>
                        @if ($userType == "child")
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        @elseif ($userType == "cysw")
                            <a href="tel:555-555-5555" class="text-phone"><img src="./assets/img/phone-call.svg" class="phone-call" />
                                &nbsp;555-555-5555
                            </a>
                            <span class="badge badge-sm bg-success-online dashboard-card-label m-auto">Online</span>
                        @endif
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 2 }})">VIEW PROFILE</button>
                        </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 card-width">
                        <img src="{{ asset('img/child-1.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            Ammy Clark
                        </h6>
                        @if ($userType == "child")
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        @elseif ($userType == "cysw")
                            <a href="tel:555-555-5555" class="text-phone"><img src="./assets/img/phone-call.svg" class="phone-call" />
                                &nbsp;555-555-5555
                            </a>
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto ">Offline</span>
                        @endif
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 3 }})">VIEW PROFILE</button>
                        </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 card-width">
                        <img src="{{ asset('img/child-2.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            Emma Watson
                        </h6>
                        @if ($userType == "child")
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        @elseif ($userType == "cysw")
                            <a href="tel:555-555-5555" class="text-phone"><img src="./assets/img/phone-call.svg" class="phone-call" />
                                &nbsp;555-555-5555
                            </a>
                            <span class="badge badge-sm bg-success-online dashboard-card-label m-auto">Online</span>
                        @endif
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 4 }})">VIEW PROFILE</button>
                        </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 card-width">
                        <img src="{{ asset('img/child-1.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            Jhonny Bravo
                        </h6>
                        @if ($userType == "child")
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        @elseif ($userType == "cysw")
                            <a href="tel:555-555-5555" class="text-phone"><img src="./assets/img/phone-call.svg" class="phone-call" />
                                &nbsp;555-555-5555
                            </a>
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto ">Offline</span>
                        @endif
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 5 }})">VIEW PROFILE</button>
                        </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 card-width">
                        <img src="{{ asset('img/child-1.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            John Doe
                        </h6>
                        @if ($userType == "child")
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        @elseif ($userType == "cysw")
                            <a href="tel:555-555-5555" class="text-phone"><img src="./assets/img/phone-call.svg" class="phone-call" />
                                &nbsp;555-555-5555
                            </a>
                            <span class="badge badge-sm bg-success-online dashboard-card-label m-auto">Online</span>
                        @endif
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 6 }})">VIEW PROFILE</button>
                        </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 card-width">
                        <img src="{{ asset('img/child-2.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            Emmily Watson
                        </h6>
                        @if ($userType == "child")
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        @elseif ($userType == "cysw")
                            <a href="tel:555-555-5555" class="text-phone"><img src="./assets/img/phone-call.svg" class="phone-call" />
                                &nbsp;555-555-5555
                            </a>
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto ">Offline</span>
                        @endif
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 7 }})">VIEW PROFILE</button>
                        </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 card-width">
                        <img src="{{ asset('img/child-1.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            Ammy Clark
                        </h6>
                        @if ($userType == "child")
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        @elseif ($userType == "cysw")
                            <a href="tel:555-555-5555" class="text-phone"><img src="./assets/img/phone-call.svg" class="phone-call" />
                                &nbsp;555-555-5555
                            </a>
                            <span class="badge badge-sm bg-success-online dashboard-card-label m-auto">Online</span>
                        @endif
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 8 }})">VIEW PROFILE</button>
                        </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 card-width">
                        <img src="{{ asset('img/child-2.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            Emma Watson
                        </h6>
                        @if ($userType == "child")
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        @elseif ($userType == "cysw")
                            <a href="tel:555-555-5555" class="text-phone"><img src="./assets/img/phone-call.svg" class="phone-call" />
                                &nbsp;555-555-5555
                            </a>
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto ">Offline</span>
                        @endif
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 9 }})">VIEW PROFILE</button>
                        </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 card-width">
                        <img src="{{ asset('img/child-1.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            Jhonny Bravo
                        </h6>
                        @if ($userType == "child")
                            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        @elseif ($userType == "cysw")
                            <a href="tel:555-555-5555" class="text-phone"><img src="./assets/img/phone-call.svg" class="phone-call" />
                                &nbsp;555-555-5555
                            </a>
                            <span class="badge badge-sm bg-success-online dashboard-card-label m-auto">Online</span>
                        @endif
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 10 }})">VIEW PROFILE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-wire-elements-pro::bootstrap.modal>