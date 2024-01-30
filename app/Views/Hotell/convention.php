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

    <!-- Theme Style -->
    <link rel="stylesheet" href="/guest/css/style.css">
    <?= $this->renderSection('stylesheets') ?>
  </head>
  <body>
    
  <?php include('inc/header.php') ?>
    <!-- END header -->



    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/big_image_1.jpg);">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
              <h1>Conventions</h1>
              <!-- <p>Discover our world's #1 Luxury Room For VIP.</p> -->
            </div>

          </div>
        </div>
      </div>
    </section>

    
    <!-- END section -->


    <section class="site-section" style="background-image: url('/guest/images/malabo5.jpg'); background-size: cover; background-position: center;  color: #000;">
      <div class="container">
        <div class="row">
        <?php foreach ($events as $event): ?>
          <div class="col-md-4 mb-4">
            <div class="media d-block room mb-0">
              <figure>
                <img src="<?=base_url('/uploads/'.$event['Image'])?>" alt="Generic placeholder image" class="img-fluid">
                
              </figure>
              <div class="media-body">
                <h3 class="mt-0"><a href="#"><?=$event['EventType']?></a></h3>
                
                <p><?=$event['Description']?></p>
                <!-- <p><a href="#" class="btn btn-primary btn-sm">Book Now</a></p> -->
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php if(session()->get('isLoggedIn')): ?>
    <section class="site-section" >
      <div class="container">
        <div class="row">
          <div class="col-md-6">

            <h2 class="mb-5">Event Inquiry</h2>
                <form action="<?= base_url('eventReservation') ?>" method="post">
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
                      <label for="Email">Email</label>
                      <input type="email" id="Email" name="Email" class="form-control" value="<?= $_SESSION['username'] ?? ''; ?>" required>
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="ContactNumber">Contact Number</label>
                      <input type="text" id="ContactNumber" name="ContactNumber" class="form-control" value="<?= $_SESSION['contact'] ?? ''; ?>" required >
                    </div>
                    
                  </div>
                  <div class="row">
                      <div class="col-md-6 form-group">
                        <label for="EventType">Event Type</label>
                        <select class="form-select form-control" id="EventType" name="EventType">
                          <option>Wedding</option>
                          <option>Team Building</option>
                          <option>Meeting</option>
                        </select>
                      </div>
                      <div class="col-sm-6 form-group">
                          <label for="CheckInDate">Preferred Date</label>
                          <div style="position: relative;">
                            <!-- <span class="fa fa-calendar icon" style="position: absolute; right: 10px; top: 10px;"></span> -->
                            <input type='datetime-local' class="form-control" id='CheckInDate' name='CheckInDate' required/>
                          </div>
                      </div>  
                  </div>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="NumberOfGuests">Number of Guest</label>
                      <input type="number" class="form-control" id="NumberOfGuests" min="2" name="NumberOfGuests" required>
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
    <?php else: ?>
      <section class="site-section" >
      <div class="container">
        <div class="row">
          <div class="col-md-6">

            <h2 class="mb-5">Event Inquiry</h2>
                <form action="<?= base_url('login') ?>">
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="FirstName">First Name</label>
                      <input type="text" id="FirstName" name="FirstName" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="LastName">Last Name</label>
                      <input type="text" id="LastName" name="LastName" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="Email">Email</label>
                      <input type="email" id="Email" name="Email" class="form-control" >
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="ContactNumber">Contact Number</label>
                      <input type="text" id="ContactNumber" name="ContactNumber" class="form-control">
                    </div>
                    
                  </div>
                  <div class="row">
                      <div class="col-md-6 form-group">
                        <label for="EventType">Event Type</label>
                        <select class="form-select form-control" id="EventType" name="EventType">
                          <option>Wedding</option>
                          <option>Team Building</option>
                          <option>Meeting</option>
                        </select>
                      </div>
                      <div class="col-sm-6 form-group">
                          <label for="CheckInDate">Preferred Date</label>
                          <div style="position: relative;">
                            <!-- <span class="fa fa-calendar icon" style="position: absolute; right: 10px; top: 10px;"></span> -->
                            <input type='datetime-local' class="form-control" id='CheckInDate' name='CheckInDate'/>
                          </div>
                      </div>  
                  </div>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="NumberOfGuests">Number of Guest</label>
                      <input type="number" class="form-control" id="NumberOfGuests" min="2" name="NumberOfGuests">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="Note">Write a Note</label>
                      <textarea name="Note" id="Note" class="form-control " cols="30" rows="8"></textarea>
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
    <?php endif; ?>

    <!-- END section -->
   
    <?php include('inc/footer.php') ?>
    <!-- END footer -->
    
    <!-- loader -->
    <?php include('inc/loader.php') ?>

    <script src="/guest/js/jquery-3.2.1.min.js"></script>
    <script src="/guest/js/jquery-migrate-3.0.0.js"></script>
    <script src="/guest/js/popper.min.js"></script>
    <script src="/guest/js/bootstrap.min.js"></script>
    <script src="/guest/js/owl.carousel.min.js"></script>
    <script src="/guest/js/jquery.waypoints.min.js"></script>
    <script src="/guest/js/jquery.stellar.min.js"></script>

    <script src="/guest/js/jquery.magnific-popup.min.js"></script>
    <script src="/guest/js/magnific-popup-options.js"></script>

    <script src="/guest/js/main.js"></script>
    <?= $this->renderSection('scripts') ?>
  </body>
</html>