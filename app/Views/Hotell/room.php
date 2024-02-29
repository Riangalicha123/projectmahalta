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
              <h1>Rooms</h1>
              <p>Cozy room with modern amenities for a comfortable stay.</p>
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
      <section class="site-section"style="background: linear-gradient(to  bottom left,#3085C3,#5CD2E6, #FAF2D3,  #FFFBE9,#F4E869,#F4E869);padding: 10px; text-align: center;">
        <div class="container" >
            <div class="row">
            <div class="col-md-12">
  <div class="card text-white mb-3" style="background-color: rgba(70, 130, 180, 0.7); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <div class="card-header text-center">Estimated Check In and Out Time</div>
    <div style="display: flex; flex-wrap: wrap;">
      <div style="flex: 0 0 50%; margin-bottom: 10px;">
        <p style="font-size: 1.2em;">Check In Time: 2:00 PM</p>
      </div>
      <div style="flex: 0 0 50%; margin-bottom: 10px;">
        <p style="font-size: 1.2em;">Check Out Time: 12:00 PM</p>
      </div>
    </div>
  </div>
</div>
                <div class="col-sm-12">
                    <div class="media d-block room mb-0">
                        <div class="media-body">
                        <form action="<?= base_url('/bookroom/submit') ?>" method="get">
                                <div class="row">
                                    <div class="col-sm-3 form-group">
                                        <label for="CheckInDate">Arrival Date</label>
                                        <div style="position: relative;">
                                            <input type='date' class="form-control" id='CheckInDate' name='CheckInDate'/>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 form-group">
                                        <label for="CheckOutDate">Departure Date</label>
                                        <div style="position: relative;">
                                            <input type='date' class="form-control" id='CheckOutDate' name='CheckOutDate'/>
                                        </div>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="Adult">Adult</label>
                                        <input type="number" class="form-control" id="Adult"   name="Adult">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="Child">Child</label>
                                        <input type="number" class="form-control" id="Child"  name="Child">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group text-center">
                                        <button type="submit" value="Reserve Now" class="btn btn-primary">Check Availability</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 

      <section class="site-section"style=" background: linear-gradient(to bottom,  #3085C3,#F4E869,#FAF2D3,#ECF9FF);">
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
                        <!-- <span class="ion-ios-star"></span>
                        <span class="ion-ios-star"></span>
                        <span class="ion-ios-star"></span> -->
                      </span>
                    </div>
                  </figure>
                  <div class="media-body">
                    <h3 class="mt-0"><a href="#"><?=$room['RoomType']?></a></h3>
                    <h5 class="mt-0"><a href="#">PHP <?=$room['PricePerNight']?>/ Night</a></h5>
                    <ul class="room-specs">
                                      <li><span class="ion-ios-people-outline"></span>Min <?= $room['minPerson'] ?></li>
                                      <li><span class="ion-ios-people-outline"></span>Max <?= $room['maxPerson'] ?></li>
                                    </ul>
                      <!-- Add this div at the end of your section, right before the closing </section> tag -->
                      <div class="row additionalDetails" style="display:none;">
                        <!-- Additional details content goes here -->
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

    <section class="site-section"style=" background: linear-gradient(to bottom,  #3085C3,#F4E869,#FAF2D3,#ECF9FF);">
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
                <!-- Add this div at the end of your section, right before the closing </section> tag -->
              <div class="row" id="additionalDetails" style="display:none;">
                <!-- Additional details content goes here -->
                <p>This is additional information about the rooms...</p>
              </div>

              <!-- View More Button -->
              <div class="row">
                <div class="col-md-12 text-center">
                  <button id="viewMoreBtn" class="btn btn-primary btn-sm-1"><h6>View More</h6></button>
                </div>
              </div>

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
    <!-- END section -->
    <?php include('inc/chat.php') ?>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get current date
    var today = new Date();

    // Set Arrival Date to today
    var arrivalDateInput = document.getElementById('CheckInDate');
    arrivalDateInput.valueAsDate = today;

    // Set Departure Date to tomorrow
    var tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1);
    var departureDateInput = document.getElementById('CheckOutDate');
    departureDateInput.valueAsDate = tomorrow;

    // Disable past dates in date picker
    var currentDate = new Date().toISOString().split('T')[0];
    document.getElementById("CheckInDate").setAttribute("min", currentDate);
    document.getElementById("CheckOutDate").setAttribute("min", currentDate);

    // Add event listener to check-in date picker
    arrivalDateInput.addEventListener('change', function() {
        // Disable past dates in check-out date picker based on selected check-in date
        var selectedDate = new Date(arrivalDateInput.value);
        var nextDay = new Date(selectedDate);
        nextDay.setDate(selectedDate.getDate() + 1);
        var minDate = nextDay.toISOString().split('T')[0];
        document.getElementById("CheckOutDate").setAttribute("min", minDate);
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

    <script>
    $('#arrival_date, #departure_date').datepicker({});
</script>
    <?= $this->renderSection('scripts') ?>
  </body>
</html>