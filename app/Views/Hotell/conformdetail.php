
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
          <div class="col-md-7">
                <form action="<?= base_url('conventionReservation') ?>" method="POST" enctype="multipart/form-data">
                <?php if (isset($ReservationData) && !empty($ReservationData)): ?>
                  <div style="text-align: center;">
                    <div class="table-responsive">
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th>Check-in Date</th>
                                      <th>Check-out Date</th>
                                      <th>Number of Guests</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td><?= esc($ReservationData['CheckInDate'] ?? '') ?></td>
                                      <td><?= esc($ReservationData['CheckOutDate'] ?? '') ?></td>
                                      <td><?= esc($ReservationData['NumberOfGuests'] ?? '') ?></td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
                <?php else: ?>
                  <p>No reservation data found.</p>
                <?php endif; ?>
                <?php if (isset($UserData) && !empty($UserData)): ?>
                  <table class="table table-responsive">
                    <thead>
                      <tr>
                        <th colspan="12"><h4 style="text-align: center;">Guest Details</h4></th>
                      </tr>
                    </thead>
                    <thead>
                      <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Contact Number</th>
                        <th>Region</th>
                        <th>Province</th>
                        <th>City</th>
                        <th>Barangay</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?= esc($UserData['FirstName'] ?? '') ?></td>
                        <td><?= esc($UserData['LastName'] ?? '') ?></td>
                        <td><?= esc($UserData['ContactNumber'] ?? '') ?></td>
                        <td><?= esc($UserData['Region'] ?? '') ?></td>
                        <td><?= esc($UserData['Province'] ?? '') ?></td>
                        <td><?= esc($UserData['City'] ?? '') ?></td>
                        <td><?= esc($UserData['Barangay'] ?? '') ?></td>
                      </tr>
                    </tbody>
                  </table>
                <?php else: ?>
                  <p>No reservation data found.</p>
                <?php endif; ?>
                <?php if (isset($EventData) && !empty($EventData)): ?>
                  <div style="text-align: center;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><h4>Event Type</h4></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= esc($EventData['EventType'] ?? '') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  </div>
                <?php else: ?>
                  <p>No reservation data found.</p>
                <?php endif; ?>
                <h2 class="mb-3">Payment Details</h2>
            <p><b>*Note: 50% down payment is required upon reservation.</b></p>
            <?php 
                $gcash = null;
                $paymaya = null;
                foreach ($qrcodes as $qr) {
                    if ($qr['PaymentOption'] === 'gcash') {
                        $gcash = $qr;
                    } elseif ($qr['PaymentOption'] === 'paymaya') {
                        $paymaya = $qr;
                    }
                }
            ?>
            <div class="row">
                <div class="col-6 form-group">
                    <label for="paymentOptionGCash">
                        <h4>GCash</h4>
                    </label>
                    <input type="radio" id="paymentOptionGCash" name="PaymentOption" value="gcash" onclick="showQR('gcash')" <?php if ($gcash['PaymentOption'] === 'gcash'); ?>>
                </div>
                
                <div class="col-6 form-group">
                    <label for="paymentOptionPayMaya">
                        <h4>PayMaya</h4>
                    </label>
                    <input type="radio" id="paymentOptionPayMaya" name="PaymentOption" value="paymaya" onclick="showQR('paymaya')" <?php if ($paymaya['PaymentOption'] === 'paymaya'); ?>>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                <div class="form-group" id="gcashReferenceDiv" style="display: block;">
                    <label for="ReferenceNumberGcash">Reference Number (Gcash)</label>
                    <input type="text" id="ReferenceNumberGcash" name="ReferenceNumberGcash" class="form-control" placeholder="Ex: 1234567894123" required pattern="\d{13}" minlength="13" maxlength="13" title="The reference number must 13 digits.">
                </div>
                <div class="form-group" id="paymayaReferenceDiv" style="display: none;">
                    <label for="ReferenceNumberPaymaya">Reference Number (Paymaya)</label>
                    <input type="text" id="ReferenceNumberPaymaya" name="ReferenceNumberPaymaya" class="form-control" placeholder="Ex: CA123456789123" required pattern="CA\d{12}" minlength="14" maxlength="14" title="The reference number must start with 'CA' followed by 12 digits.">
                </div>
                    <div class=" form-group">
                    <label for="downorfullPayment">Down Payment or Full Payment</label>
                    <select id="downorfullPayment" name="downorfullPayment" class="form-control" required>
                        <?php if (isset($DownpaymentAmount)) : ?>
                            <option value="<?= $DownpaymentAmount ?>">Down Payment</option>
                        <?php endif; ?>
                        <?php if (isset($FullpaymentAmount)) : ?>
                            <option value="<?= $FullpaymentAmount ?>">Full Payment</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="form-control" id="paymentInputContainer"></div>
                </div>
                <div class="form-group">
                <label for="Image">Proof</label>
                <input type="file" class="form-control" id="Image" name="Image" accept="image/*" required>
                </div>
                </div>
                <div class="col-md-6 form-group">
                    <div class="form-group">
                        <img id="qrImage" src="<?=base_url('/qrimage/'.$qrcodes[0]['Image'])?>" alt="QR Code" class="img-fluid" style="width: 312px; height: 320px; float: right;">
                    </div>
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
              <h2 class="mb-5">Selected Venue Details</h2>
              <?php if (isset($convenuesSelected) && is_array($convenuesSelected)): ?>
                <div class="media d-block room mb-0">
                <figure>
                <img src="<?= base_url('/convention/' . esc($convenuesSelected['Image'] ?? '')) ?>" alt="Generic placeholder image" class="img-fluid">
                
                </figure>
                    <div class="media-body">
                      <h3 class="mt-0"><a href="#"><?= esc($convenuesSelected['conVenueName'] ?? '') ?></a></h3>
                      
                      <?php if (isset($TotalAmount)): ?>
                            <h3>Total Amount:Php <?= number_format($TotalAmount, 2) ?> </h3>
                        <?php else: ?>
                            <p>No reservation data found.</p>
                        <?php endif; ?>
                      
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
function showQR(option) {
    <?php foreach ($qrcodes as $qr): ?>
        if (option === '<?php echo $qr['PaymentOption']; ?>') {
            document.getElementById('qrImage').src = "<?=base_url('/qrimage/'.$qr['Image'])?>";
            <?php if ($qr['PaymentOption'] === 'gcash'): ?>
                document.getElementById('gcashReferenceDiv').style.display = 'block';
                document.getElementById('paymayaReferenceDiv').style.display = 'none';
                document.getElementById('ReferenceNumberGcash').setAttribute('name', 'ReferenceNumberGcash');
                document.getElementById('ReferenceNumberGcash').setAttribute('required', 'required'); // Adding the required attribute
                document.getElementById('ReferenceNumberPaymaya').removeAttribute('name');
                document.getElementById('ReferenceNumberPaymaya').removeAttribute('required'); // Remove the required attribute if it's paymaya
            <?php elseif ($qr['PaymentOption'] === 'paymaya'): ?>
                document.getElementById('gcashReferenceDiv').style.display = 'none';
                document.getElementById('paymayaReferenceDiv').style.display = 'block';
                document.getElementById('ReferenceNumberPaymaya').setAttribute('name', 'ReferenceNumberPaymaya');
                document.getElementById('ReferenceNumberPaymaya').setAttribute('required', 'required'); // Adding the required attribute
                document.getElementById('ReferenceNumberGcash').removeAttribute('name');
                document.getElementById('ReferenceNumberGcash').removeAttribute('required'); // Remove the required attribute if it's gcash
            <?php endif; ?>
        }
    <?php endforeach; ?>
}
</script>
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
<script>
    function updatePaymentInputContainer() {
        var selectedOption = document.getElementById("downorfullPayment").value;
        document.getElementById("paymentInputContainer").innerHTML = selectedOption;
    }
    document.getElementById("downorfullPayment").addEventListener("change", updatePaymentInputContainer);
    updatePaymentInputContainer();
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