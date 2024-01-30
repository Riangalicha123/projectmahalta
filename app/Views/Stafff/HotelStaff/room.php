
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
    <a href="<?=base_url()?>/staff-hotel" class="brand-link elevation-4">
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
            <h1>Hotel Room Services</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Room Services</li>
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
                <h3 class="card-title">Room Services</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Add
                    </button>

                    <!-- Modal -->
                    <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Add Room</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/addRoom" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                <div class="form-group">
                                    <label for="RoomNumber">Room Number</label>
                                    <input type="text" class="form-control" id="RoomNumber" name="RoomNumber" required>
                                </div>
                                <div class="form-group">
                                    <label for="RoomType">Room Type</label>
                                    <select class="custom-select form-control-border" id="RoomType" name="RoomType" required>
                                        <option>Deluxe Room</option>
                                        <option>Jr. Suite Room</option>
                                        <option>Family Room</option>
                                        <option>Barkada Room</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="Description">Description</label>
                                    <input type="text" class="form-control" id="Description" name="Description" required>
                                </div>
                                <div class="form-group">
                                    <label for="PricePerNight">Price per Night</label>
                                    <input type="number" class="form-control" id="PricePerNight" name="PricePerNight" required>
                                </div>
                                <div class="form-group">
                                    <label for="Image">Upload</label>
                                    <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1" >Status</label>
                                    <input type="text" class="form-control" id="" name="AvailabilityStatus" required>
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
                    <?php foreach ($rooms as $room): ?>
                    <div class="modal fade" id="editModal<?=$room['RoomID']?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?=$room['RoomID']?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?=$room['RoomID']?>">Edit Room</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/updateRoom/" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                <input type="hidden" name="RoomID" id="RoomID" value="<?=$room['RoomID']?>">
                                <div class="form-group">
                                    <label for="RoomNumber">Room No.</label>
                                      <select class="custom-select form-control-border" id="RoomNumber" name="RoomNumber" required>
                                        <option <?= ($room['RoomNumber'] == 'D1') ? 'selected' : '' ?>>D1</option>
                                        <option <?= ($room['RoomNumber'] == 'D2') ? 'selected' : '' ?>>D2</option>
                                        <option <?= ($room['RoomNumber'] == 'D3') ? 'selected' : '' ?>>D3</option>
                                        <option <?= ($room['RoomNumber'] == 'D4') ? 'selected' : '' ?>>D4</option>
                                        <option <?= ($room['RoomNumber'] == 'D5') ? 'selected' : '' ?>>D5</option>
                                        <option <?= ($room['RoomNumber'] == 'D6') ? 'selected' : '' ?>>D6</option>
                                        <option <?= ($room['RoomNumber'] == 'D7') ? 'selected' : '' ?>>D7</option>
                                        <option <?= ($room['RoomNumber'] == 'D8') ? 'selected' : '' ?>>D8</option>
                                        <option <?= ($room['RoomNumber'] == 'S1') ? 'selected' : '' ?>>S1</option>
                                        <option <?= ($room['RoomNumber'] == 'S2') ? 'selected' : '' ?>>S2</option>
                                        <option <?= ($room['RoomNumber'] == 'F1') ? 'selected' : '' ?>>F1</option>
                                        <option <?= ($room['RoomNumber'] == 'F2') ? 'selected' : '' ?>>F2</option>
                                        <option <?= ($room['RoomNumber'] == 'B1') ? 'selected' : '' ?>>B1</option>
                                        <option <?= ($room['RoomNumber'] == 'B2') ? 'selected' : '' ?>>B2</option>
                                      </select>
                                </div>
                                <div class="form-group">
                                    <label for="RoomType">Room Type</label>
                                    <select class="custom-select form-control-border" id="RoomType" name="RoomType" value="<?=$room['RoomType']?>"required>
                                      <option <?= ($room['RoomType'] == 'Deluxe Room') ? 'selected' : '' ?>>Deluxe Room</option>
                                      <option <?= ($room['RoomType'] == 'Jr. Suite Room') ? 'selected' : '' ?>>Jr. Suite Room</option>
                                      <option <?= ($room['RoomType'] == 'Family Room') ? 'selected' : '' ?>>Family Room</option>
                                      <option <?= ($room['RoomType'] == 'Barkada Room') ? 'selected' : '' ?>>Barkada Room</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="Description">Description</label>
                                    <textarea class="form-control" id="Description" name="Description" required  cols="30" rows="10"><?=$room['Description']?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="PricePerNight">Price per Night</label>
                                    <input type="text" class="form-control" id="PricePerNight" name="PricePerNight"   value="<?=$room['PricePerNight']?>"required>
                                </div>
                                <div class="form-group">
                                    <label for="Image">Upload</label>
                                    <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$room['Image']?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1" >Status</label >
                                    <input type="text" class="form-control" id="" name="AvailabilityStatus"  value="<?=$room['AvailabilityStatus']?>"required>
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
                    <th>RoomNumber</th>
                    <th>RoomTypes</th>
                    <th>Description</th>
                    <th>Price per Night</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($rooms as $room): ?>
                  <tr>
                    <td><?=$room['RoomID']?></td>
                    <td><?=$room['RoomNumber']?></td>
                    <td><?=$room['RoomType']?></td>
                    <td><?=$room['Description']?></td>
                    <td><?=$room['PricePerNight']?></td>
                    <td><img src="<?=base_url('/uploads/'.$room['Image'])?>" alt="#"/></td>
                    <td style="color: red; background-border: #0056b3;" ><?=$room['AvailabilityStatus']?></td>
                    <th><a class="btn btn-danger" href="/deleteRoom/<?= $room['RoomID']?>">Delete</a> <a class="btn btn-info" data-toggle="modal" data-target="#editModal<?=$room['RoomID']?>">Edit</a></th>
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
