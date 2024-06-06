
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

    <section class="site-section" style="background-image: url(/guest/images/malabomahalta.jpg); background-repeat: no-repeat; background-size: cover;">
      <div class="container">
          <div class="col-md-12 heading-wrap text-center">
                <h2 class="heading">Convention Venue</h2>
          </div>
        <div class="row">
        <?php foreach ($convenues as $convenue): ?>
        <div class="col-md-4">
            <div class="post-entry">
              <a href="#"><img src="<?=base_url('/convention/'.$convenue['Image'])?>" alt="Image placeholder" class="img-fluid" style="background-size: cover; width: 100%; height: 100%"></a>
              <div class="body-text">
                <div class="category"></div>
                <h3 class="mb-3"><a href="#"><?=$convenue['conVenueName']?></a></h3>
                <ul class="room-specs">
                  <li><span class="ion-ios-people-outline"></span> <?=$convenue['minGuest']?></li>
                  <li><span class="ion-ios-people-outline"></span> <?=$convenue['maxGuest']?></li>
                </ul>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <section class="site-section" style="background-image: url(/guest/images/malabomahalta.jpg); background-repeat: no-repeat; background-size: cover;">
    <div class="container">
    <div class="col-md-12 heading-wrap text-center">
            <h2 class="heading" style="color: #404040;"> Convention Center Events</h2>
          </div>
        <div class="row">
            <?php foreach ($events as $event): ?>
                <div class="col-md-4">
                    <div class="post-entry">
                        <a href="#"><img src="<?=base_url('/uploads/'.$event['Image'])?>" alt="Image placeholder" class="img-fluid" style="width: 100%; height: 200px; object-fit: cover;"></a>
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