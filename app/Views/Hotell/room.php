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

    <link rel="stylesheet" href="/guest/css/bootstrap.css">
    <link rel="stylesheet" href="/guest/css/animate.css">
    <link rel="stylesheet" href="/guest/css/owl.carousel.min.css">

    <link rel="stylesheet" href="/guest/fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/guest/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/guest/css/magnific-popup.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="/guest/css/style.css">
    <style>
#search-container {
    margin-bottom: 20px;
}

#search-container input[type="number"] {
    width: 200px;
    padding: 10px;
    margin-right: 10px;
}

#search-container button {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
}

#search-container button:hover {
    background-color: #0056b3;
}

.floating-card-container {
    position: relative;
    margin-top: 50px; 
}

.floating-card {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    padding: 20px;
    z-index: 1000;
}
    </style>
    <?= $this->renderSection('stylesheets') ?>
  </head>
  <body>
  <?php include('inc/header.php') ?>
    <?php if(session()->get('isLoggedIn')): ?>
      <?php
            $session = session();
            $successMessage = $session->getFlashdata('success');
            ?>
            <?php if($successMessage): ?>
                <div class="alert alert-success">
                    <?= $successMessage ?>
                </div>
            <?php endif; ?>
 
            <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/3.jpg);">
              <div class="container">
                <div class="row align-items-center site-hero-inner justify-content-center">
                
                  <div class="col-md-12 text-center">
                  <div class="mb-5 element-animate text-center" style="max-width: 100%; margin-top:120px;">
                <h1 style="font-size: 3.5em; margin-bottom: 20px;">Room Reservation</h1>
                <div class="card-header text-center" style="color: white; font-size: 1.5em;">Estimated Check In and Out Time</div>
                        <div style="display: flex; flex-wrap: wrap;">
                          <div style="flex: 0 0 100%; margin-bottom: 10px;">
                            <p style="font-size: 1.2em; text-align: center;">Check In Time: 2:00 PM</p>
                          </div>
                          <div style="flex: 0 0 100%; margin-bottom: 10px;">
                            <p style="font-size: 1.2em; text-align: center;">Check Out Time: 12:00 PM</p>
                          </div>
                        </div>
                        <div class="col-md-12 form-group text-center">
                        <a href="<?= route_to('bookroom') ?>" class="btn btn-primary">Reservation</a>
                        </div>

                          </div>
                          <div class="container">
                              <div class="row">
                                  <div class="col-lg-12 ">
                                          <div id="search-container" style="display: flex; justify-content: center; align-items: center;">
                                            <input type="number" id="price-input" placeholder="Enter price range..."><button id="search-btn">Search</button>
                                          </div>
                                  </div>
                              </div>
                          </div>
                  </div>
                </div>
              </div>
            </section>
      <section class="site-section"style="background-image: url(/guest/images/malabomahalta.jpg); background-repeat: no-repeat; background-size: cover;">
        <div class="container">
          
          <div class="row" id="room-container">
            <?php foreach ($rooms as $room): ?>
            <?php if ($room['AvailabilityStatus'] === 'Available'): ?>
              <div class="col-md-4 mb-4">
                <div class="media d-block room mb-0">
                  <figure>
                    <img src="<?=base_url('/uploads/'.$room['Image'])?>" alt="Generic placeholder image" class="img-fluid" style="height:300 px; width:788px;">
                    <div class="overlap-text">
                      <span>
                      Room<?=$room['RoomNumber']?> 
                      <h6><b><?= $room['AvailabilityStatus'] ?></b></h6>
                      </span>
                    </div>
                  </figure>
                  <div class="media-body">
                    <h3 class="mt-0"><a href="#"><?=$room['RoomType']?></a></h3>
                    <h5 class="mt-0"><a href="#">PHP <?=$room['PricePerNight']?> (per<?=$room['PerNightHead']?>)</a></h5>
                    <ul class="room-specs">
                                      <li><span class="ion-ios-people-outline"></span>Min <?= $room['minPerson'] ?></li>
                                      <li><span class="ion-ios-people-outline"></span>Max <?= $room['maxPerson'] ?></li>
                                    </ul>
                      <div class="row">
                        <div class="col-md-12 text-center">
                        <h6 class="btn-info viewMoreBtn"><a data-toggle="modal" data-target="#roomModal<?=$room['RoomID']?>" style="cursor: pointer;">View More Details</a></h6>
                        </div>
                      </div>
                    <!-- <p><a href="<?= route_to('bookroom') ?>" class="btn btn-primary btn-sm">Book Now</a></p> -->
                  </div>
                </div>
              </div>
              <div class="modal fade" id="roomModal<?=$room['RoomID']?>" tabindex="-1" role="dialog" aria-labelledby="roomModalLabel<?=$room['RoomID']?>" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="roomModalLabel<?=$room['RoomID']?>">Room <?=$room['RoomNumber']?> <strong>||</strong> <?=$room['RoomType']?> Details</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <div id="imageCarousel<?=$room['RoomID']?>" class="carousel slide" data-ride="carousel">
                                  <div class="carousel-inner">
                                      <?php foreach ($roomimages as $roomimage): ?>
                                          <?php if ($roomimage['RoomID'] === $room['RoomID']): ?>
                                              <?php $images = explode(',', $roomimage['Images']); ?>
                                              <?php foreach ($images as $index => $image): ?>
                                                  <div class="carousel-item<?php echo $index === 0 ? ' active' : ''; ?>">
                                                      <img src="<?= base_url('/uploads/' . trim($image)); ?>" class="d-block w-100" alt="Room Image" style="width: 100px; height: 300px;">
                                                  </div>
                                              <?php endforeach; ?>
                                          <?php endif; ?>
                                      <?php endforeach; ?>
                                  </div>
                                  <a class="carousel-control-prev" href="#imageCarousel<?=$room['RoomID']?>" role="button" data-slide="prev">
                                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                      <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="carousel-control-next" href="#imageCarousel<?=$room['RoomID']?>" role="button" data-slide="next">
                                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                      <span class="sr-only">Next</span>
                                  </a>
                              </div>
                              <p><?=$room['Description']?></p>
                              <p><b>• ROOM INCLUSIONS</b></p>
                              <p>-Complimentary Breakfast(Plated Service)</p>
                              <p>-Free Flow or Brewed Coffee</p>
                              <p>-Complete Amenities</p>
                              <p>-Swimming Pool Access</p>
                              <p>-Stand By Generator Set</p>
                              <p><b>NOTE: Extra person will be charge PHP 500.00 per head</b></p>
                          </div>
                      </div>
                  </div>
              </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </section>  
    <?php else: ?>
      <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/3.jpg);">
              <div class="container">
                <div class="row align-items-center site-hero-inner justify-content-center">
                
                  <div class="col-md-12 text-center">
                  <div class="mb-5 element-animate text-center" style="max-width: 100%; margin-top:120px;">
                <h1 style="font-size: 3.5em; margin-bottom: 20px;">Room Reservation</h1>
                <div class="card-header text-center" style="color: white; font-size: 1.5em;">Estimated Check In and Out Time</div>
                        <div style="display: flex; flex-wrap: wrap;">
                          <div style="flex: 0 0 100%; margin-bottom: 10px;">
                            <p style="font-size: 1.2em; text-align: center;">Check In Time: 2:00 PM</p>
                          </div>
                          <div style="flex: 0 0 100%; margin-bottom: 10px;">
                            <p style="font-size: 1.2em; text-align: center;">Check Out Time: 12:00 PM</p>
                          </div>
                          <div class="col-md-12 form-group text-center">
                            <a href="<?= route_to('login') ?>" class="btn btn-primary">Reservation</a>
                          </div>
                        </div>
            </div>
            <div class="container">
                              <div class="row">
                                  <div class="col-lg-12 ">
                                          <div id="search-container" style="display: flex; justify-content: center; align-items: center;">
                                            <input type="number" id="price-input" placeholder="Enter price range..."><button id="search-btn">Search</button>
                                          </div>
                                  </div>
                              </div>
                          </div>

                  </div>
                </div>
              </div>
            </section>
    <section class="site-section"style="background: #FAF2D3;">
      <div class="container">
      <div class="row" id="room-container">
            <?php foreach ($rooms as $room): ?>
            <?php if ($room['AvailabilityStatus'] === 'Available'): ?>
              <div class="col-md-4 mb-4">
                <div class="media d-block room mb-0">
                  <figure>
                    <img src="<?=base_url('/uploads/'.$room['Image'])?>" alt="Generic placeholder image" class="img-fluid" style="height:300 px; width:788px;">
                    <div class="overlap-text">
                      <span>
                      Room<?=$room['RoomNumber']?> 
                      <h6><b><?= $room['AvailabilityStatus'] ?></b></h6>
                      </span>
                    </div>
                  </figure>
                  <div class="media-body">
                    <h3 class="mt-0"><a href="#"><?=$room['RoomType']?></a></h3>
                    <h5 class="mt-0"><a href="#">PHP <?=$room['PricePerNight']?> (per<?=$room['PerNightHead']?>)</a></h5>
                    <ul class="room-specs">
                                      <li><span class="ion-ios-people-outline"></span>Min <?= $room['minPerson'] ?></li>
                                      <li><span class="ion-ios-people-outline"></span>Max <?= $room['maxPerson'] ?></li>
                                    </ul>
                      <div class="row">
                        <div class="col-md-12 text-center">
                        <h6 class="btn-info viewMoreBtn"><a data-toggle="modal" data-target="#roomModal<?=$room['RoomID']?>" style="cursor: pointer;">View More Details</a></h6>
                        </div>
                      </div>
                    <!-- <p><a href="<?= route_to('bookroom') ?>" class="btn btn-primary btn-sm">Book Now</a></p> -->
                  </div>
                </div>
              </div>
              <div class="modal fade" id="roomModal<?=$room['RoomID']?>" tabindex="-1" role="dialog" aria-labelledby="roomModalLabel<?=$room['RoomID']?>" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="roomModalLabel<?=$room['RoomID']?>">Room <?=$room['RoomNumber']?> <strong>||</strong> <?=$room['RoomType']?> Details</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <div id="imageCarousel<?=$room['RoomID']?>" class="carousel slide" data-ride="carousel">
                                  <div class="carousel-inner">
                                      <?php foreach ($roomimages as $roomimage): ?>
                                          <?php if ($roomimage['RoomID'] === $room['RoomID']): ?>
                                              <?php $images = explode(',', $roomimage['Images']); ?>
                                              <?php foreach ($images as $index => $image): ?>
                                                  <div class="carousel-item<?php echo $index === 0 ? ' active' : ''; ?>">
                                                      <img src="<?= base_url('/uploads/' . trim($image)); ?>" class="d-block w-100" alt="Room Image" style="width: 100px; height: 300px;">
                                                  </div>
                                              <?php endforeach; ?>
                                          <?php endif; ?>
                                      <?php endforeach; ?>
                                  </div>
                                  <a class="carousel-control-prev" href="#imageCarousel<?=$room['RoomID']?>" role="button" data-slide="prev">
                                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                      <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="carousel-control-next" href="#imageCarousel<?=$room['RoomID']?>" role="button" data-slide="next">
                                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                      <span class="sr-only">Next</span>
                                  </a>
                              </div>
                              <p><?=$room['Description']?></p>
                              <p><b>• ROOM INCLUSIONS</b></p>
                              <p>-Complimentary Breakfast(Plated Service)</p>
                              <p>-Free Flow or Brewed Coffee</p>
                              <p>-Complete Amenities</p>
                              <p>-Swimming Pool Access</p>
                              <p>-Stand By Generator Set</p>
                              <p><b>NOTE: Extra person will be charge PHP 500.00 per head</b></p>
                          </div>
                      </div>
                  </div>
              </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
      </div>
    </section>
    <?php endif; ?>
    <section class="section-cover" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/MahaltaPic/25.jpg);">
      <div class="container">
        <div class="row justify-content-center align-items-center intro">
          <div class="col-md-9 text-center element-animate">
            <h2>Relax and Enjoy your Holiday</h2>
            <p class="lead mb-5">Explore a world of comfort and luxury on our resort and hotel website, showcasing inviting accommodations, stunning amenities, and unforgettable experiences for your perfect getaway.</p>
            <div class="btn-play-wrap"><a href="https://www.youtube.com/watch?v=9phZlJodJPA" class="btn-play popup-vimeo "><span class="ion-ios-play"></span></a></div>
          </div>
        </div>
      </div>
    </section>
    <?php include('inc/footer.php') ?>
    <?php include('inc/loader.php') ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('price-input');
    var searchBtn = document.getElementById('search-btn');
    var roomContainers = document.querySelectorAll('#room-container .col-md-4');
    searchBtn.addEventListener('click', function() {
        var priceRange = parseFloat(searchInput.value); 
        roomContainers.forEach(function(roomContainer) {
            var roomPriceElement = roomContainer.querySelector('h5 a'); 
            var roomPrice = parseFloat(roomPriceElement.innerText.replace('PHP', '').replace('per', '').replace(/\s+/g, ''));
            if (roomPrice <= priceRange) {
                roomContainer.style.display = 'block'; 
            } else {
                roomContainer.style.display = 'none'; 
            }
        });
    });
});

    </script>
    <script>
      var viewMoreButtons = document.querySelectorAll('.viewMoreBtn');
      viewMoreButtons.forEach(function(button) {
        button.addEventListener('click', function() {
          var parentContainer = button.closest('.room');
          var detailsDiv = parentContainer.querySelector('.additionalDetails');
          detailsDiv.style.display = (detailsDiv.style.display === 'none') ? 'block' : 'none';
        });
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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