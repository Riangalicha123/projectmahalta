
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mahalta Admin</title>
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
  <style>
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


/* Input Fields */
input[type="number"] {
  background-color: #f2f2f2;
  border: 1px solid darkgray; /* Reduced border thickness */
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
<?php include(__DIR__ . '/../../Admin/include/loader.php'); ?>
  <?php include(__DIR__ . '/../../Admin/include/navbar.php'); ?>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php include(__DIR__ . '/../../Admin/include/logo.php'); ?>
    <?php include(__DIR__ . '/../../Admin/include/sidebar.php'); ?>
  </aside>
  <div class="content-wrapper">
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?route_to('admin-dashboard')?>">Home</a></li>
              <li class="breadcrumb-item active">Walk In Records</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
        <div class="col-md-6">
          <h2 class="mb-5">Reservation Room Form</h2>
          <?php if(isset($validation)):?>
                                        <div class="alert alert-warning">
                                            <?=$validation->listErrors()?>
                                        </div>
                                    <?php endif;?>
          <form action="<?= base_url('/admin-hotel/walkin-availability/dataroomreservation/amenities/formdetails/addReservation') ?>" method="post" enctype="multipart/form-data">
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
                    <input type="text" id="FirstName" name="FirstName" class="form-control">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="LastName">Last Name</label>
                    <input type="text" id="LastName" name="LastName" class="form-control">
                  </div>
                </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="ContactNumber">Contact Number</label>
                    <input type="text" id="ContactNumber" name="ContactNumber" class="form-control">
                  </div>
                  <div class="col-md-6 form-group">
                    <label for="Discount">Discount</label>
                    <select id="Discount" name="Discount" class="form-control">
                      <option value="">Select Discount</option>
                      <option value="20%">20%</option>
                    </select>
                  </div>
            </div>
            <div class="row">
              <div class="col-md-6 form-group">
                <button type="submit" value="Reserve Now" class="btn btn-primary">Submit</button>
              </div>
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
          <div class="selected-room-details">
            <div class="details-content">
            <h2 class="mb-3">Featured Room</h2>
            <?php if (isset($roomReservationData) && is_array($roomReservationData)): ?>
              <div class="media d-block room mb-0">
                <figure>
                  <img src="<?= base_url('/uploads/' . esc($roomReservationData['roomSelected']['Image'] ?? '')) ?>"
                    alt="Generic placeholder image" class="img-fluid" style="height:auto; width:444px; display: block;">
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
                    <p><b>Check-in Date:</b> <?= esc($roomReservationData['reservationData']['CheckIn'] ?? '') ?></p>
                    <p><b>Check-out Date:</b> <?= esc($roomReservationData['reservationData']['CheckOut'] ?? '') ?></p>
                    <p>Number of Adults: <?= esc($roomReservationData['reservationData']['Adult'] ?? '') ?></p>
                    <p>Number of Childs: <?= esc($roomReservationData['reservationData']['Child'] ?? '') ?></p>
                    
                    <h5><b>Total Amount: PHP <?= number_format($roomReservationData['TotalAmount'], 2) ?></b></h5>
                  <hr>
                  
                </div>
              </div>
            <?php else: ?>
              <p>No reservation data found.</p>
            <?php endif; ?>
              </form>
            </div>
          </div>
        </div>
        </form>
        </div>
      </div>
    </section>
  </div>

  <?php include(__DIR__ . '/../../Admin/include/footer.php'); ?>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>


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
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["colvis"]
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
