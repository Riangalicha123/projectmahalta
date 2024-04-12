
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
              <form action="<?= base_url('/convention-center/reservation/information/getVenueDateandGuests') ?>" method="POST">
                <div class="row">
                  <div class="col-md-6 form-group">
                    <label for="dateRange">Arrival Date to Departure Date</label>
                    <div style="position: relative;">
                      <input type='text' class="form-control" id='dateRange' placeholder="Check-In-Date to Check-Out-Date" required/>
                    </div>
                    <input type="hidden" id="CheckInDate" name="CheckInDate">
                    <input type="hidden" id="CheckOutDate" name="CheckOutDate">

                  </div>
                  <div class="col-md-6 form-group">
                    <label for="NumberOfGuests">Number Of Guest</label>
                    <input type="number" class="form-control" id="NumberOfGuests"  name="NumberOfGuests" required>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-6 form-group">
                    <label for="FirstName">First Name</label>
                    <input type="text" id="FirstName" name="FirstName" class="form-control"
                      value="<?= $_SESSION['firstname'] ?? ''; ?>" required>
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="LastName">Last Name</label>
                    <input type="text" id="LastName" name="LastName" class="form-control"
                      value="<?= $_SESSION['lastname'] ?? ''; ?>" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 form-group">
                    <label for="ContactNumber">Contact Number</label>
                    <input type="text" id="ContactNumber" name="ContactNumber" class="form-control"
                      value="<?= $_SESSION['contact'] ?? ''; ?>" required>
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="Region">Region</label>
                    <input type="text" id="Region" name="Region" class="form-control"
                      value="<?= $_SESSION['region'] ?? ''; ?>" required>
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="Province">Province</label>
                    <input type="text" id="Province" name="Province" class="form-control"
                      value="<?= $_SESSION['province'] ?? ''; ?>" required>
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="City">City/Municipality</label>
                    <input type="text" id="City" name="City" class="form-control"
                      value="<?= $_SESSION['city'] ?? ''; ?>" required>
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="Barangay">Barangay</label>
                    <input type="text" id="Barangay" name="Barangay" class="form-control"
                      value="<?= $_SESSION['barangay'] ?? ''; ?>" required>
                  </div>
          
                  <div class="col-md-6 form-group">
                      <label for="EventType">Event Type</label>
                      <select class="form-select form-control" id="EventType" name="EventType" required>
                          <option>Select Event</option>
                          <?php foreach ($eventTypes as $eventType): ?>
                              <option><?= $eventType ?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>

                </div>
                <div class="row">
                        <div class="col-md-12 form-group text-center">
                          <button type="submit" value="Reserve Now" class="btn btn-primary">Check Availability</button>
                        </div>
                    </div>
              </form>
            </div>
              <div class="col-md-2"></div>
              <div class="col-md-4">
              <h2 class="mb-5">Selected Venue Details</h2>
              <form action="<?= base_url('/convention-center/reservation/getdataconVenueReservation') ?>" method="get">
              <?php if (isset($convenuesSelected)): ?>
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
                    </div>
                  </div>
          <?php else: ?>
            <p>No reservation data found.</p>
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
    <script>
flatpickr("#dateRange", {
    mode: "range",
    dateFormat: "Y-m-d",
    onClose: function(selectedDates, dateStr, instance) {
        if(selectedDates.length > 1) {
            // Convert selected dates to Philippines timezone
            const checkInDate = new Date(selectedDates[0]);
            const checkOutDate = new Date(selectedDates[1]);
            checkInDate.setHours(checkInDate.getHours() + 8); // Philippines timezone is UTC+8
            checkOutDate.setHours(checkOutDate.getHours() + 8);
            
            // Format dates as YYYY-MM-DD
            const checkInStr = checkInDate.toISOString().split('T')[0];
            const checkOutStr = checkOutDate.toISOString().split('T')[0];

            // Update input fields with formatted dates
            document.getElementById('CheckInDate').value = checkInStr;
            document.getElementById('CheckOutDate').value = checkOutStr;
        }
    },
    disable: [
        function(date) {
            // Get today's date in Philippines timezone
            const today = new Date();
            today.setHours(today.getHours() + 8); // Philippines timezone is UTC+8

            // Get yesterday's date in Philippines timezone
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 2);

            // Disable dates up to yesterday
            return (date < yesterday);
        }
    ]
});
</script>


    <?= $this->renderSection('scripts') ?>
  </body>
</html>