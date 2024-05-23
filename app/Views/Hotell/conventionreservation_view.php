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
                <p><strong>Check-Out Date:</strong> <?= $reservation->CheckOutDate ?></p>
                <p><strong>NumberOfGuests:</strong> <?= $reservation->NumberOfGuests ?></p>
                <p><strong>Venue:</strong> <?= $reservation->conVenueName ?> </p>
                <p><strong>Event:</strong> <?= $reservation->EventType ?> </p>
                <p style="color: <?= (new DateTime() > new DateTime($reservation->CheckOutDate)) ? 'red' : 'green'; ?>;"><strong>Status:</strong> <?= $reservation->Status ?></p>
            </div>
            <div class="section">
                <h2>Venue Details</h2>
                <p><strong>Venue Name:</strong> <?= $reservation->conVenueName ?></p>
                <h2>Event Details</h2>
                <p><strong>Event Type:</strong> <?= $reservation->EventType ?></p>
                <p><strong>Event Description:</strong> <?= $reservation->Description ?></p>
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
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            doc.setFont("helvetica", "bold");
            doc.setFontSize(16);
            doc.text('Reservation Receipt', 105, 20, null, null, 'center');

            doc.setFontSize(12);
            doc.setFont("helvetica", "normal");
            doc.text(20, 40, 'Guest Information');
            doc.setFontSize(10);
            doc.text(`Name: ${'<?= $reservation->FirstName ?> <?= $reservation->LastName ?>'}`, 20, 50);
            doc.text(`Email: ${'<?= $reservation->Email ?>'}`, 20, 60);
            doc.text(`Contact Number: ${'<?= $reservation->ContactNumber ?>'}`, 20, 70);

            doc.setFontSize(12);
            doc.text('Reservation Information', 20, 90);
            doc.setFontSize(10);
            doc.text(`Check-In Date: ${'<?= $reservation->CheckInDate ?>'}`, 20, 100);
            doc.text(`Check-Out Date: ${'<?= $reservation->CheckOutDate ?>'}`, 20, 110);
            doc.text(`Venue: ${'<?= $reservation->conVenueName ?>'}`, 20, 120);
            doc.text(`Event: ${'<?= $reservation->EventType ?>'}`, 20, 130);
            doc.text(`Status: ${'<?= $reservation->Status ?>'}`, 20, 140, {
                fillColor: (new Date() > new Date('<?= $reservation->CheckOutDate ?>')) ? [255, 0, 0] : [0, 255, 0]
            });

            doc.setFontSize(12);
            doc.text('Payment Details', 20, 160);
            doc.setFontSize(10);
            doc.text(`Payment Option: ${'<?= $reservation->PaymentOption ?>'}`, 20, 170);
            doc.text(`Reference Number: ${'<?= $reservation->ReferenceNumber ?>'}`, 20, 180);
            doc.text(`Payment Type: ${'<?= $reservation->downorfullPayment ==  $reservation->TotalAmount ? 'Full Payment' : 'Down Payment' ?>'} - Amount: ${'<?= $reservation->downorfullPayment ?>'}`, 20, 190);

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