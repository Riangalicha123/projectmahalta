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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/guest/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js">
    <style>
        /* Custom CSS to adjust popover width */
        .popover {
            max-width: 100%; /* Ensure popover can expand */
            width: auto !important; /* Set width to auto */
        }
        .circle {
  display: inline-block;
  width: 30px; /* Adjust as needed */
  height: 30px; /* Adjust as needed */
  border-radius: 50%;
  text-align: center;
  line-height: 30px; /* Adjust as needed to vertically center text */
  background-color: #ccc; /* Adjust background color */
  color: #fff; /* Adjust text color */
  border: 2px solid #ccc; /* Border around the circle */
  margin-right: 5px; /* Spacing between circle and number */
}

.number {
  font-size: 20px; /* Adjust font size as needed */
  border: 2px solid #ccc; /* Border around the number */
  padding: 3px; /* Padding inside the border */
}

.btn-secondary .circle {
  background-color: #6c757d; /* Adjust background color */
  border-color: #6c757d; /* Match circle border color with background */
}

.btn-secondary .circle:hover {
  background-color: #5a6268; /* Adjust hover background color */
  border-color: #5a6268; /* Match circle border color with hover background */
}

    </style>
  </head>
  <body>
  <?php include('include/header.php') ?>
    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/3.jpg);">
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
    <section class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="media d-block room mb-0">
                    <div class="media-body">
                    <form action="<?= base_url('/bookroom/submit') ?>" method="get">
                    <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="dateRange">Arrival Date to Departure Date</label>
                                <div style="position: relative;">
                                    <input type='text' class="form-control" id='dateRange' placeholder="Check-In-Date to Check-Out-Date" required/>
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
                                        <label for="Adult">Adult</label>
                                        <input type="number" class="form-control" id="Adult"  name="Adult" required>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="Child">Child</label>
                            <input type="number" class="form-control" id="Child"  name="Child" required>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group text-center">
                          <button type="submit" value="Reserve Now" class="btn btn-primary">Check Availability</button>
                        </div>
                    </div>
                    </form>        
                </div>
            </div>
        </div>
    </div>
