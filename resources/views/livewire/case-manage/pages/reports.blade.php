<div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    @section('title')
        Reports
    @endsection
    
    @livewire("case-manage.layout.navbar-black")

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
          <div class="card-report" style="background-image: url({{ asset('img/expense.png') }}); background-size: cover;">
            <div class="card-report-inner">
              <img src="{{ asset('img/report-icon.svg') }}" class="w-30 w-md-20 w-lg-20" />
              <h6 class="text-white font-weight-bold mt-2">Expenses Report</h6>
              <div class="d-flex">
                <a wire:click="ShowExpensesReport"
                  class="btn bg-transparent text-white font-weight-bold border mb-0 py-2 mr-1 px-2 w-50">VIEW REPORT</a>
                <a href=" "
                  class="btn bg-transparent text-white font-weight-bold border mb-0 py-2 ml-1 px-2 w-50">MANAGE QB</a>
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
        <div class="col-12 col-xl-3 mt-2 mt-md-0 mt-lg-0 mb-3">
          <div class="card-report" style="background-image: url({{ asset('img/bank.png') }}); background-size: cover;">
            <div class="card-report-inner">
              <img src="{{ asset('img/report-icon.svg') }}" class="w-30 w-md-20 w-lg-20" />
              <h6 class="text-white font-weight-bold mt-2">Bank Deposits Report</h6>
              <a wire:click="ShowBankDepositsReport"
                class="btn bg-transparent text-white font-weight-bold w-100 border mb-0 py-2">VIEW
                REPORT</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-3 mt-2 mt-md-0 mt-lg-0 mb-3">
          <div class="card-report" style="background-image: url({{ asset('img/oncall.png') }}); background-size: cover;">
            <div class="card-report-inner">
              <img src="{{ asset('img/report-icon.svg') }}" class="w-30 w-md-20 w-lg-20" />
              <h6 class="text-white font-weight-bold mt-2">On-Call Report</h6>
              <div class="d-flex">
                <select class="f-control f-dropdown bg-transparent border text-white w-90 mr-2 h-35">
                  <option>Select Option</option>
                </select>
                <a href=""
                  class="btn bg-white  w-10 border py-3 mb-0 d-flex justify-content-center align-items-center h-35">
                  <img src="{{ asset('img/angle-right.svg') }}" />
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-3 mt-2 mt-md-0 mt-lg-0 mb-3">
          <div class="card-report" style="background-image: url({{ asset('img/privacy.png') }}); background-size: cover;">
            <div class="card-report-inner">
              <img src="{{ asset('img/report-icon.svg') }}" class="w-30 w-md-20 w-lg-20" />
              <h6 class="text-white font-weight-bold mt-2">Privacy & Support Notes Report</h6>
              <div class="d-flex">
                <select class="f-control f-dropdown bg-transparent border text-white w-90 mr-2 h-35">
                  <option>Select Option</option>
                </select>
                <a href=""
                  class="btn bg-white  w-10 border py-3 mb-0 d-flex justify-content-center align-items-center h-35">
                  <img src="{{ asset('img/angle-right.svg') }}" />
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-3 mt-2 mt-md-0 mt-lg-0 mb-3">
          <div class="card-report" style="background-image: url({{ asset('img/mentor.png') }}); background-size: cover;">
            <div class="card-report-inner">
              <img src="{{ asset('img/report-icon.svg') }}" class="w-30 w-md-20 w-lg-20" />
              <h6 class="text-white font-weight-bold mt-2">Mentor Home Repair /Maintenance Report</h6>
              <a href="" class="btn bg-transparent text-white font-weight-bold w-100 mb-0 border py-2">VIEW
                REPORT</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-3 mt-2 mt-md-0 mt-lg-0 mb-3">
          <div class="card-report" style="background-image: url({{ asset('img/child.png') }}); background-size: cover;">
            <div class="card-report-inner">
              <img src="{{ asset('img/report-icon.svg') }}" class="w-30 w-md-20 w-lg-20" />
              <h6 class="text-white font-weight-bold mt-2">New Child Admission Report</h6>
              <a href="" class="btn bg-transparent text-white font-weight-bold w-100 mb-0 border py-2">VIEW
                REPORT</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-3 mt-2 mt-md-0 mt-lg-0 mb-3">
          <div class="card-report" style="background-image: url({{ asset('img/incident.png') }}); background-size: cover;">
            <div class="card-report-inner">
              <img src="{{ asset('img/report-icon.svg') }}" class="w-30 w-md-20 w-lg-20" />
              <h6 class="text-white font-weight-bold mt-2">Incident Report</h6>
              <a href="" class="btn bg-transparent text-white font-weight-bold w-100 mb-0 border py-2">VIEW
                REPORT</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-3 mt-2 mt-md-0 mt-lg-0 mb-3">
          <div class="card-report" style="background-image: url({{ asset('img/referal.png') }}); background-size: cover;">
            <div class="card-report-inner">
              <img src="{{ asset('img/report-icon.svg') }}" class="w-30 w-md-20 w-lg-20" />
              <h6 class="text-white font-weight-bold mt-2">Child Referal Report</h6>
              <div class="d-flex">
                <a href="" class="btn bg-transparent text-white font-weight-bold w-100 mb-0 border py-2">VIEW
                  REPORT</a>
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
      </div>
    </div>
  </div>