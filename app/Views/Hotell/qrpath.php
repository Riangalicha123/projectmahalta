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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="<?=base_url()?>guest/css/style.css">
    <style>
        .site-section {
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .download-btn {
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <?php include('inc/header.php') ?>
    <!-- <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(<?=base_url()?>guest/images/3.jpg);">
        <div class="container">
            <div class="row align-items-center site-hero-inner justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="mb-5 element-animate">
                        <h1>Qr Path</h1>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <br>
    <br>
    <br>
    <section class="site-section" style="background: rgba(250, 242, 211, 0.9); padding: 20px; height:700px;">
    <!-- Title -->
    <h1 class="text-center" style="font-size: 2.5rem; margin-bottom: 20px; line-height: 1.3; font-weight: bold;">Your QR Code</h1>
    
    <!-- Description -->
    <p class="text-center" style="font-size: 1.2rem; margin-bottom: 30px; line-height: 1.5; font-weight: 300;">Download this QR code and show it upon walk-in.</p>

    <!-- QR Code Image -->
    <div style="text-align: center;">
        <img src="<?= $qrCodePath ?>" alt="Your QR Code" style="max-width: 100%; height: auto; display: block; margin: 0 auto; max-width: 300px; width: 100%; object-fit: contain;">
    </div>

    <!-- Download Button -->
    <div class="text-center" style="margin-top: 20px;">
        <a href="<?= $qrCodePath ?>" download="QRCode.png" class="btn btn-primary" style="padding: 10px 20px; font-size: 1.2rem; text-decoration: none; background-color: #0056b3; color: white; border-radius: 5px; display: inline-block;">
            Download QR Code
        </a>
    </div>
</section>

    <?php include('inc/footer.php') ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $('#arrival_date, #departure_date').datepicker({});
    </script>
    <script src="<?=base_url()?>guest/js/main.js"></script>
</body>

</html>