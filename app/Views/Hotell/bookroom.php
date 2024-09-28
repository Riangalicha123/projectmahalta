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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?=base_url()?>guest/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js">
  <style>

/* Sticky footer for mobile */
@media (max-width: 768px) {


  .col-md-7, .col-md-5 {
    flex: 0 0 100%;
    max-width: 100%;
    padding: 0;
  }

  .selected-room-details {
    position: fixed;
    bottom: 0;
    width: 100%;
    max-height: 100%; /* Limit height to prevent overlapping header */
    background-color: #fff;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    overflow-y: auto; /* Allow scrolling if content exceeds height */
  }

  .selected-room-details .details-content {
    display: none;
    padding: 15px;
  }

  .selected-room-details .toggle-arrow {
    text-align: center;
    padding: 10px;
    cursor: pointer;
    background-color: #007bff;
    color: #fff;
  }
  .toggle-arrow {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  cursor: pointer;
  background-color: #007bff;
  color: #fff;
}

.price-per-night {
  margin-left: 10px;
}



}

  </style>
</head>

<body>
  <?php include('inc/header.php') ?>
  <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(<?=base_url()?>guest/images/3.jpg);">
  <div class="container">
    <div class="row align-items-center site-hero-inner justify-content-center">
     
      <div class="col-md-12 text-center">
      <div class="mb-5 element-animate text-center" style="max-width: 100%; margin-top:120px;">
    <h1 style="font-size: 3.5em; margin-bottom: 20px;">Room Reservation</h1>
