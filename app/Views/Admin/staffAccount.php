
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
            <h1>Staff Account</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Staff Account</li>
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
                <h3 class="card-title">Room Services</h3>
              </div>
              <div class="card-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Add
                    </button>
                    <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Add Staff</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/admin-addstaffdetails" method="post" enctype="multipart/form-data">
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
                                <div class="form-group">
                                    <label for="Email">Email</label>
                                    <input type="email" class="form-control" id="Email" name="Email" required>
                                </div>
                                <div class="form-row">
                                      <div class="form-group col-md-6">
                                          <label for="Password">Password</label>
                                          <input type="password" class="form-control" id="Password" name="Password" required>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="confirmPassword">Confirm Password</label>
                                          <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                      </div>
                                </div>
                                <div class="form-row">
                                      <div class="form-group col-md-6">
                                          <label for="ContactNumber">Contact Number</label>
                                          <input type="number" class="form-control" id="ContactNumber" name="ContactNumber" required>
                                      </div>
                                      <div class="form-group col-md-6">
                                      <h5 class="text-center text-primary">Address</h5>
                                      <select id="Region" class="form-control form-control-lg" name="Region">
                                          <option value="">Select Region</option>
                                          <?php foreach ($regions as $region): ?>
                                              <option value="<?= $region['regCode'] ?>"><?= $region['regDesc'] ?></option>
                                          <?php endforeach ?>
                                      </select>

                                      <select id="province_id" class="form-control form-control-lg" name="Province">
                                          <option value="">Select Province</option>
                                      </select>
                                      <select id="cities_id" class="form-control form-control-lg" name="City">
                                          <option value="">Select City/Municipality</option>
                                      </select>
                                      <select id="barangay_id" class="form-control form-control-lg" name="Barangay">
                                          <option value="">Select Barangay</option>
                                      </select>
                                  </div>

                                </div>
                                <div class="form-group">
                                    <label for="DepartmentName">Department</label>
                                    <select class="custom-select form-control-border" id="DepartmentName" name="DepartmentName" required>
                                        <option>Convention</option>
                                        <option>Hotel</option>
                                        <option>Restaurant</option>
                                        <option>Inventory</option>
                                    </select>
                                </div>  
                                </div>
                                <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($staffs as $staff): ?>
                    <div class="modal fade" id="editModal<?=$staff['StaffDetailsID']?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?=$staff['StaffDetailsID']?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?=$staff['StaffDetailsID']?>">Edit Staff</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= base_url('/updateStaffDetails/' . $staff['StaffDetailsID']) ?>" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" name="StaffDetailsID" id="StaffDetailsID" value="<?= $staff['StaffDetailsID'] ?>">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="FirstName">First Name</label>
                                                <input type="text" class="form-control" id="FirstName" name="FirstName" required value="<?= $staff['FirstName'] ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="LastName">Last Name</label>
                                                <input type="text" class="form-control" id="LastName" name="LastName" required value="<?= $staff['LastName'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="Email">Email</label>
                                            <input type="email" class="form-control" id="Email" name="Email" required value="<?= $staff['Email'] ?>">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="ContactNumber">Contact Number</label>
                                                <input type="number" class="form-control" id="ContactNumber" name="ContactNumber" required value="<?= $staff['ContactNumber'] ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="Address">Address</label>
                                                <input type="text" class="form-control" id="Address" name="Address" required value="<?= $staff['Address'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="DepartmentName">Department</label>
                                            <select class="custom-select form-control-border" id="DepartmentName" name="DepartmentName" required>
                                                <option <?= ($staff['DepartmentName'] == 'Convention') ? 'selected' : '' ?>>Convention</option>
                                                <option <?= ($staff['DepartmentName'] == 'Hotel') ? 'selected' : '' ?>>Hotel</option>
                                                <option <?= ($staff['DepartmentName'] == 'Restaurant') ? 'selected' : '' ?>>Restaurant</option>
                                                <option <?= ($staff['DepartmentName'] == 'Inventory') ? 'selected' : '' ?>>Inventory</option>
                                            </select>
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
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>Department</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($staffs as $staff): ?>
                  <tr>
                    <td><?=$staff['FirstName']?></td>
                    <td><?=$staff['LastName']?></td>
                    <td><?=$staff['Email']?></td>
                    <td><?=$staff['ContactNumber']?></td>
                    <td><?=$staff['Address']?></td>
                    <td><?=$staff['DepartmentName']?></td>
                    <th><a href="<?= base_url('/admin-staffaccounts/delete/' . $staff['StaffDetailsID']); ?>" 
   class="btn btn-danger" 
   onclick="return confirm('Are you sure you want to delete this staff?');">
   Delete
</a> <a class="btn btn-info" data-toggle="modal" data-target="#editModal<?=$staff['StaffDetailsID']?>">Edit</a></th>
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
<script>
    $(document).ready(function(){
        $('#Region').change(function(event){
            var idRegion = this.value; 
            $('#province_id').html(''); 

            $.ajax({
                url: "/fetch-province",
                type: 'POST',
                dataType: 'json',
                data: {regCode: idRegion}, 
                success:function(response){
                    $('#province_id').html('<option value="">Select Province</option>'); 
                    $.each(response.provinces,function(index, val){
                        $('#province_id').append('<option value="'+val.provCode+'">'+val.provDesc+'</option>'); 
                    });

                }
            });
        });

        $('#province_id').change(function(event){
            var idProvince = this.value;
            $('#cities_id').html(''); 

            $.ajax({
                url: "/fetch-city",
                type: 'POST',
                dataType: 'json',
                data: {provCode: idProvince}, 
                success:function(response){
                    $('#cities_id').html('<option value="">Select City/Municipality</option>'); 
                    $.each(response.cities,function(index, val){
                        $('#cities_id').append('<option value="'+val.citymunCode+'">'+val.citymunDesc+'</option>'); 
                    });
                }
            });
        });

        $('#cities_id').change(function(event){
            var idCity = this.value; 
            $('#barangay_id').html(''); 

            $.ajax({
                url: "/fetch-barangay",
                type: 'POST',
                dataType: 'json',
                data: {citymunCode: idCity}, 
                success:function(response){
                    $('#barangay_id').html('<option value="">Select Barangay</option>'); 
                    $.each(response.barangays,function(index, val){
                        $('#barangay_id').append('<option value="'+val.brgyCode+'">'+val.brgyDesc+'</option>'); 
                    });
                    
                }
            });
        });
    });
</script>
</body>
</html>
