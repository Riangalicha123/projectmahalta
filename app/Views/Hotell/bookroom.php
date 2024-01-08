<!doctype html>
<html lang="en">
  <head>
    <title>Mahalta</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900|Rubik:300,400,700" rel="stylesheet">

    <link rel="stylesheet" href="/guest/css/bootstrap.css">
    <link rel="stylesheet" href="/guest/css/animate.css">
    <link rel="stylesheet" href="/guest/css/owl.carousel.min.css">

    <link rel="stylesheet" href="/guest/fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/guest/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/guest/css/magnific-popup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="/guest/css/style.css">
  </head>
  <body>
    
  <?php include('inc/header.php') ?>
    <!-- END header -->

    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/3.jpg);">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>Reservation</h1>
              <!-- <p>Discover our world's #1 Luxury Room For VIP.</p> -->
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section" >
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2 class="mb-5">Reservation Room Form</h2>
                <form action="<?= base_url('addReservation') ?>" method="post">
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="FirstName">First Name</label>
                      <input type="text" id="FirstName" name="FirstName" class="form-control" required value="<?= $_SESSION['firstname'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="LastName">Last Name</label>
                      <input type="text" id="LastName" name="LastName" class="form-control" required value="<?= $_SESSION['lastname'] ?? ''; ?>">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="ContactNumber">Contact Number</label>
                      <input type="text" id="ContactNumber" name="ContactNumber" class="form-control" value="<?= $_SESSION['contact'] ?? ''; ?>" required >
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="Address">Address</label>
                      <input type="text" id="Address" name="Address" class="form-control" value="<?= $_SESSION['address'] ?? ''; ?>" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="ContactNumber">Contact Number</label>
                      <input type="text" id="ContactNumber" name="ContactNumber" class="form-control" value="<?= $_SESSION['hello'] ?? ''; ?>" required >
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="Address">Address</label>
                      <input type="text" id="Address" name="Address" class="form-control" value="<?= $_SESSION['Address'] ?? ''; ?>" required>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6 form-group">
                          
                          <label for="CheckInDate">Arrival Date</label>
                          <div style="position: relative;">
                            <!-- <span class="fa fa-calendar icon" style="position: absolute; right: 10px; top: 10px;"></span> -->
                            <input type='datetime-local' class="form-control" id='CheckInDate' name='CheckInDate' required/>
                          </div>
                      </div>

                      <div class="col-sm-6 form-group">
                          
                          <label for="CheckOutDate">Departure Date</label>
                          <div style="position: relative;">
                            <!-- <span class="fa fa-calendar icon" style="position: absolute; right: 10px; top: 10px;"></span> -->
                            <input type='datetime-local' class="form-control" id='CheckOutDate' name='CheckOutDate' required/>
                          </div>
                      </div>
                      
                  </div>

                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="RoomNumber">Room No.</label>
                      <select name="RoomNumber" id="RoomNumber" class="form-control" required>
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

                    <div class="col-md-6 form-group">
                      <label for="RoomType">Room Type</label>
                      <select class="form-select form-control" id="RoomType" name="RoomType">
                        <option>Deluxe Room</option>
                        <option>Jr. Suite Room</option>
                        <option>Family Room</option>
                        <option>Barkada Room</option>
                      </select>
                    </div>

                    <div class="col-md-12 form-group">
                      <label for="NumberOfGuests">Number of Guest</label>
                      <input type="number" class="form-control" id="NumberOfGuests" min="2" name="NumberOfGuests" required>
                    </div>
                  </div>
                  
                  <div class="row">
                  <img src="/guest/images/qr.JPG" alt="Generic placeholder image" class="img-fluid">
                  <p>Note: The downpayment is 1000 pesos minimum</p>
                  </div>
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="TotalAmount">Down Payment or Full Payment</label>
                      <input type="text" id="TotalAmount" name="TotalAmount" class="form-control" required>
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="ReferenceNumber">Reference Number</label>
                      <input type="text" id="ReferenceNumber" name="ReferenceNumber" class="form-control" required>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6 form-group">
                    <button type="submit" value="Reserve Now" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-md-1"></div>
              <div class="col-md-5">
                <h3 class="mb-5">Featured Room</h3>
                <div class="media d-block room mb-0">
              <figure>
                <img src="/guest/images/img_1.jpg" alt="Generic placeholder image" class="img-fluid">
                <div class="overlap-text">
                  <span>
                    Featured Room 
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                  </span>
                </div>
              </figure>
              <div class="media-body">
                <h3 class="mt-0"><a href="#">Presidential Room</a></h3>
                <ul class="room-specs">
                  <li><span class="ion-ios-people-outline"></span> 2 Guests</li>
                  <li><span class="ion-ios-crop"></span> 22 ft <sup>2</sup></li>
                </ul>
                <p>Nulla vel metus scelerisque ante sollicitudin. Fusce condimentum nunc ac nisi vulputate fringilla. </p>
                <p><a href="#" class="btn btn-primary btn-sm">Book Now From $20</a></p>
              </div>
            </div>
              </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2 class="mb-5">Reservation Restaurant Form</h2>
                <form action="<?= base_url('tableReservation') ?>" method="post">
                <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="FirstName">First Name</label>
                      <input type="text" id="FirstName" name="FirstName" class="form-control" required value="<?= $_SESSION['firstname'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="LastName">Last Name</label>
                      <input type="text" id="LastName" name="LastName" class="form-control" required value="<?= $_SESSION['lastname'] ?? ''; ?>">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="ContactNumber">Contact Number</label>
                      <input type="text" id="ContactNumber" name="ContactNumber" class="form-control" value="<?= $_SESSION['contact'] ?? ''; ?>" required >
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="Address">Address</label>
                      <input type="text" id="Address" name="Address" class="form-control" value="<?= $_SESSION['address'] ?? ''; ?>" required>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6 form-group">
                          
                          <label for="CheckInDate">Arrival Date</label>
                          <div style="position: relative;">
                            <!-- <span class="fa fa-calendar icon" style="position: absolute; right: 10px; top: 10px;"></span> -->
                            <input type='datetime-local' class="form-control" id='CheckInDate' name='CheckInDate' required/>
                          </div>
                      </div>

                      <div class="col-sm-6 form-group">
                          
                          <label for="CheckOutDate">Departure Date</label>
                          <div style="position: relative;">
                            <!-- <span class="fa fa-calendar icon" style="position: absolute; right: 10px; top: 10px;"></span> -->
                            <input type='datetime-local' class="form-control" id='CheckOutDate' name='CheckOutDate' required/>
                          </div>
                      </div>
                      
                  </div>
                  <div class="row">
                  <div class="col-md-6 form-group">
                      <label for="TableNumber">Table</label>
                      <select class="form-select form-control" id="TableNumber" name="TableNumber">
                        <option>T1</option>
                        <option>T2</option>
                        <option>T3</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="Note">Write a Note</label>
                      <textarea name="Note" id="Note" class="form-control " cols="30" rows="8" required></textarea>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6 form-group">
                    <button type="submit" value="Reserve Now" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-md-1"></div>
              <div class="col-md-5">
                <h3 class="mb-5">Featured Room</h3>
                <div class="media d-block room mb-0">
              <figure>
                <img src="/guest/images/img_1.jpg" alt="Generic placeholder image" class="img-fluid">
                <div class="overlap-text">
                  <span>
                    Featured Room 
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                  </span>
                </div>
              </figure>
              <div class="media-body">
                <h3 class="mt-0"><a href="#">Presidential Room</a></h3>
                <ul class="room-specs">
                  <li><span class="ion-ios-people-outline"></span> 2 Guests</li>
                  <li><span class="ion-ios-crop"></span> 22 ft <sup>2</sup></li>
                </ul>
                <p>Nulla vel metus scelerisque ante sollicitudin. Fusce condimentum nunc ac nisi vulputate fringilla. </p>
                <p><a href="#" class="btn btn-primary btn-sm">Book Now From $20</a></p>
              </div>
            </div>
              </div>
        </div>
      </div>
    </section>
    <!-- END section -->
   
    <!-- END section -->
   

    
    <!-- END section -->
   
    <?php include('inc/footer.php') ?>
    <!-- END footer -->
    
    <!-- loader -->
    <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#f4b214"/></svg></div>

    <script src="/guest/js/jquery-3.2.1.min.js"></script>
    <script src="/guest/js/jquery-migrate-3.0.0.js"></script>
    <script src="/guest/js/popper.min.js"></script>
    <script src="/guest/js/bootstrap.min.js"></script>
    <script src="/guest/js/owl.carousel.min.js"></script>
    <script src="/guest/js/jquery.waypoints.min.js"></script>
    <script src="/guest/js/jquery.stellar.min.js"></script>

    <script src="/guest/js/jquery.magnific-popup.min.js"></script>
    <script src="/guest/js/magnific-popup-options.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

    <script>
      
      $('#arrival_date, #departure_date').datepicker({});

    </script>

    

    <script src="/guest/js/main.js"></script>
  </body>
</html>