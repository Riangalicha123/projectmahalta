
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

    <!-- Theme Style -->
    <link rel="stylesheet" href="<?=base_url()?>guest/css/style.css">
    <style>
      .hover-effect-container {
    transition: transform 0.3s ease;
}

.hover-effect-container:hover {
    transform: scale(1.05);
}

    </style>
    <?= $this->renderSection('stylesheets') ?>
  </head>
  <body>
    
  <?php include('inc/header.php') ?>
    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(<?=base_url()?>guest/images/big_image_1.jpg);">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">
            <div class="mb-5 element-animate">
            <br>
            <br>
            <br>
              <h1>Convention Center</h1>
               <p>Welcome to our premier convention center—where sophistication meets innovation. We offer the perfect venue for your events, from corporate conferences to grand expos. </p> 
            </div>
           
            <?php if(session()->get('isLoggedIn')): ?>
            <div class="col-md-12 form-group text-center">
            <a href="<?= route_to('convention-center/reservation') ?>" class="btn btn-primary">Reservation</a>
            </div>
            <?php else: ?>
              <div class="col-md-12 form-group text-center">
                <a href="<?= route_to('login') ?>" class="btn btn-primary">Reservation</a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <section class="site-section" style="background-image: url(<?=base_url()?>guest/images/malabomahalta.jpg); background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center mb-5">Available Reservation Venues</h2>
            </div>
            <?php foreach ($convenues as $convenue): ?>
                <div class="col-md-4 mb-4">
                    <div class="room">
                        <a href="#">
                            <img src="<?= base_url('/convention/'.$convenue['Image']) ?>" alt="<?= $convenue['conVenueName'] ?>" class="img-fluid rounded">
                        </a>
                        <div class="media-body mt-3 text-center">
                        <h3 class="mb-3"><a><?=$convenue['conVenueName']?></a></h3>
                            <ul class="list-unstyled room-specs mb-0">
                                <li><span class="ion-ios-people-outline"></span> <?= $convenue['minGuest'] ?> - <?= $convenue['maxGuest'] ?> Guests</li>
                            </ul>
                            
                            <div class="row">
                            <div class="col-md-12 text-center">
                                <h6 class="btn-info viewMoreBtn"><a data-toggle="modal" data-target="#roomModal<?=$convenue['conVenueID']?>" style="cursor: pointer;">View More Details</a></h6>
                                </div>
                            </div>
                            <div class="modal fade" id="roomModal<?=$convenue['conVenueID']?>" tabindex="-1" role="dialog" aria-labelledby="roomModalLabel<?=$convenue['conVenueID']?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="roomModalLabel<?=$convenue['conVenueID']?>"><?=$convenue['conVenueName']?> Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?= $convenue['Description'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

    <section class="site-section" style="background-image: url(<?=base_url()?>guest/images/malabomahalta.jpg); background-repeat: no-repeat; background-size: cover;">
    <div class="container">
    <div class="col-md-12 heading-wrap text-center">
            <h2 class="heading" style="color: #404040;"> Convention Center Events</h2>
          </div>
        <div class="row">
            <?php foreach ($events as $event): ?>
                <div class="col-md-4">
                    <div class="post-entry">
                        <a href="#"><img src="<?=base_url('/uploads/'.$event['Image'])?>" alt="Image placeholder" class="img-fluid" style="width: 100%; height: 310px; object-fit: cover;"></a>
                        <div class="body-text" style="background-color: #fff; padding: 20px;">
                            <h3 class="mb-3" style="font-size: 24px; color: #333;"><a href="#" style="color: #333;"><?= $event['EventType'] ?></a></h3>
                            <p class="mb-4" style="font-size: 16px; color: #666;"><?= $event['Description'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
    <?php include('inc/footer.php') ?>

    
    <!-- loader -->
    <?php include('inc/loader.php') ?>
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
    <?= $this->renderSection('scripts') ?>
  </body>
</html>