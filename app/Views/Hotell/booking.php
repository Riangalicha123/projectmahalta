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

    
    <!-- END section -->
<br>

    <section class="site-section" style="background: linear-gradient(to bottom right,#F4E869,  #FAF2D3, #5CD2E6,#ECF9FF,#ECF9FF);">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <h2 class="mb-5 text-center">Booking</h2>
            <div class="text-center">
              <button class="btn btn-primary" onclick="showHotel()">Hotel</button>
              <button class="btn btn-primary" onclick="showRestaurant()">Restaurant</button>
              <button class="btn btn-primary" onclick="showConvention()">Convention</button>
            </div>
            <table id="hotelTable" class="table table-bordered table-striped" style="display: block;">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Adult</th>
                    <th>Child</th>
                    <th>Payment Option</th>
                    <th>Reference No.</th>
                    <th>Down or Full Payment</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hotelrevs as $hotelrev): ?>
                    <tr>
                        <td><?= $hotelrev['RoomNumber'] ?></td>
                        <td><?= $hotelrev['RoomType'] ?></td>
                        <td><?= $hotelrev['CheckInDate'] ?></td>
                        <td><?= $hotelrev['CheckOutDate'] ?></td>
                        <td><?= $hotelrev['Adult'] ?></td>
                        <td><?= $hotelrev['Child'] ?></td>
                        <td><?= $hotelrev['PaymentOption'] ?></td>
                        <td><?= $hotelrev['ReferenceNumber'] ?></td>
                        <td><?= $hotelrev['downorfullPayment'] ?></td>
                        <td><?= $hotelrev['TotalAmount'] ?></td>
                        <td class="project-state">
                            <span class="badge <?= $hotelrev['Status'] == 'Confirm' ? 'badge-success' : ($hotelrev['Status'] == 'Pending' ? 'badge-warning' : 'badge-danger') ?>">
                                <?= $hotelrev['Status'] ?>
                            </span>
                        </td>
                        <td class="project-state">              
                        <button class="btn-danger"><a href="<?= base_url("/cancelbooking/updatehotelstatus/Cancel/{$hotelrev['ReservationID']}") ?>">Cancel Reservation</a></button>
                    </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
                </table>
            <table id="restaurantTable" class="table table-bordered table-striped" style="display: none;">
            <thead>
                  <tr>
                    <th>Venue</th>
                    <th>Arrival</th>
                    <th>Arrival Time</th>
                    <th>Note</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($restrevs as $restrev): ?>
                  <tr>
                    <td><?=$restrev['VenueName']?></td>
                    <td><?=$restrev['ArivalDate']?></td>
                    <td><?=$restrev['ArivalTime']?></td>
                    <td><?=$restrev['Note']?></td>
                    <td class="project-state">
                            <span class="badge <?= $hotelrev['Status'] == 'Confirm' ? 'badge-success' : ($hotelrev['Status'] == 'Pending' ? 'badge-warning' : 'badge-danger') ?>">
                                <?= $hotelrev['Status'] ?>
                            </span>
                        </td>
                        <td class="project-state">              
                        <button class="btn-danger"><a href="<?= base_url("/cancelbooking/updaterestaustatus/Cancel/{$hotelrev['ReservationID']}") ?>">Cancel Reservation</a></button>
                    </td>
                      
                  </tr>
                  <?php endforeach; ?>
                  
                  </tbody>
            </table>
            <table id="conventionTable" class="table table-bordered table-striped" style="display: none;">
            <thead>
                  <tr>
                    <th>Venue Name</th>
                    <th>Event Type</th>
                    <th>Preferred Date</th>
                    <th>Departure Date</th>
                    <th>Number of Guests</th>
                    <th>Payment Option</th>
                    <th>Reference Number</th>
                    <th>Down or Full Payment</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($reevents as $reevent): ?>
                  <tr>
                    <td><?=$reevent['conVenueName']?></td>
                    <td><?=$reevent['EventType']?></td>
                    <td><?=$reevent['CheckInDate']?></td>
                    <td><?=$reevent['CheckOutDate']?></td>
                    <td><?=$reevent['NumberOfGuests']?></td>
                    <td><?=$reevent['PaymentOption']?></td>
                    <td><?=$reevent['ReferenceNumber']?></td>
                    <td><?=$reevent['downorfullPayment']?></td>
                    <td><?=$reevent['TotalAmount']?></td>
                    <td class="project-state">
                            <span class="badge <?= $hotelrev['Status'] == 'Confirm' ? 'badge-success' : ($hotelrev['Status'] == 'Pending' ? 'badge-warning' : 'badge-danger') ?>">
                                <?= $hotelrev['Status'] ?>
                            </span>
                        </td>
                    <td class="project-state">              
                        <button class="btn-danger"><a href="<?= base_url("/cancelbooking/updateconvenstatus/Cancel/{$reevent['ReservationID']}") ?>">Cancel Reservation</a></button>
                    </td>
                    
                  </tr>
                  <?php endforeach; ?>
                  
                  </tbody>
            </table>
            </div>
            <div class="col-md-3"></div>
        </div>
      </div>
    </section>
    <!-- END section -->

    

    
    <!-- END section -->
   
    <?php include('inc/footer.php') ?>
    <!-- END footer -->
    
    <!-- loader -->
    <?php include('inc/loader.php') ?>
    <script>
      // Function to show hotel table and hide others
      function showHotel() {
        document.getElementById("hotelTable").style.display = "table";
        document.getElementById("restaurantTable").style.display = "none";
        document.getElementById("conventionTable").style.display = "none";
      }

      // Function to show restaurant table and hide others
      function showRestaurant() {
        document.getElementById("hotelTable").style.display = "none";
        document.getElementById("restaurantTable").style.display = "table";
        document.getElementById("conventionTable").style.display = "none";
      }

      // Function to show convention table and hide others
      function showConvention() {
        document.getElementById("hotelTable").style.display = "none";
        document.getElementById("restaurantTable").style.display = "none";
        document.getElementById("conventionTable").style.display = "table";
      }
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