</div>
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="media d-block room mb-0" style="background-color: rgba(128, 128, 128, 0.5); display: flex; flex-direction: column; justify-content: flex-end; height: 100%;">
                <div class="media-body">
                  <form action="<?= base_url('/bookroom/submit') ?>" method="get">
                    <div class="row">
                      <div class="col-sm-3 form-group"></div>
                      <div class="col-md-3 form-group">
                        <label for="Adult" style="color: white; font-size: 18px; font-weight: bold;">Adult</label>
                        <input type="number" class="form-control" id="Adult" name="Adult" value="0">
                      </div>
                      <div class="col-md-3 form-group">
                        <label for="Adult" style="color: white; font-size: 18px; font-weight: bold;">Kids</label>
                        <input type="number" class="form-control" id="Child" name="Child" value="0">
                      </div>
                      <div class="col-sm-3 form-group"></div>
                    </div>
                    <input type="hidden" id="CheckInDate" name="CheckInDate">
                    <input type="hidden" id="CheckOutDate" name="CheckOutDate">
                    <div class="row">
                      <div class="col-md-12 form-group text-center">
                        <button type="submit" class="btn btn-primary">Check Availability</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="site-section" style="background: #FAF2D3;">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="mb-5">Available Reservation Rooms</h2>
        <form action="<?= base_url('getdataRoom') ?>" method="GET">
          <div class="row">
            <?php if (!empty($availableRooms)) : ?>
              <?php foreach ($availableRooms as $room) : ?>
                <div class="col-md-6 mb-4">
                  <div class="media d-block room mb-0">
                  <figure>
                    <img src="<?= base_url('/uploads/' . $room['Image']) ?>" alt="Room Image" class="img-fluid rounded" style="height:300 px; width:788px;">
                    <div class="overlap-text">
                      <span>
                        Room<?= $room['RoomNumber'] ?>
                      </span>
                    </div>
                  </figure>

                    <div class="media-body">
                      <h3 class="mt-0"><a href="#"><?= $room['RoomType'] ?></a></h3>
                      <h5 class="mt-0"><a href="#">PHP <?= $room['PricePerNight'] ?> <p>(per <?=$room['PerNightHead']?>)</p></a></h5>
                      <ul class="room-specs">
                        <li><span class="ion-ios-people-outline"></span>Min <?= $room['minPerson'] ?></li>
                        <li><span class="ion-ios-people-outline"></span>Max <?= $room['maxPerson'] ?></li>
                      </ul>
                      <div class="row">
                        <div class="col-md-12 text-center">
                            <h6 class="btn-info viewMoreBtn"><a data-toggle="modal" data-target="#roomModal<?=$room['RoomID']?>">View More Details</a></h6>
                        </div>
                    </div>
                    <div class="modal fade" id="roomModal<?=$room['RoomID']?>" tabindex="-2" role="dialog" aria-labelledby="roomModalLabel<?=$room['RoomID']?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="roomModalLabel<?=$room['RoomID']?>">Room <?=$room['RoomNumber']?> <strong>||</strong> <?=$room['RoomType']?> Details</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <div id="imageCarousel<?=$room['RoomID']?>" class="carousel slide" data-ride="carousel">
                                          <div class="carousel-inner">
                                              <?php foreach ($roomimages as $roomimage): ?>
                                                  <?php if ($roomimage['RoomID'] === $room['RoomID']): ?>
                                                      <?php $images = explode(',', $roomimage['Images']); ?>
                                                      <?php foreach ($images as $index => $image): ?>
                                                          <div class="carousel-item<?php echo $index === 0 ? ' active' : ''; ?>">
                                                              <img src="<?= base_url('/uploads/' . trim($image)); ?>" class="d-block w-100" alt="Room Image" style="width: 100px; height: 300px;">
                                                          </div>
                                                      <?php endforeach; ?>
                                                  <?php endif; ?>
                                              <?php endforeach; ?>
                                          </div>
                                          <a class="carousel-control-prev" href="#imageCarousel<?=$room['RoomID']?>" role="button" data-slide="prev">
                                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                              <span class="sr-only">Previous</span>
                                          </a>
                                          <a class="carousel-control-next" href="#imageCarousel<?=$room['RoomID']?>" role="button" data-slide="next">
                                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                              <span class="sr-only">Next</span>
                                          </a>
                                      </div>
                                      <p><?=$room['Description']?></p>
                                      <p><b>• ROOM INCLUSIONS</b></p>
                                      <p>-Complimentary Breakfast(Plated Service)</p>
                                      <p>-Free Flow or Brewed Coffee</p>
                                      <p>-Complete Amenities</p>
                                      <p>-Swimming Pool Access</p>
                                      <p>-Stand By Generator Set</p>
                                      <p><b>NOTE: Extra person will be charge PHP 500.00 per head</b></p>
                                      
                                  </div>
                              </div>
                          </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-md-12 text-center">
                          <?php if ($room['AvailabilityStatus'] == 'Not Available') : ?>
                            <h6 style="border: 1px solid #ccc"> Find available dates</h6>
                            <button type="button" class="btn btn-primary" disabled>Select</button>
                          <?php else : ?>
                            <input type="text" id="dateRange<?= $room['RoomID'] ?>" class="form-control" placeholder="Select dates">
                            <input type="hidden" id="CheckInDate<?= $room['RoomID'] ?>" name="CheckInDate<?= $room['RoomID'] ?>">
                            <input type="hidden" id="CheckOutDate<?= $room['RoomID'] ?>" name="CheckOutDate<?= $room['RoomID'] ?>">
                            <h6 style="color: black font-size: 5px;">Note: If you want to add more guests on the reservation, you must need to occupy the maximum guests based on room availability of the room. Extra person/s will be charged with PHP 500.00 per head.</h6>
                              <div>
                          <label for="addAdult" style="color: black; font-size: 18px; font-weight: bold;">Add Adult</label>
                          <input type="number" class="form-control" id="addAdult<?= $room['RoomID'] ?>" name="addAdult<?= $room['RoomID'] ?>" value="0">
                      </div>
                      <div>
                          <label for="addChild" style="color: black; font-size: 18px; font-weight: bold;">Add Kid</label>
                          <input type="number" class="form-control" id="addChild<?= $room['RoomID'] ?>" name="addChild<?= $room['RoomID'] ?>" value="0">
                      </div>
                            <br>
                            <!-- Within each room's form -->
                            <button type="submit" name="selectedRoomID" value="<?= $room['RoomID'] ?>" class="btn btn-primary" onclick="return validateDateRange('<?= $room['RoomID'] ?>');">Select</button>

                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else : ?>
              <div class="col-md-12">
                <p>No available rooms matching your criteria found.</p>
              </div>
            <?php endif; ?>
          </div>
        </form>
      </div>
      <div class="col-md-5">
        <div class="selected-room-details">
          <div class="toggle-arrow">
            ▼ <span class="room-type">Room</span>
              <span class="price-per-night">PHP 0.00</span>
          </div>
          <div class="details-content">
          <h2 class="mb-3">Selected Room Details</h2>
            <form action="<?= base_url('/bookroom/getdataRoom') ?>" method="get">
              <?php if (!empty($roomSelected)) : ?>
                <div class="media d-block room mb-0">
                  <figure style="margin: 0;width: 100%; height: auto; display: block;">
                    <img src="<?= base_url('/uploads/' . esc($roomSelected['Image'] ?? '')) ?>" alt="Generic placeholder image" class="img-fluid rounded" style="width: 100%; height: auto; display: block;">
                    <div class="overlap-text">
                      <span>
                        Room <?= esc($roomSelected['RoomNumber'] ?? '') ?>
                        <h6><b><?= $roomSelected['AvailabilityStatus'] ?></b></h6>
                      </span>
                    </div>
                  </figure>
                  <div class="media-body">
                    <h3 class="mt-0"><a href="#"><?= esc($roomSelected['RoomType'] ?? '') ?></a></h3>
                    <h5 class="mt-0"><a href="#">PHP <?= esc($roomSelected['PricePerNight'] ?? '') ?></a></h5>
                    <?php if (isset($reservationData)) : ?>
                      <p>Check-in Date: <?= esc($reservationData['CheckInDate'] ?? '') ?></p>
                      <p>Check-out Date: <?= esc($reservationData['CheckOutDate'] ?? '') ?></p>
                      <p>Number of Adults: <?= esc($reservationData['Adult'] ?? '') ?></p>
                      <p>Number of Kids: <?= esc($reservationData['Child'] ?? '') ?></p>
                      <h5><b>Total Amount: PHP:</b> <?= number_format($TotalAmount, 2) ?></h5>
                    <?php else : ?>
                      <p>No reservation data found.</p>
                    <?php endif; ?>
                    
                    <button type="submit" value="Reserve Now" class="btn btn-primary">Check</button>
                  </div>
                </div>
              <?php endif; ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

  <?php include('inc/footer.php') ?>
  <?php include('inc/loader.php') ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var toggleArrow = document.querySelector('.toggle-arrow');
      var detailsContent = document.querySelector('.details-content');
      var roomType = document.querySelector('.room-type');
      var pricePerNight = document.querySelector('.price-per-night');

      // Set initial price per night if roomSelected is not empty
      <?php if (!empty($roomSelected)) : ?>
        pricePerNight.textContent = 'PHP <?= esc($roomSelected['PricePerNight'] ?? '0.00') ?>';
        roomType.textContent = '<?= esc($roomSelected['RoomType'] ?? 'Room') ?>';
      <?php endif; ?>

      toggleArrow.addEventListener('click', function() {
        if (detailsContent.style.display === 'none' || detailsContent.style.display === '') {
          detailsContent.style.display = 'block';
          toggleArrow.textContent = '▲';
          toggleArrow.appendChild(pricePerNight);
          pricePerNight.style.display = 'none';  // Hide price when arrow is up
        } else {
          detailsContent.style.display = 'none';
          toggleArrow.textContent = '▼';
          toggleArrow.appendChild(pricePerNight);
          pricePerNight.style.display = 'inline';  // Show price when arrow is down
        }
      });
    });
  </script>
  <script>
  function validateDateRange(roomID) {
    var checkInDate = document.getElementById('CheckInDate' + roomID).value;
    var checkOutDate = document.getElementById('CheckOutDate' + roomID).value;
    if (!checkInDate || !checkOutDate) {
      alert('Please select a date range.');
      return false;
    }
    return true;
  }
