
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
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <style>
    #messageContainer {
    display: none;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
}

.success {
    background-color: #d4edda; 
    color: #155724; 
}

.error {
    background-color: #f8d7da; 
    color: #721c24;
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
            <h1>Hotel Reservation</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Hotel</a></li>
              <li class="breadcrumb-item active">Reservation</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
          <?php
            $session = session();
            $successMessage = $session->getFlashdata('success');
            ?>
            <?php if($successMessage): ?>
                <div class="alert alert-success">
                    <?= $successMessage ?>
                </div>
            <?php endif; ?>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Reservation</h3>
              </div>
              <div class="card-body">
              
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Contact No.</th>
                    <th>Address</th>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Adult</th>
                    <th>Child</th>
                    <th>Amenities</th>
                    <th>Quantity</th>
                    <th>Payment Option</th>
                    <th>Reference No.</th>
                    <th>Down or Full Payment</th>
                    <th>TotalAmount</th>
                    <th>Proof Image</th>
                    <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($amihotelrevs as $amihotelrev): ?>
                    <tr>
                    <td><?=$amihotelrev['FirstName']?></td>
                    <td><?=$amihotelrev['LastName']?></td>
                    <td><?=$amihotelrev['ContactNumber']?></td>
                    <td><?=$amihotelrev['Address']?></td>
                    <td><?=$amihotelrev['RoomNumber']?></td>
                    <td><?=$amihotelrev['RoomType']?></td>
                    <td><?=$amihotelrev['CheckInDate']?></td>
                    <td><?=$amihotelrev['CheckOutDate']?></td>
                    <td><?=$amihotelrev['Adult']?></td>
                    <td><?=$amihotelrev['Child']?></td>
                    <td><?=$amihotelrev['ProductNames']?></td>
                    <td><?=$amihotelrev['InsertQuantities']?></td>
                    <td><?=$amihotelrev['PaymentOption']?></td>
                    <td><?=$amihotelrev['ReferenceNumber']?></td>
                    <td><?=$amihotelrev['downorfullPayment']?></td>
                    <td><?=$amihotelrev['TotalAmount']?></td>
                    <td><img style="width: 200px; height: 200px;" src="<?=base_url('/proof/'.$amihotelrev['Image'])?>" alt="#"/></td>
                    <td class="project-state">
                        <?php
                        $badgeClass = '';

                        switch ($amihotelrev['Status']) {
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
                                $badgeClass = 'badge-secondary';
                        }
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= $amihotelrev['Status'] ?></span>
                    </td>
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

  <?php include(__DIR__ . '/../../Admin/include/footer.php'); ?>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<script>
function showMessage(message, type) {
    const messageContainer = document.getElementById('messageContainer');
    messageContainer.textContent = message;
    messageContainer.className = type;
    messageContainer.style.display = 'block';
    setTimeout(function() {
        messageContainer.style.display = 'none';
    }, 5000);
}

if (sessionStorage.getItem('success')) {
    showMessage(sessionStorage.getItem('success'), 'success');
}

if (sessionStorage.getItem('error')) {
    showMessage(sessionStorage.getItem('error'), 'error');
}

</script>
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
      "buttons": ["excel", "colvis"]
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
