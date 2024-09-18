
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
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
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
            <h1>Walk In Records</h1>
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
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Walk In Records</h3>
              </div>
              <div class="card-body">
              <?php foreach ($walkins as $walkin): ?>
                    <div class="modal fade" id="editModal<?=$walkin['walkinID']?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?=$walkin['walkinID']?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?=$walkin['walkinID']?>">Edit Walk-In</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= base_url('/admin-hotel/walkin-availability/dataroomreservation/amenities/formdetails/updateReservation/' . $walkin['walkinID']) ?>" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" name="walkinID" id="walkinID" value="<?= $walkin['walkinID'] ?>">
                                        <div class="form-row">
                                      <div class="form-group col-md-6">
                                          <label for="FirstName">First Name</label>
                                          <input type="text" class="form-control" id="FirstName" name="FirstName" value="<?= $walkin['FirstName'] ?>" required>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="LastName">Last Name</label>
                                          <input type="text" class="form-control" id="LastName" name="LastName" value="<?= $walkin['LastName'] ?>" required>
                                      </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                          <label for="ContactNumber">Contact Number</label>
                                          <input type="number" class="form-control" id="ContactNumber" name="ContactNumber" value="<?= $walkin['ContactNumber'] ?>" required>
                                      </div>
                                      
                                  </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                            <label for="RoomType">Room Type</label>
                                            <select class="custom-select form-control-border" id="RoomType" name="RoomType" value="<?=$walkin['RoomType']?>"required>
                                      <option <?= ($walkin['RoomType'] == 'Deluxe Room(Ruben)') ? 'selected' : '' ?>>Deluxe Room(Ruben)</option>
                                      <option <?= ($walkin['RoomType'] == 'Deluxe Room(Baby)') ? 'selected' : '' ?>>Deluxe Room(Baby)</option>
                                      <option <?= ($walkin['RoomType'] == 'Deluxe Room(Siony)') ? 'selected' : '' ?>>Deluxe Room(Siony)</option>
                                      <option <?= ($walkin['RoomType'] == 'Deluxe Room(Carlo)') ? 'selected' : '' ?>>Deluxe Room(Carlo)</option>
                                      <option <?= ($walkin['RoomType'] == 'Deluxe Room(Lyra)') ? 'selected' : '' ?>>Deluxe Room(Lyra)</option>
                                      <option <?= ($walkin['RoomType'] == 'Deluxe Room(Lyca)') ? 'selected' : '' ?>>Deluxe Room(Lyca)</option>
                                      <option <?= ($walkin['RoomType'] == 'Deluxe Room(Lambert)') ? 'selected' : '' ?>>Deluxe Room(Lambert)</option>
                                      <option <?= ($walkin['RoomType'] == 'Deluxe Room(Lyza)') ? 'selected' : '' ?>>Deluxe Room(Lyza)</option>
                                      <option <?= ($walkin['RoomType'] == 'Jr. Suite Room(Lyne)') ? 'selected' : '' ?>>Jr. Suite Room(Lyne)</option>
                                      <option <?= ($walkin['RoomType'] == 'Jr. Suite Room(Carl)') ? 'selected' : '' ?>>Jr. Suite Room(Carl)</option>
                                      <option <?= ($walkin['RoomType'] == 'Family Room(Balansig)') ? 'selected' : '' ?>>Family Room(Balansig)</option>
                                      <option <?= ($walkin['RoomType'] == 'Family Room(Limbaga)') ? 'selected' : '' ?>>Family Room(Limbaga)</option>
                                      <option <?= ($walkin['RoomType'] == 'Barkada Room(Babaylan)') ? 'selected' : '' ?>>Barkada Room(Babaylan)</option>
                                      <option <?= ($walkin['RoomType'] == 'Barkada Room(Tribo)') ? 'selected' : '' ?>>Barkada Room(Tribo)</option>
                                    </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="CheckIn">Arrival</label>
                                                <input type="datetime-local" class="form-control" id="CheckIn" name="CheckIn" required value="<?= date('Y-m-d\TH:i', strtotime($walkin['CheckIn'])) ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="CheckOut">Departure</label>
                                                <input type="datetime-local" class="form-control" id="CheckOut" name="CheckOut" required value="<?= date('Y-m-d\TH:i', strtotime($walkin['CheckOut'])) ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="form-group col-md-6">
                                                <label for="Adult">Adult</label>
                                                <input type="number" class="form-control" id="Adult" name="Adult" value="<?= $walkin['Adult'] ?>" required>
                                        </div>
                                            <div class="form-group col-md-6">
                                                <label for="Child">Child</label>
                                                <input type="number" class="form-control" id="Child" name="Child" value="<?= $walkin['Child'] ?>" required>
                                            </div>
                                    </div>
                                    <div class="form-row">
                
                                        <div class="form-group col-md-6">
                                            <label for="TotalAmount">Total Amount</label>
                                            <input type="number" class="form-control" id="TotalAmount" name="TotalAmount" required value="<?= $walkin['TotalAmount'] ?>">
                                        </div>
                                    </div>

                                        <!-- ProductName and InsertQuantity Section -->
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Room Inventory</label>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Insert Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Assuming $roomInventories contains all room inventory items
                                        foreach ($roomInventories as $roinvent) :
                                            // Check if the product is already selected
                                            $isChecked = in_array($roinvent['ProductName'], explode(', ', $walkin['ProductNames']));
                                            $selectedQuantity = array_search($roinvent['ProductName'], explode(', ', $walkin['ProductNames'])) !== false ? explode(', ', $walkin['InsertQuantities'])[array_search($roinvent['ProductName'], explode(', ', $walkin['ProductNames']))] : 0;
                                            $availableQuantity = 100; // Replace with actual available quantity
                                        ?>
                                            <tr style="border-bottom: 1px solid #000;">
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="roomInventoryID[]" name="roomInventoryID[]" value="<?= $roinvent['roomInventoryID'] ?>" <?= $isChecked ? 'checked' : '' ?>>
                                                        <input type="hidden" name="roinvents[<?= $roinvent['roomInventoryID'] ?>][ProductName]" value="<?= $roinvent['ProductName'] ?>">
                                                        <input type="hidden" name="roinvents[<?= $roinvent['roomInventoryID'] ?>][Price]" value="<?= $roinvent['Price'] ?>">
                                                    </div>
                                                </td>
                                                <td><?= $roinvent['ProductName'] ?></td>
                                                <td>Php<?= $roinvent['Price'] ?></td>
                                                <td>
                                                    <select class="form-control" name="insertQuantity[<?= $roinvent['roomInventoryID'] ?>]">
                                                        <?php for ($i = 0; $i <= $availableQuantity; $i++) : ?>
                                                            <option value="<?= $i ?>" <?= $i == $selectedQuantity ? 'selected' : '' ?>><?= $i ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                    <?php if ($availableQuantity <= 10): ?>
                                                        <span style="color: red;">Warning: Only <?= $availableQuantity ?> left in stock!</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th>ContactNumber</th>
                    <th>Room Name</th>
                    <th>AmenitiesProduct</th>
                    <th>Quantity</th>
                    <th>CheckIn</th>
                    <th>CheckOut</th>
                    <th>Adult</th>
                    <th>Kid</th>
                    <th>Discount</th>
                    <th>TotalAmount</th>
                    <th>Action</th>
                    <th>Receipt</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($walkins as $walkin): ?>
                  <tr>
                    <td><?=$walkin['FirstName']?></td>
                    <td><?=$walkin['LastName']?></td>
                    <td><?=$walkin['ContactNumber']?></td>
                    <td><?=$walkin['RoomType']?></td>
                    <td><?=$walkin['ProductNames']?></td>
                    <td><?=$walkin['InsertQuantities']?></td>
                    <td><?=$walkin['CheckIn']?></td>
                    <td><?=$walkin['CheckOut']?></td>
                    <td><?=$walkin['Adult']?></td>
                    <td><?=$walkin['Child']?></td>
                    <td><?=$walkin['Discount']?></td>
                    <td><?=$walkin['TotalAmount']?></td>
                    <td><a class="btn btn-info" data-toggle="modal" data-target="#editModal<?=$walkin['walkinID']?>">Edit</a></td>
                    <td><button class="btn btn-primary" onclick="generatePDF(<?=$walkin['walkinID']?>)">Print</button></td>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script>
  function generatePDF(walkinID) {
    // Get the data for the specific walkinID
    var walkinData = <?=json_encode($walkins)?>;
    var walkin = walkinData.find(w => w.walkinID == walkinID);

    // Import jsPDF library
    const { jsPDF } = window.jspdf;

    // Create a new jsPDF instance
    var doc = new jsPDF();

    // Load the logo image
    const logoImg = new Image();
    logoImg.src = '<?=base_url()?>guest/images/logomahalta.png'; // Path to your logo image

    // Ensure image loads before adding to the PDF
    logoImg.onload = function() {
      // Calculate the logo size
      const logoWidth = 40; // Adjust logo width as needed
      const logoHeight = (logoWidth / logoImg.width) * logoImg.height;
      const paperWidth = doc.internal.pageSize.getWidth();
      const paperHeight = doc.internal.pageSize.getHeight();
      const scaledFontSize = 20; // Adjust based on font size

      // Add the logo to the top-right corner
      doc.addImage(logoImg, 'PNG', paperWidth - logoWidth - 10, 10, logoWidth, logoHeight);

      // Document title
      doc.setFontSize(16);
      doc.text("Receipt for Walk-in", 20, 30);

      // Walk-in information
      doc.setFontSize(12);
      doc.text("Name: " + walkin.FirstName + " " + walkin.LastName, 20, 50);
      doc.text("Contact: " + walkin.ContactNumber, 20, 60);
      doc.text("Room Name: " + walkin.RoomType, 20, 70);
      doc.text("Check-In: " + walkin.CheckIn, 20, 80);
      doc.text("Check-Out: " + walkin.CheckOut, 20, 90);
      doc.text("Adults: " + walkin.Adult, 20, 100);
      doc.text("Kids: " + walkin.Child, 20, 110);
      doc.text("Amenities Product: " + walkin.ProductNames, 20, 120);
      doc.text("Quantity: " + walkin.InsertQuantities, 20, 130);
      doc.text("Total Amount: " + walkin.TotalAmount, 20, 140);

      // Footer Information
      const footerText = 'Mahalta Resorts and Convention Center\nBrgy,Parang Calapan City,Oriental Mindoro,5200-Philippines\nMobile no. 096812480329, Email: mahaltaresorts@gmail.com';
      doc.setFontSize(10);
      doc.text(footerText, paperWidth / 2, paperHeight - scaledFontSize, null, null, 'center');

      // Save the PDF
      doc.save("Walkin_Receipt_" + walkin.FirstName + "_" + walkin.LastName + ".pdf");
    };
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
      "buttons": ["excel","colvis"]
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
