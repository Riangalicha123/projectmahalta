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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- Theme Style -->
    <link rel="stylesheet" href="/guest/css/style.css">
    <?= $this->renderSection('stylesheets') ?>
  </head>
  <body>
    
  <?php include('inc/header.php') ?>
    <!-- END header -->

    
    <!-- END section -->
<br>


<section class="site-section" style="background: #FAF2D3;">
  <div class="container">
    <h2 class="mb-5 text-center">Booking</h2>
    <div class="text-center">
      <button class="btn btn-primary" onclick="showHotel()">Hotel</button>
      <button class="btn btn-primary" onclick="showRestaurant()">Restaurant</button>
      <button class="btn btn-primary" onclick="showConvention()">Convention</button>
    </div>
    <div class="row" id="hotelTable">
      <?php foreach ($hotelrevs as $hotelrev): ?>
      <div class="col-md-4 mb-4">
        <div class="media d-block room mb-0">
          <figure>
            <img src="<?=base_url('/uploads/'.$hotelrev['room_image'])?>" alt="Generic placeholder image" class="img-fluid">
            <div class="overlap-text">
              <span>Room <?= $hotelrev['RoomNumber'] ?></span>
            </div>
          </figure>
          <div class="media-body">
            <h3 class="mt-0"><a><?= $hotelrev['RoomType'] ?></a></h3>
            <ul class="room-specs">
              <li><span class="fad fa-calendar-check"></span><?= $hotelrev['CheckInDate'] ?></li>
              <li><span class="fad fa-calendar-times"></span><?= $hotelrev['CheckOutDate'] ?></li>
            </ul>
            <div class="room-specs additionalDetails" style="display:none;">
              <li><span class="fas fa-user-alt"></span>ADULT: <?= $hotelrev['Adult'] ?></li>
              <li><span class="fas fa-user-alt"></span>KID: <?= $hotelrev['Child'] ?></li>
              <p><strong>Payment Option: </strong><?= $hotelrev['PaymentOption'] ?></p>
              <p><strong>Reference No.: </strong><?= $hotelrev['ReferenceNumber'] ?></p>
              <p><strong>Down or Full Payment: </strong><?= $hotelrev['downorfullPayment'] ?></p>
              <p><strong>Total Amount: </strong><?= $hotelrev['TotalAmount'] ?></p>
              <p><span class="badge <?= $hotelrev['Status'] == 'Confirm' ? 'badge-success' : ($hotelrev['Status'] == 'Pending' ? 'badge-warning' : 'badge-danger') ?>">
                <?= $hotelrev['Status'] ?>
              </span></p>
            </div>
            <div class="row">
              <div class="col-md-12 text-center">
                <h6 class="btn-info viewMoreBtn" style="cursor: pointer;"><a>View More Details</a></h6>
              </div>
            </div>
            <p><a href="<?= base_url("/cancelbooking/updatehotelstatus/Cancel/{$hotelrev['ReservationID']}") ?>" class="btn btn-danger btn-sm">Cancel Reservation</a></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="row" id="restaurantTable" style="display: none;">
      <?php foreach ($restrevs as $restrev): ?>
      <div class="col-md-4 mb-4">
        <div class="media d-block room mb-0">
          <figure>
            <img src="<?=base_url('/uploads/'.$restrev['venue_image'])?>" alt="Generic placeholder image" class="img-fluid">
          </figure>
          <div class="media-body">
            <h3 class="mt-0"><a><?= $restrev['VenueName'] ?></a></h3>
            <ul class="room-specs">
              <li><span class="fad fa-calendar-check"></span><?= $restrev['CheckInDate'] ?></li>
            </ul>
            <div class="room-specs additionalDetails" style="display:none;">
              <li><span class="fas fa-user-alt"></span>Guests: <?= $restrev['NumberOfGuests'] ?></li>
              <p><strong>Note: </strong><?= $restrev['Note'] ?></p>
              <p><span class="badge <?= $restrev['Status'] == 'Confirm' ? 'badge-success' : ($restrev['Status'] == 'Pending' ? 'badge-warning' : 'badge-danger') ?>">
                <?= $restrev['Status'] ?>
              </span></p>
            </div>
            <div class="row">
              <div class="col-md-12 text-center">
                <h6 class="btn-info viewMoreBtn" style="cursor: pointer;"><a>View More Details</a></h6>
              </div>
            </div>
            <p><a href="<?= base_url("/cancelbooking/updatehotelstatus/Cancel/{$restrev['ReservationID']}") ?>" class="btn btn-danger btn-sm">Cancel Reservation</a></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="row" id="conventionTable" style="display: none;">
      <?php foreach ($reevents as $reevent): ?>
      <div class="col-md-4 mb-4">
        <div class="media d-block room mb-0">
          <figure>
            <img src="<?=base_url('/convention/'.$reevent['venue_image'])?>" alt="Generic placeholder image" class="img-fluid">
            <div class="overlap-text">
              <span>EVENT <?= $reevent['EventType'] ?></span>
            </div>
          </figure>
          <div class="media-body">
            <h3 class="mt-0"><a><?= $reevent['conVenueName'] ?></a></h3>
            <ul class="room-specs">
              <li><span class="fad fa-calendar-check"></span><?= $reevent['CheckInDate'] ?></li>
              <li><span class="fad fa-calendar-times"></span><?= $reevent['CheckOutDate'] ?></li>
            </ul>
            <div class="room-specs additionalDetails" style="display:none;">
              <li><span class="fas fa-user-alt"></span>Guests: <?= $reevent['NumberOfGuests'] ?></li>
              <p><strong>Payment Option: </strong><?= $reevent['PaymentOption'] ?></p>
              <p><strong>Reference No.: </strong><?= $reevent['ReferenceNumber'] ?></p>
              <p><strong>Down or Full Payment: </strong><?= $reevent['downorfullPayment'] ?></p>
              <p><strong>Total Amount: </strong><?= $reevent['TotalAmount'] ?></p>
              <p><span class="badge <?= $reevent['Status'] == 'Confirm' ? 'badge-success' : ($reevent['Status'] == 'Pending' ? 'badge-warning' : 'badge-danger') ?>">
                <?= $reevent['Status'] ?>
              </span></p>
            </div>
            <div class="row">
              <div class="col-md-12 text-center">
                <h6 class="btn-info viewMoreBtn" style="cursor: pointer;"><a>View More Details</a></h6>
              </div>
            </div>
            <p><a href="<?= base_url("/cancelbooking/updatehotelstatus/Cancel/{$reevent['ReservationID']}") ?>" class="btn btn-danger btn-sm">Cancel Reservation</a></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
    

    
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
<script>
  function showHotel() {
    document.getElementById('hotelTable').style.display = 'flex';
    document.getElementById('restaurantTable').style.display = 'none';
    document.getElementById('conventionTable').style.display = 'none';
  }

  function showRestaurant() {
    document.getElementById('hotelTable').style.display = 'none';
    document.getElementById('restaurantTable').style.display = 'flex';
    document.getElementById('conventionTable').style.display = 'none';
  }

  function showConvention() {
    document.getElementById('hotelTable').style.display = 'none';
    document.getElementById('restaurantTable').style.display = 'none';
    document.getElementById('conventionTable').style.display = 'flex';
  }

  document.querySelectorAll('.viewMoreBtn').forEach(button => {
    button.addEventListener('click', () => {
      const parentContainer = button.closest('.room');
      const detailsDiv = parentContainer.querySelector('.additionalDetails');
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