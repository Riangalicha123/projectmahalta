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
    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/big_image_1.jpg);">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">
            <div class="mb-5 element-animate">
              <h1>Restaurant</h1>
               <p>Savor the moment, indulge in flavor at Mahalta's Restaurant</p> 
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
              <div class="card text-white mb-3" style="background-color: rgba(70, 130, 180, 0.7); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
              <div class="card-header text-center">À la Carte Service</div>
                <div style="flex: 0 0 50%; margin-bottom: 10px;">
                    <p style="font-size: 1.2em;">  Monday-Thursday (7:00 PM - 9:00 PM)</p>
                  </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card text-white mb-3" style="background-color: rgba(70, 130, 180, 0.7); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <div class="card-header text-center">Buffet Service</div>
                <div style="display: flex; flex-wrap: wrap;">
                  <div style="flex: 0 0 50%; margin-bottom: 10px;">
                    <p style="font-size: 1.2em;">Friday-Saturday</p>
                  </div>
                  <div style="flex: 0 0 50%; margin-bottom: 10px;">
                    <p style="font-size: 1.2em;">Breakfast: 7:00 AM - 10:00 AM</p>
                  </div>
                  <div style="flex: 0 0 50%; margin-bottom: 10px;">
                    <p style="font-size: 1.2em;">Lunch: 12:00 PM - 3:00 PM</p>
                  </div>
                  <div style="flex: 0 0 50%; margin-bottom: 10px;">
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
    <section class="site-section "style="background: linear-gradient(to  bottom left,#3085C3,  #3085C3, #FAF2D3,  #5CD2E6, #FFFBE9,#F4E869,#F4E869);">
      <div class="container">
        <div class="row mb-5">
        </div>
        <div class="row ">
          <div class="col-md-7">
            <div class="media d-block room mb-0">
              <figure>
                <img src="/guest/images/dining.jpg" alt="Generic placeholder image" class="img-fluid">
              </figure>
              <div class="media-body">
                <h3 class="mt-0"><a href="#">Dining</a></h3>
                <p>An inviting eatery offering a diverse menu of delicious dishes, our restaurant combines warm ambiance with attentive service for the guests.</p>
                <p>    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFormModal">
        Make Online Reservation
    </button></p>
              </div>
            </div>
          </div>
          <div class="col-md-5 room-thumbnail-absolute">
            <a href="#" class="media d-block room bg first-room" style="background-image: url(/guest/images/cafe.jpg); ">
                <div class="overlap-text">
                  <span>
                    Cafe
                  </span>
                </div>
            </a>
            <a href="#" class="media d-block room bg second-room" style="background-image: url(/guest/images/cafe1.jpg); ">
                <div class="overlap-text">
                  <span>
                    Cafe
                  </span>
                </div>
            </a>
          </div>
        </div>
      </div>
    </section>
    <!-- Add Form Modal -->
    <div class="modal fade" id="addFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reservation at Mahalta Resort</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form here -->
                <form action="<?= base_url('tableReservation') ?>" method="post" id="addItemForm">
                  <div class="col-6">
                  <label for="Date">Arrival Date</label>
                          <div style="position: relative;">
                            <input type='date' class="form-control" id='Date' name='Date' required/>
                          </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6 form-group">
                          
                      </div>
                      <div class="col-md-6 form-group">
                      <label for="NumberOfGuests">Number Of Guest</label>
                      <select class="form-select form-control" id="NumberOfGuests" name="NumberOfGuests">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                  <div class="col-md-6 form-group">
                      <label for="VenueName">VenueName</label>
                      <select class="form-select form-control" id="VenueName" name="VenueName">
                        <option>Main Restaurant</option>
                        <option>Venue 2</option>
                        <option>Venue 3</option>
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
                    
                  </div>
                  <div class="row">
                    <div class="col-md-6 form-group">
                    <button type="submit" value="Reserve Now" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--     <section class="site-section"style="background: linear-gradient(to bottom right,#F4E869,  #FAF2D3, #5CD2E6,#ECF9FF,#ECF9FF);">
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
                            
                            <input type='datetime-local' class="form-control" id='CheckInDate' name='CheckInDate' required/>
                          </div>
                      </div>
                      
                  </div>
                  <div class="row">
                  <div class="col-md-6 form-group">
                      <label for="Venue">Venue</label>
                      <select class="form-select form-control" id="Venue" name="Venue">
                        <option>Venue 1</option>
                        <option>Venue 2</option>
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
                <h3 class="mb-5">Featured Restaurant</h3>
                <div class="media d-block room mb-0">
              <figure>
                <img src="/guest/images/MahaltaPic/20.jpg" alt="Generic placeholder image" class="img-fluid">
                <div class="overlap-text">
                  <span>
                    Main Restaurant
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                  </span>
                </div>
              </figure>
              <div class="media-body">
                
                <ul class="room-specs">
                  <li><span class="ion-ios-people-outline"></span> 25 Guests</li>
                  <li><span class="ion-ios-crop"></span> 22 ft <sup>2</sup></li>
                </ul>
                <p>An inviting eatery offering a diverse menu of delicious dishes, our restaurant combines warm ambiance with attentive service for the guests .</p>
                <p><a href="#" class="btn btn-primary btn-sm">Book Now </a></p>
              </div>
            </div>
              </div>
        </div>
      </div>
    </section> -->

    
    <section  class="site-section"style="background: linear-gradient(to bottom right,#F4E869,  #FAF2D3, #5CD2E6,#ECF9FF,#ECF9FF); padding: 20px;  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <div class="menu-title">
      <h1>Main Menu</h1>
    </div>

    <div class="category-buttons" style="margin-top: 20px; text-align: center;">
<!--       <button onclick="showCategory('barmenu')" style="padding: 10px 20px; margin: 5px; background-color: #F5DD61; color: #333; border: none; border-radius: 5px; cursor: pointer;">BAR MENU</button>
      <button onclick="showCategory('cafemenu')" style="padding: 10px 20px; margin: 5px; background-color: #F5DD61; color: #333; border: none; border-radius: 5px; cursor: pointer;">CAFE MENU</button> -->
    </div>
      <div style="margin-top: 20px; border-bottom: 2px solid #ccc;">
        <!-- <h1 style="color: #333; margin-bottom: 10px;">CAFE MENU</h1> -->
        <div class="row">
          <?php foreach ($menumains as $menumain): ?>
              <?php if ($menumain['MenuType'] === 'Main Menu' && $menumain['CategoryID'] >= 1 && $menumain['CategoryID'] <= 11): ?>
                  <div class="col-md-3" style="display: flex; flex-direction: column; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 2px solid #555;">
                      <h2 style="color: #333; margin-bottom: 10px;"><?=$menumain['CategoryName']?></h2>
                      <div style="display: flex; justify-content: space-between; align-items: center;">
                          <img src="<?=base_url('/restaurant/'.$menumain['Image'])?>" alt="Dessert 1" style="width: 120px; height: 100px; border-radius: 8px; margin-right: 10px;">
                          <div style="flex-grow: 1;">
                              <h3 style="margin-top: 0;"><?=$menumain['ProductName']?></h3>
                              <p>Php<?=$menumain['ProductPrice']?></p>
                          </div>
                      </div>
                  </div>
              <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
  </section>
   

    <?php include('inc/chat.php') ?>
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