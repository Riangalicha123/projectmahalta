<!doctype html>
<html lang="en">
  <head>
    <title>Mahalta</title>
        <!-- Site favicon -->
		<link
			rel="apple-touch-icon"
			sizes="180x180"
			href="<?=base_url()?>guest/images/mahaltalogooo.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="<?=base_url()?>guest/images/mahaltalogooo.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="<?=base_url()?>guest/images/mahaltalogooo.png"
		/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900|Rubik:300,400,700" rel="stylesheet">

    <link rel="stylesheet" href="<?=base_url()?>guest/css/bootstrap.css">
    <link rel="stylesheet" href="<?=base_url()?>guest/css/animate.css">
    <link rel="stylesheet" href="<?=base_url()?>guest/css/owl.carousel.min.css">

    <link rel="stylesheet" href="<?=base_url()?>guest/fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?=base_url()?>guest/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url()?>guest/css/magnific-popup.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="<?=base_url()?>guest/css/style.css">
    <?= $this->renderSection('stylesheets') ?>
    <style>
/* Background Color */
.bg-light {
  background-color: #FAF2D3 !important;
}

/* Card Styling */
.card {
  background: #FAF2D3;
  box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}

/* Form Input Styling */
.form-control {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 10px;
  font-size: 16px;
}

/* Button Styling */
.btn-dark {
  background-color: lightskyblue;
  color: #FFF;
  transition: background-color 0.3s ease;
}
.btn-dark:hover {
  background-color: #2A2A2A;
}

/* Heading */
h2 {
  font-family: 'Poppins', sans-serif;
  font-weight: 600;
}

    </style>
  </head>
  <body>
    
  <?php include('inc/header.php') ?>
    <!-- END header -->

    
    <!-- END section -->
<br>
<section class="site-section bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        
        <!-- Profile Card -->
        <div class="card shadow-sm rounded-lg border-0">
          <div class="card-body p-4">
            
            <!-- Heading -->
            <h2 class="text-center mb-4" style="font-size: 32px; color: #3D3D3D;">Guest Profile</h2>
            
            <!-- Form Start -->
            <form action="<?= base_url('updateProfile/' . $_SESSION['id']) ?>" method="post">
              
              <!-- Name Fields -->
              <div class="form-row">
                <div class="col form-group">
                  <label for="FirstName">First Name</label>
                  <input type="text" id="FirstName" name="FirstName" class="form-control" value="<?= $_SESSION['firstname'] ?? ''; ?>" required>
                </div>
                <div class="col form-group">
                  <label for="LastName">Last Name</label>
                  <input type="text" id="LastName" name="LastName" class="form-control" value="<?= $_SESSION['lastname'] ?? ''; ?>" required>
                </div>
              </div>

              <!-- Email Field -->
              <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" id="Email" name="Email" class="form-control" value="<?= $_SESSION['username'] ?? ''; ?>" required>
              </div>
              
              <!-- Contact Number Field -->
              <div class="form-group">
                <label for="ContactNumber">Contact Number</label>
                <input type="text" id="ContactNumber" name="ContactNumber" class="form-control" value="<?= $_SESSION['contact'] ?? ''; ?>">
              </div>
              
              <!-- Address Field -->
              <div class="form-group">
                <label for="Address">Address</label>
                <input type="text" id="Address" name="Address" class="form-control" value="<?= $_SESSION['address'] ?? ''; ?>">
              </div>
              
              <!-- Submit Button -->
              <div class="form-group text-center mt-4">
                <button type="submit" class="btn btn-dark btn-lg px-4 py-2">Update</button>
              </div>
            </form>
            <!-- Form End -->
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- END section -->

    

    
    <!-- END section -->
   
    <?php include('inc/footer.php') ?>
    <!-- END footer -->
    
    <!-- loader -->
    <?php include('inc/loader.php') ?>

    <script src="<?=base_url()?>guest/js/jquery-3.2.1.min.js"></script>
    <script src="<?=base_url()?>guest/js/jquery-migrate-3.0.0.js"></script>
    <script src="<?=base_url()?>guest/js/popper.min.js"></script>
    <script src="<?=base_url()?>guest/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>guest/js/owl.carousel.min.js"></script>
    <script src="<?=base_url()?>guest/js/jquery.waypoints.min.js"></script>
    <script src="<?=base_url()?>guest/js/jquery.stellar.min.js"></script>

    <script src="<?=base_url()?>guest/js/jquery.magnific-popup.min.js"></script>
    <script src="<?=base_url()?>guest/js/magnific-popup-options.js"></script>

    <script src="<?=base_url()?>guest/js/main.js"></script>
    <?= $this->renderSection('scripts') ?>
  </body>
</html>