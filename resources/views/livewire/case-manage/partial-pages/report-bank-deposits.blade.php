<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    @section('title')
        Bank Deposits Report
    @endsection
    
    @livewire("case-manage.layout.navbar-black")

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-lg-12 mb-lg-0 mb-4">
          <div class="d-flex justify-content-end">
            <button type="button" class="btn bg-gradient-dark w-60 w-md-20 w-lg-20 mb-2">Add Bank Deposit</button>
          </div>
          <div class="card">
            <div class="px-4 py-3 d-flex justify-content-end bank-input-main">
              <input name="firstName" class="form-control bank-input w-50 w-md-20 w-lg-20  mx-2" type="date"
                placeholder="Date of Birth" required="required">
              <select class="f-control f-dropdown bank-input w-50 w-md-20 w-lg-20">
                <option>Select Activity</option>
              </select>
            </div>
            <div class="card-body p-0">
              <div class="card-body p-3 bank-overflow">
                <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto mb-2"> 11 Aug 23</span>
                <div class="timeline timeline-one-side">
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <img alt="Image" class="timeline-user-icon" src="{{ asset('img/dollar.svg') }}">
                    </span>
                    <div class="timeline-content mw-100">
                      <div class="cursor-pointer timeline-collapse-btn p-2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="d-flex align-items-center">
                            <div class="form-check form-check-info text-left">
                              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            </div>
                            <div class="mx-2">
                              <h6 class="text-dark text-sm font-weight-bold mb-0 ">Arsalan
                                submitted a new <b>Bank Deposit Entry</b>: Bank Deposit - <b>$400.00</b>
                              </h6>
                              <p class="text-secondary font-weight-bold text-xs mt-1 mb-2">22 DEC 7:20 PM</p>
                            </div>
                          </div>
                          <div>
                            <img alt="Image" class="timeline-icon cursor-pointer mx-2" src="{{ asset('img/delete.svg') }}">
                            <img alt="Image" class="timeline-icon cursor-pointer mx-2" data-bs-toggle="collapse"
                              href="#collapseExample" role="button" aria-expanded="false"
                              aria-controls="collapseExample" src="{{ asset('img/angle-down.svg') }}">
                          </div>
                        </div>

                        <div class="collapse" id="collapseExample">
                          <div class="card card-body">
                            <div class="table-responsive p-0">
                              <table class="table align-items-center mb-0">
                                <thead>
                                  <tr>
                                    <th
                                      class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                      CHECK DATE</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      DEPOSIT DATE</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      (D) OR DIRECT (DD)</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      AGENCY</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      REFERENCE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      CHEQUE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      INVOICE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      INVOICE AMOUNT</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">D</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">Case Manage</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">$200</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">D</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">Case Manage</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">$200</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="7">
                                      <span class="text-blue text-xs font-weight-bolder">TOTAL</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-xs font-weight-bolder text-blue">$400</span>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="deposit-collapse-comment mt-3 p-3">
                              <div class="d-block d-md-flex d-lg-flex activity-separator">
                                <div class="flex-shrink-0">
                                  <img alt="Image placeholder" class="avatar rounded-circle image-avatar"
                                    src="{{ asset('img/team-2.jpg') }}">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <div class="d-block d-md-flex d-lg-flex justify-content-between">
                                    <h6 class="h5 mt-0 text-sm m-0">Arsalan Saleem</h6>
                                    <p class="activity-date m-0">Yesterday at 5:50 PM</p>
                                  </div>
                                  <p class="text-sm">He is very good boy.</p>
                                </div>
                              </div> 
                              <form class="activity-comment-main bg-white d-block d-md-flex d-lg-flex align-items-center">
                                <input class="form-control border-0" placeholder="Write a note..." />
                                <a href=""><img alt="Image" class="timeline-icon mx-2 mx-md-0 mx-lg-0" src="{{ asset('img/attachment.svg') }}"></a>
                                <button type="button"
                                  class="btn bg-gradient-primary w-90 w-md-25 w-lg-25 mb-0 activity-comment-btn py-2">Post</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto mb-2"> 11 Aug 23</span>
                <div class="timeline timeline-one-side">
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <img alt="Image" class="timeline-user-icon" src="{{ asset('img/dollar.svg') }}">
                    </span>
                    <div class="timeline-content mw-100">
                      <div class="cursor-pointer timeline-collapse-btn p-2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="d-flex align-items-center">
                            <div class="form-check form-check-info text-left">
                              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            </div>
                            <div class="mx-2">
                              <h6 class="text-dark text-sm font-weight-bold mb-0 ">Arsalan
                                submitted a new <b>Bank Deposit Entry</b>: Bank Deposit - <b>$400.00</b>
                              </h6>
                              <p class="text-secondary font-weight-bold text-xs mt-1 mb-2">22 DEC 7:20 PM</p>
                            </div>
                          </div>
                          <div>
                            <img alt="Image" class="timeline-icon cursor-pointer mx-2" src="{{ asset('img/delete.svg') }}">
                            <img alt="Image" class="timeline-icon cursor-pointer mx-2" data-bs-toggle="collapse"
                              href="#collapseExample" role="button" aria-expanded="false"
                              aria-controls="collapseExample" src="{{ asset('img/angle-down.svg') }}">
                          </div>
                        </div>

                        <div class="collapse" id="collapseExample">
                          <div class="card card-body">
                            <div class="table-responsive p-0">
                              <table class="table align-items-center mb-0">
                                <thead>
                                  <tr>
                                    <th
                                      class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                      CHECK DATE</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      DEPOSIT DATE</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      (D) OR DIRECT (DD)</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      AGENCY</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      REFERENCE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      CHEQUE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      INVOICE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      INVOICE AMOUNT</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">D</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">Case Manage</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">$200</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">D</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">Case Manage</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">$200</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="7">
                                      <span class="text-blue text-xs font-weight-bolder">TOTAL</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-xs font-weight-bolder text-blue">$400</span>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="deposit-collapse-comment mt-3 p-3">
                              <div class="d-block d-md-flex d-lg-flex activity-separator">
                                <div class="flex-shrink-0">
                                  <img alt="Image placeholder" class="avatar rounded-circle image-avatar"
                                    src="{{ asset('img/team-2.jpg') }}">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <div class="d-block d-md-flex d-lg-flex justify-content-between">
                                    <h6 class="h5 mt-0 text-sm m-0">Arsalan Saleem</h6>
                                    <p class="activity-date m-0">Yesterday at 5:50 PM</p>
                                  </div>
                                  <p class="text-sm">He is very good boy.</p>
                                </div>
                              </div> 
                              <form class="activity-comment-main bg-white d-block d-md-flex d-lg-flex align-items-center">
                                <input class="form-control border-0" placeholder="Write a note..." />
                                <a href=""><img alt="Image" class="timeline-icon mx-2 mx-md-0 mx-lg-0" src="{{ asset('img/attachment.svg') }}"></a>
                                <button type="button"
                                  class="btn bg-gradient-primary w-90 w-md-25 w-lg-25 mb-0 activity-comment-btn py-2">Post</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto mb-2"> 11 Aug 23</span>
                <div class="timeline timeline-one-side">
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <img alt="Image" class="timeline-user-icon" src="{{ asset('img/dollar.svg') }}">
                    </span>
                    <div class="timeline-content mw-100">
                      <div class="cursor-pointer timeline-collapse-btn p-2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="d-flex align-items-center">
                            <div class="form-check form-check-info text-left">
                              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            </div>
                            <div class="mx-2">
                              <h6 class="text-dark text-sm font-weight-bold mb-0 ">Arsalan
                                submitted a new <b>Bank Deposit Entry</b>: Bank Deposit - <b>$400.00</b>
                              </h6>
                              <p class="text-secondary font-weight-bold text-xs mt-1 mb-2">22 DEC 7:20 PM</p>
                            </div>
                          </div>
                          <div>
                            <img alt="Image" class="timeline-icon cursor-pointer mx-2" src="{{ asset('img/delete.svg') }}">
                            <img alt="Image" class="timeline-icon cursor-pointer mx-2" data-bs-toggle="collapse"
                              href="#collapseExample" role="button" aria-expanded="false"
                              aria-controls="collapseExample" src="{{ asset('img/angle-down.svg') }}">
                          </div>
                        </div>

                        <div class="collapse" id="collapseExample">
                          <div class="card card-body">
                            <div class="table-responsive p-0">
                              <table class="table align-items-center mb-0">
                                <thead>
                                  <tr>
                                    <th
                                      class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                      CHECK DATE</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      DEPOSIT DATE</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      (D) OR DIRECT (DD)</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      AGENCY</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      REFERENCE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      CHEQUE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      INVOICE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      INVOICE AMOUNT</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">D</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">Case Manage</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">$200</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">D</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">Case Manage</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">$200</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="7">
                                      <span class="text-blue text-xs font-weight-bolder">TOTAL</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-xs font-weight-bolder text-blue">$400</span>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="deposit-collapse-comment mt-3 p-3">
                              <div class="d-block d-md-flex d-lg-flex activity-separator">
                                <div class="flex-shrink-0">
                                  <img alt="Image placeholder" class="avatar rounded-circle image-avatar"
                                    src="{{ asset('img/team-2.jpg') }}">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <div class="d-block d-md-flex d-lg-flex justify-content-between">
                                    <h6 class="h5 mt-0 text-sm m-0">Arsalan Saleem</h6>
                                    <p class="activity-date m-0">Yesterday at 5:50 PM</p>
                                  </div>
                                  <p class="text-sm">He is very good boy.</p>
                                </div>
                              </div> 
                              <form class="activity-comment-main bg-white d-block d-md-flex d-lg-flex align-items-center">
                                <input class="form-control border-0" placeholder="Write a note..." />
                                <a href=""><img alt="Image" class="timeline-icon mx-2 mx-md-0 mx-lg-0" src="{{ asset('img/attachment.svg') }}"></a>
                                <button type="button"
                                  class="btn bg-gradient-primary w-90 w-md-25 w-lg-25 mb-0 activity-comment-btn py-2">Post</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto mb-2"> 11 Aug 23</span>
                <div class="timeline timeline-one-side">
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <img alt="Image" class="timeline-user-icon" src="{{ asset('img/dollar.svg') }}">
                    </span>
                    <div class="timeline-content mw-100">
                      <div class="cursor-pointer timeline-collapse-btn p-2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="d-flex align-items-center">
                            <div class="form-check form-check-info text-left">
                              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            </div>
                            <div class="mx-2">
                              <h6 class="text-dark text-sm font-weight-bold mb-0 ">Arsalan
                                submitted a new <b>Bank Deposit Entry</b>: Bank Deposit - <b>$400.00</b>
                              </h6>
                              <p class="text-secondary font-weight-bold text-xs mt-1 mb-2">22 DEC 7:20 PM</p>
                            </div>
                          </div>
                          <div>
                            <img alt="Image" class="timeline-icon cursor-pointer mx-2" src="{{ asset('img/delete.svg') }}">
                            <img alt="Image" class="timeline-icon cursor-pointer mx-2" data-bs-toggle="collapse"
                              href="#collapseExample" role="button" aria-expanded="false"
                              aria-controls="collapseExample" src="{{ asset('img/angle-down.svg') }}">
                          </div>
                        </div>

                        <div class="collapse" id="collapseExample">
                          <div class="card card-body">
                            <div class="table-responsive p-0">
                              <table class="table align-items-center mb-0">
                                <thead>
                                  <tr>
                                    <th
                                      class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                      CHECK DATE</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      DEPOSIT DATE</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      (D) OR DIRECT (DD)</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      AGENCY</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      REFERENCE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      CHEQUE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      INVOICE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      INVOICE AMOUNT</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">D</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">Case Manage</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">$200</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">D</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">Case Manage</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">$200</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="7">
                                      <span class="text-blue text-xs font-weight-bolder">TOTAL</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-xs font-weight-bolder text-blue">$400</span>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="deposit-collapse-comment mt-3 p-3">
                              <div class="d-block d-md-flex d-lg-flex activity-separator">
                                <div class="flex-shrink-0">
                                  <img alt="Image placeholder" class="avatar rounded-circle image-avatar"
                                    src="{{ asset('img/team-2.jpg') }}">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <div class="d-block d-md-flex d-lg-flex justify-content-between">
                                    <h6 class="h5 mt-0 text-sm m-0">Arsalan Saleem</h6>
                                    <p class="activity-date m-0">Yesterday at 5:50 PM</p>
                                  </div>
                                  <p class="text-sm">He is very good boy.</p>
                                </div>
                              </div> 
                              <form class="activity-comment-main bg-white d-block d-md-flex d-lg-flex align-items-center">
                                <input class="form-control border-0" placeholder="Write a note..." />
                                <a href=""><img alt="Image" class="timeline-icon mx-2 mx-md-0 mx-lg-0" src="{{ asset('img/attachment.svg') }}"></a>
                                <button type="button"
                                  class="btn bg-gradient-primary w-90 w-md-25 w-lg-25 mb-0 activity-comment-btn py-2">Post</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto mb-2"> 11 Aug 23</span>
                <div class="timeline timeline-one-side">
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <img alt="Image" class="timeline-user-icon" src="{{ asset('img/dollar.svg') }}">
                    </span>
                    <div class="timeline-content mw-100">
                      <div class="cursor-pointer timeline-collapse-btn p-2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="d-flex align-items-center">
                            <div class="form-check form-check-info text-left">
                              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            </div>
                            <div class="mx-2">
                              <h6 class="text-dark text-sm font-weight-bold mb-0 ">Arsalan
                                submitted a new <b>Bank Deposit Entry</b>: Bank Deposit - <b>$400.00</b>
                              </h6>
                              <p class="text-secondary font-weight-bold text-xs mt-1 mb-2">22 DEC 7:20 PM</p>
                            </div>
                          </div>
                          <div>
                            <img alt="Image" class="timeline-icon cursor-pointer mx-2" src="{{ asset('img/delete.svg') }}">
                            <img alt="Image" class="timeline-icon cursor-pointer mx-2" data-bs-toggle="collapse"
                              href="#collapseExample" role="button" aria-expanded="false"
                              aria-controls="collapseExample" src="{{ asset('img/angle-down.svg') }}">
                          </div>
                        </div>

                        <div class="collapse" id="collapseExample">
                          <div class="card card-body">
                            <div class="table-responsive p-0">
                              <table class="table align-items-center mb-0">
                                <thead>
                                  <tr>
                                    <th
                                      class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                      CHECK DATE</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      DEPOSIT DATE</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      (D) OR DIRECT (DD)</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      AGENCY</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      REFERENCE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      CHEQUE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      INVOICE #</th>
                                    <th
                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      INVOICE AMOUNT</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">D</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">Case Manage</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">$200</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                      <span class="text-secondary text-xs font-weight-bold">28 Dec 23</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">D</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">Case Manage</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">1111111111</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-secondary text-xs font-weight-bold">$200</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="7">
                                      <span class="text-blue text-xs font-weight-bolder">TOTAL</span>
                                    </td>
                                    <td class="align-middle text-center">
                                      <span class="text-xs font-weight-bolder text-blue">$400</span>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="deposit-collapse-comment mt-3 p-3">
                              <div class="d-block d-md-flex d-lg-flex activity-separator">
                                <div class="flex-shrink-0">
                                  <img alt="Image placeholder" class="avatar rounded-circle image-avatar"
                                    src="{{ asset('img/team-2.jpg') }}">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <div class="d-block d-md-flex d-lg-flex justify-content-between">
                                    <h6 class="h5 mt-0 text-sm m-0">Arsalan Saleem</h6>
                                    <p class="activity-date m-0">Yesterday at 5:50 PM</p>
                                  </div>
                                  <p class="text-sm">He is very good boy.</p>
                                </div>
                              </div> 
                              <form class="activity-comment-main bg-white d-block d-md-flex d-lg-flex align-items-center">
                                <input class="form-control border-0" placeholder="Write a note..." />
                                <a href=""><img alt="Image" class="timeline-icon mx-2 mx-md-0 mx-lg-0" src="{{ asset('img/attachment.svg') }}"></a>
                                <button type="button"
                                  class="btn bg-gradient-primary w-90 w-md-25 w-lg-25 mb-0 activity-comment-btn py-2">Post</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</main>