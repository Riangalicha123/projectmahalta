
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



    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/big_image_1.jpg);">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
            <br>
            <br>
            <br>
              <h1>Convention Reservation</h1>
               
            </div>

          </div>
        </div>
      </div>
    </section>
    <section class="site-section" >
      <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-5">Available Reservation Venues</h2>
                <form action="<?= base_url('/convention-center/reservation') ?>" method="GET">
          <?php foreach ($convenues as $convenue): ?>
            <div class="col-md-12">
              <div class="post-entry">
                <a><img src="<?=base_url('/convention/'.$convenue['Image'])?>" alt="Image placeholder" class="img-fluid" style="background-size: cover; width: 100%; height: 100%"></a>
                <div class="body-text">
                  <div class="category"></div>
                  <h3 class="mb-3"><a ><?=$convenue['conVenueName']?></a></h3>
                  <ul class="room-specs">
                    <li><span class="ion-ios-people-outline"></span> <?=$convenue['minGuest']?></li>
                    <li><span class="ion-ios-people-outline"></span> <?=$convenue['maxGuest']?></li>
                  </ul>
                  <button type="submit" name="selectedconVenueID" value="<?= $convenue['conVenueID'] ?>" class="btn btn-primary">Select</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          </form>
            </div>
              <div class="col-md-2"></div>
              <div class="col-md-4">
              <h2 class="mb-5">Selected Venue Details</h2>
               <form action="<?= base_url('/convention-center/reservation/getconvenuedirectInformation') ?>" method="get">
                <?php if (!empty($convenuesSelected)): ?>
                    
                    <div class="media d-block room mb-0">
                <figure>
                <img src="<?= base_url('/convention/' . esc($convenuesSelected['Image'] ?? '')) ?>" alt="Generic placeholder image" class="img-fluid">
                
                </figure>
                    <div class="media-body">
                      <h3 class="mt-0"><a href="#"><?= esc($convenuesSelected['conVenueName'] ?? '') ?></a></h3>
                      
                        <div class="row additionalDetails" style="display:none;">
                        <h6 class="mt-0"><a >Maximum Guests: <?= esc($convenuesSelected['maxGuest'] ?? '') ?></a></h6>
                      <h6 class="mt-0"><a >Minimum Guests: <?= esc($convenuesSelected['minGuest'] ?? '') ?></a></h6>
                          
                          
                        </div>
                        <div class="row">
                          <div class="col-md-12 text-center">
                          <h6 class="btn-info viewMoreBtn"><a>View More Details</a></h6>
                          </div>
                        </div>
                      
                              <button type="submit" value="Reserve Now" class="btn btn-primary">Check</button>
                    </div>
                    
                  </div>
                  <?php endif; ?>
              </form>
              </div>    
            </div>
        </div>
      </div>
    </section>
    <?php include('inc/footer.php') ?>
    <!-- END footer -->
    
    <!-- loader -->
    <?php include('inc/loader.php') ?>
    <script>
  // Use a class for the View More buttons to distinguish between them
  var viewMoreButtons = document.querySelectorAll('.viewMoreBtn');

  // Loop through each button and add a click event listener
  viewMoreButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      // Find the parent container of the clicked button
      var parentContainer = button.closest('.room');

      // Find the additional details div inside the parent container
      var detailsDiv = parentContainer.querySelector('.additionalDetails');

      // Toggle the display of the additional details
      detailsDiv.style.display = (detailsDiv.style.display === 'none') ? 'block' : 'none';
    });
  });
</script>
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