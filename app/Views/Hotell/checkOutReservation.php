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
  <style>
    .form-group input[type="text"],
    .form-group input[type="file"],
    .form-group select {
        border-radius: 5px; 
    }
    #paymentInputContainer {
        border-radius: 5px;
        border: 1px solid #ced4da;
    }
</style>
</head>
<body>
  <?php include('inc/header.php') ?>
  <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5"
    style="background-image: url(/guest/images/3.jpg);">
    <div class="container">
      <div class="row align-items-center site-hero-inner justify-content-center">
        <div class="col-md-12 text-center">
          <div class="mb-5 element-animate">
            <h1>Room Reservation</h1>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="site-section"style="background: #FAF2D3;">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h2 class="mb-5">Reservation Room Form</h2>
          <?php if(isset($validation)):?>
                                        <div class="alert alert-warning">
                                            <?=$validation->listErrors()?>
                                        </div>
                                    <?php endif;?>
          <form action="<?= base_url('/bookroom/addReservation') ?>" method="post" enctype="multipart/form-data">
          <h2 class="mb-5">Extras/Amenities</h2>
          <div style="text-align: center;">
                    <div class="table-responsive">
                          <table class="table">
                              <thead>
                                  <tr>
                                    <th>Product Name</th>
                                    <th colspan="2">Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                  </tr>
                              </thead>
                              <tbody>
                              <?php if (isset($amenitiesData) && !empty($amenitiesData)) : ?>
                                <?php foreach ($amenitiesData as $amenity) : ?>
                                  <tr>
                                    <td><?= $amenity['ProductName']; ?></td>
                                    <td colspan="2">Php <?= $amenity['Price']; ?></td>
                                    <td><?= $amenity['insertQuantity']; ?></td>
                                    <td>Php <?= $totalPrice = $amenity['Price'] * $amenity['insertQuantity']; ?></td>
                                    <input type="hidden" name="UserID[]">
                                  </tr>
                                <?php endforeach; ?>
                                  <tr>
                                      <td colspan="4" class="text-right">Total Price for Extra: </td>
                                      <td><b>Php <?= number_format($totalExtraPrice, 2); ?></b></td>
                                  </tr>
                              <?php else : ?>
                                <tr>
                                  <td colspan="5">No amenities data found.</td>
                                </tr>
                              <?php endif; ?>
                              <?php if (isset($roomReservationData) && is_array($roomReservationData)) : ?>
                                  <tr>
                                      <td colspan="4" class="text-right">Total Amount with Extras: </td>
                                      <td><b>Php <?= number_format($roomReservationData['TotalAmount'], 2); ?></b></td>
                                  </tr>
                              <?php else : ?>
                                  <tr>
                                      <td colspan="5">No reservation data found.</td>
                                  </tr>
                              <?php endif; ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
            <h2 class="mb-5">Guest Details</h2>
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
            </div>
            <hr>
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
                    <input type="radio" id="paymentOptionGCash" name="PaymentOption" value="gcash" onclick="showQR('gcash')" <?php if ($gcash['PaymentOption'] === 'gcash') echo 'checked'; ?>>
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
        <input type="text" id="ReferenceNumberGcash" name="ReferenceNumberGcash" class="form-control" placeholder="Enter Gcash Reference Number" required> <!-- Added 'required' attribute -->
    </div>
    <div class="form-group" id="paymayaReferenceDiv" style="display: none;">
        <label for="ReferenceNumberPaymaya">Reference Number (Paymaya)</label>
        <input type="text" id="ReferenceNumberPaymaya" name="ReferenceNumberPaymaya" class="form-control" placeholder="Enter Paymaya Reference Number" required> <!-- Added 'required' attribute -->
    </div>
    <div class="form-group">
        <label for="downorfullPayment">Down Payment or Full Payment</label>
        <select id="downorfullPayment" name="downorfullPayment" class="form-control" required>
            <?php if (isset($roomReservationData['DownpaymentAmount'])) : ?>
                <option value="<?= $roomReservationData['DownpaymentAmount'] ?>">Down Payment</option>
            <?php endif; ?>
            <?php if (isset($roomReservationData['FullpaymentAmount'])) : ?>
                <option value="<?= $roomReservationData['FullpaymentAmount'] ?>">Full Payment</option>
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
        
          <h2 class="mb-5">Featured Room</h2>
          <?php if (isset($roomReservationData) && is_array($roomReservationData)): ?>
            <div class="media d-block room mb-0">
              <figure>
                <img src="<?= base_url('/uploads/' . esc($roomReservationData['roomSelected']['Image'] ?? '')) ?>"
                  alt="Generic placeholder image" class="img-fluid">
                <div class="overlap-text">
                  <span>
                    Room
                    <?= esc($roomReservationData['roomSelected']['RoomNumber'] ?? '') ?>
                    <h6><b><?= esc($roomReservationData['roomSelected']['AvailabilityStatus'] ?? '') ?></b></h6>
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
                  <p>Number of Adults: <?= esc($roomReservationData['reservationData']['Adult'] ?? '') ?></p>
                  <p>Number of Childs: <?= esc($roomReservationData['reservationData']['Child'] ?? '') ?></p>
                  
                  <h5><b>Total Amount: PHP <?= number_format($roomReservationData['TotalAmount'], 2) ?></b></h5>
                <hr>
                <div class="row additionalDetails" style="display:none;">
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
  </section>


  <?php include('inc/footer.php') ?>
  <!-- END footer -->
  <?php include('inc/header.php') ?>
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
    function updatePaymentInputContainer() {
        var selectedOption = document.getElementById("downorfullPayment").value;
        document.getElementById("paymentInputContainer").innerHTML = selectedOption;
    }
    document.getElementById("downorfullPayment").addEventListener("change", updatePaymentInputContainer);
    updatePaymentInputContainer();
</script>
  <script>
function showMessage(message, type) {
    const messageContainer = document.getElementById('messageContainer');
    messageContainer.textContent = message;
    messageContainer.className = type;
    messageContainer.style.display = 'block';
    setTimeout(function() {
        messageContainer.style.display = 'none';
    }, 5000);
}
if (sessionStorage.getItem('success')) {
    showMessage(sessionStorage.getItem('success'), 'success');
}
if (sessionStorage.getItem('error')) {
    showMessage(sessionStorage.getItem('error'), 'error');
}

</script>
  <script>
    function padZero(number) {
      return number < 10 ? '0' + number : number;
    }
    let currentDate = new Date();
    let philippineTime = new Date(currentDate.getTime());
    let formattedDate = philippineTime.getFullYear() + '-' +
      padZero(philippineTime.getMonth() + 1) + '-' +
      padZero(philippineTime.getDate()) + 'T' +
      padZero(philippineTime.getHours()) + ':' +
      padZero(philippineTime.getMinutes());
    document.getElementById('CheckInDate').value = formattedDate;
    document.getElementById('CheckOutDate').value = formattedDate;
  </script>
  <script>
    var viewMoreButtons = document.querySelectorAll('.viewMoreBtn');
    viewMoreButtons.forEach(function (button) {
      button.addEventListener('click', function () {
        var parentContainer = button.closest('.room');
        var detailsDiv = parentContainer.querySelector('.additionalDetails');
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