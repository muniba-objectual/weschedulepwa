<div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    @section('title')
        Reports
    @endsection
    
    @livewire("we-schedule.layout.navbar-black")

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12 col-xl-3 mt-2 mt-md-0 mt-lg-0 mb-3">
          <div class="card-report" style="background-image: url({{ asset('img/payroll.png') }}); background-size: cover;">
            <div class="card-report-inner">
              <img src="{{ asset('img/report-icon.svg') }}" class="w-30 w-md-20 w-lg-20" />
              <h6 class="text-white font-weight-bold mt-2">Payroll Report</h6>
              <div class="d-flex mb-2">
                <select class="f-control f-dropdown bg-transparent border text-white w-50 h-35 mr-1">
                  <option>Select Option</option>
                </select>
                <select class="f-control f-dropdown bg-transparent border text-white w-50 h-35 ml-1">
                  <option>Select Option</option>
                </select>
              </div>
              <div class="d-flex">
                <input name="firstName" class="form-control bg-transparent text-white w-45 mr-2 h-35 select-date"
                  type="date" placeholder="" required="required">
                <input name="firstName" class="form-control bg-transparent text-white w-45 mr-2 h-35 select-date"
                  type="date" placeholder="" required="required">
                <a href=""
                  class="btn bg-white  w-10 border py-3 mb-0 d-flex justify-content-center align-items-center h-35">
                  <img src="{{ asset('img/angle-right.svg') }}" />
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-3 mt-2 mt-md-0 mt-lg-0 mb-3">
          <div class="card-report" style="background-image: url({{ asset('img/csv.png') }}); background-size: cover;">
            <div class="card-report-inner">
              <img src="{{ asset('img/report-icon.svg') }}" class="w-30 w-md-20 w-lg-20" />
              <h6 class="text-white font-weight-bold mt-2">Expense CSV Report</h6>
              <div class="d-flex">
                <input name="firstName" class="form-control bg-transparent text-white w-90 mr-2 h-35 select-date"
                  type="date" placeholder="Date of Birth" required="required">
                <a href=""
                  class="btn bg-white  w-10 border py-3 mb-0 d-flex justify-content-center align-items-center h-35">
                  <img src="{{ asset('img/angle-right.svg') }}" />
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-3 mt-2 mt-md-0 mt-lg-0 mb-3">
          <div class="card-report" style="background-image: url({{ asset('img/holiday.png') }}); background-size: cover;">
            <div class="card-report-inner">
              <img src="{{ asset('img/report-icon.svg') }}" class="w-30 w-md-20 w-lg-20" />
              <h6 class="text-white font-weight-bold mt-2">Statutory Holiday Report</h6>
              <div class="d-flex">
                <input name="firstName" class="form-control bg-transparent text-white w-90 mr-2 h-35 select-date"
                  type="date" placeholder="Date of Birth" required="required">
                <a href=""
                  class="btn bg-white  w-10 border py-3 mb-0 d-flex justify-content-center align-items-center h-35">
                  <img src="{{ asset('img/angle-right.svg') }}" />
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>