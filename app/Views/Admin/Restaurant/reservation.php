
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mahalta Admin</title>

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
<?php include(__DIR__ . '/../../Admin/include/loader.php'); ?>
  <!-- Navbar -->
  <?php include(__DIR__ . '/../../Admin/include/navbar.php'); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php include(__DIR__ . '/../../Admin/include/logo.php'); ?>

    <!-- Sidebar -->
    <?php include(__DIR__ . '/../../Admin/include/sidebar.php'); ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Restaurant Reservation</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Restaurant</a></li>
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
                            <form action="<?= base_url('/addRestauReservation') ?>" method="post" enctype="multipart/form-data">
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
                                            <label for="TableNumber">Room No.</label>
                                            <select class="custom-select form-control-border" id="TableNumber" name="TableNumber" required>
                                                <option>T1</option>
                                                <option>T2</option>
                                                <option>T3</option>
                                            </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="CheckInDate">Arrival</label>
                                                <input type="datetime-local" class="form-control" id="CheckInDate" name="CheckInDate" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="Note">Note</label>
                                                <textarea class="form-control" id="Note" name="Note" required  cols="30" rows="10"></textarea>
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
                    <?php foreach ($restrevs as $restrev): ?>
                    <div class="modal fade" id="editModal<?=$restrev['ReservationID']?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?=$restrev['ReservationID']?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?=$restrev['ReservationID']?>">Edit Reservation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= base_url('/updateRestauReservation/' . $restrev['ReservationID']) ?>" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" name="ReservationID" id="ReservationID" value="<?= $restrev['ReservationID'] ?>">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                            <label for="Venue">Venue</label>
                                            <select class="custom-select form-control-border" id="Venue" name="Venue" required>
                                                <option <?= ($restrev['Venue'] == 'Venue 1') ? 'selected' : '' ?>>Venue 1</option>
                                                <option <?= ($restrev['Venue'] == 'Venue 2') ? 'selected' : '' ?>>Venue 2</option>
                                            </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="CheckInDate">Arrival</label>
                                                <input type="datetime-local" class="form-control" id="CheckInDate" name="CheckInDate" required value="<?= date('Y-m-d\TH:i', strtotime($restrev['CheckInDate'])) ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="Note">Note</label>
                                                <textarea class="form-control" id="Note" name="Note" required  cols="30" rows="10"><?= $restrev['Note'] ?></textarea>
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
                    <th>Venue</th>
                    <th>Arrival</th>
                    <th>Note</th>
                    <th>Status</th>
                    <th>Status Action</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($restrevs as $restrev): ?>
                  <tr>
                    <td><?=$restrev['ReservationID']?></td>
                    <td><?=$restrev['FirstName']?></td>
                    <td><?=$restrev['LastName']?></td>
                    <td><?=$restrev['ContactNumber']?></td>
                    <td><?=$restrev['Address']?></td>
                    <td><?=$restrev['Venue']?></td>
                    <td><?=$restrev['CheckInDate']?></td>
                    <td><?=$restrev['Note']?></td>
                    <td class="project-state">
                        <?php
                        $badgeClass = '';

                        switch ($restrev['Status']) {
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
                        <span class="badge <?= $badgeClass ?>"><?= $restrev['Status'] ?></span>
                    </td>
                    <td class="project-state">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <!-- Three dots icon -->
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="statusDropdown">
                            <!-- Inside the dropdown menu in your HTML template -->
                            <a class="dropdown-item" href="<?= base_url("/admin/updateRestauStatus/Confirm/{$restrev['ReservationID']}") ?>">Confirm</a>
                            <a class="dropdown-item" href="<?= base_url("/admin/updateRestauStatus/Pending/{$restrev['ReservationID']}") ?>">Pending</a>
                            <a class="dropdown-item" href="<?= base_url("/admin/updateRestauStatus/Cancel/{$restrev['ReservationID']}") ?>">Cancel</a>
                            </div>
                        </div>
                    </td>
                    <th><a class="btn btn-info" data-toggle="modal" data-target="#editModal<?=$restrev['ReservationID']?>">Edit</a></th>
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

  <?php include(__DIR__ . '/../../Admin/include/footer.php'); ?>

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
