
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
                                          <input type="number" class="form-control" id="ContactNumber" name="ContactNumber" value="<?= $walkin['ContactNumber'] ?>" >
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

    // Create a new jsPDF instance for 4x6 inch paper size
    var doc = new jsPDF({
      unit: 'in', 
      format: [4, 6] 
    });

    // Load the logo image
    const logoImg = new Image();
    logoImg.src = '<?=base_url()?>guest/images/mahaltalogooo.png'; 

    // Ensure image loads before adding to the PDF
    logoImg.onload = function() {
      const paperWidth = 4; 
      const paperHeight = 6; 
      const bgLogoWidth = paperWidth; 
      const bgLogoHeight = (bgLogoWidth / logoImg.width) * logoImg.height; 

      // Set 30% opacity for a blurred background effect
      doc.setGState(new doc.GState({ opacity: 0.3 })); 
      doc.addImage(logoImg, 'PNG', 0, (paperHeight - bgLogoHeight) / 2, bgLogoWidth, bgLogoHeight);

      // Reset opacity to normal
      doc.setGState(new doc.GState({ opacity: 1 }));

      // Document title and content offset
      const contentOffsetY = 0.5; 

      // Title
      doc.setFontSize(18);
      doc.setFont('helvetica', 'bold');
      doc.text("Acknowledgment Receipt", paperWidth / 2, contentOffsetY, null, null, 'center');

      // Greeting
      doc.setFontSize(10);
      doc.setFont('helvetica', 'normal');
      doc.text("Thank you for choosing Mahalta Resorts!", paperWidth / 2, contentOffsetY + 0.3, null, null, 'center');


      // Walk-in information
      doc.setFontSize(9); 
      const leftMargin = 0.3; 
      const lineHeight = 0.15; 

      // Set bold font for labels
      doc.setFont('helvetica', 'bold');
      doc.text("Name:", leftMargin, contentOffsetY + 0.7);
      doc.text("Contact:", leftMargin, contentOffsetY + 0.7 + lineHeight);
      doc.text("Room Name:", leftMargin, contentOffsetY + 0.7 + lineHeight * 2);
      doc.text("Check-In:", leftMargin, contentOffsetY + 0.7 + lineHeight * 3);
      doc.text("Check-Out:", leftMargin, contentOffsetY + 0.7 + lineHeight * 4);
      doc.text("Adults:", leftMargin, contentOffsetY + 0.7 + lineHeight * 5);
      doc.text("Kids:", leftMargin, contentOffsetY + 0.7 + lineHeight * 6);
      doc.text("Amenities Product:", leftMargin, contentOffsetY + 0.7 + lineHeight * 7);
      doc.text("Quantity:", leftMargin, contentOffsetY + 0.7 + lineHeight * 8);
      doc.text("Total Amount:", leftMargin, contentOffsetY + 0.7 + lineHeight * 9);

      // Set normal font for the content
      doc.setFont('helvetica', 'normal');
      doc.text(walkin.FirstName + " " + walkin.LastName, leftMargin + 1.4, contentOffsetY + 0.7);
      doc.text(walkin.ContactNumber, leftMargin + 1.4, contentOffsetY + 0.7 + lineHeight);
      doc.text(walkin.RoomType, leftMargin + 1.4, contentOffsetY + 0.7 + lineHeight * 2);
      doc.text(walkin.CheckIn, leftMargin + 1.4, contentOffsetY + 0.7 + lineHeight * 3);
      doc.text(walkin.CheckOut, leftMargin + 1.4, contentOffsetY + 0.7 + lineHeight * 4);
      doc.text(walkin.Adult, leftMargin + 1.4, contentOffsetY + 0.7 + lineHeight * 5);
      doc.text(walkin.Child, leftMargin + 1.4, contentOffsetY + 0.7 + lineHeight * 6);
      doc.text(walkin.ProductNames, leftMargin + 1.4, contentOffsetY + 0.7 + lineHeight * 7);
      doc.text(walkin.InsertQuantities, leftMargin + 1.4, contentOffsetY + 0.7 + lineHeight * 8);
      doc.text("Php" + walkin.TotalAmount, leftMargin + 1.4, contentOffsetY + 0.7 + lineHeight * 9);

       // Add Received By and Prepared By section
       const footerY = paperHeight - 2.5; // Position for footer
      doc.setFontSize(9);

       // Received by
       doc.text("Received by:", leftMargin, footerY);
      doc.setFont('helvetica', 'bold');
      const name = "MARIBETH BOTONES";
      doc.text(name, leftMargin, footerY + 0.2); 

      // Fixed underline width for both names
      const underlineWidth = 1.5; // Set a fixed width for the underline
      
      // Add underline for MARIBETH BOTONES
      doc.setLineWidth(0.01); 
      doc.line(leftMargin, footerY + 0.25, leftMargin + underlineWidth, footerY + 0.25);
      
      doc.setFont('helvetica', 'normal');
      doc.text("General Manager", leftMargin, footerY + 0.35); 

      // Prepared by
      const rightMargin = paperWidth - 2; // Adjust for alignment on the right
      doc.text("Prepared by:", rightMargin, footerY);
      
      // Add matching underline for the Front Desk Officer, closer to the text
      const signatureLineY = footerY + 0.22;  // Adjusted Y to move the line closer
      doc.line(rightMargin, signatureLineY, rightMargin + underlineWidth, signatureLineY); // Use the same underline width
      doc.setFont('helvetica', 'normal');
      doc.text("Front Desk Officer", rightMargin, footerY + 0.35);

      // Closing Quote in royal blue
      doc.setFontSize(12);
      doc.setTextColor(65, 105, 225); 
      doc.text('"Your comfort is our priority."', paperWidth / 2, paperHeight - 0.8, null, null, 'center');

      // Reset text color to black for footer
      doc.setTextColor(0, 0, 0); 

      // Footer Information
      const footerText = 'Mahalta Resorts and Convention Center\nBrgy, Parang Calapan City, Oriental Mindoro, 5200-Philippines\nMobile no. 096812480329, Email: mahaltaresorts@gmail.com';
      doc.setFontSize(8);
      doc.text(footerText, paperWidth / 2, paperHeight - 0.3, null, null, 'center');

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
