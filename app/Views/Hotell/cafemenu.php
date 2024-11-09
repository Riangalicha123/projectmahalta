<!doctype html>
<html lang="en">
  <head>
    <title>Mahalta</title>
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900|Rubik:300,400,700" rel="stylesheet">

    <link rel="stylesheet" href="<?=base_url()?>guest/css/bootstrap.css">
    <link rel="stylesheet" href="<?=base_url()?>guest/css/animate.css">
    <link rel="stylesheet" href="<?=base_url()?>guest/css/owl.carousel.min.css">

    <link rel="stylesheet" href="<?=base_url()?>guest/fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?=base_url()?>guest/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url()?>guest/css/magnific-popup.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Theme Style -->
    <link rel="stylesheet" href="<?=base_url()?>guest/css/style.css">
    <style>
                .menu-record {
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.3s;
        }
        .menu-record img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .menu-record:hover img {
            transform: scale(1.1);
        }
        .menu-record:hover {
            transform: scale(1.05);
        }
        .menu-record div {
            padding: 15px;
        }
        .menu-record h3 {
            margin: 0;
            color: #333;
        }
        .menu-record p {
            margin: 10px 0;
            color: #999;
        }
    </style>
    <?= $this->renderSection('stylesheets') ?>
  </head>
  <body>
  <?php include('inc/header.php') ?>
  <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url('<?=base_url()?>guest/images/3.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh;">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">
          <br>
          <br>
          <br>
          <br>
            <div class="mb-1 element-animate" style="text-align: center;">
              <h1 style="font-size: 3em; margin-bottom: -5px;">Restaurant</h1>
               <p style="margin-bottom: -25px;">Savor the moment, indulge in flavor at Mahalta's Restaurant</p> 
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
              <div class="card text-white mb-1" style="background-color: rgba(135, 206, 235, 0.4); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; justify-content: flex-end; height: 100%;">
              <div class="card-header text-center">À la Carte Service</div>
                <div style="flex: 0 0 50%; ">
                    <p style="font-size: 1.2em;">  Monday-Thursday (7:00 PM - 9:00 PM)</p>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card text-white mb-1" style="background-color: rgba(135, 206, 235, 0.4); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; justify-content: flex-end; height: 100%;">
                <div class="card-header text-center">Buffet Service</div>
                <div style="display: flex; flex-wrap: wrap;">
                  <div style="flex: 0 0 50%; margin-bottom: -5px;">
                    <p style="font-size: 1.2em;">Friday-Saturday</p>
                  </div>
                  <div style="flex: 0 0 50%; margin-bottom: -5px;">
                    <p style="font-size: 1.2em;">Breakfast: 7:00 AM - 10:00 AM</p>
                  </div>
                  <div style="flex: 0 0 50%; margin-bottom: -5px;">
                    <p style="font-size: 1.2em;">Lunch: 12:00 PM - 3:00 PM</p>
                  </div>
                  <div style="flex: 0 0 50%; margin-bottom: -5px;">
                    <p style="font-size: 1.2em;">Dinner: 6:30 PM - 9:00 PM</p>
                  </div>
                </div>
              </div>
            </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="site-section "style="background-image: url(<?=base_url()?>guest/images/malabomahalta.jpg); background-repeat: no-repeat; background-size: cover;">
      <div class="container">
        <div class="row mb-5">
        </div>
        <div class="row ">
          <div class="col-md-7">
            <div class="media d-block room mb-0">
              <figure>
                <?php if (!empty($venues)): ?>
                <img src="<?=base_url('/uploads/'.$venues[0]['Image'])?>" alt="Generic placeholder image" class="img-fluid">
                <?php endif; ?>
              </figure>
              <div class="media-body">
                <?php if (!empty($venues)): ?>
                <h3 class="mt-0"><a ><?=$venues[0]['VenueName']?></a></h3>
                <?php endif; ?>
                <p>An inviting eatery offering a diverse menu of delicious dishes, our restaurant combines warm ambiance with attentive service for the guests.</p>
                <?php if(session()->get('isLoggedIn')): ?>
                <p>    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addFormModal">
                    Make Online Reservation
                </button></p> 
                <?php else: ?>
                    <p> 
                <a href="<?= base_url('/login') ?>" class="btn btn-primary btn-sm">Make Online Reservation</a></p> 
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-md-5 room-thumbnail-absolute">
          <?php if (!empty($venues)): ?>
            <a class="media d-block room bg first-room" style="background-image: url(<?=base_url('/uploads/'.$venues[1]['Image'])?>); ">
                <div class="overlap-text">
                  <span>
                  <?=$venues[1]['VenueName']?>
                  </span>
                </div>
            </a>
            <a class="media d-block room bg second-room" style="background-image: url(<?=base_url('/uploads/'.$venues[2]['Image'])?>); ">
                <div class="overlap-text">
                  <span>
                  <?=$venues[2]['VenueName']?>
                  </span>
                </div>
            </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
    <div class="modal fade" id="addFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:skyblue;">
                <h5 class="modal-title" id="exampleModalLabel">Reservation at Mahalta Resort</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('tableReservation') ?>" method="post" id="addItemForm">
                    <div id="page1">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="CheckInDate">Arrival Date</label>
                                <div style="position: relative;">
                                    <input type='text' class="form-control" id='CheckInDate' name="CheckInDate" placeholder="Check-In-Date" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="NumberOfGuests">Number Of Guests</label>
                                <select class="form-select form-control" id="NumberOfGuests" name="NumberOfGuests" onchange="updateVenueOptions()">
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="VenueName">Venue Name</label>
                                <select class="form-select form-control" id="VenueName" name="VenueName">
                                </select>
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <button type="button" class="btn btn-primary" onclick="validateAndNextPage(2)" style="margin: auto;">Enter your details</button>
                        </div>
                    </div>
                    <div id="page2" style="display: none;">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="FirstName">First Name</label>
                                <input type="text" id="FirstName" name="FirstName" class="form-control" required value="<?= $_SESSION['firstname'] ?? ''; ?>">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="LastName">Last Name</label>
                                <input type="text" id="LastName" name="LastName" class="form-control" required value="<?= $_SESSION['lastname'] ?? ''; ?>">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="ContactNumber">Contact Number</label>
                                <input type="text" id="ContactNumber" name="ContactNumber" class="form-control" required value="<?= $_SESSION['contact'] ?? ''; ?>">
                            </div>
                        </div>
                        <div class="row">
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="Note">Write a Note</label>
                                <textarea name="Note" id="Note" class="form-control" cols="30" rows="8"></textarea>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: center;">
                            <button type="button" class="btn btn-primary" onclick="nextPage(1)">Previous</button><br>
                            <button type="button" class="btn btn-primary" onclick="nextPage(3)">Next</button>
                        </div>
                    </div>

                    <div id="page3" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Arrival Date:</label>
                                <span id="displayCheckInDate"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Number Of Guest:</label>
                                <span id="displayGuests"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Venue Name:</label>
                                <span id="displayVenue"></span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name:</label>
                                <span id="displayFirstName"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name:</label>
                                <span id="displayLastName"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Contact Number:</label>
                                <span id="displayContactNumber"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Note:</label>
                                <span id="displayNote"></span>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: center; align-items: center;">
                            <button type="button" class="btn btn-primary" onclick="nextPage(2)">Previous</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
              <section  class="site-section"style="background: #FAF2D3;">
                  <div class="menu-title">
                    <h1>Cafe Menu</h1>
                  </div>
                      <div class="category-buttons" style="margin-top: 20px; display: flex; flex-wrap: wrap; justify-content: center; gap: 10px;">
                        <button onclick="showCategory('22')" style="padding: 10px 20px; flex: 1 1 100px; max-width: 150px; min-width: 100px; background: linear-gradient(to bottom, rgba(245, 245, 245, 0.9), rgba(230, 230, 230, 0.7)); color: #333; font-weight: bold; border: none; border-radius: 5px; cursor: pointer; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); transition: background 0.3s, transform 0.2s; text-align: center;">Iced Coffee</button>
                        <button onclick="showCategory('23')" style="padding: 10px 20px; flex: 1 1 100px; max-width: 150px; min-width: 100px; background: linear-gradient(to bottom, rgba(245, 245, 245, 0.9), rgba(230, 230, 230, 0.7)); color: #333; font-weight: bold; border: none; border-radius: 5px; cursor: pointer; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); transition: background 0.3s, transform 0.2s; text-align: center;">Hot Coffee</button>
                        <button onclick="showCategory('24')" style="padding: 10px 20px; flex: 1 1 100px; max-width: 150px; min-width: 100px; background: linear-gradient(to bottom, rgba(245, 245, 245, 0.9), rgba(230, 230, 230, 0.7)); color: #333; font-weight: bold; border: none; border-radius: 5px; cursor: pointer; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); transition: background 0.3s, transform 0.2s; text-align: center;">Cold Brew</button>
                      </div>
                      <div style="margin-top: 20px;">
                    <div class="row" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
                    <?php foreach ($menuices as $menuice): ?>
                        <?php if ($menuice['MenuType'] === 'Cafe Menu' && $menuice['CategoryID'] == 22): ?>
                            <div class="col-md-3 menu-record" style="width: 300px; border: 1px solid #ddd; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); cursor: pointer;background: linear-gradient(to bottom, rgba(245, 245, 245, 0.9), rgba(230, 230, 230, 0.7));" data-category="<?= $menuice['CategoryID'] ?>" data-toggle="modal" data-target="#aaddFormModal">
                            <div style="width: 100%; height: 200px; overflow: hidden;">
                            <img src="<?= base_url('/restaurant/' . $menuice['Image']) ?>" alt="<?= $menuice['IcedName'] ?>" style="width: 100%; height: 200px; object-fit: cover;">
                                </div>
                                
                                <div style="padding: 15px;">
                                    <h3 style="margin: 0; color: #333;"><?= $menuice['IcedName'] ?></h3>
                                    <p style="margin: 10px 0; color: #999;">Tall: Php<?= $menuice['PriceTall'] ?></p>
                                    <p style="margin: 10px 0; color: #999;">Grande: Php<?= $menuice['PriceGrande'] ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php foreach ($menucafes as $menucafe): ?>
                        <?php if ($menucafe['MenuType'] === 'Cafe Menu' && $menucafe['CategoryID'] >= 22 && $menucafe['CategoryID'] <= 24): ?>
                            <div class="col-md-3 menu-record" style="width: 300px; border: 1px solid #ddd; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); cursor: pointer;background: linear-gradient(to bottom, rgba(245, 245, 245, 0.9), rgba(230, 230, 230, 0.7));" data-category="<?= $menucafe['CategoryID'] ?>" data-toggle="modal" data-target="#aaddFormModal">
                            <div style="width: 100%; height: 200px; overflow: hidden;">
                            <img src="<?= base_url('/restaurant/' . $menucafe['Image']) ?>" alt="<?= $menucafe['ProductName'] ?>" style="width: 100%; height: 200px; object-fit: cover;">
                                </div>

                                
                                <div style="padding: 15px;">
                                    <h3 style="margin: 0; color: #333;"><?= $menucafe['ProductName'] ?></h3>
                                    <p style="margin: 10px 0; color: #999;">Php<?= $menucafe['ProductPrice'] ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                      </div>
                      </div>
              </section>
    <?php include('inc/footer.php') ?>
    <?php include('inc/loader.php') ?>
    <script>
    function nextPage(page) {
        document.getElementById('page1').style.display = 'none';
        document.getElementById('page2').style.display = 'none';
        document.getElementById('page3').style.display = 'none';
        document.getElementById('page' + page).style.display = 'block';

        if (page === 3) {
            displayFormData();
        }
    }

    function validateAndNextPage(page) {
        // Check if required fields on page 1 are filled
        const checkInDate = document.getElementById('CheckInDate').value;
        const numberOfGuests = document.getElementById('NumberOfGuests').value;
        const venueName = document.getElementById('VenueName').value;

        if (!checkInDate || !numberOfGuests || !venueName) {
            alert('Please fill in all required fields.');
            return;
        }

        // Proceed to the next page
        nextPage(page);
    }

    function displayFormData() {
        document.getElementById('displayCheckInDate').innerText = document.getElementById('CheckInDate').value; 
        document.getElementById('displayGuests').innerText = document.getElementById('NumberOfGuests').value;
        document.getElementById('displayVenue').innerText = document.getElementById('VenueName').value;
        document.getElementById('displayNote').innerText = document.getElementById('Note').value;
        document.getElementById('displayFirstName').innerText = document.getElementById('FirstName').value;
        document.getElementById('displayLastName').innerText = document.getElementById('LastName').value;
        document.getElementById('displayContactNumber').innerText = document.getElementById('ContactNumber').value;
    }
</script>
<script>
    function showCategory(categoryID) {
        $('.col-md-3').hide(); 
        $('.col-md-3[data-category="' + categoryID + '"]').show(); 
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="<?=base_url()?>guest/js/jquery-3.2.1.min.js"></script>
    <script src="<?=base_url()?>guest/js/jquery-migrate-3.0.0.js"></script>
    <script src="<?=base_url()?>guest/js/popper.min.js"></script>
    <script src="<?=base_url()?>guest/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>guest/js/owl.carousel.min.js"></script>
    <script src="<?=base_url()?>guest/js/jquery.waypoints.min.js"></script>
    <script src="<?=base_url()?>guest/js/jquery.stellar.min.js"></script>
    <script src="<?=base_url()?>guest/js/jquery.magnific-popup.min.js"></script>
    <script src="<?=base_url()?>guest/js/magnific-popup-options.js"></script>
    <script src="<?=base_url()?>guest/js/main.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#CheckInDate", {
            mode: "single",
            dateFormat: "Y-m-d H:i",
            enableTime: true,
            onClose: function(selectedDates, dateStr, instance) {
                if (selectedDates.length > 1) {
                    const checkInDate = new Date(selectedDates[0]);
                    checkInDate.setHours(checkInDate.getHours() + 8); 
                    const checkInStr = checkInDate.toISOString().slice(0, 16).replace('T', ' ');
                    document.getElementById('CheckInDate').value = checkInStr;
                }
            },
            disable: [
                function(date) {
                    const today = new Date();
                    today.setHours(today.getHours() + 8); 
                    const yesterday = new Date(today);
                    yesterday.setDate(yesterday.getDate() - 1); 
                    return date < yesterday;
                },
                <?php if (!empty($unavailableDates)) : ?>
                    <?php foreach ($unavailableDates as $unavailableDate) : ?>
                        '<?php echo $unavailableDate ?>',
                    <?php endforeach; ?>
                <?php endif; ?>
            ]
        });
    });
    </script>
    <?= $this->renderSection('scripts') ?>
  </body>
</html>