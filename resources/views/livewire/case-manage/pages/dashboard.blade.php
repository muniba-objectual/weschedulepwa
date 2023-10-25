<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    @section('title')
        Dashboard
    @endsection
    
    @livewire("case-manage.layout.navbar-black")

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8 d-flex align-items-center">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold-700">Foster Parents</p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div
                    class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-between">
                    <img class="w-40 m-auto" src="{{ asset('img/parent.png') }}" />
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
                <div class="col-8 d-flex align-items-center">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold-700">Children</p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div
                    class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-between">
                    <img class="w-40 m-auto" src="{{ asset('img/parent.png') }}" />
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
                <div class="col-8 d-flex align-items-center">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold-700">Staff</p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div
                    class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-between">
                    <img class="w-40 m-auto" src="{{ asset('img/parent.png') }}" />
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
                <div class="col-8 d-flex align-items-center">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold-700">Placing Agencies</p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div
                    class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-between">
                    <img class="w-40 m-auto" src="{{ asset('img/parent.png') }}" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mt-3">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8 d-flex align-items-center">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold-700">Global Sandwich Board</p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div
                    class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-between">
                    <img class="w-40 m-auto" src="{{ asset('img/sandwich.svg') }}" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mt-3">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8 d-flex align-items-center">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold-700">Reports</p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div
                    class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-between">
                    <img class="w-40 m-auto" src="{{ asset('img/reports.svg') }}" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mt-3">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8 d-flex align-items-center">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold-700">We-Schedule.ca</p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div
                    class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-between">
                    <img class="w-40 m-auto" src="{{ asset('img/we-Schedule.svg') }}" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mt-3">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8 d-flex align-items-center">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold-700">Mobile Apps</p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div
                    class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-between">
                    <img class="w-40 m-auto" src="{{ asset('img/MobileApp.svg') }}" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mt-3">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8 d-flex align-items-center">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold-700">Forms</p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div
                    class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md d-flex align-items-center justify-content-between">
                    <img class="w-40 m-auto" src="{{ asset('img/reports.svg') }}" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @livewire('modal-pro')
  </main>
