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

  <?php include('include/header.php') ?>
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
  
  <section class="site-section">
    <div class="container">
        <div class="col-md-12 text-center">
        <div class="mb-5 element-animate">
            <h6><b>--ADD ONS--</b></h6>
            <h1><b>Choose your Additional</b></h1>
          </div>    
        </div>
      <div class="row">
        <div class="col-md-6">
            <table class="table table-responsive">
                <thead>
                    <th></th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </thead>
            <form method="post" action="">
                <tbody>
                    <input type="hidden" value="15068" name="booking_id"></input>
                    <tr>
                        <td><input type="checkbox" value="Bath Towel" name="amenities_id[]"></td>
                        <td>Bath Towel</td>
                        <td>50<input type="hidden" class="form-control" value="Bath Towel" name="amenities_name[]">
                        <input type="hidden" class="form-control" value="50" name="charge_per_item[]" id="charge_per_item7"></td>
                        <td><input type="text" class="form-control" name="quantity[]" id="quantity" value="0" id="quantity7"></td>  
                    </tr>
                                                                        <tr>
                                            <td><input type="checkbox" value="Pillow" name="amenities_id[]"></td>
                                            <td>Pillow</td>
                                            <td>50                                        <input type="hidden" class="form-control" value="Pillow" name="amenities_name[]">
                                            <input type="hidden" class="form-control" value="50" name="charge_per_item[]" id="charge_per_item3"></td>
                                            <td><input type="text" class="form-control" name="quantity[]" id="quantity" value="0" id="quantity3"></td>
                                            
                                        </tr>
                                                                        <tr>
                                            <td><input type="checkbox" value="Blanket" name="amenities_id[]"></td>
                                            <td>Blanket</td>
                                            <td>200                                        <input type="hidden" class="form-control" value="Blanket" name="amenities_name[]">
                                            <input type="hidden" class="form-control" value="200" name="charge_per_item[]" id="charge_per_item4"></td>
                                            <td><input type="text" class="form-control" name="quantity[]" id="quantity" value="0" id="quantity4"></td>
                                            
                                        </tr>
                                                                        <tr>
                                            <td><input type="checkbox" value="Flat sheet" name="amenities_id[]"></td>
                                            <td>Flat sheet</td>
                                            <td>50                                        <input type="hidden" class="form-control" value="Flat sheet" name="amenities_name[]">
                                            <input type="hidden" class="form-control" value="50" name="charge_per_item[]" id="charge_per_item5"></td>
                                            <td><input type="text" class="form-control" name="quantity[]" id="quantity" value="0" id="quantity5"></td>
                                            
                                        </tr>
                                                                        <tr>
                                            <td><input type="checkbox" value="Bed sheet" name="amenities_id[]"></td>
                                            <td>Bed sheet</td>
                                            <td>50                                        <input type="hidden" class="form-control" value="Bed sheet" name="amenities_name[]">
                                            <input type="hidden" class="form-control" value="50" name="charge_per_item[]" id="charge_per_item6"></td>
                                            <td><input type="text" class="form-control" name="quantity[]" id="quantity" value="0" id="quantity6"></td>
                                            
                                        </tr>
                                                                        <tr>
                                            <td><input type="checkbox" value="Mattress Pad" name="amenities_id[]"></td>
                                            <td>Mattress Pad</td>
                                            <td>200                                        <input type="hidden" class="form-control" value="Mattress Pad" name="amenities_name[]">
                                            <input type="hidden" class="form-control" value="200" name="charge_per_item[]" id="charge_per_item8"></td>
                                            <td><input type="text" class="form-control" name="quantity[]" id="quantity" value="0" id="quantity8"></td>
                                            
                                        </tr>
                                                                    
                                </tbody>
            </table>
            <tfoot><button type="submit" class="btn btn-dark text-right"><i class="fa fa-download"></i> SUBMIT</button>&nbsp;
            <a href="<?= route_to('bookroom/formdetails') ?>" class="btn btn-dark text-right">Skip <i class="fa fa-arrow-right"></i></a></tfoot>
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

  <?php include('include/footer.php') ?>
  <!-- END footer -->

  <!-- loader -->
  <?php include('include/loader.php') ?>
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
    // Function to update payment input container
    function updatePaymentInputContainer() {
        // Get the selected option
        var selectedOption = document.getElementById("downorfullPayment").value;
        
        // Update the paymentInputContainer with the selected value
        document.getElementById("paymentInputContainer").innerHTML = selectedOption;
    }
    
    // Add event listener to the dropdown
    document.getElementById("downorfullPayment").addEventListener("change", updatePaymentInputContainer);
    
    // Initially call the function to populate the container with the default selected value
    updatePaymentInputContainer();
</script>
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