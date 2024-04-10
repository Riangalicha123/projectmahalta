<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mahalta</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900|Rubik:300,400,700" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/guest/css/bootstrap.css">
    <link rel="stylesheet" href="/guest/css/animate.css">
    <link rel="stylesheet" href="/guest/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/guest/fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/guest/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/guest/css/magnific-popup.css">
    <!-- Theme Style -->
    <link rel="stylesheet" href="/guest/css/style.css">
    <?= $this->renderSection('stylesheets') ?>
    <style>
        /* Custom Styles */
        .room {
            margin-bottom: 30px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }
        .room img {
            width: 100%;
            height: auto;
            display: block;
        }
        .room .media-body {
            padding: 20px;
            background-color: #f9f9f9;
        }
        .room h3 {
            margin-top: 0;
        }
        .additionalDetails {
            display: none;
        }
        .viewMoreBtn {
            cursor: pointer;
        }
    </style>
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
                    <h1>Convention Reservation</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="site-section"style="background-image: url(/guest/images/malabomahalta.jpg); background-repeat: no-repeat; background-size: cover;">
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
                            <h3 class="h5"><a href="#" class="text-dark"><?= $convenue['conVenueName'] ?></a></h3>
                            <ul class="list-unstyled room-specs mb-3">
                                <li><span class="ion-ios-people-outline"></span> <?= $convenue['minGuest'] ?> - <?= $convenue['maxGuest'] ?> Guests</li>
                            </ul>
                            <!-- Add data attributes to store venue details and trigger modal -->
                            <button type="button" class="btn btn-primary btn-sm select-venue" data-toggle="modal" data-target="#venueModal" data-name="<?= $convenue['conVenueName'] ?>" data-image="<?= base_url('/convention/'.$convenue['Image']) ?>" data-min-guest="<?= $convenue['minGuest'] ?>" data-max-guest="<?= $convenue['maxGuest'] ?>">Select</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Venue Details Modal -->
<div class="modal fade" id="venueModal" tabindex="-1" role="dialog" aria-labelledby="venueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="venueModalLabel">Selected Venue Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" alt="" class="img-fluid rounded mb-3" id="venueImage">
                <div class="additional-details">
                    <h6 id="venueName"></h6>
                    <h6 id="minGuest"></h6>
                    <h6 id="maxGuest"></h6>
                </div>
            </div>
            <div class="modal-footer">
                <form action="<?= base_url('/convention-center/reservation/getconvenuedirectInformation') ?>" method="get">
                    <button type="submit" value="Reserve Now" class="btn btn-primary btn-sm">Check</button>
                </form>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to update modal content based on selected venue
    var selectButtons = document.querySelectorAll('.select-venue');
    selectButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var name = this.getAttribute('data-name');
            var minGuest = this.getAttribute('data-min-guest');
            var maxGuest = this.getAttribute('data-max-guest');
            var imageURL = this.getAttribute('data-image');

            // Update modal content with selected venue details
            document.getElementById('venueName').textContent = name;
            document.getElementById('minGuest').textContent = "Minimum Guests: " + minGuest;
            document.getElementById('maxGuest').textContent = "Maximum Guests: " + maxGuest;
            document.getElementById('venueImage').setAttribute('src', imageURL);
        });
    });
</script>






<?php include('inc/footer.php') ?>
<!-- END footer -->

<!-- loader -->
<?php include('inc/loader.php') ?>

<script>
    // Use a class for the View More buttons to distinguish between them
    var viewMoreButtons = document.querySelectorAll('.viewMoreBtn');

    // Loop through each button and add a click event listener
    viewMoreButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Find the parent container of the clicked button
            var parentContainer = button.closest('.room');

            // Find the additional details div inside the parent container
            var detailsDiv = parentContainer.querySelector('.additionalDetails');

            // Toggle the display of the additional details
            detailsDiv.style.display = (detailsDiv.style.display === 'none') ? 'block' : 'none';
        });
    });
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
