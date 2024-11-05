
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mahalta Staff</title>
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

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>admin/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?=base_url()?>admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url()?>admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url()?>admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>admin/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <style>
    /* Form Container */
.room {
  background-color: white;
  border-radius: 10px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
  padding: 15px;
  max-width: 1000px;
  margin: 0 auto;
  transition: box-shadow 0.3s ease, transform 0.3s ease; /* Smooth transition for hover effects */
}

/* Hover effect */
.room:hover {
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3); /* Increased shadow for hover effect */
  transform: scale(1.02); /* Slightly scale up the container */
}

/* Labels */
label {
  color: white;
  font-size: 18px;
  font-weight: bold;
}

/* Input Fields */
input[type="number"] {
  background-color: #f2f2f2;
  border: 1px solid darkgray;
  color: #333;
  padding: 10px;
  border-radius: 5px;
  width: 100%;
}

/* Button */
button[type="submit"] {
  background-color: #007BFF;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
  background-color: #0056b3;
}

  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <?php include('include/navbar.php'); ?>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link">
      <img src="<?=base_url()?>admin/dist/img/mahaltalogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    </a>
    <?php include('include/sidebar.php'); ?>
  </aside>


  <div class="content-wrapper">
  <div id="flash-message" style="display:none;">
    <div class="alert alert-success">
      <strong>Success!</strong> <span id="flash-message-content"></span>
    </div>
  </div>
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Walk In</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?route_to('admin-dashboard')?>">Home</a></li>
              <li class="breadcrumb-item active">Walk In</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
        <div class="content-fluid">
        <div class="row">
            <div class="col-sm-12">
              <div class="media d-block room mb-0" style="background-color: rgba(128, 128, 128, 0.5); display: flex; flex-direction: column; justify-content: flex-end; height: 100%;">
                <div class="media-body">
                  <form action="<?= base_url('/staff-walkin-availability') ?>" method="get">
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
                    <input type="hidden" id="CheckIn" name="CheckIn">
                    <input type="hidden" id="CheckOut" name="CheckOut">
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
    </section>
    <section class="content">
      <div class="container-fluid">
      <div class="row">
      <div class="col-md-6">
        <h2 class="mb-5">Available Reservation Rooms</h2>
        <form action="<?= base_url('staff-walkin-availability/dataroom') ?>" method="GET">
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
                            <input type="hidden" id="CheckIn<?= $room['RoomID'] ?>" name="CheckIn<?= $room['RoomID'] ?>">
                            <input type="hidden" id="CheckOut<?= $room['RoomID'] ?>" name="CheckOut<?= $room['RoomID'] ?>">
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

          <div class="details-content">
          <h2 class="mb-3">Selected Room Details</h2>
            <form action="<?= base_url('/staff-walkin-availability/dataroomreservation') ?>" method="get">
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
                      <p>Check-in Date: <?= esc($reservationData['CheckIn'] ?? '') ?></p>
                      <p>Check-out Date: <?= esc($reservationData['CheckOut'] ?? '') ?></p>
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
  </div>

  <?php include('include/footer.php'); ?>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
<script>
// Check if session has flashdata
document.addEventListener('DOMContentLoaded', function() {
    <?php if (session()->getFlashdata('success')) : ?>
        var flashMessage = '<?= session()->getFlashdata('success') ?>';
        document.getElementById('flash-message-content').innerHTML = flashMessage;
        document.getElementById('flash-message').style.display = 'block';

        // Optionally hide the flash message after a few seconds
        setTimeout(function() {
            document.getElementById('flash-message').style.display = 'none';
        }, 5000); // Hide after 5 seconds
    <?php endif; ?>
});
</script>

<!-- jQuery -->
<script src="<?=base_url()?>admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>admin/dist/js/adminlte.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?=base_url()?>admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url()?>admin/plugins/jszip/jszip.min.js"></script>
<script src="<?=base_url()?>admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=base_url()?>admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
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
            document.getElementById('CheckIn').value = formatDate(checkInDate);
            document.getElementById('CheckOut').value = formatDate(checkOutDate);
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
                document.getElementById('CheckIn<?= $room['RoomID'] ?>').value = adjustedStart;
                document.getElementById('CheckOut<?= $room['RoomID'] ?>').value = adjustedEnd;
              }
            }
          });
        <?php endforeach; ?>
      <?php endif ?>
    });
  </script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": [""]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
