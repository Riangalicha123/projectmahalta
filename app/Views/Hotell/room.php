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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="/guest/css/style.css">
    <style>
      /* CSS Styles */
.floating-card-container {
    position: relative;
    margin-top: 50px; /* Adjust as needed */
}

.floating-card {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    padding: 20px;
    z-index: 1000; /* Ensure the card appears above other content */
}
  
    </style>
    <?= $this->renderSection('stylesheets') ?>
  </head>
  <body>
    
  <?php include('inc/header.php') ?>
    <!-- END header -->


    
    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="1" style="background-image: url(/guest/images/big_image_1.jpg); background-repeat: no-repeat; background-image: cover;">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">
          <br>
          <br>
          <div class="mb-7 element-animate" style="text-align: center;">
            <h1 style="font-size: 3em; margin-bottom: -5px;">Rooms</h1>
            <p>Cozy room with modern amenities for a comfortable stay.</p>
            
          </div>
                      <div class="card text-white mb-3" style="background-color: rgba(135, 206, 235, 0); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; justify-content: flex-end; height: 100%;">
            <div class="card-header text-center" style="color: white; font-size: 1.5em;">Estimated Check In and Out Time</div>
            <div style="display: flex; flex-wrap: wrap;">
              <div style="flex: 0 0 100%; margin-bottom: 10px;">
                <p style="font-size: 1.2em; text-align: center;">Check In Time: 2:00 PM</p>
              </div>
              <div style="flex: 0 0 100%; margin-bottom: 10px;">
                <p style="font-size: 1.2em; text-align: center;">Check Out Time: 12:00 PM</p>
              </div>
              
            </div>
            
          </div>
          <div class="col-md-12 form-group text-center">
                                <a href="<?= route_to('bookroom') ?>" class="btn btn-primary">Room Reservation</a>
                              </div>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <?php if(session()->get('isLoggedIn')): ?>
      <?php
            // Retrieve flash messages from session
            $session = session();
            $successMessage = $session->getFlashdata('success');
            ?>

            
            <!-- Check if there's a success message and display it -->
            <?php if($successMessage): ?>
                <div class="alert alert-success">
                    <?= $successMessage ?>
                </div>
            <?php endif; ?>
 

      <section class="site-section"style="background-image: url(/guest/images/malabomahalta.jpg); background-repeat: no-repeat; background-size: cover;">
        <div class="container">
          <div class="row">
          <?php foreach ($rooms as $room): ?>
            <?php if ($room['AvailabilityStatus'] === 'Available'): ?> <!-- Check availability status -->
              <div class="col-md-4 mb-4">
                <div class="media d-block room mb-0">
                  <figure>
                    <img src="<?=base_url('/uploads/'.$room['Image'])?>" alt="Generic placeholder image" class="img-fluid">
                    <div class="overlap-text">
                      <span>
                      Room<?=$room['RoomNumber']?> 
                      <h6><b><?= $room['AvailabilityStatus'] ?></b></h6>
                      </span>
                    </div>
                  </figure>
                  <div class="media-body">
                    <h3 class="mt-0"><a href="#"><?=$room['RoomType']?></a></h3>
                    <h5 class="mt-0"><a href="#">PHP <?=$room['PricePerNight']?></a></h5>
                    <ul class="room-specs">
                                      <li><span class="ion-ios-people-outline"></span>Min <?= $room['minPerson'] ?></li>
                                      <li><span class="ion-ios-people-outline"></span>Max <?= $room['maxPerson'] ?></li>
                                    </ul>
                      <div class="row additionalDetails" style="display:none;">
                        <p><?=$room['Description']?></p>
                        
                        <p><b>• ROOM INCLUSIONS</b></p>
                        <p>-Complimentary Breakfast(Plated Service)</p>
                        <p>-Free Flow or Brewed Coffee</p>
                        <p>-Complete Amenities</p>
                        <p>-Swimming Pool Access</p>
                        <p>-Stand By Generator Set</p>
                        <p><b>NOTE: Extra person will be charge PHP 500.00 per head</b></p>
                      </div>

                      <!-- View More Button -->
                      <div class="row">
                        <div class="col-md-12 text-center">
                        <h6 class="btn-info viewMoreBtn"><a>View More Details</a></h6>
                        </div>
                      </div>
                    
                    
                    <!-- <p><a href="<?= route_to('bookroom') ?>" class="btn btn-primary btn-sm">Book Now</a></p> -->
                  </div>
                </div>
              </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </section>  
    <?php else: ?>

    <section class="site-section"style="background: #FAF2D3;">
      <div class="container">
        <div class="row">
        <div class="col-md-4 mb-4">
            <div class="media d-block room mb-0">
              <figure>
                <img src="/guest/images/room5.jpg" alt="Generic placeholder image" class="img-fluid">
                <div class="overlap-text">
                  <span>
                    Featured Room 
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                  </span>
                </div>
              </figure>
              <div class="media-body">
                <h3 class="mt-0"><a href="#">Deluxe Room</a></h3>
                <ul class="room-specs">
                  <li><span class="ion-ios-people-outline"></span> 2 Guests</li>
                  <li><span class="ion-ios-crop"></span> 22 ft <sup>2</sup></li>
                </ul>
                <p>Indulge in comfort and style with our Jr. Suite Rooms. </p>
                <p><a href="<?= route_to('login') ?>" class="btn btn-primary btn-sm">Book Now</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="media d-block room mb-0">
              <figure>
                <img src="/guest/images/room6.jpg" alt="Generic placeholder image" class="img-fluid">
                <div class="overlap-text">
                  <span>
                    Featured Room 
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                  </span>
                </div>
              </figure>
              <div class="media-body">
                <h3 class="mt-0"><a href="#">Jr. Suite Room</a></h3>
                <ul class="room-specs">
                  <li><span class="ion-ios-people-outline"></span> 2 Guests</li>
                  <li><span class="ion-ios-crop"></span> 22 ft <sup>2</sup></li>
                </ul>
                <p>Indulge in comfort and style with our Jr. Suite Rooms. </p>
                <p><a href="<?= route_to('login') ?>" class="btn btn-primary btn-sm">Book Now</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="media d-block room mb-0">
              <figure>
                <img src="/guest/images/room1.jpg" alt="Generic placeholder image" class="img-fluid">
                <div class="overlap-text">
                  <span>
                    Featured Room 
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                  </span>
                </div>
              </figure>
              <div class="media-body">
                <h3 class="mt-0"><a href="#">Family Room</a></h3>
                <ul class="room-specs">
                  <li><span class="ion-ios-people-outline"></span> 2 Guests</li>
                  <li><span class="ion-ios-crop"></span> 22 ft <sup>2</sup></li>
                </ul>
                <p>Create lasting family memories in our spacious Family Rooms. </p>
                <p><a href="<?= route_to('login') ?>" class="btn btn-primary btn-sm">Book Now</a></p>
              </div>
            </div>
          </div>


          <div class="col-md-4 mb-4">
            <div class="media d-block room mb-0">
              <figure>
                <img src="/guest/images/room4.jpg" alt="Generic placeholder image" class="img-fluid">
                <div class="overlap-text">
                  <span>
                    Featured Room 
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                  </span>
                </div>
              </figure>
              <div class="media-body">
                <h3 class="mt-0"><a href="#">Barkada Room</a></h3>
                <ul class="room-specs">
                  <li><span class="ion-ios-people-outline"></span> 2 Guests</li>
                  <li><span class="ion-ios-crop"></span> 22 ft <sup>2</sup></li>
                </ul>
                <p> Our Barkada Rooms offer the ideal setting for a memorable and shared experience. </p>
                <p><a href="<?= route_to('login') ?>" class="btn btn-primary btn-sm">Book Now</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>

   
   

    <section class="section-cover" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/MahaltaPic/25.jpg);">
      <div class="container">
        <div class="row justify-content-center align-items-center intro">
          <div class="col-md-9 text-center element-animate">
            <h2>Relax and Enjoy your Holiday</h2>
            <p class="lead mb-5">Explore a world of comfort and luxury on our resort and hotel website, showcasing inviting accommodations, stunning amenities, and unforgettable experiences for your perfect getaway.</p>
            <div class="btn-play-wrap"><a href="https://www.youtube.com/watch?v=9phZlJodJPA" class="btn-play popup-vimeo "><span class="ion-ios-play"></span></a></div>
          </div>
        </div>
      </div>
    </section>
    
    <?php include('inc/footer.php') ?>
    <?php include('inc/loader.php') ?>
    <script>
      var viewMoreButtons = document.querySelectorAll('.viewMoreBtn');
      viewMoreButtons.forEach(function(button) {
        button.addEventListener('click', function() {
          var parentContainer = button.closest('.room');
          var detailsDiv = parentContainer.querySelector('.additionalDetails');
          detailsDiv.style.display = (detailsDiv.style.display === 'none') ? 'block' : 'none';
        });
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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