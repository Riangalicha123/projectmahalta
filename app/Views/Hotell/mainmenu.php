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
            <div class="modal-header" style="background:skyblue;">
                <h5 class="modal-title" id="exampleModalLabel">Reservation at Mahalta Resort</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form here -->
                <form action="<?= base_url('tableReservation') ?>" method="post" id="addItemForm">
                <div id="page1">
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="ArivalDate">Arrival Date</label>
                    <input type='date' class="form-control" id='ArivalDate' name='ArivalDate' required/>
                </div>
                <div class="col-sm-6 form-group">
                    <label for="ArivalTime">Arrival Time</label>
                    <input type='time' class="form-control" id='ArivalTime' name='ArivalTime' required/>
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
    <button type="button" class="btn btn-primary" onclick="nextPage(2)" style="margin: auto;">Enter your details</button>
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
                    <span id="displayDate"></span>
                </div>
                <div class="col-md-6 form-group">
                    <label>Arrival Time:</label>
                    <span id="displayTime"></span>
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
    <section  class="site-section"style="background: linear-gradient(to bottom right,#F4E869,  #FAF2D3, #5CD2E6,#ECF9FF,#ECF9FF); padding: 20px;  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <div class="menu-title">
      <h1>Main Menu</h1>
    </div>

    <div class="category-buttons" style="margin-top: 20px; text-align: center;">
      <button onclick="showCategory('1')" style="padding: 10px 20px; margin: 5px; background-color: #F5DD61; color: #333; border: none; border-radius: 5px; cursor: pointer;">Pasta</button>
      <button onclick="showCategory('2')" style="padding: 10px 20px; margin: 5px; background-color: #F5DD61; color: #333; border: none; border-radius: 5px; cursor: pointer;">Breakfast</button>
      <button onclick="showCategory('3')" style="padding: 10px 20px; margin: 5px; background-color: #F5DD61; color: #333; border: none; border-radius: 5px; cursor: pointer;">Sizzling</button>
      <button onclick="showCategory('4')" style="padding: 10px 20px; margin: 5px; background-color: #F5DD61; color: #333; border: none; border-radius: 5px; cursor: pointer;">Chicken</button>
      <button onclick="showCategory('5')" style="padding: 10px 20px; margin: 5px; background-color: #F5DD61; color: #333; border: none; border-radius: 5px; cursor: pointer;">Pork</button>
      <button onclick="showCategory('6')" style="padding: 10px 20px; margin: 5px; background-color: #F5DD61; color: #333; border: none; border-radius: 5px; cursor: pointer;">Soup</button>
      <button onclick="showCategory('7')" style="padding: 10px 20px; margin: 5px; background-color: #F5DD61; color: #333; border: none; border-radius: 5px; cursor: pointer;">Meal Deals</button>
      <button onclick="showCategory('8')" style="padding: 10px 20px; margin: 5px; background-color: #F5DD61; color: #333; border: none; border-radius: 5px; cursor: pointer;">Veggies</button>
      <button onclick="showCategory('9')" style="padding: 10px 20px; margin: 5px; background-color: #F5DD61; color: #333; border: none; border-radius: 5px; cursor: pointer;">Solo Meal</button>
      <button onclick="showCategory('10')" style="padding: 10px 20px; margin: 5px; background-color: #F5DD61; color: #333; border: none; border-radius: 5px; cursor: pointer;">Seafood/Fish</button>
      <button onclick="showCategory('11')" style="padding: 10px 20px; margin: 5px; background-color: #F5DD61; color: #333; border: none; border-radius: 5px; cursor: pointer;">Appetizer/Snack</button>
    </div>
    
      <div style="margin-top: 20px; border-bottom: 2px solid #ccc;">
        <!-- <h1 style="color: #333; margin-bottom: 10px;">CAFE MENU</h1> -->
        <div class="row">
    <?php foreach ($menumains as $menumain): ?>
        <?php if ($menumain['MenuType'] === 'Main Menu' && $menumain['CategoryID'] >= 1 && $menumain['CategoryID'] <= 11): ?>
            <div class="col-md-3" style="display: flex; flex-direction: column; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 2px solid #555;" data-category="<?= $menumain['CategoryID'] ?>">
                <h2 style="color: #333; margin-bottom: 10px;"><?= $menumain['CategoryName'] ?></h2>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <img src="<?= base_url('/restaurant/' . $menumain['Image']) ?>" alt="Dessert 1" style="width: 120px; height: 100px; border-radius: 8px; margin-right: 10px;">
                    <div style="flex-grow: 1;">
                        <h3 style="margin-top: 0;"><?= $menumain['ProductName'] ?></h3>
                        <p>Php<?= $menumain['ProductPrice'] ?></p>
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
    <script>
    // Get the current date
    var today = new Date().toISOString().split('T')[0];
    // Set the minimum date for the input field
    document.getElementById('ArivalDate').setAttribute('min', today);
</script>
<script>
    function updateVenueOptions() {
        var NumberOfGuests = document.getElementById('NumberOfGuests').value;

        // Send AJAX request to updateVenueOptions method in TableReservation controller
        $.ajax({
            url: "<?= base_url('updateVenueOptions') ?>",
            type: 'GET',
            data: { NumberOfGuests: NumberOfGuests },
            dataType: 'json',
            success: function(response) {
                var venueSelect = document.getElementById('VenueName');
                venueSelect.innerHTML = '<option>Select Venue</option>'; // Clear existing options
                response.forEach(function(venue) {
                    venueSelect.innerHTML += '<option value="' + venue.VenueName + '">' + venue.VenueName + '</option>';
                });
            }
        });
    }
</script>
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

    function displayFormData() {
        document.getElementById('displayDate').innerText = document.getElementById('ArivalDate').value;
        document.getElementById('displayTime').innerText = document.getElementById('ArivalTime').value;
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
        $('.col-md-3').hide(); // Hide all products initially
        $('.col-md-3[data-category="' + categoryID + '"]').show(); // Show products with the selected category ID
    }
</script>
<script>
    // Function to enable/disable buttons on page 1
    function enablePage1Button() {
        var arrivalDate = document.getElementById('ArivalDate').value;
        var arrivalTime = document.getElementById('ArivalTime').value;
        var venueName = document.getElementById('VenueName').value;
        var button = document.querySelector('#page1 button');
        if (arrivalDate && arrivalTime && venueName !== 'Select Venue') {
            button.disabled = false;
        } else {
            button.disabled = true;
        }
    }

    // Function to enable/disable buttons on page 2
    function enablePage2Button() {
        var firstName = document.getElementById('FirstName').value;
        var lastName = document.getElementById('LastName').value;
        var contactNumber = document.getElementById('ContactNumber').value;
        var button = document.querySelector('#page2 button[type="button"]');
        if (firstName && lastName && contactNumber) {
            button.disabled = false;
        } else {
            button.disabled = true;
        }
    }

    // Call enablePage1Button and enablePage2Button initially
    enablePage1Button();
    enablePage2Button();

    // Event listeners to call enable/disable functions on input/change
    document.getElementById('ArivalDate').addEventListener('change', enablePage1Button);
    document.getElementById('ArivalTime').addEventListener('change', enablePage1Button);
    document.getElementById('VenueName').addEventListener('change', enablePage1Button);
    document.getElementById('FirstName').addEventListener('input', enablePage2Button);
    document.getElementById('LastName').addEventListener('input', enablePage2Button);
    document.getElementById('ContactNumber').addEventListener('input', enablePage2Button);
</script>


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