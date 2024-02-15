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

    <section class="site-hero overlay" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/1.1.jpg);">
      <div class="container">
        <div class="row align-items-center site-hero-inner justify-content-center">
          <div class="col-md-12 text-center">

            <div class="mb-5 element-animate">
            <h1 style="background: linear-gradient(to bottom, skyblue, lightgreen); -webkit-background-clip: text; color: transparent;">
        Welcome to Mahalta Resort and Convention Center
    </h1>
              <!-- <p>Discover our world's #1 Luxury Room For VIP.</p> -->
              <?php if(session()->get('isLoggedIn')): ?>
                <p><a href="<?= route_to('bookroom') ?>" class="btn btn-primary"style="border-radius: 20px;">Book Now</a></p>
                <?php else: ?>
                  <p><a href="<?= route_to('login') ?>" class="btn btn-primary"style="border-radius: 20px;">Book Now</a></p>
                <?php endif; ?>
              
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section"style="background: linear-gradient(to bottom right,#F4E869, #3085C3, #FAF2D3,  #5CD2E6);">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-4">
            <div class="heading-wrap text-center element-animate"><!-- 
              <h4 class="sub-heading">Stay with our luxury rooms</h4> -->
              <h1 >About Us</h1>

              <p class="mb-5"style="color: #161A30; text-align: justify;font-size:16px;">The term <b><span style="color: blue;font-size:20px;">MAHALTA</span></b>
 was coined by Florante Villarica in the book Mindoro that was published in the year 1998. Mahalta from the three things that Mindoreños are proud of: the peaceloving indigenous Mangyans who offers a rich artistic heritage to the history of the pre-colonial Philippines; Mt. Halcon, the fourt highest mountain in the Philippines and earnss the reputation of being the most difficult mountain to climb in the country. Its rich vegetation contains rich fauna and flora including the critically endangered Mindoro bleeding heart. Tamaraw, a fierce Mindoro Dwarf Buffalo, it symbolizes Mindoro since it could only be found in this island and nowhere else in the world.</p>
              <!-- <p><a href="" class="btn btn-primary btn-sm">More About Us</a></p> -->
            </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-7">
    <div id="imageCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
        <div class="carousel-item active">
                <img src="/guest/images/pool.png" alt="Image 1" class="img-md-fluid">
            </div>
            <div class="carousel-item">
                <img src="/guest/images/MahaltaPic/5.jpg" alt="Image 2" class="img-md-fluid">
            </div>
            <div class="carousel-item">
                <img src="/guest/images/MahaltaPic/9.jpg" alt="Image 2" class="img-md-fluid">
            </div>
            <div class="carousel-item">
                <img src="/guest/images/MahaltaPic/20.jpg" alt="Image 2" class="img-md-fluid">
            </div>
            <div class="carousel-item">
                <img src="/guest/images/MahaltaPic/22.jpg" alt="Image 2" class="img-md-fluid">
            </div>
            <!-- Add more carousel items with different images as needed -->
        </div>

        <!-- Add navigation arrows -->
        <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>


        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section "style="background: linear-gradient(to  bottom left,#3085C3,  #3085C3, #FAF2D3,  #5CD2E6, #FFFBE9,#F4E869,#F4E869);">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-12 heading-wrap text-center">
            <h4 class="sub-heading"  style="color: darkgrey;"> Hotel Rooms</h4>
              <h2 class="heading">Featured Rooms</h2>
          </div>
        </div>
        <div class="row ">
          <div class="col-md-7">
            <div class="media d-block room mb-0">
              <figure>
                <img src="/guest/images/MahaltaPic/4.jpg" alt="Generic placeholder image" class="img-fluid">
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
                <h3 class="mt-0"><a href="#">Jr.Suite Room</a></h3>
                <ul class="room-specs">
                  <li><span class="ion-ios-people-outline"></span> 2 Guests</li>
                  <li><span class="ion-ios-crop"></span> 22 ft <sup>2</sup></li>
                </ul>
                <p>Picture a special room with a peaceful ambiance and inviting decor, designed for relaxation. </p>
                <p><a href="#" class="btn btn-primary btn-sm">Book Now </a></p>
              </div>
            </div>
          </div>
          <div class="col-md-5 room-thumbnail-absolute">
            <a href="#" class="media d-block room bg first-room" style="background-image: url(/guest/images/MahaltaPic/2.jpg); ">
              <!-- <figure> -->
                <div class="overlap-text">
                  <span>
                    Family Room 
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                  </span>
                  <span class="pricing-from">
                    Php6,499.00
                  </span>
                </div>
              <!-- </figure> -->
            </a>

            <a href="#" class="media d-block room bg second-room" style="background-image: url(/guest/images/MahaltaPic/5.jpg); ">
              <!-- <figure> -->
                <div class="overlap-text">
                  <span>
                    Barkada Room 
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                    <span class="ion-ios-star"></span>
                  </span>
                  <span class="pricing-from">
                    Php 1,000.00/head
                  </span>
                </div>
                
              <!-- </figure> -->
            </a>
            
          </div>
        </div>
      </div>
    </section>

    <section class="site-section "style="background: linear-gradient(to bottom right,#F4E869,  #FAF2D3, #5CD2E6,#3085C3);" >
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-12 heading-wrap text-center">
            <h4 class="sub-heading"style="color: darkgrey;">Mahalta's Restaurant</h4>
              <h2 class="heading">Featured Restaurant</h2>
          </div>
        </div>
        <div class="row ">
          <div class="col-md-7">
            <div class="media d-block room mb-0">
              <figure>
                <img src="/guest/images/MahaltaPic/20.jpg" alt="Generic placeholder image" class="img-fluid">
                
              </figure>
              <div class="media-body">
                <h3 class="mt-0"><a href="#">Dine In</a></h3>
                
                <p>Savor exquisite dining at our hotel and resort restaurant with a diverse menu and inviting ambiance. </p>
                <p><a href="<?= route_to('restaurant') ?>" class="btn btn-primary btn-sm">View Our Restaurant Options</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-5 room-thumbnail-absolute">
            <a href="#" class="media d-block room bg first-room" style="background-image: url(/guest/images/MahaltaPic/24.jpg); ">
              <!-- <figure> -->
                <div class="overlap-text">
                  <span>
                    Cafe 
                    
                  </span>
                  
                </div>
              <!-- </figure> -->
            </a>

            <a href="#" class="media d-block room bg second-room" style="background-image: url(/guest/images/cafe1.jpg); ">
              <!-- <figure> -->
                <div class="overlap-text">
                  <span>
                    Cafe Bar
                    
                  </span>
                </div>
              <!-- </figure> -->
            </a>
            
          </div>
        </div>
      </div>
    </section>

    <section class="site-section "style="background: linear-gradient(to  bottom left,#3085C3,#5CD2E6, #FAF2D3,  #FFFBE9,#F4E869,#F4E869);">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-12 heading-wrap text-center">
            <h4 class="sub-heading"style="color: darkgrey;">Mahalta's Conventions</h4>
              <h2 class="heading">Featured Conventions</h2>
          </div>
        </div>
        <div class="row ">
          <div class="col-md-7">
            <div class="media d-block room mb-0">
              <figure>
                <img src="/guest/images/event.jpg" alt="Generic placeholder image" class="img-fluid">
                <div class="overlap-text">
                  
                </div>
              </figure>
              <div class="media-body">
                <h3 class="mt-0"><a href="#">Events</a></h3>
                
                <p>Enjoy your events at our convention center – modern spaces, great amenities, and expert support for successful gatherings. </p>
                <p><a href="<?= route_to('convention') ?>" class="btn btn-primary btn-sm">View Our Convetions Options</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-5 room-thumbnail-absolute">
            <a href="#" class="media d-block room bg first-room" style="background-image: url(/guest/images/wedding.jpg); ">
              <!-- <figure> -->
                <div class="overlap-text">
                  <span>
                    Wedding and Celebrations
                    
                  </span>
                  
                </div>
              <!-- </figure> -->
            </a>

            <a href="#" class="media d-block room bg second-room" style="background-image: url(/guest/images/meeting.jpg); ">
              <!-- <figure> -->
                <div class="overlap-text">
                  <span>
                    Meeting 
                    
                  </span>
                  
                </div>
              <!-- </figure> -->
            </a>
            
          </div>
        </div>
      </div>
    </section>
    
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
    <!-- END section -->
    
<!--     <section class="site-section bg-light"style=" background: linear-gradient(to bottom,  #3085C3,#F4E869,#FAF2D3,#ECF9FF);">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-12 heading-wrap text-center">
            <h4 class="sub-heading"style="color: darkgrey;">Our Blog</h4>
              <h2 class="heading">Our Recent Blog</h2>
          </div>
        </div>
        <div class="row ">
          <div class="col-md-4">
            <div class="post-entry">
              <img src="/guest/images/MahaltaPic/5.jpg" alt="Image placeholder" class="img-fluid">
              <div class="body-text">
                <div class="category">Rooms</div>
                <h3 class="mb-3"><a href="#">New Rooms</a></h3>
                <p class="mb-4">Cozy room with modern amenities for a comfortable stay.</p>
                <p><a href="#" class="btn btn-primary btn-outline-primary btn-sm">Read More</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="post-entry">
              <img src="/guest/images/img_6.jpg" alt="Image placeholder" class="img-fluid">
              <div class="body-text">
                <div class="category">News</div>
                <h3 class="mb-3"><a href="#">New Staff Added</a></h3>
                <p class="mb-4">Professional staff dedicated to ensuring your satisfaction during your stay.</p>
                <p><a href="#" class="btn btn-primary btn-outline-primary btn-sm">Read More</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="post-entry">
              <img src="/guest/images/MahaltaPic/20.jpg" alt="Image placeholder" class="img-fluid">
              <div class="body-text">
                <div class="category">Restaurant</div>
                <h3 class="mb-3"><a href="#">Restaurant for All</a></h3>
                <p class="mb-4">Enjoy delicious meals in our restaurant for a delightful dining experience.</p>
                <p><a href="#" class="btn btn-primary btn-outline-primary btn-sm">Read More</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    <section class="testimonial-section" style="background: linear-gradient(to bottom,  #3085C3,#F4E869,#FAF2D3,#ECF9FF);">
  <div class="container">
    <div class="row mb-5">
    <div class="col-md-12 heading-wrap text-center">
    <br>
            <h4 class="sub-heading"style="color: darkgrey;">Guest Feedback</h4>
              <h2 class="heading">Feedback</h2>
          </div>
    </div>
    <div class="row">
      <?php foreach ($feedbacks as $feedback): ?>
        <div class="col-md-6">
          <div class="testimonial" style="background-color: #fff; border: 1px solid #ddd; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease-in-out; position: relative;">
            <div class="testimonial-content">
              <h3 class="testimonial-email" style="color: #333; font-size: 18px; margin-bottom: 10px;"><?=$feedback['Email']?></h3>
              <p class="testimonial-message" style="font-style: italic; font-size: 16px; color: #555;">"<?=$feedback['FeedbackMessage']?>"</p>
              <!-- Like button and count inline -->
              <button class="like-btn" onclick="likeFeedback(this)" style="background-color: #3498db; color: #fff; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">&#x1F44D;</button>
              <span class="like-count" style="margin-left: 5px;">0</span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <script>
    function likeFeedback(button) {
      var likeCountElement = button.nextElementSibling;
      var currentLikes = parseInt(likeCountElement.innerText);
      likeCountElement.innerText = currentLikes + 1;
    }
  </script>
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
    <script>
      
    </script>
    <?= $this->renderSection('scripts') ?>
  </body>
</html>