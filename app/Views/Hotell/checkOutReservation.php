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
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">

  <!-- Theme Style -->
  <link rel="stylesheet" href="/guest/css/style.css">
</head>

<body>

  <?php include('inc/header.php') ?>
  <!-- END header -->

  <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5"
    style="background-image: url(/guest/images/3.jpg);">
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
  <section class="site-section">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          
          <h2 class="mb-5">Reservation Room Form</h2>
          <form action="<?= base_url('/bookroom/addReservation') ?>" method="post">
            <h3 class="mb-5">Guest Details</h3>
            <div class="row">
              <div class="col-md-6 form-group">
                <label for="FirstName">First Name</label>
                <input type="text" id="FirstName" name="FirstName" class="form-control" required
                  value="<?= $_SESSION['firstname'] ?? ''; ?>">
              </div>
              <div class="col-md-6 form-group">
                <label for="LastName">Last Name</label>
                <input type="text" id="LastName" name="LastName" class="form-control" required
                  value="<?= $_SESSION['lastname'] ?? ''; ?>">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 form-group">
                <label for="ContactNumber">Contact Number</label>
                <input type="text" id="ContactNumber" name="ContactNumber" class="form-control"
                  value="<?= $_SESSION['contact'] ?? ''; ?>" required>
              </div>
              <div class="col-md-6 form-group">
                <label for="Address">Address</label>
                <input type="text" id="Address" name="Address" class="form-control"
                  value="<?= $_SESSION['address'] ?? ''; ?>" required>
              </div>
            </div>
            <hr>
            <h3 class="mb-5">Payment Details</h3>
            <div class="row">
              <img src="/guest/images/qr.JPG" alt="Generic placeholder image" class="img-fluid">
              <p>Note: The downpayment is 1000 pesos minimum</p>
            </div>
            <div class="row">
              <div class="col-md-6 form-group">
                <label for="downorfullPayment">Down Payment or Full Payment</label>
                <input type="text" id="downorfullPayment" name="downorfullPayment" class="form-control" required>
              </div>
              <div class="col-md-6 form-group">
                <label for="ReferenceNumber">Reference Number</label>
                <input type="text" id="ReferenceNumber" name="ReferenceNumber" class="form-control" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 form-group">
                <button type="submit" value="Reserve Now" class="btn btn-primary">Submit</button>
              </div>
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-4">
          <h3 class="mb-5">Featured Room</h3>

          <?php if (isset($roomReservationData)): ?>
            <div class="media d-block room mb-0">

              <figure>
                <img src="<?= base_url('/uploads/' . esc($roomReservationData['roomSelected']['Image'] ?? '')) ?>"
                  alt="Generic placeholder image" class="img-fluid">
                <div class="overlap-text">
                  <span>
                    Room
                    <?= esc($roomReservationData['roomSelected']['RoomNumber'] ?? '') ?>
                  </span>
                </div>
              </figure>
              <div class="media-body">
                <h3 class="mt-0"><a href="#">
                    <?= esc($roomReservationData['roomSelected']['RoomType'] ?? '') ?>
                  </a></h3>
                <h5 class="mt-0"><a href="#">PHP
                    <?= esc($roomReservationData['roomSelected']['PricePerNight'] ?? '') ?>/ Night
                  </a></h5>
                  <p><b>Check-in Date:</b> <?= esc($roomReservationData['reservationData']['CheckInDate'] ?? '') ?></p>
                  <p><b>Check-out Date:</b> <?= esc($roomReservationData['reservationData']['CheckOutDate'] ?? '') ?></p>
                  <p><b>Number of Guests:</b> <?= esc($roomReservationData['reservationData']['NumberOfGuests'] ?? '') ?></p>
                  <h5><b>Total Amount: PHP:</b> <?= number_format($roomReservationData['TotalAmount'], 2) ?></h5>
                <hr>
                
                <!-- Add this div at the end of your section, right before the closing </section> tag -->
                <div class="row additionalDetails" style="display:none;">
                  <!-- Additional details content goes here -->
                  <p>
                      <?= esc($roomReservationData['roomSelected']['Description'] ?? '') ?>
                  </p>

                  <p><b>• ROOM INCLUSIONS</b></p>
                  <ul>
                      <li>Complimentary Breakfast (Plated Service)</li>
                      <li>Free Flow or Brewed Coffee</li>
                      <li>Complete Amenities</li>
                      <li>Swimming Pool Access</li>
                      <li>Stand By Generator Set</li>
                  </ul>
                  <p><b>NOTE: Extra person will be charged PHP 500.00 per head</b></p>
                </div>

                <!-- View More Button -->
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

        </div>
        </form>
      </div>
    </div>
  </section>
  <!-- END section -->


  <!-- END section -->

  <!-- END section -->



  <!-- END section -->

  <?php include('inc/footer.php') ?>
  <!-- END footer -->

  <!-- loader -->
  <?php include('inc/loader.php') ?>
  <script>
  // Function to show a message in the message container
function showMessage(message, type) {
    const messageContainer = document.getElementById('messageContainer');
    messageContainer.textContent = message;
    messageContainer.className = type;
    messageContainer.style.display = 'block';
    // Automatically hide the message after 5 seconds (adjust as needed)
    setTimeout(function() {
        messageContainer.style.display = 'none';
    }, 5000);
}

// Check if a success message exists in the session and display it
if (sessionStorage.getItem('success')) {
    showMessage(sessionStorage.getItem('success'), 'success');
}

// Check if an error message exists in the session and display it
if (sessionStorage.getItem('error')) {
    showMessage(sessionStorage.getItem('error'), 'error');
}

</script>
  <script>
    // Function to add leading zeros to single-digit numbers
    function padZero(number) {
      return number < 10 ? '0' + number : number;
    }

    // Get current date and time in the Philippine timezone (UTC+8)
    let currentDate = new Date();
    let philippineTime = new Date(currentDate.getTime());

    // Format the date to match the datetime-local input format
    let formattedDate = philippineTime.getFullYear() + '-' +
      padZero(philippineTime.getMonth() + 1) + '-' +
      padZero(philippineTime.getDate()) + 'T' +
      padZero(philippineTime.getHours()) + ':' +
      padZero(philippineTime.getMinutes());

    // Set the values of Arrival Date and Departure Date fields
    document.getElementById('CheckInDate').value = formattedDate;
    document.getElementById('CheckOutDate').value = formattedDate;
  </script>
  <script>
    // Use a class for the View More buttons to distinguish between them
    var viewMoreButtons = document.querySelectorAll('.viewMoreBtn');

    // Loop through each button and add a click event listener
    viewMoreButtons.forEach(function (button) {
      button.addEventListener('click', function () {
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
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

  <script>

    $('#arrival_date, #departure_date').datepicker({});

  </script>



  <script src="/guest/js/main.js"></script>
</body>

</html>