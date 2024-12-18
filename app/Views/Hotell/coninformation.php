
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Theme Style -->
    <link rel="stylesheet" href="<?=base_url()?>guest/css/style.css">
    <?= $this->renderSection('stylesheets') ?>
  </head>
  <body>
    
  <?php include('inc/header.php') ?>
    <!-- <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(<?=base_url()?>guest/images/big_image_1.jpg);">
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
    </section> -->
    <section class="site-section" style="background: #FAF2D3;">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="mb-5">Available Reservation Venues</h2>
        <form id="reservationForm" action="<?= base_url('/convention-center/reservation/information/getVenueDateandGuests') ?>" method="POST">
          <div class="row">
            <div class="col-md-12 form-group">
              <label for="dateRange">Arrival Date to Departure Date</label>
              <div style="position: relative;">
                <input type='text' class="form-control" id='dateRange' placeholder="Check-In-Date to Check-Out-Date" required style="border-radius: 10px;" />
              </div>
              <input type="hidden" id="CheckInDate" name="CheckInDate" required style="border-radius: 10px;">
              <input type="hidden" id="CheckOutDate" name="CheckOutDate" required style="border-radius: 10px;">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 form-group">
              <label for="Set">Set</label>
              <select class="form-select form-control" id="Set" name="Set" required  style="border-radius: 10px;">
                <option value="" disabled selected>Select Set</option>
                <?php foreach ($setTypes as $setType): ?>
                <option><?= $setType ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 form-group">
              <label for="NumberOfGuests">Number Of Guests</label>
              <input type="number" class="form-control" id="NumberOfGuests" name="NumberOfGuests" required style="border-radius: 10px;">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 form-group">
              <label for="FirstName">First Name</label>
              <input type="text" id="FirstName" name="FirstName" class="form-control" value="<?= $_SESSION['firstname'] ?? ''; ?>" disabled style="border-radius: 10px;">
              <input type="hidden" name="FirstName" value="<?= $_SESSION['firstname'] ?? ''; ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="LastName">Last Name</label>
              <input type="text" id="LastName" class="form-control" value="<?= $_SESSION['lastname'] ?? ''; ?>" disabled style="border-radius: 10px;">
              <input type="hidden" name="LastName" value="<?= $_SESSION['lastname'] ?? ''; ?>">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 form-group">
              <label for="ContactNumber">Contact Number</label>
              <input type="text" id="ContactNumber" class="form-control" value="<?= $_SESSION['contact'] ?? ''; ?>" disabled style="border-radius: 10px;">
              <input type="hidden" name="ContactNumber" value="<?= $_SESSION['contact'] ?? ''; ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="Region">Region</label>
              <input type="text" id="Region" class="form-control" value="<?= $_SESSION['region'] ?? ''; ?>" disabled style="border-radius: 10px;">
              <input type="hidden" name="Region" value="<?= $_SESSION['region'] ?? ''; ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="Province">Province</label>
              <input type="text" id="Province" class="form-control" value="<?= $_SESSION['province'] ?? ''; ?>" disabled style="border-radius: 10px;">
              <input type="hidden" name="Province" value="<?= $_SESSION['province'] ?? ''; ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="City">City/Municipality</label>
              <input type="text" id="City" class="form-control" value="<?= $_SESSION['city'] ?? ''; ?>" disabled style="border-radius: 10px;">
              <input type="hidden" name="City" value="<?= $_SESSION['city'] ?? ''; ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="Barangay">Barangay</label>
              <input type="text" id="Barangay" class="form-control" value="<?= $_SESSION['barangay'] ?? ''; ?>" disabled style="border-radius: 10px;">
              <input type="hidden" name="Barangay" value="<?= $_SESSION['barangay'] ?? ''; ?>">
            </div>
            <div class="col-md-6 form-group">
              <label for="EventType">Event Type</label>
              <select class="form-select form-control" id="EventType" name="EventType" required style="border-radius: 10px;">
                <option value="" disabled selected>Select Event</option>
                <?php foreach ($eventTypes as $eventType): ?>
                <option><?= $eventType ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 form-group">
              <label for="Note">Write a Note</label>
              <textarea name="Note" id="Note" class="form-control" cols="30" rows="8"></textarea>
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
              <div>
              <ul class="list-unstyled room-specs mb-0">
                                <li><span class="ion-ios-people-outline"></span> <?= esc($convenuesSelected['minGuest'] ?? '') ?> - <?= esc($convenuesSelected['maxGuest'] ?? '') ?> Guests</li>
                            </ul>
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
</section>
    <?php include('inc/footer.php') ?>
    <?php include('inc/loader.php') ?>
    <!-- Add the JavaScript for validation -->
<script>
document.getElementById('reservationForm').addEventListener('submit', function (event) {
    const selectedVenue = "<?= $convenuesSelected['conVenueName'] ?? '' ?>";
    const setType = document.getElementById('Set').value;
    const numberOfGuests = parseInt(document.getElementById('NumberOfGuests').value);

    // Check if the selected venue is 'CBRC Hall' and the setType is 'Per Head w/Food'
    if (selectedVenue === 'CBRC Hall' && setType === 'Per Head w/Food' && numberOfGuests < 100) {
        alert('For "CBRC Hall" with "Per Head w/Food", the minimum number of guests should be 100.');
        event.preventDefault(); // Prevent form submission
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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