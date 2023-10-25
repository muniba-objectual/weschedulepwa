<div>
  @section('title')
      Login
  @endsection
  <main class="main-content  mt-0">
      <section>
        <div class="page-header min-vh-75">
          <div class="container">
            <div class="row">
              <div class="col-xl-5 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                <div class="card card-plain mt-8">
                  <img src="{{ asset('img/logo-case-manage.png') }}" class="navbar-brand-img w-40 m-auto" alt="main_logo">
                  <div class="card-header pb-0 text-left bg-transparent">
                    <h3 class="font-weight-bolder text-dark text-center">Welcome back</h3>
                    <p class="mb-0 text-center">Enter your email and password to sign in</p>
                  </div>
                  <div class="card-body">
                    <form role="form">
                      <label>Email</label>
                      <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Email" aria-label="Email"
                          aria-describedby="email-addon">
                      </div>
                      <label>Password</label>
                      <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Password" aria-label="Password"
                          aria-describedby="password-addon">
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                      <div class="text-center">
                        <button type="button" class="btn bg-gradient-primary w-100 mt-4 mb-0" wire:click="SignIn">Sign in</button>
                      </div>
                    </form>
                  </div>
                  <div class="card-footer text-center pt-0 px-lg-2 px-1">
                    <p class="mb-4 text-sm mx-auto">
                      Don't have an account?
                      <a href="{{ route('case-manage.signup') }}" class="text-info text-gradient font-weight-bold">Sign up</a>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                  <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                    style="background-image:url('{{ asset('img/curved-images/curved6.jpg') }}');     background-position: right;"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
  </main>
  @livewire("case-manage.layout.footer")
</div>