</section>
<section class="site-section" >
      <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-5">Available Reservation Rooms</h2>
                <form action="<?= base_url('getdataRoom') ?>" method="GET">
                <?php if (!empty($availableRooms)): ?>
                    <?php foreach ($availableRooms as $room): ?>
                        <div class="col-md-12">
                            <div class="media d-block room mb-0">
                                <!-- Room details display here -->
                                <figure>
                                    <img src="<?= base_url('/uploads/' . $room['Image']) ?>" alt="Room Image" class="img-fluid" style="width:510px">
                                    <div class="overlap-text">
                                        <span>
                                            Room<?= $room['RoomNumber'] ?>
                                            <h6><b><?= $room['AvailabilityStatus'] ?></b></h6>
                                        </span>
                                    </div>
                                </figure>
                                <div class="media-body">
                                    <h3 class="mt-0"><a href="#"><?= $room['RoomType'] ?></a></h3>
                                    <h5 class="mt-0"><a href="#">PHP <?= $room['PricePerNight'] ?></a></h5>
                                    <ul class="room-specs">
                                      <li><span class="ion-ios-people-outline"></span>Min <?= $room['minPerson'] ?></li>
                                      <li><span class="ion-ios-people-outline"></span>Max <?= $room['maxPerson'] ?></li>
                                    </ul>
                                    <!-- Add this div at the end of your section, right before the closing </section> tag -->
                                    <div class="row additionalDetails" style="display:none;">
                                      <!-- Additional details content goes here -->
                                      <p><?= $room['Description'] ?></p>
                                      
                                      <p><b>• ROOM INCLUSIONS</b></p>
                                      <p>-Complimentary Breakfast(Plated Service)</p>
                                      <p>-Free Flow or Brewed Coffee</p>
                                      <p>-Complete Amenities</p>
                                      <p>-Swimming Pool Access</p>
                                      <p>-Stand By Generator Set</p>
                                      <p><b>NOTE: Extra person will be charge PHP 500.00 per head</b></p>
                                    </div>

                                    <!-- View More Button -->
                                    <div class="row">
                                      <div class="col-md-12 text-center">
                                      <h6 class="btn-info viewMoreBtn"><a>View More Details</a></h6>
                                      </div>
                                    </div>
                                    <div class="row">
                            <div class="col-md-12 text-center">
                                <?php if ($room['AvailabilityStatus'] == 'Not Available'): ?>
                                    <h6 style="border: 1px solid #ccc" id='dateRange'> Find available dates</h6>
                                    <!-- Gumamit ng button para mag-submit ng form -->
                                    <button type="button" class="btn btn-primary" disabled>Select</button>
                                <?php else: ?>
                                  <button type="submit" name="selectedRoomID" value="<?= $room['RoomID'] ?>" class="btn btn-primary">Select</button>
                                    
                                <?php endif; ?>
                            </div>
                        </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No available rooms matching your criteria found.</p>
                <?php endif; ?>
                </form>
            </div>
              <div class="col-md-2"></div>
              <div class="col-md-4">
               <form action="<?= base_url('/bookroom/getdataRoom') ?>" method="get">
                <?php if (!empty($roomSelected)): ?>
                    <h2>Selected Room Details</h2>
                    <div class="media d-block room mb-0">
                
                <figure>
                <img src="<?= base_url('/uploads/' . esc($roomSelected['Image'] ?? '')) ?>" alt="Generic placeholder image" class="img-fluid">
                <div class="overlap-text">
                  <span>
                    Room <?= esc($roomSelected['RoomNumber'] ?? '') ?>
                    <h6><b><?= $roomSelected['AvailabilityStatus'] ?></b></h6>
                  </span>
                </div>
                </figure>
                    <div class="media-body">
                      <h3 class="mt-0"><a href="#"><?= esc($roomSelected['RoomType'] ?? '') ?></a></h3>
                      <h5 class="mt-0"><a href="#">PHP <?= esc($roomSelected['PricePerNight'] ?? '') ?>/ Night</a></h5>
                      <?php if (isset($reservationData)): ?>
                              <p>Check-in Date: <?= esc($reservationData['CheckInDate'] ?? '') ?></p>
                              <p>Check-out Date: <?= esc($reservationData['CheckOutDate'] ?? '') ?></p>
                              <p>Number of Adults: <?= esc($reservationData['Adult'] ?? '') ?></p>
                              <p>Number of Childs: <?= esc($reservationData['Child'] ?? '') ?></p>
                              <h5><b>Total Amount: PHP:</b> <?= number_format($TotalAmount, 2) ?></h5>
                          <?php else: ?>
                              <p>No reservation data found.</p>
                          <?php endif; ?>
                          <hr>
                        <div class="row additionalDetails" style="display:none;">
                          <p><?= esc($roomSelected['Description'] ?? '') ?></p>
                          
                          <p><b>• ROOM INCLUSIONS</b></p>
                          <p>-Complimentary Breakfast(Plated Service)</p>
                          <p>-Free Flow or Brewed Coffee</p>
                          <p>-Complete Amenities</p>
                          <p>-Swimming Pool Access</p>
                          <p>-Stand By Generator Set</p>
                          <p><b>NOTE: Extra person will be charge PHP 500.00 per head</b></p>
                        </div>
                        <div class="row">
                          <div class="col-md-12 text-center">
                          <h6 class="btn-info viewMoreBtn"><a>View More Details</a></h6>
                          </div>
                        </div>
                      
                              <button type="submit" value="Reserve Now" class="btn btn-primary">Check</button>
                    </div>
                    
                  </div>
                  <?php endif; ?>
              </form>
              </div>    
            </div>
        </div>
      </div>
    </section>

    <!-- END section -->

    
    <!-- END section -->
   
    <!-- END section -->
   

    
    <!-- END section -->
   
    <?php include('include/footer.php') ?>
    <!-- END footer -->
    
    <!-- loader -->
    <?php include('include/loader.php') ?>

    <script>
// Get current date
var today = new Date();

// Set Arrival Date to today
var arrivalDateInput = document.getElementById('CheckInDate');
arrivalDateInput.valueAsDate = today;

// Set Departure Date to tomorrow
var tomorrow = new Date(today);
tomorrow.setDate(today.getDate() + 1);
var departureDateInput = document.getElementById('CheckOutDate');
departureDateInput.valueAsDate = tomorrow;
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="/guest/js/jquery-3.2.1.min.js"></script>
    <script src="/guest/js/jquery-migrate-3.0.0.js"></script>
    <script src="/guest/js/popper.min.js"></script>
    <script src="/guest/js/bootstrap.min.js"></script>
    <script src="/guest/js/owl.carousel.min.js"></script>
    <script src="/guest/js/jquery.waypoints.min.js"></script>
    <script src="/guest/js/jquery.stellar.min.js"></script>
    <script src="/guest/js/jquery.magnific-popup.min.js"></script>
    <script src="/guest/js/magnific-popup-options.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script>
