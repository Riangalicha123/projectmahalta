
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mahalta-Staff</title>
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
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <?php include('include/navbar.php') ?>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link elevation-4">
      <img src="<?=base_url()?>admin/dist/img/mahaltalogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    </a>
    <?php include('include/sidebar.php') ?>
  </aside>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Restaurant Services</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Restaurant Services</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Restaurant Services</h3>
              </div>
              <div class="card-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Add
                    </button>
                    <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Add Table</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/addVenue" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                <div class="form-group">
                                    <label for="VenueName">Venue Name</label>
                                      <select class="custom-select form-control-border" id="VenueName" name="VenueName" required>
                                        <option >Main Restaurant</option>
                                        <option >Venue 2</option>
                                        <option >Venue 3</option>
                                      </select>
                                </div>
                                <div class="form-group">
                                    <label for="VenueCapacity" >Status</label >
                                    <input type="number" class="form-control" id="VenueCapacity" name="VenueCapacity"  required>
                                </div>
                                <div class="form-group">
                                    <label for="AvailableCapacity" >Status</label >
                                    <input type="number" class="form-control" id="AvailableCapacity" name="AvailableCapacity"  required>
                                </div>
                                <div class="form-group">
                                    <label for="Image">Upload</label>
                                    <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" required>
                                </div>
                                </div>
                                <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($venues as $venue): ?>
                    <div class="modal fade" id="editModal<?=$venue['VenueID']?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?=$venue['VenueID']?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?=$venue['VenueID']?>">Edit Table</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/updateVenue" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                <input type="hidden" name="VenueID" id="VenueID" value="<?=$venue['VenueID']?>">
                                
                                <div class="form-group">
                                    <label for="VenueName">Venue Name</label>
                                      <select class="custom-select form-control-border" id="VenueName" name="VenueName" required>
                                        <option <?= ($venue['VenueName'] == 'Main Restaurant') ? 'selected' : '' ?>>Main Restaurant</option>
                                        <option <?= ($venue['VenueName'] == 'Venue 2') ? 'selected' : '' ?>>Venue 2</option>
                                        <option <?= ($venue['VenueName'] == 'Venue 3') ? 'selected' : '' ?>>Venue 3</option>
                                      </select>
                                </div>
                                <div class="form-group">
                                    <label for="VenueCapacity" >Status</label >
                                    <input type="number" class="form-control" id="VenueCapacity" name="VenueCapacity"  required value="<?=$venue['VenueCapacity']?>">
                                </div>
                                <div class="form-group">
                                    <label for="AvailableCapacity" >Status</label >
                                    <input type="number" class="form-control" id="AvailableCapacity" name="AvailableCapacity"  required value="<?=$venue['AvailableCapacity']?>">
                                </div>
                                <div class="form-group">
                                    <label for="Image">Upload</label>
                                    <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="image/*" required>
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
                    <th>Venue Name</th>
                    <th>Venue Capacity</th>
                    <th>Available Capacity</th>
                    <th>Venue Image</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($venues as $venue): ?>
                  <tr>
                    <td><?=$venue['VenueID']?></td>
                    <td><?=$venue['VenueName']?></td>
                    <td><?=$venue['VenueCapacity']?></td>
                    <td><?=$venue['AvailableCapacity']?></td>
                    <td><img  style="width: 300px; height: 250px;" src="<?=base_url('/uploads/'.$venue['Image'])?>" alt="#"/></td>
                    <th><a class="btn btn-danger" href="/staff-restaurant/service/delete/<?= $venue['VenueID']; ?>" onclick="return confirm('Are you sure you want to delete this Venue?');">Delete</a> <a class="btn btn-info" data-toggle="modal" data-target="#editModal<?=$venue['VenueID']?>">Edit</a></th>
                  </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <?php include('include/footer.php') ?>
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
