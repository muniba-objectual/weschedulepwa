<x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
    <x-slot name="title">Timeline</x-slot>

    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="timeline-date-area px-4 py-3 d-flex justify-content-end">
          <input name="firstName" class="form-control border-blue w-40 w-md-30 w-lg-30  mx-2" type="date"
            placeholder="Date of Birth" required="required">
          <select class="f-control f-dropdown border-blue w-40 w-md-30 w-lg-30">
            <option>Select Activity</option>
          </select>
        </div>
        <div class="modal-body">
          <div class="card-body p-3 timeline-overflow">
            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto mb-2"> 11 Aug 23</span>
            <div class="timeline timeline-one-side">
              <div class="timeline-block mb-3">
                <span class="timeline-step">
                  <img alt="Image" class="timeline-icon" src="{{ asset('img/briefcase.svg') }}">
                </span>
                <div class="timeline-content">
                  <div class="cursor-pointer timeline-collapse-btn p-2" data-bs-toggle="collapse"
                    href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <h6 class="text-dark text-sm font-weight-bold mb-0 d-flex justify-content-between">Bobby
                      Handles submitted an End of Shift Report
                      <img alt="Image" class="timeline-icon" src="{{ asset('img/briefcase.svg') }}">
                    </h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-2">22 DEC 7:20 PM</p>
                    <div class="collapse" id="collapseExample">
                      <div class="card card-body">
                        <ul class="list-group">
                          <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Mood Upon Arrival:
                            </strong>
                            &nbsp; </li>
                          <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Interaction with
                              Staff:
                            </strong>
                            &nbsp; </li>
                          <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">General
                              Observations:
                            </strong>
                            &nbsp; </li>
                          <li class="list-group-item border-0 ps-0 pt-0 text-sm mt-3"><strong
                              class="text-dark">Date/Time:
                            </strong>
                            &nbsp; 2023-04-11 23:11:00</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="timeline-block mb-3 ">
                <span class="timeline-step">
                  <img alt="Image" class="timeline-icon" src="{{ asset('img/signin.svg') }}">
                </span>
                <div class="timeline-content cursor-pointer timeline-collapse-btn p-2">
                  <h6 class="text-dark text-sm font-weight-bold mb-0">Bobby Handles Signed In</h6>
                  <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
                </div>
              </div>
              <div class="timeline-block mb-3">
                <span class="timeline-step">
                  <img alt="Image" class="timeline-icon" src="{{ asset('img/signout.svg') }}">
                </span>
                <div class="timeline-content cursor-pointer timeline-collapse-btn p-2">
                  <h6 class="text-dark text-sm font-weight-bold mb-0">Bobby Handles Signed In</h6>
                  <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>
                </div>
              </div>
            </div>
            <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto mb-2"> 11 Aug 23</span>
            <div class="timeline timeline-one-side">
              <div class="timeline-block mb-3">
                <span class="timeline-step">
                  <img alt="Image" class="timeline-icon" src="{{ asset('img/briefcase.svg') }}">
                </span>
                <div class="timeline-content">
                  <div class="cursor-pointer timeline-collapse-btn p-2" data-bs-toggle="collapse"
                    href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <h6 class="text-dark text-sm font-weight-bold mb-0 d-flex justify-content-between">Bobby
                      Handles submitted an End of Shift Report
                      <img alt="Image" class="timeline-icon" src="{{ asset('img/briefcase.svg') }}">
                    </h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-2">22 DEC 7:20 PM</p>
                    <div class="collapse" id="collapseExample">
                      <div class="card card-body">
                        <ul class="list-group">
                          <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Mood Upon Arrival:
                            </strong>
                            &nbsp; </li>
                          <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Interaction with
                              Staff:
                            </strong>
                            &nbsp; </li>
                          <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">General
                              Observations:
                            </strong>
                            &nbsp; </li>
                          <li class="list-group-item border-0 ps-0 pt-0 text-sm mt-3"><strong
                              class="text-dark">Date/Time:
                            </strong>
                            &nbsp; 2023-04-11 23:11:00</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="timeline-block mb-3 ">
                <span class="timeline-step">
                  <img alt="Image" class="timeline-icon" src="{{ asset('img/signin.svg') }}">
                </span>
                <div class="timeline-content cursor-pointer timeline-collapse-btn p-2">
                  <h6 class="text-dark text-sm font-weight-bold mb-0">Bobby Handles Signed In</h6>
                  <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
                </div>
              </div>
              <div class="timeline-block mb-3">
                <span class="timeline-step">
                  <img alt="Image" class="timeline-icon" src="{{ asset('img/signout.svg') }}">
                </span>
                <div class="timeline-content cursor-pointer timeline-collapse-btn p-2">
                  <h6 class="text-dark text-sm font-weight-bold mb-0">Bobby Handles Signed In</h6>
                  <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</x-wire-elements-pro::bootstrap.modal>