// Function to initialize popover
function initializePopover() {
  var popoverContent = `
    <div id="popoverContent" style="width: 500px;">
      <table class="table table-responsive">
        <thead>
          <tr>
            <th cols="4"></th>
            <th cols="4">Adults (Ages 12+)</th>
            <th cols="4">Children (Ages 1-11)</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="roomTableBody">
          <tr class="room">
            <td><b>Room1</b></td>
            <td>
              <button class="" onclick="decrement('adults1')">
                <span class="circle">-</span>
              </button>
              <span id="adults1"class="number">2</span>
              <button class="" onclick="increment('adults1')">
                <span class="circle">+</span>
              </button>
            </td>
            <td>
              <button class="" onclick="decrement('children1')">
                <span class="circle">-</span>
              </button>
              <span id="children1" class="number">0</span>
              <button class="" onclick="increment('children1')">
                <span class="circle">+</span>
              </button>
            </td>
            <td><button  onclick="removeRoom(1)" style="">Remove</button></td>
          </tr>
        </tbody>
        <tfooter>
        
        </tfooter>
      </table>
      <div class="popover-footer">
        <button type="button" class="btn btn-primary btn-sm" onclick="addRoom()">
          <i class="bi bi-plus"></i> Add additional room
        </button>
        <button type="button" class="btn btn-success btn-sm" onclick="done()">
          <i class="bi bi-check"></i> Done
        </button>
      </div>
    </div>
  `;

  var popoverOptions = {
    container: 'body',
    placement: 'bottom',
    html: true,
    content: popoverContent
  };

  $('#roomsguestsPopover').popover(popoverOptions);
}

function generateRoomDetails(roomNumber) {
  return `
    <tr class="room">
      <td><b>Room${roomNumber}</b></td>
      <td>
        <button onclick="decrement('adults${roomNumber}')">
          <span class="circle">-</span>
        </button>
        <span id="adults${roomNumber}" class="number" name="adults${roomNumber}">2</span>
        <button onclick="increment('adults${roomNumber}')">
          <span class="circle">+</span>
        </button>
      </td>
      <td>
        <button onclick="decrement('children${roomNumber}')">
          <span class="circle">-</span>
        </button>
        <span id="children${roomNumber}" class="number" name="children${roomNumber}">0</span>
        <button onclick="increment('children${roomNumber}')">
          <span class="circle">+</span>
        </button>
      </td>
      <td><button onclick="removeRoom(${roomNumber})">Remove</button></td>
    </tr>
  `;
}


function addRoom() {
  var numRooms = $('.room').length;
  if (numRooms <= 8) { 
    var roomNumber = numRooms;
    var roomDetails = generateRoomDetails(roomNumber);
    $('#roomTableBody').append(roomDetails);
  } else {
    alert("Maximum room limit reached (8 rooms).");
  }
}

// Function to remove a room
function removeRoom(roomNumber) {
  $('#popoverContent').find('.room').eq(roomNumber - 1).remove();
}


// Function to handle increment
function increment(elementId) {
  var value = parseInt($('#' + elementId).text());
  $('#' + elementId).text(value + 1);
}

// Function to handle decrement
function decrement(elementId) {
  var value = parseInt($('#' + elementId).text());
  if (value > 0) {
    $('#' + elementId).text(value - 1);
  }
}

// Function to handle "Done" button click
function done() {
  $('#roomsguestsPopover').popover('hide');
}

// Function to initialize the page
function initializePage() {
  initializePopover();
}

$(document).ready(function () {
  initializePage();
});
</script>

<script>
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Adding 1 because months are zero-indexed
        const dayOfMonth = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${dayOfMonth}`;
    }

    function getNightsCount(checkIn, checkOut) {
        const oneDay = 24 * 60 * 60 * 1000;
        const diffDays = Math.round(Math.abs((checkOut - checkIn) / oneDay));
        return diffDays;
    }

    const currentDate = new Date();
    currentDate.setDate(currentDate.getDate());
    const config = {
        mode: "range",
        dateFormat: "Y-m-d - Y-m-d (d\\ nights)", 
        showMonths: 2,
        minDate: currentDate,
        onChange: function(selectedDates, dateStr, instance) {
            const [checkIn, checkOut] = selectedDates;
            const formattedCheckIn = formatDate(checkIn);
            const formattedCheckOut = formatDate(checkOut);
            const formattedDateRange = `${formattedCheckIn} - ${formattedCheckOut}`;
            document.getElementById('dateRange').value = formattedDateRange;
            document.getElementById('dateRange').setAttribute('name', 'CheckInDate, CheckOutDate');
            const sessionData = {
                CheckInDate: formattedCheckIn,
                CheckOutDate: formattedCheckOut,
            };
            sessionStorage.setItem('reservationData', JSON.stringify(sessionData));
            document.getElementById('checkInDate').textContent =  formattedCheckIn;
            document.getElementById('checkOutDate').textContent = formattedCheckOut;

            const queryString = `CheckInDate=${formattedCheckIn}&CheckOutDate=${formattedCheckOut}`;
            document.getElementById('queryString').textContent = queryString;

        }
    };
    flatpickr("#dateRange", config);
</script>


    <script src="/guest/js/main.js"></script>
  </body>
</html>