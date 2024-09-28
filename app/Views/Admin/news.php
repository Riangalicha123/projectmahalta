
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
<?php include('include/loader.php') ?>
  <?php include('include/navbar.php') ?>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php include('include/logo.php') ?>
    <?php include('include/sidebar.php') ?>
  </aside>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>News-Promotion</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">News-Promotion</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="card card-solid">
        <div class="card-body pb-0">
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addnewsModal">
            Add
          </button>
          <div class="row">
          <?php foreach ($news as $new): ?>
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                <img src="<?=base_url('/news/'. $new['Image'])?>" alt="user-avatar" style="width:350px;height:380px;">
                </div>
                <div class="card-footer">
                  <div class="text-right">
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editnewsModal<?=$new['NewsID']?>">
                    Update 
                  </button>
                  <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $new['NewsID'] ?>)">
                  Delete
                  </button>
                  </div>
                  <div class="modal fade" id="addnewsModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add News</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="/admin-addnewspromotion" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                          <div class="form-group">
                            <input type="hidden" class="form-control" id="NewsID" name="NewsID" placeholder="Enter Name" >
                          </div> 
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" name="Image" accept="image/*" >
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="modal fade" id="editnewsModal<?=$new['NewsID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$new['NewsID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$new['NewsID']?>">Update News</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="/admin-editnewspromotion" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                              <input type="hidden" name="NewsID" id="NewsID" value="<?=$new['NewsID']?>">
                              <div class="form-group">
                                  <label for="Image">Upload</label>
                                  <input type="file" class="form-control" name="Image" accept="image/*">
                              </div>
                          </div>
                          <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>  
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
<script>
    function confirmDelete(newsID) {
        if (confirm('Are you sure you want to delete this news?')) {
            window.location.href = '/deleteNews/' + newsID;
        }
    }
</script>

</body>
</html>
