
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
    <section class="site-section" style="background: #FAF2D3;">
      <div class="container">
        <div class="row">
            <div class="col-md-6">
              <h2 class="mb-5">Available Reservation Venues</h2>
              <form action="<?= base_url('/convention-center/reservation/information/getVenueDateandGuests') ?>" method="POST">
                <div class="row">
                  <div class="col-md-12 form-group">
                    <label for="dateRange">Arrival Date to Departure Date</label>
                    <div style="position: relative;">
                      <input type='text' class="form-control" id='dateRange' placeholder="Check-In-Date to Check-Out-Date" required/>
                    </div>
                    <input type="hidden" id="CheckInDate" name="CheckInDate">
                    <input type="hidden" id="CheckOutDate" name="CheckOutDate">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 form-group">
                    <label for="NumberOfGuests">Number Of Guest</label>
                    <input type="number" class="form-control" id="NumberOfGuests"  name="NumberOfGuests" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 form-group">
                    <label for="FirstName">First Name</label>
                    <input type="text" id="FirstName" name="FirstName" class="form-control" value="<?= $_SESSION['firstname'] ?? ''; ?>" disabled>
                    <input type="hidden" name="FirstName" value="<?= $_SESSION['firstname'] ?? ''; ?>">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="LastName">Last Name</label>
                    <input type="text" id="LastName" class="form-control" value="<?= $_SESSION['lastname'] ?? ''; ?>" disabled>
                    <input type="hidden" name="LastName" value="<?= $_SESSION['lastname'] ?? ''; ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 form-group">
                    <label for="ContactNumber">Contact Number</label>
                    <input type="text" id="ContactNumber" class="form-control" value="<?= $_SESSION['contact'] ?? ''; ?>" disabled>
                      <input type="hidden" name="ContactNumber" value="<?= $_SESSION['contact'] ?? ''; ?>">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="Region">Region</label>
                    <input type="text" id="Region"  class="form-control" value="<?= $_SESSION['region'] ?? ''; ?>" disabled>
                      <input type="hidden" name="Region" value="<?= $_SESSION['region'] ?? ''; ?>">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="Province">Province</label>
                    <input type="text" id="Province" class="form-control" value="<?= $_SESSION['province'] ?? ''; ?>" disabled>
                      <input type="hidden" name="Province" value="<?= $_SESSION['province'] ?? ''; ?>">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="City">City/Municipality</label>
                    <input type="text" id="City" class="form-control" value="<?= $_SESSION['city'] ?? ''; ?>" disabled>
                      <input type="hidden" name="City" value="<?= $_SESSION['city'] ?? ''; ?>">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="Barangay">Barangay</label>
                    <input type="text" id="Barangay" class="form-control" value="<?= $_SESSION['barangay'] ?? ''; ?>" disabled>
                      <input type="hidden" name="Barangay" value="<?= $_SESSION['barangay'] ?? ''; ?>">
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#dateRange", {
            mode: "range",
            dateFormat: "Y-m-d H:i",
            enableTime: true,
            onClose: function(selectedDates, dateStr, instance) {
                if (selectedDates.length > 1) {
                    const checkInDate = new Date(selectedDates[0]);
                    const checkOutDate = new Date(selectedDates[1]);
                    checkInDate.setHours(checkInDate.getHours() + 8); 
                    checkOutDate.setHours(checkOutDate.getHours() + 8);
                    const checkInStr = checkInDate.toISOString().slice(0, 16).replace('T', ' ');
                    const checkOutStr = checkOutDate.toISOString().slice(0, 16).replace('T', ' ');
                    document.getElementById('CheckInDate').value = checkInStr;
                    document.getElementById('CheckOutDate').value = checkOutStr;
                }
            },
            disable: [
                function(date) {
                    const today = new Date();
                    today.setHours(today.getHours() + 8); 
                    const yesterday = new Date(today);
                    yesterday.setDate(yesterday.getDate() - 1); 
                    return date < yesterday;
                },
                <?php if (!empty($unavailableDates)) : ?>
                    <?php foreach ($unavailableDates as $unavailableDate) : ?>
                        '<?php echo $unavailableDate ?>',
                    <?php endforeach; ?>
                <?php endif; ?>
            ]
        });
    });
</script>
    <?= $this->renderSection('scripts') ?>
  </body>
</html>