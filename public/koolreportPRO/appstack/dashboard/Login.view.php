<?php use koolreport\dashboard\Lang; ?>
<script>
  KoolReport.dashboard.page.name='Login';
  KoolReport.dashboard.dboard.name='';
</script>
<div id="loginPage" class="vertial-middle align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group">
          <div class="card p-4">
            <div class="card-body">
              <h1><?php echo $this->page()->headerText(); ?></h1>
              <p class="text-muted"><?php echo $this->page()->descriptionText(); ?></p>
              <form onSubmit="KoolReport.dashboard.loginPage.login(event)">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input id="username" type="text" class="form-control" placeholder="<?php Lang::echo("Username"); ?>">
                </div>
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  </div>
                  <input id="password" type="password" class="form-control" placeholder="<?php Lang::echo("Password"); ?>">
                </div>
                <?php echo $this->page()->ajaxPanel("App-Login-Error",""); ?>
                <div class="row">
                  <div class="col-12">
                    <input id="continueKDR" type="hidden" value="<?php echo $this->page()->continueKDR(); ?>"/>
                    <button type="submit" class="btn btn-primary px-4"><?php echo $this->page()->buttonText(); ?></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none bluesky" style="width:44%;<?php echo $this->page()->rightImageUrl()?"background-image:url('".$this->page()->rightImageUrl()."')":"";?>">
            <div class="card-body text-center">
              <div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
KoolReport.dashboard.headerTitle("<?php echo $this->page()->headerText()." - ".$this->page()->app()->title(); ?>");
</script>