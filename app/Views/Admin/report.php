
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mahalta-Staff</title>

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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<!-- Site wrapper -->
<div class="wrapper">
<?php include('include/loader.php'); ?>
  <!-- Navbar -->
  <?php include('include/navbar.php'); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php include('include/logo.php'); ?>

    <!-- Sidebar -->
    <?php include('include/sidebar.php'); ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">

            <h2 class="mb-5 text-center">Reports</h2>
            <div class="text-center">
            <input type='text' class="form-control" id='dateRange' placeholder="Check-In-Date to Check-Out-Date" required/>
            </div>
            <div class="text-center mb-3">
            <div class="btn-group" role="group">
                <button class="btn btn-primary" onclick="showHotel()">Hotel</button>
                <button class="btn btn-primary" onclick="showRestaurant()">Restaurant</button>
                <button class="btn btn-primary" onclick="showConvention()">Convention</button>
            </div>
        </div>
            <table id="hotelreportTable" class="table table-bordered table-striped" style="display: block;">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Address</th>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Arrival</th>
                        <th>Departure</th>
                        <th>Adult</th>
                        <th>Child</th>
                        <th>Payment Option</th>
                        <th>Reference No.</th>
                        <th>Down or Full Payment</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hotelrevs as $hotelrev): ?>
                        <tr>
                            <td><?=$hotelrev['FirstName'] ?></td>
                            <td><?=$hotelrev['LastName'] ?></td>
                            <td><?=$hotelrev['Address'] ?></td>
                            <td><?=$hotelrev['RoomNumber'] ?></td>
                            <td><?=$hotelrev['RoomType'] ?></td>
                            <td><?=$hotelrev['CheckInDate'] ?></td>
                            <td><?=$hotelrev['CheckOutDate'] ?></td>
                            <td><?=$hotelrev['Adult'] ?></td>
                            <td><?=$hotelrev['Child'] ?></td>
                            <td><?=$hotelrev['PaymentOption'] ?></td>
                            <td><?=$hotelrev['ReferenceNumber'] ?></td>
                            <td><?=$hotelrev['downorfullPayment'] ?></td>
                            <td class="project-state">
                                <span class="badge <?=$hotelrev['Status'] == 'Confirm' ? 'badge-success' : ($hotelrev['Status'] == 'Pending' ? 'badge-warning' : 'badge-danger') ?>"><?=$hotelrev['Status'] ?>
                                </span>
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <table id="restaurantreportTable" class="table table-bordered table-striped" style="display: none;">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Address</th>
                  <th>Venue</th>
                  <th>Arrival</th>
                  <th>Note</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($restrevs as $restrev): ?>
                  <tr>
                    <td><?=$restrev['FirstName'] ?></td>
                    <td><?=$restrev['LastName'] ?></td>
                    <td><?=$restrev['Address'] ?></td>
                    <td><?=$restrev['VenueName']?></td>
                    <td><?=$restrev['CheckInDate']?></td>
                    <td><?=$restrev['Note']?></td>
                    <td class="project-state">
                      <span class="badge <?= $restrev['Status'] == 'Confirm' ? 'badge-success' : ($restrev['Status'] == 'Pending' ? 'badge-warning' : 'badge-danger') ?>"><?= $restrev['Status'] ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <table id="conventionreportTable" class="table table-bordered table-striped" style="display: none;">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Address</th>
                  <th>Venue Name</th>
                  <th>Event Type</th>
                  <th>Preferred Date</th>
                  <th>Departure Date</th>
                  <th>Number of Guests</th>
                  <th>Payment Option</th>
                  <th>Reference Number</th>
                  <th>Down or Full Payment</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($reevents as $reevent): ?>
                  <tr>
                    <td><?=$reevent['FirstName'] ?></td>
                    <td><?=$reevent['LastName'] ?></td>
                    <td><?=$reevent['Address'] ?></td>
                    <td><?=$reevent['conVenueName']?></td>
                    <td><?=$reevent['EventType']?></td>
                    <td><?=$reevent['CheckInDate']?></td>
                    <td><?=$reevent['CheckOutDate']?></td>
                    <td><?=$reevent['NumberOfGuests']?></td>
                    <td><?=$reevent['PaymentOption']?></td>
                    <td><?=$reevent['ReferenceNumber']?></td>
                    <td><?=$reevent['downorfullPayment']?></td>
                    <td class="project-state">
                      <span class="badge <?= $reevent['Status'] == 'Confirm' ? 'badge-success' : ($reevent['Status'] == 'Pending' ? 'badge-warning' : 'badge-danger') ?>"><?= $reevent['Status'] ?>
                      </span>
                    </td>
                  </tr>
                 <?php endforeach; ?>
              </tbody>
            </table>
            </div>
            <div class="col-md-3"></div>
        </div>
        
        
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('include/footer.php'); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#dateRange", {
            mode: "range",
            dateFormat: "Y-m-d",
            onClose: function(selectedDates, dateStr, instance) {
                let startDate = selectedDates[0].toISOString().split('T')[0];
                let endDate = new Date(selectedDates[1]);
                endDate.setDate(endDate.getDate() + 1);
                endDate = endDate.toISOString().split('T')[0];

                let dataType = getSelectedDataType(); // Get the selected data type

                $.ajax({
                    url: '/admin-report/fetch-report-data',
                    method: 'POST',
                    dataType: 'json',
                    data: { start_date: startDate, end_date: endDate, data_type: dataType }, // Pass data type to the server
                    success: function(response) {
                        updateTable(response, dataType); // Pass data type to updateTable function
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
    });

    function updateTable(data, dataType) {
        let tableBody;
        if (dataType === 'hotel') {
            tableBody = $('#hotelreportTable tbody');
            $('#restaurantreportTable').hide(); // Hide restaurant table
            $('#conventionreportTable').hide(); // Hide convention table
        } else if (dataType === 'restaurant') {
            tableBody = $('#restaurantreportTable tbody');
            $('#hotelreportTable').hide(); // Hide hotel table
            $('#conventionreportTable').hide(); // Hide convention table
        } else if (dataType === 'convention') {
            tableBody = $('#conventionreportTable tbody');
            $('#hotelreportTable').hide(); // Hide hotel table
            $('#restaurantreportTable').hide(); // Hide restaurant table
        }

        tableBody.empty();

        data.forEach(function(item) {
            let row = $('<tr>');
            if (dataType === 'hotel') {
                row.append($('<td>').text(item.FirstName));
                row.append($('<td>').text(item.LastName));
                row.append($('<td>').text(item.Address));
                row.append($('<td>').text(item.RoomNumber));
                row.append($('<td>').text(item.RoomType));
                row.append($('<td>').text(item.CheckInDate));
                row.append($('<td>').text(item.CheckOutDate));
                row.append($('<td>').text(item.Adult));
                row.append($('<td>').text(item.Child));
                row.append($('<td>').text(item.PaymentOption));
                row.append($('<td>').text(item.ReferenceNumber));
                row.append($('<td>').text(item.downorfullPayment));
                let statusBadgeClass = item.Status == 'Confirm' ? 'badge-success' : (item.Status == 'Pending' ? 'badge-warning' : 'badge-danger');
                let statusBadge = $('<span>').addClass('badge ' + statusBadgeClass).text(item.Status);
                row.append($('<td>').append(statusBadge));
            } else if (dataType === 'restaurant') {
                row.append($('<td>').text(item.FirstName));
                row.append($('<td>').text(item.LastName));
                row.append($('<td>').text(item.Address));
                row.append($('<td>').text(item.VenueName));
                row.append($('<td>').text(item.CheckInDate));
                row.append($('<td>').text(item.Note));
                let statusBadgeClass = item.Status == 'Confirm' ? 'badge-success' : (item.Status == 'Pending' ? 'badge-warning' : 'badge-danger');
                let statusBadge = $('<span>').addClass('badge ' + statusBadgeClass).text(item.Status);
                row.append($('<td>').append(statusBadge));
            } else if (dataType === 'convention') {
                row.append($('<td>').text(item.FirstName));
                row.append($('<td>').text(item.LastName));
                row.append($('<td>').text(item.Address));
                row.append($('<td>').text(item.conVenueName));
                row.append($('<td>').text(item.EventType));
                row.append($('<td>').text(item.CheckInDate));
                row.append($('<td>').text(item.CheckOutDate));
                row.append($('<td>').text(item.NumberOfGuests));
                row.append($('<td>').text(item.PaymentOption));
                row.append($('<td>').text(item.ReferenceNumber));
                row.append($('<td>').text(item.downorfullPayment));
                let statusBadgeClass = item.Status == 'Confirm' ? 'badge-success' : (item.Status == 'Pending' ? 'badge-warning' : 'badge-danger');
                let statusBadge = $('<span>').addClass('badge ' + statusBadgeClass).text(item.Status);
                row.append($('<td>').append(statusBadge));
            }
            tableBody.append(row);
        });
    }

    function getSelectedDataType() {
        // Determine which data type is selected (hotel, restaurant, convention)
        if ($('#hotelreportTable').is(':visible')) {
            return 'hotel';
        } else if ($('#restaurantreportTable').is(':visible')) {
            return 'restaurant';
        } else if ($('#conventionreportTable').is(':visible')) {
            return 'convention';
        }
    }
</script>

<script>
      // Function to show hotel table and hide others
      function showHotel() {
        document.getElementById("hotelreportTable").style.display = "table";
        document.getElementById("restaurantreportTable").style.display = "none";
        document.getElementById("conventionreportTable").style.display = "none";
      }

      // Function to show restaurant table and hide others
      function showRestaurant() {
        document.getElementById("hotelreportTable").style.display = "none";
        document.getElementById("restaurantreportTable").style.display = "table";
        document.getElementById("conventionreportTable").style.display = "none";
      }

      // Function to show convention table and hide others
      function showConvention() {
        document.getElementById("hotelreportTable").style.display = "none";
        document.getElementById("restaurantreportTable").style.display = "none";
        document.getElementById("conventionreportTable").style.display = "table";
      }
</script>

</body>
</html>
