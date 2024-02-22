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
    <!-- END header -->

    
    <!-- END section -->
<br>
    <section class="site-section" style="background: linear-gradient(to bottom right,#F4E869,  #FAF2D3, #5CD2E6,#ECF9FF,#ECF9FF);">
      <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
          <div class="col-md-6">

            <h2 class="mb-5">Profile</h2>
            <form action="<?= base_url('updateProfile/' . $_SESSION['id']) ?>" method="post">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="FirstName">First Name</label>
                        <input type="text" id="FirstName" name="FirstName" class="form-control" value="<?= $_SESSION['firstname'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="LastName">Last Name</label>
                        <input type="text" id="LastName" name="LastName" class="form-control" value="<?= $_SESSION['lastname'] ?? ''; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="Email">Email</label>
                        <input type="email" id="Email" name="Email" class="form-control" value="<?= $_SESSION['username'] ?? ''; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="ContactNumber">Contact Number</label>
                        <input type="text" id="ContactNumber" name="ContactNumber" class="form-control" value="<?= $_SESSION['contact'] ?? ''; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="Address">Address</label>
                        <input type="text" id="Address" name="Address" class="form-control" value="<?= $_SESSION['address'] ?? ''; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group align-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>

            </div>
            <div class="col-md-3"></div>
        </div>
      </div>
    </section>
    <!-- END section -->

    

    
    <!-- END section -->
   
    <?php include('inc/footer.php') ?>
    <!-- END footer -->
    
    <!-- loader -->
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