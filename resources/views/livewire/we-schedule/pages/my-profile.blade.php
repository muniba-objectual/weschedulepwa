<div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    @section('title')
        My Profile
    @endsection
    
    @livewire("we-schedule.layout.navbar-black")

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-body blur shadow-blur overflow-hidden">
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
                  <span class="dashboard-card-label m-auto">CEO</span>
                </div>
              </div>
              <div class="col-lg-2 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 text-right">
                <div class="form-check form-switch ps-0 text-end">
                  <input class="form-check-input ms-auto float-right" type="checkbox" id="flexSwitchCheckDefault"
                    checked>
                  <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0 font-weight-bold mt-2"
                    for="flexSwitchCheckDefault">Active</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12 col-xl-12 mt-2 mt-md-0 mt-lg-0">
          <div class="card h-100">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Profile Information</h6>
            </div>
            <div class="card-body p-3">
              <div class="row">
                <div class="col-12 col-xl-4">
                  <label>Name</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Name">
                  </div>
                </div>
                <div class="col-12 col-xl-4">
                  <label>Email</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Email">
                  </div>
                </div>
                <div class="col-12 col-xl-4">
                  <label>Address</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Address">
                  </div>
                </div>
                <div class="col-12 col-xl-4">
                  <label>City</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="City">
                  </div>
                </div>
                <div class="col-12 col-xl-4">
                  <label>Province</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Province">
                  </div>
                </div>
                <div class="col-12 col-xl-4">
                  <label>Postal Code</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Postal Code">
                  </div>
                </div>
                <div class="col-12 col-xl-4">
                  <label>Driving License</label>
                  <div class="mb-3">
                    <input type="file" class="form-control" placeholder="Postal Code">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-12 col-xl-12 mt-2 mt-md-0 mt-lg-0">
          <div class="card h-100">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Change Password</h6>
            </div>
            <div class="card-body p-3">
              <div class="row">
                <div class="col-12 col-xl-6">
                  <label>Password</label>
                  <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Password">
                  </div>
                </div>
                <div class="col-12 col-xl-6">
                  <label>Confirm Password</label>
                  <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Confirm Password">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-end">
        <button type="button" class="btn bg-gradient-dark w-40 w-md-20 w-lg-20 mb-2 mt-3">Save Changes</button>
      </div>
    </div>
  </div>