
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
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php include('include/navbar.php') ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=base_url()?>admin/index3.html" class="brand-link elevation-4">
      <img src="<?=base_url()?>admin/dist/img/mahaltalogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <!-- <span class="brand-text font-weight-light">Mahalta</span> -->
    </a>

    <!-- Sidebar -->
    <?php include('include/sidebar.php') ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Hotel Reservation</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Hotel</a></li>
              <li class="breadcrumb-item active">Reservation</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Reservation</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Add
                    </button>

                    <!-- Modal -->
                    <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Add Staff</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('/addhotelReservation') ?>" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                          <label for="FirstName">First Name</label>
                                          <input type="text" class="form-control" id="FirstName" name="FirstName" required>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="LastName">Last Name</label>
                                          <input type="text" class="form-control" id="LastName" name="LastName" required>
                                      </div>
                                  </div>
                                <div class="form-row">
                                      <div class="form-group col-md-6">
                                          <label for="ContactNumber">Contact Number</label>
                                          <input type="number" class="form-control" id="ContactNumber" name="ContactNumber" required>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="Address">Address</label>
                                          <input type="text" class="form-control" id="Address" name="Address" required>
                                      </div>
                                </div>
                                <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="CheckInDate">Arrival</label>
                                                <input type="datetime-local" class="form-control" id="CheckInDate" name="CheckInDate" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="CheckOutDate">Departure</label>
                                                <input type="datetime-local" class="form-control" id="CheckOutDate" name="CheckOutDate" required>
                                            </div>
                                        </div>
                                <div class="form-row">
                                      <div class="form-group col-md-6">
                                        <label for="RoomNumber">Room Type</label>
                                          <select class="custom-select form-control-border" id="RoomNumber" name="RoomNumber" required>
                                            <option>D1</option>
                                            <option>D2</option>
                                            <option>D3</option>
                                            <option>D4</option>
                                            <option>D5</option>
                                            <option>D6</option>
                                            <option>D7</option>
                                            <option>D8</option>
                                            <option>S1</option>
                                            <option>S2</option>
                                            <option>F1</option>
                                            <option>F2</option>
                                            <option>B1</option>
                                            <option>B2</option>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-6">
                                        <label for="RoomType">Room Type</label>
                                            <select class="custom-select form-control-border" id="RoomType" name="RoomType" required>
                                              <option>Deluxe Room</option>
                                              <option>Jr. Suite Room</option>
                                              <option>Family Room</option>
                                              <option>Barkada Room</option>
                                            </select>
                                      </div>
                                </div>
                                <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="NumberOfGuests">Number of Guests</label>
                                                <input type="number" class="form-control" id="NumberOfGuests" name="NumberOfGuests" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="ReferenceNumber">Reference No.</label>
                                                <input type="number" class="form-control" id="ReferenceNumber" name="ReferenceNumber" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="downorfullPayment">Down or Full Payment</label>
                                                <input type="number" class="form-control" id="downorfullPayment" name="downorfullPayment" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="TotalAmount">Total Amounts</label>
                                                <input type="number" class="form-control" id="TotalAmount" name="TotalAmount" required>
                                            </div>
                                        </div>
                                
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Room Modal -->
                    <?php foreach ($hotelrevs as $hotelrev): ?>
                    <div class="modal fade" id="editModal<?=$hotelrev['ReservationID']?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?=$hotelrev['ReservationID']?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?=$hotelrev['ReservationID']?>">Edit Reservation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= base_url('/updatehotelReservation/' . $hotelrev['ReservationID']) ?>" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" name="ReservationID" id="ReservationID" value="<?= $hotelrev['ReservationID'] ?>">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                            <label for="RoomNumber">Room No.</label>
                                            <select class="custom-select form-control-border" id="RoomNumber" name="RoomNumber" required>
                                                <option <?= ($hotelrev['RoomNumber'] == 'D1') ? 'selected' : '' ?>>D1</option>
                                                <option <?= ($hotelrev['RoomNumber'] == 'D2') ? 'selected' : '' ?>>D2</option>
                                                <option <?= ($hotelrev['RoomNumber'] == 'D3') ? 'selected' : '' ?>>D3</option>
                                                <option <?= ($hotelrev['RoomNumber'] == 'D4') ? 'selected' : '' ?>>D4</option>
                                                <option <?= ($hotelrev['RoomNumber'] == 'D5') ? 'selected' : '' ?>>D5</option>
                                                <option <?= ($hotelrev['RoomNumber'] == 'D6') ? 'selected' : '' ?>>D6</option>
                                                <option <?= ($hotelrev['RoomNumber'] == 'D7') ? 'selected' : '' ?>>D7</option>
                                                <option <?= ($hotelrev['RoomNumber'] == 'D8') ? 'selected' : '' ?>>D8</option>
                                                <option <?= ($hotelrev['RoomNumber'] == 'S1') ? 'selected' : '' ?>>S1</option>
                                                <option <?= ($hotelrev['RoomNumber'] == 'S2') ? 'selected' : '' ?>>S2</option>
                                                <option <?= ($hotelrev['RoomNumber'] == 'F1') ? 'selected' : '' ?>>F1</option>
                                                <option <?= ($hotelrev['RoomNumber'] == 'F2') ? 'selected' : '' ?>>F2</option>
                                                <option <?= ($hotelrev['RoomNumber'] == 'B1') ? 'selected' : '' ?>>B1</option>
                                                <option <?= ($hotelrev['RoomNumber'] == 'B2') ? 'selected' : '' ?>>B2</option>
                                            </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                            <label for="RoomType">Room Type</label>
                                            <select class="custom-select form-control-border" id="RoomType" name="RoomType" required>
                                                <option <?= ($hotelrev['RoomType'] == 'Deluxe Room') ? 'selected' : '' ?>>Deluxe Room</option>
                                                <option <?= ($hotelrev['RoomType'] == 'Jr. Suite Room') ? 'selected' : '' ?>>Jr. Suite Room</option>
                                                <option <?= ($hotelrev['RoomType'] == 'Family Room') ? 'selected' : '' ?>>Family Room</option>
                                                <option <?= ($hotelrev['RoomType'] == 'Barkada Room') ? 'selected' : '' ?>>Barkada Room</option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="CheckInDate">Arrival</label>
                                                <input type="datetime-local" class="form-control" id="CheckInDate" name="CheckInDate" required value="<?= date('Y-m-d\TH:i', strtotime($hotelrev['CheckInDate'])) ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="CheckOutDate">Departure</label>
                                                <input type="datetime-local" class="form-control" id="CheckOutDate" name="CheckOutDate" required value="<?= date('Y-m-d\TH:i', strtotime($hotelrev['CheckOutDate'])) ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="NumberOfGuests">Number of Guests</label>
                                                <input type="number" class="form-control" id="NumberOfGuests" name="NumberOfGuests" required value="<?= $hotelrev['NumberOfGuests'] ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="ReferenceNumber">Reference No.</label>
                                                <input type="number" class="form-control" id="ReferenceNumber" name="ReferenceNumber" required value="<?= $hotelrev['ReferenceNumber'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="downorfullPayment">Down or Full Payment</label>
                                                <input type="number" class="form-control" id="downorfullPayment" name="downorfullPayment" required value="<?= $hotelrev['downorfullPayment'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="TotalAmount">Total Amounts</label>
                                                <input type="number" class="form-control" id="TotalAmount" name="TotalAmount" required value="<?= $hotelrev['TotalAmount'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Contact No.</th>
                    <th>Address</th>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Number of Guests</th>
                    <th>Reference No.</th>
                    <th>Down or Full Payment</th>
                    <th>TotalAmount</th>
                    <th>Status</th>
                    <th>Status Action</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($hotelrevs as $hotelrev): ?>
                  <tr>
                    <td><?=$hotelrev['ReservationID']?></td>
                    <td><?=$hotelrev['FirstName']?></td>
                    <td><?=$hotelrev['LastName']?></td>
                    <td><?=$hotelrev['ContactNumber']?></td>
                    <td><?=$hotelrev['Address']?></td>
                    <td><?=$hotelrev['RoomNumber']?></td>
                    <td><?=$hotelrev['RoomType']?></td>
                    <td><?=$hotelrev['CheckInDate']?></td>
                    <td><?=$hotelrev['CheckOutDate']?></td>
                    <td><?=$hotelrev['NumberOfGuests']?></td>
                    <td><?=$hotelrev['ReferenceNumber']?></td>
                    <td><?=$hotelrev['downorfullPayment']?></td>
                    <td><?=$hotelrev['TotalAmount']?></td>
                    <td class="project-state">
                        <?php
                        $badgeClass = '';

                        switch ($hotelrev['Status']) {
                            case 'Confirm':
                                $badgeClass = 'badge-success';
                                break;
                            case 'Pending':
                                $badgeClass = 'badge-warning';
                                break;
                            case 'Cancel':
                                $badgeClass = 'badge-danger';
                                break;
                            default:
                                $badgeClass = 'badge-secondary'; // Default class for other cases
                        }
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= $hotelrev['Status'] ?></span>
                    </td>
                    <td class="project-state">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <!-- Three dots icon -->
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="statusDropdown">
                            <!-- Inside the dropdown menu in your HTML template -->
                            <a class="dropdown-item" href="<?= base_url("/staff/updatestatus/Confirm/{$hotelrev['ReservationID']}") ?>">Confirm</a>
                            <a class="dropdown-item" href="<?= base_url("/staff/updatestatus/Pending/{$hotelrev['ReservationID']}") ?>">Pending</a>
                            <a class="dropdown-item" href="<?= base_url("/staff/updatestatus/Cancel/{$hotelrev['ReservationID']}") ?>">Cancel</a>
                            </div>
                        </div>
                    </td>
                    <th><a class="btn btn-info" data-toggle="modal" data-target="#editModal<?=$hotelrev['ReservationID']?>">Edit</a></th>
                  </tr>
                  <?php endforeach; ?>
                  
                  </tbody>
                  
                </table>
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include('include/footer.php') ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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
      "buttons": ["pdf"]
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
