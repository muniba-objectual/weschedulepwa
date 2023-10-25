<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    @section('title')
        Expense Report
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
                <div class="card-body p-3 bank-overflow px-0 px-md-3 p-lg-3">
                    <span class="badge badge-sm bg-gradient-dark dashboard-card-label m-auto mb-2"> 11 Aug 23</span>
                    <div class="timeline timeline-one-side">
                    <div class="timeline-block mb-3">
                        <span class="timeline-step">
                        <img alt="Image" class="timeline-user-icon" src="{{ asset('img/timeline-user.svg') }}">
                        </span>
                        <div class="timeline-content mw-100">
                        <div class="timeline-collapse-btn pb-3  ">
                            <div class="cursor-pointer expenses-main" data-bs-toggle="collapse" href="#collapseExample"
                            role="button" aria-expanded="false" aria-controls="collapseExample">
                            <div class="d-block d-lg-flex d-md-flex justify-content-between align-items-center">
                                <div class="card card-body p-0">
                                <div class="bg-gradient-primary verified-main border-radius-lg w-100 text-center">
                                    <div
                                    class="white-shadow-card h-80 px-2 py-2 d-flex align-items-center expense-top-left ">
                                    <img alt="Image" class="expense-profile cursor-pointer mx-2 border-radius-md"
                                        src="{{ asset('img/marie.jpg') }}">
                                    <div class="text-start">
                                        <p class="text-sm m-0 font-weight-bold text-blue">Larry Cox</p>
                                        <p class="text-sm m-0">Staff</p>
                                    </div>
                                    </div>
                                    <div>
                                    <p class="m-0 text-white font-weight-bold">Verified Expenses:</p>
                                    </div>
                                    <div class="white-shadow-card px-2 py-2 text-center expense-top-right">
                                    <img alt="Image" class="w-20 w-md-40 w-lg-40 h-40 mt-2"
                                        src="{{ asset('img/amazaon-pay.svg') }}">
                                    <div>
                                        <p class="text-sm m-0 pending-payment">Pending Payments</p>
                                    </div>
                                    </div>
                                </div>
                                <div class="d-block d-lg-flex d-md-flex px-2 py-3">
                                    <div class="w-100 w-md-50 w-lg-50 px-3 border-right">
                                    <h6 class="text-left text-md-center text-lg-center text-dark-blue">Other Payment
                                        Methods:</h6>
                                    <div
                                        class="d-block d-lg-flex d-md-flex justify-content-between expenses-bottom-separate">
                                        <p class="text-left text-md-center text-lg-center text-dark-blue text-sm m-0">
                                        <b>Total:</b> $137.55</p>
                                        <p class="text-left text-md-center text-lg-center text-dark-blue text-sm m-0">
                                        <b>HST:</b> $13.15</p>
                                        <p class="text-left text-md-center text-lg-center text-dark-blue text-sm m-0">
                                        <b>Receipts:</b> 2/2</p>
                                    </div>
                                    <p class="text-dark-blue text-sm m-0"><b>Categories</b></p>
                                    <div class="d-block d-lg-flex d-md-block">
                                        <div class="w-100 w-md-100 w-lg-50 px-2">
                                        <ul class="text-sm ul-expenses">
                                            <li>Utilities: Telephone Case Managers: $ 83.76</li>
                                            <li>Office Expenses: $41.14</li>
                                        </ul>
                                        </div>
                                        <div class="w-100 w-md-100 w-lg-50 px-2">

                                        </div>
                                    </div>
                                    </div>
                                    <div class="w-100 w-md-50 w-lg-50 px-3">
                                    <h6 class="text-left text-md-center text-lg-center text-dark-blue">Company Credit
                                        Cards:</h6>
                                    <div
                                        class="d-block d-lg-flex d-md-flex justify-content-between  expenses-bottom-separate">
                                        <p class="text-left text-md-center text-lg-center text-dark-blue text-sm m-0">
                                        <b>Total:</b> $137.55</p>
                                        <p class="text-left text-md-center text-lg-center text-dark-blue text-sm m-0">
                                        <b>HST:</b> $13.15</p>
                                        <p class="text-left text-md-center text-lg-center text-dark-blue text-sm m-0">
                                        <b>Receipts:</b> 2/2</p>
                                    </div>
                                    <p class="text-dark-blue text-sm m-0"><b>Categories</b></p>
                                    <div class="d-block d-lg-flex d-md-100">
                                        <div class="w-100 w-md-100 w-lg-50 px-2">
                                        <ul class="text-sm ul-expenses">
                                            <li>Recreational (COGS): $5864.76</li>
                                            <li>Children Medical (COGS) : $7028.14</li>
                                            <li>Office Expenses: $716.88</li>
                                            <li>Repair & Maintenance: $120.00</li>
                                        </ul>
                                        </div>
                                        <div class="w-100 w-md-100 w-lg-50 px-2">
                                        <ul class="text-sm ul-expenses">
                                            <li>Meals & Entertainment: $41.14</li>
                                            <li>Baby Formula (COGS): $41.14</li>
                                            <li>Mileage (COGS) : $41.14</li>
                                            <li>School Supplies (COGS): $41.14</li>
                                        </ul>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="px-3  text-end mt-2">
                                <img alt="Image" class="timeline-icon cursor-pointer mx-2"
                                    src="{{ asset('img/angle-down.svg') }}">
                                </div>
                            </div>
                            </div>
                            <div class="collapse" id="collapseExample">
                            <div class="card card-body mt-3 w-95 m-auto padding-card">
                                <div class="d-block d-lg-flex d-md-flex justify-content-between py-2">
                                <div class="d-block d-lg-flex d-md-block">
                                    <div class="border-right pr-2 ">
                                    <h6 class="text-dark-blue m-0">Teen.Ranch - $1363.35</h6>
                                    <p class="text-dark-blue text-sm m-0"><b>Vendor:</b> Teen Ranch - Caledon</p>
                                    </div>
                                    <select class="ml-2 f-control f-dropdown expense-input expense-select">
                                    <option>Select Category</option>
                                    </select>
                                    <select class="ml-2 f-control f-dropdown expense-input expense-select">
                                    <option>Select Child</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="px-2 border-right border-left">
                                    <p class="text-dark-blue text-sm m-0"><img
                                        src="{{ asset('img/credit-card.svg') }}" />&nbsp;++++1989</p>
                                    <p class="text-dark-blue text-sm m-0"><img src="{{ asset('img/time.svg') }}" />&nbsp;Mon May
                                        26</p>
                                    </div>
                                    <div class="px-2">
                                    <p class="text-dark-blue text-sm m-0"><img
                                        src="{{ asset('img/right.svg') }}" />&nbsp;++++1989
                                    </p>
                                    <p class="text-dark-blue text-sm m-0"><img src="{{ asset('img/cancel.svg') }}" />&nbsp;Mon
                                        May
                                        26</p>
                                    </div>
                                    <div class="px-3">
                                    <img alt="Image" class="timeline-icon cursor-pointer mx-2"
                                        src="{{ asset('img/angle-down.svg') }}" data-bs-toggle="collapse"
                                        href="#collapseExampleTwo" role="button" aria-expanded="false"
                                        aria-controls="collapseExampleTwo">
                                    </div>
                                </div>
                                </div>
                                <div class="collapse border-top py-2" id="collapseExampleTwo">
                                <div class="d-block d-lg-flex d-md-flex justify-content-between py-2">
                                    <div class="d-block d-lg-flex d-md-flex">
                                    <div class="border-right pr-2">
                                        <p class="text-dark-blue text-sm m-0"><b>Receipt Details:</b> <i>(Manual Cacl)</i>
                                        </p>
                                        <ul class="text-sm d-block d-md-block d-lg-flex mx-3 mx-md-0 mx-lg-0 p-0">
                                        <li class="ml-2 mr-2">Subtotal: $200</li>
                                        <li class="ml-2  mr-2">HST: $200</li>
                                        <li class="ml-2  mr-2">Total: $400</li>
                                        </ul>
                                    </div>
                                    <div class="px-2">
                                        <p class="text-dark-blue text-sm m-0"><b>Notes:</b></p>
                                        <p class="w-100 w-md-80 w-lg-80">Final camp payment for Brendon Deadman Final camp
                                        payment for
                                        Brendon Deadman.
                                        </p>
                                    </div>
                                    </div>
                                    <div
                                    class="border-left px-3 d-flex justify-content-center align-items-center w-100 w-md-60 w-lg-30">
                                    <button type="button"
                                        class="d-flex justify-content-center align-items-center btn bg-gradient-dark mb-2"
                                        wire:click="$emit('modal.open', 'case-manage.modals.s-r-a-report-modal', {}, {'size':'3xl'})" >
                                            <img src="{{ asset('img/white-form.svg') }}" /> &nbsp;&nbsp;View Receipt
                                    </button>
                                    </div>
                                </div>

                                </div>
                            </div>
                            <div class="card card-body mt-3 w-95 m-auto padding-card">
                                <div class="d-block d-lg-flex d-md-flex justify-content-between py-2">
                                <div class="d-block d-lg-flex d-md-block">
                                    <div class="border-right pr-2">
                                    <h6 class="text-dark-blue m-0">Teen.Ranch - $1363.35</h6>
                                    <p class="text-dark-blue text-sm m-0"><b>Vendor:</b> Teen Ranch - Caledon</p>
                                    </div>
                                    <select class="ml-2 f-control f-dropdown expense-input expense-select">
                                    <option>Select Category</option>
                                    </select>
                                    <select class="ml-2 f-control f-dropdown expense-input expense-select">
                                    <option>Select Child</option>
                                    </select>
                                </div>
                                <div class="d-flex mt-2 mt-md-0 mt-lg-0 align-items-center">
                                    <div class="px-2 border-right border-left">
                                    <p class="text-dark-blue text-sm m-0"><img
                                        src="{{ asset('img/credit-card.svg') }}" />&nbsp;++++1989</p>
                                    <p class="text-dark-blue text-sm m-0"><img src="{{ asset('img/time.svg') }}" />&nbsp;Mon May
                                        26</p>
                                    </div>
                                    <div class="px-2">
                                    <p class="text-dark-blue text-sm m-0"><img
                                        src="{{ asset('img/right.svg') }}" />&nbsp;++++1989
                                    </p>
                                    <p class="text-dark-blue text-sm m-0"><img src="{{ asset('img/cancel.svg') }}" />&nbsp;Mon
                                        May
                                        26</p>
                                    </div>
                                    <div class="px-3">
                                    <img alt="Image" class="timeline-icon cursor-pointer mx-2"
                                        src="{{ asset('img/angle-down.svg') }}" data-bs-toggle="collapse"
                                        href="#collapseExampleThree" role="button" aria-expanded="false"
                                        aria-controls="collapseExampleThree">
                                    </div>
                                </div>
                                </div>
                                <div class="collapse border-top py-2" id="collapseExampleThree">
                                <div class="d-block d-lg-flex d-md-flex justify-content-between py-2">
                                    <div class="d-block d-lg-flex d-md-flex">
                                    <div class="border-right pr-2">
                                        <p class="text-dark-blue text-sm m-0"><b>Receipt Details:</b> <i>(Manual Cacl)</i>
                                        </p>
                                        <ul class="text-sm d-block d-md-block d-lg-flex mx-3 mx-md-0 mx-lg-0 p-0">
                                        <li class="ml-2 mr-2">Subtotal: $200</li>
                                        <li class="ml-2  mr-2">HST: $200</li>
                                        <li class="ml-2  mr-2">Total: $400</li>
                                        </ul>
                                    </div>
                                    <div class="px-2">
                                        <p class="text-dark-blue text-sm m-0"><b>Notes:</b></p>
                                        <p class="w-100 w-md-80 w-lg-80">Final camp payment for Brendon Deadman Final camp
                                        payment for
                                        Brendon Deadman.
                                        </p>
                                    </div>
                                    </div>
                                    <div
                                    class="border-left px-3 d-flex justify-content-center align-items-center w-100 w-md-60 w-lg-30">
                                    <button type="button"
                                        class="d-flex justify-content-center align-items-center btn bg-gradient-dark mb-2"
                                        wire:click="$emit('modal.open', 'case-manage.modals.s-r-a-report-modal', {}, {'size':'3xl'})" >
                                            <img src="{{ asset('img/white-form.svg') }}" /> &nbsp;&nbsp;View Receipt
                                    </button>
                                    </div>
                                </div>
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
                        <img alt="Image" class="timeline-user-icon" src="{{ asset('img/timeline-user.svg') }}">
                        </span>
                        <div class="timeline-content mw-100">
                        <div class="timeline-collapse-btn pb-3  ">
                            <div class="cursor-pointer expenses-main" data-bs-toggle="collapse" href="#collapseSecond"
                            role="button" aria-expanded="false" aria-controls="collapseSecond">
                            <div class="d-block d-lg-flex d-md-flex justify-content-between align-items-center">
                                <div class="card card-body p-0">
                                <div class="bg-gradient-primary verified-main border-radius-lg w-100 text-center">
                                    <div
                                    class="white-shadow-card h-80 px-2 py-2 d-flex align-items-center expense-top-left ">
                                    <img alt="Image" class="expense-profile cursor-pointer mx-2 border-radius-md"
                                        src="{{ asset('img/marie.jpg') }}">
                                    <div class="text-start">
                                        <p class="text-sm m-0 font-weight-bold text-blue">Larry Cox</p>
                                        <p class="text-sm m-0">Staff</p>
                                    </div>
                                    </div>
                                    <div>
                                    <p class="m-0 text-white font-weight-bold">Verified Expenses:</p>
                                    </div>
                                    <div class="white-shadow-card px-2 py-2 text-center expense-top-right">
                                    <img alt="Image" class="w-20 w-md-40 w-lg-40 h-40 mt-2"
                                        src="{{ asset('img/amazaon-pay.svg') }}">
                                    <div>
                                        <p class="text-sm m-0 pending-payment">Pending Payments</p>
                                    </div>
                                    </div>
                                </div>
                                <div class="d-block d-lg-flex d-md-flex px-2 py-3">
                                    <div class="w-100 w-md-50 w-lg-50 px-3 border-right">
                                    <h6 class="text-left text-md-center text-lg-center text-dark-blue">Other Payment
                                        Methods:</h6>
                                    <div
                                        class="d-block d-lg-flex d-md-flex justify-content-between expenses-bottom-separate">
                                        <p class="text-left text-md-center text-lg-center text-dark-blue text-sm m-0">
                                        <b>Total:</b> $137.55</p>
                                        <p class="text-left text-md-center text-lg-center text-dark-blue text-sm m-0">
                                        <b>HST:</b> $13.15</p>
                                        <p class="text-left text-md-center text-lg-center text-dark-blue text-sm m-0">
                                        <b>Receipts:</b> 2/2</p>
                                    </div>
                                    <p class="text-dark-blue text-sm m-0"><b>Categories</b></p>
                                    <div class="d-block d-lg-flex d-md-block">
                                        <div class="w-100 w-md-100 w-lg-50 px-2">
                                        <ul class="text-sm ul-expenses">
                                            <li>Utilities: Telephone Case Managers: $ 83.76</li>
                                            <li>Office Expenses: $41.14</li>
                                        </ul>
                                        </div>
                                        <div class="w-100 w-md-100 w-lg-50 px-2">

                                        </div>
                                    </div>
                                    </div>
                                    <div class="w-100 w-md-50 w-lg-50 px-3">
                                    <h6 class="text-left text-md-center text-lg-center text-dark-blue">Company Credit
                                        Cards:</h6>
                                    <div
                                        class="d-block d-lg-flex d-md-flex justify-content-between  expenses-bottom-separate">
                                        <p class="text-left text-md-center text-lg-center text-dark-blue text-sm m-0">
                                        <b>Total:</b> $137.55</p>
                                        <p class="text-left text-md-center text-lg-center text-dark-blue text-sm m-0">
                                        <b>HST:</b> $13.15</p>
                                        <p class="text-left text-md-center text-lg-center text-dark-blue text-sm m-0">
                                        <b>Receipts:</b> 2/2</p>
                                    </div>
                                    <p class="text-dark-blue text-sm m-0"><b>Categories</b></p>
                                    <div class="d-block d-lg-flex d-md-block">
                                        <div class="w-100 w-md-100 w-lg-50 px-2">
                                        <ul class="text-sm ul-expenses">
                                            <li>Recreational (COGS): $5864.76</li>
                                            <li>Children Medical (COGS) : $7028.14</li>
                                            <li>Office Expenses: $716.88</li>
                                            <li>Repair & Maintenance: $120.00</li>
                                        </ul>
                                        </div>
                                        <div class="w-100 w-md-100 w-lg-50 px-2">
                                        <ul class="text-sm ul-expenses">
                                            <li>Meals & Entertainment: $41.14</li>
                                            <li>Baby Formula (COGS): $41.14</li>
                                            <li>Mileage (COGS) : $41.14</li>
                                            <li>School Supplies (COGS): $41.14</li>
                                        </ul>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="px-3  text-end mt-2">
                                <img alt="Image" class="timeline-icon cursor-pointer mx-2"
                                    src="{{ asset('img/angle-down.svg') }}">
                                </div>
                            </div>
                            </div>
                            <div class="collapse" id="collapseSecond">
                            <div class="card card-body mt-3 w-95 m-auto padding-card">
                                <div class="d-block d-lg-flex d-md-flex justify-content-between py-2">
                                <div class="d-block d-lg-flex d-md-block">
                                    <div class="border-right pr-2 ">
                                    <h6 class="text-dark-blue m-0">Teen.Ranch - $1363.35</h6>
                                    <p class="text-dark-blue text-sm m-0"><b>Vendor:</b> Teen Ranch - Caledon</p>
                                    </div>
                                    <select class="ml-2 f-control f-dropdown expense-input expense-select">
                                    <option>Select Category</option>
                                    </select>
                                    <select class="ml-2 f-control f-dropdown expense-input expense-select">
                                    <option>Select Child</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="px-2 border-right border-left">
                                    <p class="text-dark-blue text-sm m-0"><img
                                        src="{{ asset('img/credit-card.svg') }}" />&nbsp;++++1989</p>
                                    <p class="text-dark-blue text-sm m-0"><img src="{{ asset('img/time.svg') }}" />&nbsp;Mon May
                                        26</p>
                                    </div>
                                    <div class="px-2">
                                    <p class="text-dark-blue text-sm m-0"><img
                                        src="{{ asset('img/right.svg') }}" />&nbsp;++++1989
                                    </p>
                                    <p class="text-dark-blue text-sm m-0"><img src="{{ asset('img/cancel.svg') }}" />&nbsp;Mon
                                        May
                                        26</p>
                                    </div>
                                    <div class="px-3">
                                    <img alt="Image" class="timeline-icon cursor-pointer mx-2"
                                        src="{{ asset('img/angle-down.svg') }}" data-bs-toggle="collapse"
                                        href="#collapseExampleTwo" role="button" aria-expanded="false"
                                        aria-controls="collapseExampleTwo">
                                    </div>
                                </div>
                                </div>
                                <div class="collapse border-top py-2" id="collapseExampleTwo">
                                <div class="d-block d-lg-flex d-md-flex justify-content-between py-2">
                                    <div class="d-block d-lg-flex d-md-flex">
                                    <div class="border-right pr-2">
                                        <p class="text-dark-blue text-sm m-0"><b>Receipt Details:</b> <i>(Manual Cacl)</i>
                                        </p>
                                        <ul class="text-sm d-block d-md-block d-lg-flex mx-3 mx-md-0 mx-lg-0 p-0">
                                        <li class="ml-2 mr-2">Subtotal: $200</li>
                                        <li class="ml-2  mr-2">HST: $200</li>
                                        <li class="ml-2  mr-2">Total: $400</li>
                                        </ul>
                                    </div>
                                    <div class="px-2">
                                        <p class="text-dark-blue text-sm m-0"><b>Notes:</b></p>
                                        <p class="w-100 w-md-80 w-lg-80">Final camp payment for Brendon Deadman Final camp
                                        payment for
                                        Brendon Deadman.
                                        </p>
                                    </div>
                                    </div>
                                    <div
                                    class="border-left px-3 d-flex justify-content-center align-items-center w-100 w-md-60 w-lg-30">
                                    <button type="button"
                                        class="d-flex justify-content-center align-items-center btn bg-gradient-dark mb-2"
                                        wire:click="$emit('modal.open', 'case-manage.modals.s-r-a-report-modal', {}, {'size':'3xl'})" >
                                            <img src="{{ asset('img/white-form.svg') }}" /> &nbsp;&nbsp;View Receipt
                                    </button>
                                    </div>
                                </div>

                                </div>
                            </div>
                            <div class="card card-body mt-3 w-95 m-auto padding-card">
                                <div class="d-block d-lg-flex d-md-flex justify-content-between py-2">
                                <div class="d-block d-lg-flex d-md-block">
                                    <div class="border-right pr-2">
                                    <h6 class="text-dark-blue m-0">Teen.Ranch - $1363.35</h6>
                                    <p class="text-dark-blue text-sm m-0"><b>Vendor:</b> Teen Ranch - Caledon</p>
                                    </div>
                                    <select class="ml-2 f-control f-dropdown expense-input expense-select">
                                    <option>Select Category</option>
                                    </select>
                                    <select class="ml-2 f-control f-dropdown expense-input expense-select">
                                    <option>Select Child</option>
                                    </select>
                                </div>
                                <div class="d-flex mt-2 mt-md-0 mt-lg-0 align-items-center">
                                    <div class="px-2 border-right border-left">
                                    <p class="text-dark-blue text-sm m-0"><img
                                        src="{{ asset('img/credit-card.svg') }}" />&nbsp;++++1989</p>
                                    <p class="text-dark-blue text-sm m-0"><img src="{{ asset('img/time.svg') }}" />&nbsp;Mon May
                                        26</p>
                                    </div>
                                    <div class="px-2">
                                    <p class="text-dark-blue text-sm m-0"><img
                                        src="{{ asset('img/right.svg') }}" />&nbsp;++++1989
                                    </p>
                                    <p class="text-dark-blue text-sm m-0"><img src="{{ asset('img/cancel.svg') }}" />&nbsp;Mon
                                        May
                                        26</p>
                                    </div>
                                    <div class="px-3">
                                    <img alt="Image" class="timeline-icon cursor-pointer mx-2"
                                        src="{{ asset('img/angle-down.svg') }}" data-bs-toggle="collapse"
                                        href="#collapseExampleThree" role="button" aria-expanded="false"
                                        aria-controls="collapseExampleThree">
                                    </div>
                                </div>
                                </div>
                                <div class="collapse border-top py-2" id="collapseExampleThree">
                                <div class="d-block d-lg-flex d-md-flex justify-content-between py-2">
                                    <div class="d-block d-lg-flex d-md-flex">
                                    <div class="border-right pr-2">
                                        <p class="text-dark-blue text-sm m-0"><b>Receipt Details:</b> <i>(Manual Cacl)</i>
                                        </p>
                                        <ul class="text-sm d-block d-md-block d-lg-flex mx-3 mx-md-0 mx-lg-0 p-0">
                                        <li class="ml-2 mr-2">Subtotal: $200</li>
                                        <li class="ml-2  mr-2">HST: $200</li>
                                        <li class="ml-2  mr-2">Total: $400</li>
                                        </ul>
                                    </div>
                                    <div class="px-2">
                                        <p class="text-dark-blue text-sm m-0"><b>Notes:</b></p>
                                        <p class="w-100 w-md-80 w-lg-80">Final camp payment for Brendon Deadman Final camp
                                        payment for
                                        Brendon Deadman.
                                        </p>
                                    </div>
                                    </div>
                                    <div
                                    class="border-left px-3 d-flex justify-content-center align-items-center w-100 w-md-60 w-lg-30">
                                    <button type="button"
                                        class="d-flex justify-content-center align-items-center btn bg-gradient-dark mb-2"
                                        wire:click="$emit('modal.open', 'case-manage.modals.s-r-a-report-modal', {}, {'size':'3xl'})" >
                                            <img src="{{ asset('img/white-form.svg') }}" /> &nbsp;&nbsp;View Receipt
                                    </button>
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
        </div>
    </div>
    @livewire('modal-pro')
</main>