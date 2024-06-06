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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="/guest/css/style.css">
    <style>
        .receipt-container {
            background: white;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .receipt-header,
        .receipt-footer {
            text-align: center;
            padding: 10px 0;
        }

        .receipt-header h1 {
            margin: 0;
        }

        .section {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        p {
            margin: 5px 0;
            color: #555;
        }

        strong {
            color: #000;
        }

        .receipt-footer {
            font-size: 0.85em;
        }

        .button {
            display: block;
            width: max-content;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php include('inc/header.php') ?>
    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(/guest/images/3.jpg);">
        <div class="container">
            <div class="row align-items-center site-hero-inner justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="mb-5 element-animate">
                        <h1>Qr Path</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="site-section">
        <div class="receipt-container">
            <div class="receipt-header">
                <h1>Reservation Receipt</h1>
            </div>
            <div class="section">
                <h2>Guest Information</h2>
                <p><strong>Name:</strong> <?= $reservation->FirstName ?> <?= $reservation->LastName ?></p>
                <p><strong>Email:</strong> <?= $reservation->Email ?></p>
                <p><strong>Contact Number:</strong> <?= $reservation->ContactNumber ?></p>
            </div>
            <div class="section">
                <h2>Reservation Information</h2>
                <p><strong>Check-In Date:</strong> <?= $reservation->CheckInDate ?></p>
                <p><strong>NumberOfGuests:</strong> <?= $reservation->NumberOfGuests ?></p>
                <p><strong>Table:</strong> <?= $reservation->VenueName ?> </p>
                <p><strong>Note:</strong> <?= $reservation->Note ?> </p>
                <p style="color: <?= (new DateTime() > new DateTime($reservation->CheckInDate)) ? 'red' : 'green'; ?>;"><strong>Status:</strong> <?= $reservation->Status ?></p>
            </div>
            <div class="receipt-footer">
                <p>Thank you for choosing us!</p>
            </div>
            <button onclick="downloadPDF()" style="cursor: pointer;" class="button">Download Receipt</button>

            <a href="<?= base_url('') ?>" class="button">Back to Reservations</a>
        </div>
    </section>
    <?php include('inc/footer.php') ?>
    <?php include('inc/loader.php') ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
function downloadPDF() {
    const { jsPDF } = window.jspdf;

    const paperWidth = 210 / 2; 
    const paperHeight = 297 / 2; 
    const scaleFactor = Math.min(paperWidth / 210, paperHeight / 297);

    const doc = new jsPDF({
        orientation: 'portrait',
        unit: 'mm',
        format: [paperWidth, paperHeight]
    });

    const baseFontSize = 16; 
    const scaledFontSize = baseFontSize * scaleFactor;

    doc.setFont("helvetica", "bold");
    doc.setFontSize(scaledFontSize);

    const logoImg = new Image();
    logoImg.src = '<?=base_url()?>guest/images/logomahalta.png'; 
    const logoWidth = 20; 
    const logoHeight = (logoWidth / logoImg.width) * logoImg.height; 
    doc.addImage(logoImg, 'PNG', paperWidth - logoWidth - 10, scaledFontSize - 5, logoWidth, logoHeight);

    const receiptTitle = 'Reservation Receipt';
    const guestInfoText = `Name: <?= $reservation->FirstName ?> <?= $reservation->LastName ?>\nEmail: <?= $reservation->Email ?>\nContact Number: <?= $reservation->ContactNumber ?>`;
    const reservationInfoText = `Check-In Date: <?= $reservation->CheckInDate ?>\nNumber of Guests: <?= $reservation->NumberOfGuests ?>\nTable: <?= $reservation->VenueName ?>\nStatus: <?= $reservation->Status ?>`;

    doc.text(receiptTitle, paperWidth / 2, scaledFontSize, null, null, 'center');
    doc.text('Guest Information', 20, scaledFontSize * 2);
    doc.text(guestInfoText, 20, scaledFontSize * 3);
    doc.text('Reservation Information', 20, scaledFontSize * 5);
    doc.text(reservationInfoText, 20, scaledFontSize * 6);

    const footerText = 'Mahalta Resorts and Convention Center\nBrgy,Parang Calapan City,Oriental Mindoro,5200-Philippines\nMobile no.096812480329,Email:mahaltaresorts@gmail.com';
    doc.text(footerText, paperWidth / 2, paperHeight - scaledFontSize, null, null, 'center');

    doc.save('ReservationReceipt.pdf');
}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $('#arrival_date, #departure_date').datepicker({});
    </script>
    <script src="/guest/js/main.js"></script>
</body>

</html>