
  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

    @livewire("we-schedule.layout.navbar-white")

    <div class="container-fluid">
      <div class="page-header min-height-300 border-radius-xl mt-4"
        style="background-image: url({{ asset('img/profile-banner.png') }}); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
      </div>
      <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="{{ asset('img/bruce-mars.jpg') }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                Alec Thompson
              </h5>
              <span class="badge badge-sm bg-success-online dashboard-card-label m-auto">SRA</span>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 text-right">
            <div class="form-check form-switch ps-0 text-end">
              <input class="form-check-input ms-auto float-right" type="checkbox" id="flexSwitchCheckDefault" checked>
              <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0 font-weight-bold mt-2"
                for="flexSwitchCheckDefault">Active</label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12 col-xl-4 mt-2 mt-md-0 mt-lg-0">
          <div class="card h-100">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Profile Information</h6>
            </div>
            <div class="card-body p-3">
              <ul class="list-group">
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Initials: </strong>
                  &nbsp;Alec M. Thompsom</li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Date of Birth: </strong>
                  &nbsp; 1st January 2000</li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Assigned Home: </strong>
                  &nbsp;
                  Foster Home</li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Notes: </strong> &nbsp;
                  He is a lovely boy</li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Total Shifts: </strong>
                  &nbsp;
                  160</li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Staff Assigned (2):
                  </strong> &nbsp;
                  <a href="">Smith John, Bobby Handles</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-4 mt-2 mt-md-0 mt-lg-0">
          <div class="card h-100">
            <div class="card-header pb-0 p-3 pt-0">
              <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                  <h6 class="mb-0">Activity</h6>
                </div>
                <div class="col-md-4 text-end">
                  <a href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.activity-modal', {'zzz':0}, {'size':'3xl'})">
                    <p class="text-sm mt-3 font-weight-bold cursor-pointer">See more</p>
                  </a>
                </div>
              </div>
            </div>
            <div class="card-body p-3 pt-0">
              <div class="mb-1">
                <div class="d-flex activity-separator">
                  <div class="flex-shrink-0">
                    <img alt="Image placeholder" class="avatar rounded-circle image-avatar"
                      src="{{ asset('img/team-2.jpg') }}">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <div class="d-flex justify-content-between">
                      <h6 class="h5 mt-0 text-sm">Arsalan Saleem</h6>
                      <p class="activity-date">Yesterday at 5:50 PM</p>
                    </div>
                    <p class="text-sm">He is very good boy.</p>
                    <div class="d-flex align-items-center">
                      <div>
                        <img alt="Image" class="timeline-icon" src="{{ asset('img/reply.svg') }}">
                      </div>
                      <span class="text-sm me-2 font-weight-bold">&nbsp;REPLY</span>
                    </div>
                  </div>
                </div>
                <div class="d-flex mt-2 activity-separator">
                  <div class="flex-shrink-0">
                    <img alt="Image placeholder" class="avatar rounded-circle image-avatar"
                      src="{{ asset('img/team-2.jpg') }}">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <div class="d-flex justify-content-between">
                      <h6 class="h5 mt-0 text-sm">Arsalan Saleem</h6>
                      <p class="activity-date">Yesterday at 5:50 PM</p>
                    </div>
                    <p class="text-sm">He is very good boy.</p>
                    <div class="d-flex align-items-center">
                      <div>
                        <img alt="Image" class="timeline-icon" src="{{ asset('img/reply.svg') }}">
                      </div>
                      <span class="text-sm me-2 font-weight-bold">&nbsp;REPLY</span>
                    </div>
                  </div>
                </div>
                <div class="d-flex mt-4">
                  <div class="flex-grow-1 my-auto">
                    <form class="activity-comment-main d-flex align-items-center">
                      <input class="form-control border-0" placeholder="Write a comment" />
                      <a href=""><img alt="Image" class="timeline-icon" src="{{ asset('img/attachment.svg') }}"></a>
                      <button type="button"
                        class="btn bg-gradient-primary w-30 w-md-25 w-lg-25 mb-0 activity-comment-btn py-2">Post</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-4 mt-2 mt-md-0 mt-lg-0">
          <div class="card h-100">
            <div class="card-header pb-0 pt-0">
              <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                  <h6 class="mb-0">Timeline</h6>
                </div>
                <div class="col-md-4 text-end">
                  <a href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.timeline-modal', {'zzz':0}, {'size':'xl'})">
                    <p class="text-sm mt-3 font-weight-bold">See more</p>
                  </a>
                </div>
              </div>
            </div>
            <div class="card-body p-3 timeline-overflow">
              <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto"> 11 Aug 23</span>
              <div class="timeline timeline-one-side">
                <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <img alt="Image" class="timeline-icon" src="{{ asset('img/briefcase.svg') }}">
                  </span>
                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">Bobby Handles submitted an End of Shift Report
                    </h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>
                  </div>
                </div>
                <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <img alt="Image" class="timeline-icon" src="{{ asset('img/signin.svg') }}">
                  </span>
                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">Bobby Handles Signed In</h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
                  </div>
                </div>
                <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <img alt="Image" class="timeline-icon" src="{{ asset('img/signout.svg') }}">
                  </span>
                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">Bobby Handles Signed In</h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>
                  </div>
                </div>
              </div>
              <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto"> 11 Aug 23</span>
              <div class="timeline timeline-one-side">
                <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <img alt="Image" class="timeline-icon" src="{{ asset('img/briefcase.svg') }}">
                  </span>
                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">Bobby Handles submitted an End of Shift Report
                    </h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>
                  </div>
                </div>
                <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <img alt="Image" class="timeline-icon" src="{{ asset('img/signin.svg') }}">
                  </span>
                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">Bobby Handles Signed In</h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
                  </div>
                </div>
                <div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <img alt="Image" class="timeline-icon" src="{{ asset('img/signout.svg') }}">
                  </span>
                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">Bobby Handles Signed In</h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-xl-4 mt-4">
          <div class="card h-100">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Safety Plan</h6>
            </div>
            <div class="card-body p-3">
              <div class="d-flex justify-content-between align-items-center safety-btn px-2 py-2 icon-move-right" 
                wire:click="$emit('modal.open', 'we-schedule.modals.emergency-contacts-modal', {'zzz':0}, {'size':'xl'})">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('img/form.svg') }}" class="avatar avatar-sm me-2">
                  <p class="m-0">Emergency Contacts</p>
                </div>
                <div>
                  <i class="fas fa-arrow-right text-sm ms-1 mx-2" aria-hidden="true"></i>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center safety-btn px-2 py-2 icon-move-right mt-2"
                wire:click="$emit('modal.open', 'we-schedule.modals.identifying-information-modal', {'zzz':0}, {'size':'xl'})">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('img/form.svg') }}" class="avatar avatar-sm me-2">
                  <p class="m-0">Identifying Information</p>
                </div>
                <div>
                  <i class="fas fa-arrow-right text-sm ms-1 mx-2" aria-hidden="true"></i>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center safety-btn px-2 py-2 icon-move-right mt-2"
                wire:click="$emit('modal.open', 'we-schedule.modals.medical-information-modal', {'zzz':0}, {'size':'xl'})">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('img/form.svg') }}" class="avatar avatar-sm me-2">
                  <p class="m-0">Medical Information</p>
                </div>
                <div>
                  <i class="fas fa-arrow-right text-sm ms-1 mx-2" aria-hidden="true"></i>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center safety-btn px-2 py-2 icon-move-right mt-2"
                wire:click="$emit('modal.open', 'we-schedule.modals.other-information-modal', {'zzz':0}, {'size':'xl'})">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('img/form.svg') }}" class="avatar avatar-sm me-2">
                  <p class="m-0">Other Information</p>
                </div>
                <div>
                  <i class="fas fa-arrow-right text-sm ms-1 mx-2" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-8 mt-4">
          <div class="card timeline-overflow">
            <div class="card-header pb-0 p-3 pt-0">
              <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                  <h6 class="mb-0 mt-3">SRA</h6>
                </div>
                <div class="col-md-4 text-end">
                </div>
              </div>
            </div>
            <div class="row m-0">
              <div class="col-12 col-xl-6 mt-2 mt-md-0 mt-lg-0">
                <div class="card-entries p-3">
                  <h6 class="mb-0 font-weight-bold">Entries</h6>
                  <div class="f-group">
                    <select class="f-control f-dropdown w-100 mt-3">
                      <option>Select Month</option>
                    </select>
                  </div>
                  <div class="f-group">
                    <select class="f-control f-dropdown w-100 mt-3">
                      <option>Select Entry</option>
                    </select>
                  </div>
                  <button type="button" class="btn bg-gradient-dark w-100 mt-4 mb-0 text-capitalize"
                    wire:click="$emit('modal.open', 'we-schedule.modals.s-r-a-report-modal', {'zzz':0}, {'size':'3xl'})">Generate SRA Report
                  </button>
                </div>
              </div>
              <div class="col-12 col-xl-6 mt-2 mt-md-0 mt-lg-0">
                <div class="card-entries p-3">
                  <h6 class="mb-0 font-weight-bold">Add Contract Entry</h6>
                  <input type="date" class="form-control mt-3" aria-label="Email" aria-describedby="email-addon">
                  <input type="file" class="form-control mt-3" aria-label="Email" aria-describedby="email-addon">
                  <button type="button" class="btn bg-gradient-dark w-100 mt-4 mb-0 text-capitalize">Add Entry</button>
                </div>
              </div>
              <div class="col-12 col-xl-12 mt-3 mb-3">
                <div class="card-entries p-3">
                  <h6 class="mb-0 font-weight-bold">Financial Notes</h6>
                  <div class="d-flex activity-separator">
                    <div class="flex-shrink-0">
                      <img alt="Image placeholder" class="avatar rounded-circle image-avatar"
                        src="{{ asset('img/team-2.jpg') }}">
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <div class="d-flex justify-content-between">
                        <h6 class="h5 mt-0 text-sm m-0">Arsalan Saleem</h6>
                        <p class="activity-date m-0">Yesterday at 5:50 PM</p>
                      </div>
                      <p class="text-sm">He is very good boy.</p>
                    </div>
                  </div>
                  <div class="d-flex activity-separator mt-2">
                    <div class="flex-shrink-0">
                      <img alt="Image placeholder" class="avatar rounded-circle image-avatar"
                        src="{{ asset('img/team-2.jpg') }}">
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <div class="d-flex justify-content-between">
                        <h6 class="h5 mt-0 text-sm m-0">Arsalan Saleem</h6>
                        <p class="activity-date m-0">Yesterday at 5:50 PM</p>
                      </div>
                      <p class="text-sm">He is very good boy.</p>
                    </div>
                  </div>
                  <div class="d-flex activity-separator">
                    <div class="flex-shrink-0">
                      <img alt="Image placeholder" class="avatar rounded-circle image-avatar"
                        src="{{ asset('img/team-2.jpg') }}">
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <div class="d-flex justify-content-between">
                        <h6 class="h5 mt-0 text-sm m-0">Arsalan Saleem</h6>
                        <p class="activity-date m-0">Yesterday at 5:50 PM</p>
                      </div>
                      <p class="text-sm">He is very good boy.</p>
                    </div>
                  </div>
                  <form class="financial-main d-flex align-items-center">
                    <input class="form-control border-0" placeholder="Write a note entry" />
                    <button type="button" class="btn bg-gradient-primary w-30 mb-0 activity-comment-btn py-2">Add
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @livewire('modal-pro')
  </div>