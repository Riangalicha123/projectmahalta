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
    
/* Style the buttons */
.btn-info, .btn-secondary {
  display: inline-block;
  padding: 10px 20px;
  margin-top: 10px;
  margin-right: 10px;
  text-decoration: none;
  color: #fff;
  background-color: #007bff;
  border: none;
  border-radius: 5px;
}

.btn-secondary {
  background-color: #6c757d;
}

  </style>
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
            <h1>Amenities</h1>
            <!-- <p>Discover our world's #1 Luxury Room For VIP.</p> -->
          </div>

        </div>
      </div>
    </div>
  </section>
  <!-- END section -->
  
  <section class="site-section"style="background: linear-gradient(to bottom left ,#F4E869, #FFFBE9  ,#5CD2E6);">
    <div class="container">
        <div class="col-md-12 text-center">
        <div class="mb-5 element-animate">
            <h6><b>--ADD ONS--</b></h6>
            <h1><b>Choose your Additional</b></h1>
          </div>    
        </div>
      <div class="row">
        <div class="col-md-6">
        <form method="post" action="<?= base_url('/addAmenities') ?>">
          <table class="table table-responsive">
              <thead>
                  <tr>
                      <th>Select</th>
                      <th>Product Name</th>
                      <th>Price</th>
                      <th>Quantity</th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($roinvents as $roinvent): ?>
                  <tr>
                      <td>
                          <input type="checkbox" id="roomInventoryID[]" name="roomInventoryID[]" value="<?= $roinvent['roomInventoryID'] ?>">
                          <!-- Hidden inputs for additional data -->
                          <input type="hidden" name="roinvents[<?= $roinvent['roomInventoryID'] ?>][ProductName]" value="<?= $roinvent['ProductName'] ?>">
                          <input type="hidden" name="roinvents[<?= $roinvent['roomInventoryID'] ?>][Price]" value="<?= $roinvent['Price'] ?>">
                      </td>
                      <td><?= $roinvent['ProductName'] ?></td>
                      <td><?= $roinvent['Price'] ?></td>
                      <td>
                      <select name="insertQuantity[<?= $roinvent['roomInventoryID'] ?>]">
                          <?php for ($i = 0; $i <= 10; $i++) : ?>
                              <option value="<?= $i ?>"><?= $i ?></option>
                          <?php endfor; ?>
                      </select>
                      </td>
                  </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
          <button type="submit" class="btn-info">Submit</button>
          <a class="btn-secondary" href="<?= route_to('bookroom/formdetails') ?>?skip=true">Skip</a>
      </form>
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
        </div>
        </form>
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