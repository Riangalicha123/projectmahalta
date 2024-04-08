
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
                <form action="<?= base_url('getdataconVenue') ?>" method="GET">
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
            </div>
            <hr>
            <h3 class="mb-3">Payment Details</h3>
            <p><b>*Note: 50% down payment is required upon reservation.</b></p>
            <?php foreach ($qrcodes as $qr): ?>
              <div class="row">
                  <div class="col-md-6 form-group">
                      <label for="paymentOption<?php echo ucfirst($qr['PaymentOption']); ?>">
                          <h4><?php echo ucfirst($qr['PaymentOption']); ?></h4>
                      </label>
                      <input type="radio" id="paymentOption<?php echo ucfirst($qr['PaymentOption']); ?>" name="PaymentOption" value="<?php echo $qr['PaymentOption']; ?>" onclick="showQR('<?php echo $qr['PaymentOption']; ?>')" <?php if ($qr['PaymentOption'] === 'gcash') echo 'checked'; ?>>
                  </div>
              </div>
            <?php endforeach; ?>

            <!-- QR Code Image -->
            <div class="row">
                <div class="col-md-12 form-group">
                    <img id="qrImage" src="<?=base_url('/qrimage/'.$qrcodes[0]['Image'])?>" alt="QR Code" class="img-fluid" style="width: 312px; height: 320px;">
                </div>
            </div>

            <!-- Reference Number Fields -->
            <div class="row">
                <!-- Gcash Reference Number -->
                <div class="col-md-12 form-group" id="gcashReferenceDiv" style="display: block;">
                    <label for="ReferenceNumberGcash">Reference Number (Gcash)</label>
                    <input type="text" id="ReferenceNumberGcash" name="ReferenceNumberGcash" class="form-control" placeholder="Enter Gcash Reference Number">
                </div>
                <!-- Paymaya Reference Number -->
                <div class="col-md-12 form-group" id="paymayaReferenceDiv" style="display: none;">
                    <label for="ReferenceNumberPaymaya">Reference Number (Paymaya)</label>
                    <input type="text" id="ReferenceNumberPaymaya" name="ReferenceNumberPaymaya" class="form-control" placeholder="Enter Paymaya Reference Number">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    
                </div>
            </div>
            <div class="row">
              <div class="col-md-12 form-group">
              <div class="form-control" id="paymentInputContainer"></div>
              </div>
            </div>
            <div class="row">
            <div class="col-md-12 form-group">
                <label for="Image">Proof</label>
                <input type="file" class="form-control" id="Image" name="Image" accept="image/*" required>
            </div>
            </div>
            <div class="row">
              <div class="col-md-6 form-group">
                <button type="submit" value="Reserve Now" class="btn btn-primary">Submit</button>
              </div>
            </div>
          
            </div>
              <div class="col-md-2"></div>
              <div class="col-md-4">
              <h2 class="mb-5">Selected Venue Details</h2>
              <?php if (isset($convenueReservationData) && is_array($convenueReservationData)): ?>
                <div class="media d-block room mb-0">
                <figure>
                <img src="<?= base_url('/convention/' . esc($convenueReservationData['convenuesSelected']['Image'] ?? '')) ?>" alt="Generic placeholder image" class="img-fluid">
                
                </figure>
                    <div class="media-body">
                      <h3 class="mt-0"><a href="#"><?= esc($convenueReservationData['convenuesSelected']['conVenueName'] ?? '') ?></a></h3>
                      <h6 class="mt-0"><a >Maximum Guests: <?= esc($convenueReservationData['convenuesSelected']['maxGuest'] ?? '') ?></a></h6>
                      <h6 class="mt-0"><a >Minimum Guests: <?= esc($convenueReservationData['convenuesSelected']['minGuest'] ?? '') ?></a></h6>
                        <div class="row additionalDetails" style="display:none;">
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
function showQR(option) {
    <?php foreach ($qrcodes as $qr): ?>
        if (option === '<?php echo $qr['PaymentOption']; ?>') {
            document.getElementById('qrImage').src = "<?=base_url('/qrimage/'.$qr['Image'])?>";
            <?php if ($qr['PaymentOption'] === 'gcash'): ?>
                document.getElementById('gcashReferenceDiv').style.display = 'block';
                document.getElementById('paymayaReferenceDiv').style.display = 'none';
                document.getElementById('gcashReferenceNumber').setAttribute('name', 'gcashReferenceNumber');
                document.getElementById('paymayaReferenceNumber').removeAttribute('name');
            <?php elseif ($qr['PaymentOption'] === 'paymaya'): ?>
                document.getElementById('gcashReferenceDiv').style.display = 'none';
                document.getElementById('paymayaReferenceDiv').style.display = 'block';
                document.getElementById('paymayaReferenceNumber').setAttribute('name', 'paymayaReferenceNumber');
                document.getElementById('gcashReferenceNumber').removeAttribute('name');
            <?php endif; ?>
        }
    <?php endforeach; ?>
}
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

    <script src="/guest/js/main.js"></script>
    <?= $this->renderSection('scripts') ?>
  </body>
</html>