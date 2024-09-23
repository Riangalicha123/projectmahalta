
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
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <?php include('include/navbar.php'); ?>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?=base_url()?>admin/index3.html" class="brand-link">
      <img src="<?=base_url()?>admin/dist/img/mahaltalogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    </a>
    <?php include('include/sidebar.php'); ?>
  </aside>
  <div class="content-wrapper">
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Amenities</h1>
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
    <div class="col-md-12 text-center">
      <div class="mb-5 element-animate">
        <h6><b>--ADD ONS--</b></h6>
        <h1><b>Choose your Additional</b></h1>
      </div>    
    </div>
    <div class="row">
      <div class="col-md-12">
        <form method="post" action="<?= base_url('/staff-walkin-availability/dataroomreservation/addAmenities') ?>">
        <div class="table-responsive">
            <table class="table">
              <thead style="background: linear-gradient(to bottom,#00BFFF, white);">
                <tr>
                  <th>Select</th>
                  <th>Product Name</th>
                  <th>Price</th>
                  <th>Quantity</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($roinvents as $roinvent): ?>
                  <?php if ($roinvent['Quantity'] > 0): ?>
                    <tr style="border-bottom: 1px solid #000;">
                      <td>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="roomInventoryID[]" name="roomInventoryID[]" value="<?= $roinvent['roomInventoryID'] ?>">
                          <input type="hidden" name="roinvents[<?= $roinvent['roomInventoryID'] ?>][ProductName]" value="<?= $roinvent['ProductName'] ?>">
                          <input type="hidden" name="roinvents[<?= $roinvent['roomInventoryID'] ?>][Price]" value="<?= $roinvent['Price'] ?>">
                        </div>
                      </td>
                      <td><?= $roinvent['ProductName'] ?></td>
                      <td>Php<?= $roinvent['Price'] ?></td>
                      <td>
                        <select class="form-control" name="insertQuantity[<?= $roinvent['roomInventoryID'] ?>]">
                          <?php for ($i = 0; $i <= $roinvent['Quantity']; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                          <?php endfor; ?>
                        </select>
                        <?php if ($roinvent['Quantity'] <= 10): ?>
                          <span style="color: red;">Warning: Only <?= $roinvent['Quantity'] ?> left in stock!</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endif; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary" style="width: 250px;">Submit</button>
            <button type="submit" name="skip" value="true" class="btn btn-secondary" style="width: 250px;">Skip</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

  </div>

  <?php include('include/footer.php'); ?>
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
