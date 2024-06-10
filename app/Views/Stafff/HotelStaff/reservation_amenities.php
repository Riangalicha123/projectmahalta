
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
    <a href="<?=base_url()?>admin/index3.html" class="brand-link elevation-4">
      <img src="<?=base_url()?>admin/dist/img/mahaltalogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    </a>
    <?php include('include/sidebar.php') ?>
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
                            <form action="<?= base_url('/addHotelReservation') ?>" method="post" enctype="multipart/form-data">
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
                                    <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="CheckInDate">Arrival</label>
                                                <input type="datetime-local" class="form-control" id="CheckInDate" name="CheckInDate" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="CheckOutDate">Departure</label>
                                                <input type="datetime-local" class="form-control" id="CheckOutDate" name="CheckOutDate" required>
                                            </div>
                                        </div>
                                    <div class="form-row">
                                      <div class="form-group col-md-6">
                                        <label for="RoomNumber">Room Type</label>
                                          <select class="custom-select form-control-border" id="RoomNumber" name="RoomNumber" required>
                                            <option>D1</option>
                                            <option>D2</option>
                                            <option>D3</option>
                                            <option>D4</option>
                                            <option>D5</option>
                                            <option>D6</option>
                                            <option>D7</option>
                                            <option>D8</option>
                                            <option>S1</option>
                                            <option>S2</option>
                                            <option>F1</option>
                                            <option>F2</option>
                                            <option>B1</option>
                                            <option>B2</option>
                                          </select>
                                      </div>
                                      <div class="form-group col-md-6">
                                        <label for="RoomType">Room Type</label>
                                            <select class="custom-select form-control-border" id="RoomType" name="RoomType" required>
                                              <option>Deluxe Room(Ruben)</option>
                                              <option>Deluxe Room(Baby)</option>
                                              <option>Deluxe Room(Siony)</option>
                                              <option>Deluxe Room(Carlo)</option>
                                              <option>Deluxe Room(Lyra)</option>
                                              <option>Deluxe Room(Lyca)</option>
                                              <option>Deluxe Room(Lambert)</option>
                                              <option>Deluxe Room(Lyza)</option>
                                              <option>Jr. Suite Room(Lyne)</option>
                                              <option>Jr. Suite Room(Carl)</option>
                                              <option>Family Room(Balansig)</option>
                                              <option>Family Room(Limbaga)</option>
                                              <option>Barkada Room(Babaylan)</option>
                                              <option>Barkada Room(Tribo)</option>
                                            </select>
                                      </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                                <label for="Adult">Adult</label>
                                                <input type="number" class="form-control" id="Adult" name="Adult" value="0" required>
                                        </div>
                                            <div class="form-group col-md-6">
                                                <label for="Child">Child</label>
                                                <input type="number" class="form-control" id="Child" name="Child" value="0" required>
                                            </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                        <label for="PaymentOption">Payment Option</label>
                                            <select class="custom-select form-control-border" id="PaymentOption" name="PaymentOption" required>
                                              <option>gcash</option>
                                              <option>paymaya</option>
                                            </select>
                                      </div>
                                        <div class="form-group col-md-6">
                                                <label for="ReferenceNumber">Reference No.</label>
                                                <input type="text" class="form-control" id="ReferenceNumber" name="ReferenceNumber" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="form-group col-md-6">
                                                <label for="downorfullPayment">Down or Full Payment</label>
                                                <input type="number" class="form-control" id="downorfullPayment" name="downorfullPayment" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="TotalAmount">Total Amounts</label>
                                                <input type="number" class="form-control" id="TotalAmount" name="TotalAmount" required>
                                            </div>
                                        </div>
                                </div>
                                <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($amihotelrevs as $amihotelrev): ?>
                    <div class="modal fade" id="editModal<?=$amihotelrev['AmenitiesID']?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?=$amihotelrev['AmenitiesID']?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?=$amihotelrev['AmenitiesID']?>">Edit Reservation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= base_url('/updatehotelamenitiesReservation/' . $amihotelrev['AmenitiesID']) ?>" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" name="AmenitiesID" id="AmenitiesID" value="<?= $amihotelrev['AmenitiesID'] ?>">
                                        <div class="form-row">
                                      <div class="form-group col-md-6">
                                          <label for="FirstName">First Name</label>
                                          <input type="text" class="form-control" id="FirstName" name="FirstName" value="<?= $amihotelrev['FirstName'] ?>" required>
                                      </div>
                                      <div class="form-group col-md-6">
                                          <label for="LastName">Last Name</label>
                                          <input type="text" class="form-control" id="LastName" name="LastName" value="<?= $amihotelrev['LastName'] ?>" required>
                                      </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                          <label for="ContactNumber">Contact Number</label>
                                          <input type="number" class="form-control" id="ContactNumber" name="ContactNumber" value="<?= $amihotelrev['ContactNumber'] ?>" required>
                                      </div>
                                      
                                  </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                            <label for="RoomNumber">Room No.</label>
                                            <select class="custom-select form-control-border" id="RoomNumber" name="RoomNumber" required>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'D1') ? 'selected' : '' ?>>D1</option>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'D2') ? 'selected' : '' ?>>D2</option>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'D3') ? 'selected' : '' ?>>D3</option>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'D4') ? 'selected' : '' ?>>D4</option>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'D5') ? 'selected' : '' ?>>D5</option>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'D6') ? 'selected' : '' ?>>D6</option>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'D7') ? 'selected' : '' ?>>D7</option>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'D8') ? 'selected' : '' ?>>D8</option>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'S1') ? 'selected' : '' ?>>S1</option>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'S2') ? 'selected' : '' ?>>S2</option>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'F1') ? 'selected' : '' ?>>F1</option>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'F2') ? 'selected' : '' ?>>F2</option>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'B1') ? 'selected' : '' ?>>B1</option>
                                                <option <?= ($amihotelrev['RoomNumber'] == 'B2') ? 'selected' : '' ?>>B2</option>
                                            </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                            <label for="RoomType">Room Type</label>
                                            <select class="custom-select form-control-border" id="RoomType" name="RoomType" value="<?=$amihotelrev['RoomType']?>"required>
                                      <option <?= ($amihotelrev['RoomType'] == 'Deluxe Room(Ruben)') ? 'selected' : '' ?>>Deluxe Room(Ruben)</option>
                                      <option <?= ($amihotelrev['RoomType'] == 'Deluxe Room(Baby)') ? 'selected' : '' ?>>Deluxe Room(Baby)</option>
                                      <option <?= ($amihotelrev['RoomType'] == 'Deluxe Room(Siony)') ? 'selected' : '' ?>>Deluxe Room(Siony)</option>
                                      <option <?= ($amihotelrev['RoomType'] == 'Deluxe Room(Carlo)') ? 'selected' : '' ?>>Deluxe Room(Carlo)</option>
                                      <option <?= ($amihotelrev['RoomType'] == 'Deluxe Room(Lyra)') ? 'selected' : '' ?>>Deluxe Room(Lyra)</option>
                                      <option <?= ($amihotelrev['RoomType'] == 'Deluxe Room(Lyca)') ? 'selected' : '' ?>>Deluxe Room(Lyca)</option>
                                      <option <?= ($amihotelrev['RoomType'] == 'Deluxe Room(Lambert)') ? 'selected' : '' ?>>Deluxe Room(Lambert)</option>
                                      <option <?= ($amihotelrev['RoomType'] == 'Deluxe Room(Lyza)') ? 'selected' : '' ?>>Deluxe Room(Lyza)</option>
                                      <option <?= ($amihotelrev['RoomType'] == 'Jr. Suite Room(Lyne)') ? 'selected' : '' ?>>Jr. Suite Room(Lyne)</option>
                                      <option <?= ($amihotelrev['RoomType'] == 'Jr. Suite Room(Carl)') ? 'selected' : '' ?>>Jr. Suite Room(Carl)</option>
                                      <option <?= ($amihotelrev['RoomType'] == 'Family Room(Balansig)') ? 'selected' : '' ?>>Family Room(Balansig)</option>
                                      <option <?= ($amihotelrev['RoomType'] == 'Family Room(Limbaga)') ? 'selected' : '' ?>>Family Room(Limbaga)</option>
                                      <option <?= ($amihotelrev['RoomType'] == 'Barkada Room(Babaylan)') ? 'selected' : '' ?>>Barkada Room(Babaylan)</option>
                                      <option <?= ($amihotelrev['RoomType'] == 'Barkada Room(Tribo)') ? 'selected' : '' ?>>Barkada Room(Tribo)</option>
                                    </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="CheckInDate">Arrival</label>
                                                <input type="datetime-local" class="form-control" id="CheckInDate" name="CheckInDate" required value="<?= date('Y-m-d\TH:i', strtotime($amihotelrev['CheckInDate'])) ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="CheckOutDate">Departure</label>
                                                <input type="datetime-local" class="form-control" id="CheckOutDate" name="CheckOutDate" required value="<?= date('Y-m-d\TH:i', strtotime($amihotelrev['CheckOutDate'])) ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="form-group col-md-6">
                                                <label for="Adult">Adult</label>
                                                <input type="number" class="form-control" id="Adult" name="Adult" value="<?= $amihotelrev['Adult'] ?>" required>
                                        </div>
                                            <div class="form-group col-md-6">
                                                <label for="Child">Child</label>
                                                <input type="number" class="form-control" id="Child" name="Child" value="<?= $amihotelrev['Child'] ?>" required>
                                            </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                        <label for="PaymentOption">Payment Option</label>
                                            <select class="custom-select form-control-border" id="PaymentOption" name="PaymentOption" required>
                                            <option <?= ($amihotelrev['PaymentOption'] == 'gcash') ? 'selected' : '' ?>>gcash</option>
                                                <option <?= ($amihotelrev['PaymentOption'] == 'paymaya') ? 'selected' : '' ?>>paymaya</option>
                                            </select>
                                      </div>
                                        <div class="form-group col-md-6">
                                                <label for="ReferenceNumber">Reference No.</label>
                                                <input type="text" class="form-control" id="ReferenceNumber" name="ReferenceNumber" required value="<?= $amihotelrev['ReferenceNumber'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="downorfullPayment">Down or Full Payment</label>
                                                <input type="number" class="form-control" id="downorfullPayment" name="downorfullPayment" required value="<?= $amihotelrev['downorfullPayment'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="TotalAmount">Total Amounts</label>
                                                <input type="number" class="form-control" id="TotalAmount" name="TotalAmount" required value="<?= $amihotelrev['TotalAmount'] ?>">
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
                                            $isChecked = in_array($roinvent['ProductName'], explode(', ', $amihotelrev['ProductNames']));
                                            $selectedQuantity = array_search($roinvent['ProductName'], explode(', ', $amihotelrev['ProductNames'])) !== false ? explode(', ', $amihotelrev['InsertQuantities'])[array_search($roinvent['ProductName'], explode(', ', $amihotelrev['ProductNames']))] : 0;
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
                    <th>Action</th>
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
                    <td><a class="btn btn-info" data-toggle="modal" data-target="#editModal<?=$amihotelrev['AmenitiesID']?>">Edit</a></td>
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

  <!-- Control Sidebar -->
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
