
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
            <br>
            <br>
            <br>
              <h1>Convention Center</h1>
               <p>Welcome to our premier convention center—where sophistication meets innovation. We offer the perfect venue for your events, from corporate conferences to grand expos. </p> 
            </div>
            <div class="col-md-12 form-group text-center">
                                <a href="<?= route_to('convention-center/reservation') ?>" class="btn btn-primary">Reservation</a>
                              </div>
          </div>
        </div>
      </div>
    </section>

    
    <!-- END section -->

    <!-- <section class="site-section"style="background: linear-gradient(to  bottom left,#3085C3,#5CD2E6, #FAF2D3,  #FFFBE9,#F4E869,#F4E869);padding: 10px; text-align: center;">
        <div class="container" style="display: grid; place-items: center;" >
        
            <div class="row">
            <div class="col-md-12">
                <div class="col-sm-6">
                        <div class="media-body" style="border-radius: 5px;">
                            <div class="row">
                              <div class="col-md-12 form-group text-center">
                                <a href="<?= route_to('convention-center/reservation') ?>" class="btn btn-primary">Reservation</a>
                              </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section> -->
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
                            <!-- <p><a href="#" class="btn btn-primary btn-outline-primary btn-sm">Read More</a></p> -->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

    
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