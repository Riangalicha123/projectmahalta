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
    <section class="site-hero site-hero-innerpage overlay" data-stellar-background-ratio="0.5" style="background-image: url(<?=base_url()?>guest/images/3.jpg);">
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
                <p><strong>Check-Out Date:</strong> <?= $reservation->CheckOutDate ?></p>
                <p><strong>Adult:</strong> <?= $reservation->Adult ?></p>
                <p><strong>Child:</strong> <?= $reservation->Child ?></p>
                <p><strong>Room:</strong> <?= $reservation->RoomNumber ?> - <?= $reservation->RoomType ?></p>
                
                <p style="color: <?= (new DateTime() > new DateTime($reservation->CheckOutDate)) ? 'red' : 'green'; ?>;"><strong>Status:</strong> <?= $reservation->Status ?></p>
            </div>
            <div class="section">
                <h2>Amenities Details</h2>
                <?php if (!empty($amenities)) : ?>
                    <ul>
                        <?php foreach ($amenities as $amenity) : ?>
                            <li><?= $amenity['ProductName'] ?> - <?= $amenity['insertQuantity'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No amenities selected</p>
                <?php endif; ?>
            </div>

            <div class="section">
                <h2>Room Details</h2>
                <p><strong>Description:</strong> <?= $reservation->Description ?></p>
                <p><strong>Price Per Night:</strong> <?= $reservation->PricePerNight ?></p>
            </div>
            <div class="section">
                <h2>Payment Details</h2>
                <p><strong>Payment Option:</strong> <?= $reservation->PaymentOption ?></p>
                <p><strong>Reference Number:</strong> <?= $reservation->ReferenceNumber ?></p>
                <p><strong>Payment Type:</strong> <?= $reservation->downorfullPayment ==  $reservation->TotalAmount ? 'Full Payment' : 'Down Payment' ?></p>
                <p><strong>Payment Amount:</strong> <?= $reservation->downorfullPayment ?></p>
                <p><strong>Total Amount:</strong> <?= $reservation->TotalAmount ?></p>

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
    const reservationInfoText = `Check-In Date: <?= $reservation->CheckInDate ?>\nCheck-Out Date: <?= $reservation->CheckOutDate ?>\nRoom: <?= $reservation->RoomNumber ?> - <?= $reservation->RoomType ?> - Total Amount: <?= $reservation->TotalAmount ?>\nStatus: <?= $reservation->Status ?>`;
    
    // Modified amenities section to handle multiple inserts
    let amenitiesText = 'Amenities Details:\n';
    <?php if (!empty($amenities)) : ?>
        <?php foreach ($amenities as $amenity) : ?>
            amenitiesText += `<?= $amenity['ProductName'] ?> - <?= $amenity['insertQuantity'] ?>\n`;
        <?php endforeach; ?>
    <?php else : ?>
        amenitiesText += 'No amenities selected';
    <?php endif; ?>

    const paymentDetailsText = `Payment Option: <?= $reservation->PaymentOption ?>\nReference Number: <?= $reservation->ReferenceNumber ?>\nPayment Type: <?= $reservation->downorfullPayment ==  $reservation->TotalAmount ? 'Full Payment' : 'Down Payment' ?> - Amount: <?= $reservation->downorfullPayment ?>`;

    doc.text(receiptTitle, paperWidth / 2, scaledFontSize, null, null, 'center');
    doc.text('Guest Information', 20, scaledFontSize * 2);
    doc.text(guestInfoText, 20, scaledFontSize * 3);
    doc.text('Reservation Information', 20, scaledFontSize * 5);
    doc.text(reservationInfoText, 20, scaledFontSize * 6);
    doc.text(amenitiesText, 20, scaledFontSize * 8);
    doc.text('Payment Details', 20, scaledFontSize * 11);
    doc.text(paymentDetailsText, 20, scaledFontSize * 12);

    const footerText = 'Mahalta Resorts and Convention Center\nBrgy,Parang Calapan City,Oriental Mindoro,5200-Philippines\nMobile no.096812480329,Email:mahaltaresorts@gmail.com';
    doc.text(footerText, paperWidth / 2, paperHeight - scaledFontSize, null, null, 'center');

    doc.save('ReservationReceipt.pdf');
}

</script>
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