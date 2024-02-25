
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="/guest/css/style.css">
  </head>
  <body>
    
  <?php include('include/header.php') ?>
    <!-- END header -->
    
    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/3.jpg);">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>Reservation</h1>
              <!-- <p>Discover our world's #1 Luxury Room For VIP.</p> -->
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->
    <section class="site-section">
    <div class="container">
        <div class="row">
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
                                        <input type="number" class="form-control" id="Adult"  name="Adult" required>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="Child">Child</label>
                                        <input type="number" class="form-control" id="Child"  name="Child" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group text-center">
                                        <button type="submit" value="Reserve Now" class="btn btn-primary">Check Availability</button>
                                    </div>
                                </div>
                            </form>
                        <?php if (isset($reservationData)): ?>
                            <p>Check-in Date: <?= esc($reservationData['CheckInDate'] ?? '') ?></p>
                            <p>Check-out Date: <?= esc($reservationData['CheckOutDate'] ?? '') ?></p>
                            <p>Number of Adults: <?= esc($reservationData['Adult'] ?? '') ?></p>
                            <p>Number of Childs: <?= esc($reservationData['Child'] ?? '') ?></p>
                        <?php else: ?>
                            <p>No reservation data found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="site-section" >
      <div class="container">
        <div class="row">
        <div class="col-md-6">
                <h2 class="mb-5">Available Reservation Rooms</h2>
                <form action="<?= base_url('getdataRoom') ?>" method="GET">
                <?php if (!empty($availableRooms)): ?>
                    <?php foreach ($availableRooms as $room): ?>
                        <div class="col-md-8">
                            <div class="media d-block room mb-0">
                                <!-- Room details display here -->
                                <figure>
                                    <img src="<?= base_url('/uploads/' . $room['Image']) ?>" alt="Room Image" class="img-fluid">
                                    <div class="overlap-text">
                                        <span>
                                            Room<?= $room['RoomNumber'] ?>
                                            <h6><b><?= $room['AvailabilityStatus'] ?></b></h6>
                                        </span>
                                    </div>
                                </figure>
                                <div class="media-body">
                                    <h3 class="mt-0"><a href="#"><?= $room['RoomType'] ?></a></h3>
                                    <h5 class="mt-0"><a href="#">PHP <?= $room['PricePerNight'] ?></a></h5>
                                    <ul class="room-specs">
                                      <li><span class="ion-ios-people-outline"></span>Min <?= $room['minPerson'] ?></li>
                                      <li><span class="ion-ios-people-outline"></span>Max <?= $room['maxPerson'] ?></li>
                                    </ul>
                                    <!-- Add this div at the end of your section, right before the closing </section> tag -->
                                    <div class="row additionalDetails" style="display:none;">
                                      <!-- Additional details content goes here -->
                                      <p><?= $room['Description'] ?></p>
                                      
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
                                    <!-- Gumamit ng button para mag-submit ng form -->
                                    <button type="submit" name="selectedRoomID" value="<?= $room['RoomID'] ?>" class="btn btn-primary">Select</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No available rooms matching your criteria found.</p>
                <?php endif; ?>
                </form>
            </div>
              <div class="col-md-2"></div>
              <div class="col-md-4">
              <form action="<?= base_url('/bookroom/getdataRoom') ?>" method="get">
                <?php if (!empty($roomSelected)): ?>
                    <h2>Selected Room Details</h2>
                    <!-- Display selected room details here -->
                    <div class="media d-block room mb-0">
                
                <figure>
                <img src="<?= base_url('/uploads/' . esc($roomSelected['Image'] ?? '')) ?>" alt="Generic placeholder image" class="img-fluid">
                <div class="overlap-text">
                  <span>
                    Room <?= esc($roomSelected['RoomNumber'] ?? '') ?>
                    <h6><b><?= $roomSelected['AvailabilityStatus'] ?></b></h6>
                  </span>
                </div>
                </figure>
                    <div class="media-body">
                      <h3 class="mt-0"><a href="#"><?= esc($roomSelected['RoomType'] ?? '') ?></a></h3>
                      <h5 class="mt-0"><a href="#">PHP <?= esc($roomSelected['PricePerNight'] ?? '') ?>/ Night</a></h5>
                      <?php if (isset($reservationData)): ?>
                              <p>Check-in Date: <?= esc($reservationData['CheckInDate'] ?? '') ?></p>
                              <p>Check-out Date: <?= esc($reservationData['CheckOutDate'] ?? '') ?></p>
                              <p>Number of Adults: <?= esc($reservationData['Adult'] ?? '') ?></p>
                              <p>Number of Childs: <?= esc($reservationData['Child'] ?? '') ?></p>
                              <h5><b>Total Amount: PHP:</b> <?= number_format($TotalAmount, 2) ?></h5>
                          <?php else: ?>
                              <p>No reservation data found.</p>
                          <?php endif; ?>
                          <hr>
                        <!-- Add this div at the end of your section, right before the closing </section> tag -->
                        <div class="row additionalDetails" style="display:none;">
                          <!-- Additional details content goes here -->
                          <p><?= esc($roomSelected['Description'] ?? '') ?></p>
                          
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

    <!-- END section -->

    
    <!-- END section -->
   
    <!-- END section -->
   

    
    <!-- END section -->
   
    <?php include('include/footer.php') ?>
    <!-- END footer -->
    
    <!-- loader -->
    <?php include('include/loader.php') ?>

    <script>
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
</script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

    <script>
    window.onload = function() {
        // Get the current date
        var currentDate = new Date().toISOString().split('T')[0];

        // Set the minimum date for CheckInDate input
        document.getElementById('CheckInDate').min = currentDate;

        // Set the minimum date for CheckOutDate input
        document.getElementById('CheckOutDate').min = currentDate;
    };
</script>


    

    <script src="/guest/js/main.js"></script>
  </body>
</html>