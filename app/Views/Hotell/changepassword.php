<!doctype html>
<html lang="en">
  <head>
    <title>Mahalta</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900|Rubik:300,400,700" rel="stylesheet">

    <link rel="stylesheet" href="/guest/css/bootstrap.css">
    <link rel="stylesheet" href="/guest/css/animate.css">
    <link rel="stylesheet" href="/guest/css/owl.carousel.min.css">

    <link rel="stylesheet" href="/guest/fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/guest/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/guest/css/magnific-popup.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="/guest/css/style.css">
    <?= $this->renderSection('stylesheets') ?>
  </head>
  <body>
    
  <?php include('inc/header.php') ?>
<br>
    <section class="site-section" style="background: linear-gradient(to bottom right,#F4E869,  #FAF2D3, #5CD2E6,#ECF9FF,#ECF9FF);">
      <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
          <div class="col-md-6">
          <h2 class="mb-5" style="text-align: center; font-size: 34px;">Change Password</h2>
          <?php if (session()->getFlashdata('msg')): ?>
        <div class="alert alert-warning">
            <?= session()->getFlashdata('msg') ?>
        </div>
    <?php endif; ?>
    <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>
                    <form class="form-horizontal" action="<?= base_url('/update-password') ?>" method="post">
                      <div class="form-group row">
                        <label for="oldpassword" class="col-sm-2 col-form-label">Old Password</label>
                        <div class="col-sm-10">
                        <input type="password" name="oldpassword" class="form-control" id="oldpassword" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="newpassword" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                        <input type="password" name="newpassword" class="form-control" id="newpassword" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="confirmpassword" class="col-sm-2 col-form-label">Cofirm Password</label>
                        <div class="col-sm-10">
                        <input type="password" name="confirmpassword" class="form-control" id="confirmpassword" required>
                        </div>
                      </div>
                     
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                      </div>
                    </form>
            </div>
            <div class="col-md-3"></div>
        </div>
      </div>
    </section>
    <?php include('inc/footer.php') ?>
    <?php include('inc/loader.php') ?>
    <script src="/guest/js/jquery-3.2.1.min.js"></script>
    <script src="/guest/js/jquery-migrate-3.0.0.js"></script>
    <script src="/guest/js/popper.min.js"></script>
    <script src="/guest/js/bootstrap.min.js"></script>
    <script src="/guest/js/owl.carousel.min.js"></script>
    <script src="/guest/js/jquery.waypoints.min.js"></script>
    <script src="/guest/js/jquery.stellar.min.js"></script>
    <script src="/guest/js/jquery.magnific-popup.min.js"></script>
    <script src="/guest/js/magnific-popup-options.js"></script>
    <script src="/guest/js/main.js"></script>
    <?= $this->renderSection('scripts') ?>
  </body>
</html>