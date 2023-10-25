<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    @section('title')
        Dashboard
    @endsection
    
    @livewire("we-schedule.layout.navbar-black")

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8 d-flex justify-content-center align-items-center">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold-700">Staff Management</p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8 d-flex justify-content-center align-items-center">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold-700">Home Management</p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8 d-flex justify-content-center align-items-center">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold-700">Child Management</p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8 d-flex justify-content-center align-items-center">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold-700">Shift Management</p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-lg-12">
                    <div class="d-block d-md-flex d-lg-flex justify-content-between">
                        <p class="mb-1 font-weight-bold text-body">Child Profiles</p>
                        <div class="d-flex justify-content-end align-items-center">
                        <div class="input-group mx-2">
                            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Search...">
                        </div>
                        <div class="form-check form-switch ps-0">
                            <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault" checked>
                        </div>
                        </div>

                    </div>
                    <div class="overflow-scroll dashboard-card-main mt-2">
                        <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 w-18">
                        <img src="{{ asset('img/child-1.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            John Doe
                        </h6>
                        <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto ">ISA</span>
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 1 }})">VIEW PROFILE</button>
                        </div>
                        </div>
                        <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 w-18">
                        <img src="{{ asset('img/child-2.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            Emmily Watson
                        </h6>
                        <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 2 }})">VIEW PROFILE</button>
                        </div>
                        </div>
                        <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 w-18">
                        <img src="{{ asset('img/child-1.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            Ammy Clark
                        </h6>
                        <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 3 }})">VIEW PROFILE</button>
                        </div>
                        </div>
                        <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 w-18">
                        <img src="{{ asset('img/child-2.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            Emma Watson
                        </h6>
                        <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 4 }})">VIEW PROFILE</button>
                        </div>
                        </div>
                        <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 w-18">
                        <img src="{{ asset('img/child-1.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            Jhonny Bravo
                        </h6>
                        <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 5 }})">VIEW PROFILE</button>
                        </div>
                        </div>
                        <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 w-18">
                        <img src="{{ asset('img/child-2.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                        <h6 class="text-center mt-3">
                            Minimalist
                        </h6>
                        <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">ISA</span>
                        <div class="text-center">
                            <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 6 }})">VIEW PROFILE</button>
                        </div>
                        </div>
                    </div>
                    <a class="text-body text-sm font-weight-bold mb-0 icon-move-right float-right mt-2 d-block"
                        href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.user-list-modal', {'userType': 'child'}, {'size':'5xl'})">
                        View all
                        <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                    </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-lg-12">
                  <div class="d-block d-md-flex d-lg-flex justify-content-between">
                    <p class="mb-1 font-weight-bold text-body">CYSW Profiles</p>
                    <div class="d-flex justify-content-end align-items-center">
                      <div class="input-group mx-2">
                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" placeholder="Search...">
                      </div>
                      <div class="form-check form-switch ps-0">
                        <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault" checked>
                      </div>
                    </div>
                  </div>
                  <div class="overflow-scroll dashboard-card-main">
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 w-18">
                      <img src="{{ asset('img/child-1.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                      <h6 class="text-center mt-3">
                        Maria Clark
                      </h6>
                      <a href="tel:555-555-5555" class="text-phone"><img src="{{ asset('img/phone-call.svg') }}"
                          class="phone-call" /> &nbsp;555-555-5555</a>
                      <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto ">Offline</span>
                      <div class="text-center">
                        <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 7 }})">VIEW PROFILE</button>
                      </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 w-18">
                      <img src="{{ asset('img/child-2.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                      <h6 class="text-center mt-3">
                        Emmily Watson
                      </h6>
                      <a href="tel:555-555-5555" class="text-phone"><img src="{{ asset('img/phone-call.svg') }}"
                          class="phone-call" /> &nbsp;555-555-5555</a>
                      <span class="badge badge-sm bg-success-online dashboard-card-label m-auto">Online</span>
                      <div class="text-center">
                        <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 8 }})">VIEW PROFILE</button>
                      </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 w-18">
                      <img src="{{ asset('img/child-1.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                      <h6 class="text-center mt-3">
                        John Doe
                      </h6>
                      <a href="tel:555-555-5555" class="text-phone"><img src="{{ asset('img/phone-call.svg') }}"
                          class="phone-call" /> &nbsp;555-555-5555</a>
                      <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto">Offline</span>
                      <div class="text-center">
                        <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 9 }})">VIEW PROFILE</button>
                      </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 w-18">
                      <img src="{{ asset('img/child-2.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                      <h6 class="text-center mt-3">
                        Maria Clark
                      </h6>
                      <a href="tel:555-555-5555" class="text-phone"><img src="{{ asset('img/phone-call.svg') }}"
                          class="phone-call" /> &nbsp;555-555-5555</a>
                      <span class="badge badge-sm bg-success-online dashboard-card-label m-auto">Online</span>
                      <div class="text-center">
                        <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 10 }})">VIEW PROFILE</button>
                      </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 w-18">
                      <img src="{{ asset('img/child-1.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                      <h6 class="text-center mt-3">
                        Emmily Watson
                      </h6>
                      <a href="tel:555-555-5555" class="text-phone"><img src="{{ asset('img/phone-call.svg') }}"
                          class="phone-call" /> &nbsp;555-555-5555</a>
                      <span class="badge badge-sm bg-success-online dashboard-card-label m-auto">Online</span>
                      <div class="text-center">
                        <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 11 }})">VIEW PROFILE</button>
                      </div>
                    </div>
                    <div class="card dashboard-child-card mt-2 mx-2 p-2 h-100 mb-4 w-18">
                      <img src="{{ asset('img/child-2.png') }}" alt="img-blur-shadow" class="img-fluid shadow w-100">
                      <h6 class="text-center mt-3">
                        Minimalist
                      </h6>
                      <a href="tel:555-555-5555" class="text-phone"><img src="{{ asset('img/phone-call.svg') }}"
                          class="phone-call" /> &nbsp;555-555-5555</a>
                      <span class="badge badge-sm bg-success-online dashboard-card-label m-auto">Online</span>
                      <div class="text-center">
                        <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" wire:click="GetUser({{ 12 }})">VIEW PROFILE</button>
                      </div>
                    </div>
                    
                  </div>
                  <a class="text-body text-sm font-weight-bold mb-0 icon-move-right float-right mt-2 d-block"
                    href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.user-list-modal', {'userType': 'cysw'}, {'size':'5xl'})">
                    View all
                    <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @livewire('modal-pro')
  </main>
