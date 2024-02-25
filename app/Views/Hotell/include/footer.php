<footer class="site-footer">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-4">
            <h3 style="background: linear-gradient(to bottom, blue, lightgreen); -webkit-background-clip: text; color: transparent;font-weight: bold; font-size: 20px;">Phone Support</h3>
            <!-- <p>24/7 Call us now.</p> -->
            <p class="lead">
    <a href="tel://"> 
        <i class="fa fa-phone"style="color: #007bff;"></i> 09812480320
    </a>
</p>
<p class="lead">
    <a href="mailto:your-email@example.com">
        <i class="fa fa-envelope"style="color: #d93025;"></i> mahaltaresort@gmail.com
    </a>
</p>

            <h3 style="color: black;">Connect With Us</h3>
           <!--  <p>We are socialized. Follow us</p> -->
            <p>
            <a href="#" class="pl-0 p-3"style="color: #1877f2;"><span class="fa fa-facebook fa-lg"></span></a>
              <a href="#" class="p-3"style="color: #1da1f2;"><span class="fa fa-twitter fa-lg"></span></a>
              <a href="#" class="p-3"style="background: linear-gradient(to right, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d, #f56040, #f77737, #fcaf45, #ffdc80); -webkit-background-clip: text; color: transparent; display: inline-block;"><span class="fa fa-instagram fa-lg"></span></a>
              <a href="#" class="p-3" style="color: #ff0000;"><span class="fa fa-youtube fa-lg"></span></a>
              <!-- <a href="#" class="p-3"><span class="fa fa-vimeo"></span></a>
              <a href="#" class="p-3"><span class="fa fa-youtube-play"></span></a> -->
            </p>
          </div>
          <!-- <div class="col-md-4">
            <h3>Connect With Us</h3>
            <p>We are socialized. Follow us</p>
            <p>
            <a href="#" class="pl-0 p-3">
          <span class="fa fa-facebook fa-lg"></span></a>

              <a href="#" class="p-3"><span class="fa fa-twitter fa-lg"></span></a>
              <a href="#" class="p-3"><span class="fa fa-instagram fa-lg"></span></a>
              <a href="#" class="p-3"><span class="fa fa-vimeo"></span></a>
              <a href="#" class="p-3"><span class="fa fa-youtube-play"></span></a> 
            </p>
          </div> -->
          <!-- <div class="col-md-4">
            <h3>Connect With Us</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, odio.</p>
            <form action="#" class="subscribe">
              <div class="form-group">
                <button type="submit"><span class="ion-ios-arrow-thin-right"></span></button>
                <input type="email" class="form-control" placeholder="Enter email">
              </div>
              
            </form>
          </div> -->
          <div class="col-md-4">
    <!-- ... Your existing content ... -->
    <!-- Add Google Map -->
    <div class="col-md-4">
       <!--  <h3>Our Location</h3> -->
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7761.750176350001!2d121.20824972542549!3d13.42005806230071!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bce9395c682133%3A0x2a54eb8df931b1c2!2sMahalta%20Resorts%20and%20Convention%20Center!5e0!3m2!1sen!2sph!4v1700304323303!5m2!1sen!2sph" width="350" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" width="s" height="400" frameborder="0" style="border:0; width: 100%;" allowfullscreen=""></iframe>
    </div>
    <!-- ... Your existing content ... -->
</div>
        <?php if(session()->get('isLoggedIn')): ?>
        <div class="col-md-4">
                  <h3 style="background: linear-gradient(to bottom, blue, lightgreen); -webkit-background-clip: text; color: transparent;font-weight: bold; font-size: 20px;">Leave Your Feedback</h3>
                  <p> Share your thoughts with us!</p>
          <form action="/postFeedback" method="post" class="feedback-form">
            <div class="form-group">
              <!-- <label for="feedbackEmail">Your Email:</label> -->
              <input type="email" class="form-control" id="Email" name="Email" required value="<?= $_SESSION['username'] ?? ''; ?>">
              <!-- <label for="feedbackMessage"style="color: skyblue;">Your Feedback:</label> -->
              <textarea class="form-control" id="FeedbackMessage" name="FeedbackMessage" rows="4" placeholder="Enter your feedback" required ></textarea>
            </div>
            <div class="form-group text-center">
              <button type="submit" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; background-color: #007bff; color: #fff; border: 1px solid #fff; cursor: pointer;">Submit Feedback</button>
            </div>

          </form>
        </div>
        <?php else: ?>
        <div class="col-md-4">
                  <h3 style="background: linear-gradient(to bottom, blue, lightgreen); -webkit-background-clip: text; color: transparent;font-weight: bold; font-size: 20px;">Leave Your Feedback</h3>
                  <p> Share your thoughts with us!</p>
          <form action="#" class="feedback-form">
            <div class="form-group">
              <!-- <label for="feedbackEmail">Your Email:</label> -->
              <!-- <input type="email" class="form-control" id="Email" name="Email" required> -->
              <!-- <label for="feedbackMessage"style="color: skyblue;">Your Feedback:</label> -->
              <textarea class="form-control" id="FeedbackMessage" name="FeedbackMessage" rows="4" placeholder="Enter your feedback" ></textarea>
            </div>
            <div class="form-group text-center">
              <button type="submit" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; background-color: #007bff; color: #fff; border: 1px solid #fff; cursor: pointer;">Submit Feedback</button>
            </div>

          </form>
        </div>
        <?php endif; ?>
        </div>
        
        <div class="row justify-content-center">
          <div class="col-md-7 text-center" style="color: black;font-size: 16px;">
 <!--            &copy; 
Copyright --> &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | <a target="_blank">Mahalta Resort and Convention Center</a>

          </div>
        </div>
      </div>
    </footer>