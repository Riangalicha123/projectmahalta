
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
            <h1>Hotel Products/Stocks</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Products/Stocks</li>
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
                <h3 class="card-title">Products/Stocks</h3>
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
                                <h5 class="modal-title" id="exampleModalLongTitle">Add Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/addinHotel" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                <div class="form-group">
                                    <label for="ProductName">Product Name</label>
                                    <input type="text" class="form-control" id="ProductName" name="ProductName" required>
                                </div>
                                <div class="form-group">
                                    <label for="Quantity">Quantity</label>
                                    <input type="number" class="form-control" id="Quantity" name="Quantity" required>
                                </div>
                                <div class="form-group">
                                    <label for="Price">Price</label>
                                    <input type="number" class="form-control" id="Price" name="Price" required>
                                </div>
                                <div class="form-group">
                                    <label for="TotalPrice">Total Price</label>
                                    <input type="number" class="form-control" id="TotalPrice" name="TotalPrice" required>
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
                    <?php foreach ($roinvents as $roinvent): ?>
                      <div class="modal fade" id="editModal<?=$roinvent['roomInventoryID']?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?=$roinvent['roomInventoryID']?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="editModalLabel<?=$roinvent['roomInventoryID']?>">Edit Product</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <form action="<?= base_url('/updateinHotel/' . $roinvent['roomInventoryID']) ?>" method="post" enctype="multipart/form-data">
                                      <div class="card-body">
                                          <input type="hidden" name="roomInventoryID" id="roomInventoryID" value="<?=$roinvent['roomInventoryID']?>">
                                          <div class="form-group">
                                              <label for="ProductName">Product Name</label>
                                              <input type="text" class="form-control" id="ProductName" name="ProductName" value="<?=$roinvent['ProductName']?>" required>
                                          </div>
                                          <div class="form-group">
                                              <label for="Quantity">Quantity</label>
                                              <input type="number" class="form-control" id="Quantity" name="Quantity" value="<?=$roinvent['Quantity']?>" required>
                                          </div>
                                          <div class="form-group">
                                              <label for="Price">Price</label>
                                              <input type="number" class="form-control" id="Price" name="Price" value="<?=$roinvent['Price']?>" required>
                                          </div>
                                          <div class="form-group">
                                              <label for="TotalPrice">TotalPrice</label>
                                              <input type="number" class="form-control" id="TotalPrice" name="TotalPrice" value="<?=$roinvent['TotalPrice']?>" required>
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
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($roinvents as $roinvent): ?>
                  <tr>
                    <td><?=$roinvent['roomInventoryID']?></td>
                    <td><?=$roinvent['ProductName']?></td>
                    <td><?=$roinvent['Quantity']?></td>
                    <td><?=$roinvent['Price']?></td>
                    <td><?=$roinvent['TotalPrice']?></td>
                    <th><a class="btn btn-danger" href="/deleteProduct/<?= $roinvent['roomInventoryID']?>">Delete</a> <a class="btn btn-info" data-toggle="modal" data-target="#editModal<?=$roinvent['roomInventoryID']?>">Edit</a></th>
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
