<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    @section('title')
        Home Management
    @endsection
    
    @livewire("we-schedule.layout.navbar-black")

    <div class="container-fluid py-4">
      <div class="d-flex justify-content-end">
        <button type="button" class="btn bg-gradient-dark w-60 w-md-20 w-lg-15 mb-2" 
                wire:click="$emit('modal.open', 'we-schedule.modals.add-update-home-modal', {'methed': 'add'}, {'size':'md'})">Add New
        </button>
      </div>
      <div class="row">
        <div class="col-xl-12 mb-4">
          <div class="card">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Address</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> City</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> Province</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> Notes</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="{{ asset('img/bruce-mars.jpg') }}"
                            class="avatar avatar-sm me-3">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-xs">John Michael</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">100 Yonge Street</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Toronto</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Ontario</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Test</p>
                    </td>
                    <td class="align-middle text-center">
                      <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="" src="{{ asset('img/ellipsis.svg') }}" />
                      </a>
                      <ul class="dropdown-menu shadow  dropdown-menu-end px-2 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                          <a class="dropdown-item border-radius-md" 
                             href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.add-update-home-modal', {'methed': 'update'}, {'size':'md'})" >
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">Edit</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li class="mb-2">
                          <a class="dropdown-item border-radius-md" 
                             href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.delete-modal', {}, {'size':'md'})" >
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">Delete</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li class="">
                          <a class="dropdown-item border-radius-md" href="javascript:;">
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">View Profile</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="{{ asset('img/bruce-mars.jpg') }}"
                            class="avatar avatar-sm me-3">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-xs">John Michael</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">100 Yonge Street</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Toronto</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Ontario</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Test</p>
                    </td>
                    <td class="align-middle text-center">
                      <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="" src="{{ asset('img/ellipsis.svg') }}" />
                      </a>
                      <ul class="dropdown-menu shadow  dropdown-menu-end px-2 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                          <a class="dropdown-item border-radius-md" 
                             href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.add-update-home-modal', {'methed': 'update'}, {'size':'md'})" >
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">Edit</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li class="mb-2">
                          <a class="dropdown-item border-radius-md" 
                             href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.delete-modal', {}, {'size':'md'})" >
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">Delete</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li class="">
                          <a class="dropdown-item border-radius-md" href="javascript:;">
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">View Profile</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="{{ asset('img/bruce-mars.jpg') }}"
                            class="avatar avatar-sm me-3">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-xs">John Michael</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">100 Yonge Street</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Toronto</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Ontario</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Test</p>
                    </td>
                    <td class="align-middle text-center">
                      <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="" src="{{ asset('img/ellipsis.svg') }}" />
                      </a>
                      <ul class="dropdown-menu shadow  dropdown-menu-end px-2 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                          <a class="dropdown-item border-radius-md" 
                             href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.add-update-home-modal', {'methed': 'update'}, {'size':'md'})" >
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">Edit</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li class="mb-2">
                          <a class="dropdown-item border-radius-md" 
                             href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.delete-modal', {}, {'size':'md'})" >
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">Delete</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li class="">
                          <a class="dropdown-item border-radius-md" href="javascript:;">
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">View Profile</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="{{ asset('img/bruce-mars.jpg') }}"
                            class="avatar avatar-sm me-3">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-xs">John Michael</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">100 Yonge Street</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Toronto</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Ontario</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Test</p>
                    </td>
                    <td class="align-middle text-center">
                      <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="" src="{{ asset('img/ellipsis.svg') }}" />
                      </a>
                      <ul class="dropdown-menu shadow  dropdown-menu-end px-2 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                          <a class="dropdown-item border-radius-md" 
                             href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.add-update-home-modal', {'methed': 'update'}, {'size':'md'})" >
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">Edit</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li class="mb-2">
                          <a class="dropdown-item border-radius-md" 
                             href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.delete-modal', {}, {'size':'md'})" >
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">Delete</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li class="">
                          <a class="dropdown-item border-radius-md" href="javascript:;">
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">View Profile</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="{{ asset('img/bruce-mars.jpg') }}"
                            class="avatar avatar-sm me-3">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-xs">John Michael</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">100 Yonge Street</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Toronto</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Ontario</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Test</p>
                    </td>
                    <td class="align-middle text-center">
                      <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="" src="{{ asset('img/ellipsis.svg') }}" />
                      </a>
                      <ul class="dropdown-menu shadow  dropdown-menu-end px-2 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                          <a class="dropdown-item border-radius-md" 
                             href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.add-update-home-modal', {'methed': 'update'}, {'size':'md'})" >
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">Edit</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li class="mb-2">
                          <a class="dropdown-item border-radius-md" 
                             href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.delete-modal', {}, {'size':'md'})" >
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">Delete</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li class="">
                          <a class="dropdown-item border-radius-md" href="javascript:;">
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">View Profile</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="{{ asset('img/bruce-mars.jpg') }}"
                            class="avatar avatar-sm me-3">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-xs">John Michael</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">100 Yonge Street</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Toronto</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Ontario</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Test</p>
                    </td>
                    <td class="align-middle text-center">
                      <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="" src="{{ asset('img/ellipsis.svg') }}" />
                      </a>
                      <ul class="dropdown-menu shadow  dropdown-menu-end px-2 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                          <a class="dropdown-item border-radius-md" 
                             href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.add-update-home-modal', {'methed': 'update'}, {'size':'md'})" >
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">Edit</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li class="mb-2">
                          <a class="dropdown-item border-radius-md" 
                             href="javascript:window.livewire.emit('modal.open', 'we-schedule.modals.delete-modal', {}, {'size':'md'})" >
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">Delete</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                        <li class="">
                          <a class="dropdown-item border-radius-md" href="javascript:;">
                            <div class="d-flex py-1">
                              <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1">
                                  <span class="font-weight-bold">View Profile</span>
                                </h6>
                              </div>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="d-flex justify-content-end mt-3">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link" href="javascript:;" aria-label="Previous">
                    <i class="fa fa-angle-left"></i>
                    <span class="sr-only">Previous</span>
                  </a>
                </li>
                <li class="page-item"><a class="page-link" href="javascript:;">1</a></li>
                <li class="page-item"><a class="page-link" href="javascript:;">2</a></li>
                <li class="page-item"><a class="page-link" href="javascript:;">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="javascript:;" aria-label="Next">
                    <i class="fa fa-angle-right"></i>
                    <span class="sr-only">Next</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
    @livewire('modal-pro')
</main>