</script>
  <script>
    var today = new Date();
    var arrivalDateInput = document.getElementById('CheckInDate');
    arrivalDateInput.valueAsDate = today;
    var tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1);
    var departureDateInput = document.getElementById('CheckOutDate');
    departureDateInput.valueAsDate = tomorrow;
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
  <script src="<?=base_url()?>guest/js/jquery-3.2.1.min.js"></script>
  <script src="<?=base_url()?>guest/js/jquery-migrate-3.0.0.js"></script>
  <script src="<?=base_url()?>guest/js/popper.min.js"></script>
  <script src="<?=base_url()?>guest/js/bootstrap.min.js"></script>
  <script src="<?=base_url()?>guest/js/owl.carousel.min.js"></script>
  <script src="<?=base_url()?>guest/js/jquery.waypoints.min.js"></script>
  <script src="<?=base_url()?>guest/js/jquery.stellar.min.js"></script>
  <script src="<?=base_url()?>guest/js/jquery.magnific-popup.min.js"></script>
  <script src="<?=base_url()?>guest/js/magnific-popup-options.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      function formatDate(date) {
        const d = new Date(date);
        let month = `${d.getMonth() + 1}`;
        let day = `${d.getDate()}`;
        const year = d.getFullYear();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        return [year, month, day].join('-');
      }
      flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "Y-m-d",
        minDate: "today",
        maxDate: new Date().fp_incr(365), 
        onClose: function(selectedDates) {
          if (selectedDates.length === 2) {
            const [checkInDate, checkOutDate] = selectedDates;
            document.getElementById('CheckInDate').value = formatDate(checkInDate);
            document.getElementById('CheckOutDate').value = formatDate(checkOutDate);
          }
        }
      });
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      <?php if (!empty($availableRooms)) : ?>
        <?php foreach ($availableRooms as $room) : ?>
          flatpickr("#dateRange<?= $room['RoomID'] ?>", {
            mode: "range",
            dateFormat: 'Y-m-d',
            disable: <?= json_encode($room['unavailableDates']) ?>,
            minDate: 'today',
            onClose: function(selectedDates) {
              if (selectedDates.length === 2) {
                const offset = selectedDates[0].getTimezoneOffset() * 60000; 
                const adjustedStart = new Date(selectedDates[0].getTime() - offset).toISOString().slice(0, 10);
                const adjustedEnd = new Date(selectedDates[1].getTime() - offset).toISOString().slice(0, 10);
                document.getElementById('CheckInDate<?= $room['RoomID'] ?>').value = adjustedStart;
                document.getElementById('CheckOutDate<?= $room['RoomID'] ?>').value = adjustedEnd;
              }
            }
          });
        <?php endforeach; ?>
      <?php endif ?>
    });
  </script>
  <script src="<?=base_url()?>guest/js/main.js"></script>
</body>
</html>