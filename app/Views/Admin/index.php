
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mahalta Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link rel="stylesheet" href="<?=base_url()?>admin/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  
<div class="wrapper">
  <?php include('include/loader.php') ?>
  <!-- Navbar -->
  
  <?php include('include/navbar.php') ?>
  <!-- /.navbar -->
  
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" >
    <!-- Brand Logo -->
    <?php include('include/logo.php') ?>

    <!-- Sidebar -->
    
    <?php include('include/sidebar.php') ?>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= count($hotelrevs); ?></h3>
                <p>Hotel Reservation</p>
              </div>
              <div class="icon">
              <i class="nav-icon fas fa-bed"></i>
              </div>
              <a href="<?= route_to('admin-hotel/reservation') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= count($restrevs); ?></h3>
                <p>Restaurant Reservation</p>
              </div>
              <div class="icon">
              <i class="nav-icon fas fa-utensils"></i>
              </div>
              <a href="<?= route_to('admin-restaurant/reservation') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
              <h3><?= count($reevents); ?></h3>
                <p>Convention Reservation</p>
              </div>
              <div class="icon">
                <i class="nav-icon fas fa-ethernet"></i>
              </div>
              <a href="<?= route_to('admin-convention/reservation') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <h3><?= count($customers); ?></h3>
                      <p>Customer Registrations</p>
              </div>
              <div class="icon">
              <i class="ion ion-person-add"></i>
              </div>
              <a href="<?= route_to('admin-customer') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                  <h3 class="card-title">
                      <i class="fas fa-chart-bar mr-1"></i>
                      Reservation Reports
                  </h3>
                  <div class="card-tools">
                    <select class="form-control" id="yearSelect">
                        <?php
                        // Generate options for years based on available data
                        $currentYear = date('Y');
                        $startYear = 2024; // Start year
                        $endYear = $currentYear + 5; // End year (current year)
                        for ($year = $startYear; $year <= $endYear; $year++) {
                            echo "<option value='$year'>$year</option>";
                        }
                        ?>
                    </select>
                  </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                  <div class="tab-content p-0">
                      <!-- Morris chart - Sales -->
                      <div class="chart tab-pane active" id="reservation-monthly"
                          style="position: relative; height: 300px;">
                          <canvas id="reservationbarchart-monthly" height="300" style="height: 300px;"></canvas>
                      </div>
                  </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Sentiment Analysis
                </h3>
                
              </div><!-- /.card-header -->
              <div class="card-body">
                <canvas id="sentimental-analysis" height="300" style="height: 300px;"></canvas>
              </div><!-- /.card-body -->
            </div>
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-line mr-1"></i>
                  Inventory Report
                </h3>
                <div class="card-tools">
                  <div class="input-group">
                    <select class="custom-select" id="year-selector">
                      <option value="2024" selected>2024</option>
                      <option value="2025">2025</option>
                      <option value="2026">2026</option>
                      <option value="2027">2027</option>
                    </select>
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="reservation-monthly"
                      style="position: relative; height: 300px;">
                      <canvas id="salesbarchart-monthly" height="300" style="height: 300px;"></canvas>
                  </div>
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-bar mr-1"></i>
                  Room Reservation Chart
                </h3>
                <div class="card-tools">
                  <div class="input-group">
                    <select class="custom-select" id="year-selectorr">
                      <?php
                      // Generate options for years based on available data
                      $currentYear = date('Y');
                      $startYear = 2024; // Start year
                      $endYear = $currentYear + 5; // End year (current year)
                      for ($year = $startYear; $year <= $endYear; $year++) {
                          echo "<option value='$year'>$year</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Chart -->
                  <div class="chart tab-pane active" id="reservation-monthly"
                      style="position: relative; height: 300px;">
                      <canvas id="room" height="300" style="height: 300px;"></canvas>
                  </div>
                </div>
              </div><!-- /.card-body -->
            </div>




            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

  <?php include('include/footer.php') ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
    <?php foreach ($roinvents as $roinvent): ?>
        <?php if ($roinvent['Quantity'] <= 10): ?>
            alert('Warning: Quantity is <?= $roinvent['Quantity'] ?> for <?= $roinvent['ProductName'] ?>');
        <?php endif; ?>
    <?php endforeach; ?>
</script>
<script src="<?=base_url()?>admin/plugins/jquery/jquery.min.js"></script>
<script src="<?=base_url()?>admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url()?>admin/plugins/chart.js/Chart.min.js"></script>
<script src="<?=base_url()?>admin/dist/js/adminlte.min.js"></script>
<script>
   var pieChartCanvas = document.getElementById('sentimental-analysis').getContext('2d');
        var pieData = {
            labels: ['Positive', 'Neutral', 'Negative'],
            datasets: [{
                data: [<?= $positivePercentage ?>, <?= $neutralPercentage ?>, <?= $negativePercentage ?>],
                backgroundColor: ['#00a65a', '#f39c12', '#f56954']
            }]
        };
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true, // Display the legend
                position: 'bottom', // You can adjust the position as per your requirement
                labels: {
                    boxWidth: 20, // Width of each legend box
                    fontSize: 12, // Font size of legend text
                    padding: 20 // Padding between legend elements
                }
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                            return previousValue + currentValue;
                        });
                        var currentValue = dataset.data[tooltipItem.index];
                        var percentage = Math.round((currentValue / total) * 100);
                        return percentage + "%";
                    }
                }
            }
        };
        var pieChart = new Chart(pieChartCanvas, {
            type: 'doughnut',
            data: pieData,
            options: pieOptions
        });
</script>
<script>
$(function () {
    // Function to fetch data based on selected year
    function fetchData(year) {
        $.ajax({
            url: '<?php echo base_url('admin/getReservationData'); ?>', // Change the URL accordingly
            method: 'POST',
            data: { year: year },
            success: function (response) {
                var reservations = JSON.parse(response);
                var hotelReservations = [];
                var restaurantReservations = [];
                var conventionReservations = [];

                reservations.forEach(function(reservation) {
                    if (reservation.Status === 'Confirm') { // Only process confirmed reservations
                        var checkInDate = new Date(reservation.CheckInDate);
                        var month = checkInDate.getMonth();

                        if (reservation.RoomID != null) {
                            hotelReservations[month] = hotelReservations[month] ? hotelReservations[month] + 1 : 1;
                        } else if (reservation.VenueID != null) {
                            restaurantReservations[month] = restaurantReservations[month] ? restaurantReservations[month] + 1 : 1;
                        } else if (reservation.conventionID != null) {
                            conventionReservations[month] = conventionReservations[month] ? conventionReservations[month] + 1 : 1;
                        }
                    }
                });

                var barChartCanvas = $('#reservationbarchart-monthly').get(0).getContext('2d');
                var barChartDataMonthly = {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [
                        {
                            label: 'Hotel Reservation',
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: hotelReservations
                        },
                        {
                            label: 'Restaurant Reservation',
                            backgroundColor: 'rgba(60,0,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: restaurantReservations
                        },
                        {
                            label: 'Convention Reservation',
                            backgroundColor: 'rgba(210, 214, 222, 1)',
                            borderColor: 'rgba(210, 214, 222, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(210, 214, 222, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(220,220,220,1)',
                            data: conventionReservations
                        },
                    ]
                };

                var barChartOptionsMonthly = {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true, // Ensure the scale starts at zero
                                suggestedMin: 0 // Set the suggested minimum value to zero
                            }
                        }]
                    }
                };

                new Chart(barChartCanvas, {
                    type: 'bar',
                    data: barChartDataMonthly,
                    options: barChartOptionsMonthly
                });
            }
        });
    }

    // Initial fetch for current year
    var currentYear = new Date().getFullYear();
    fetchData(currentYear);

    // Change event for year select
    $('#yearSelect').change(function() {
        var selectedYear = $(this).val();
        fetchData(selectedYear);
    });
});
</script>

<script>
  $(function () {
    $('#year-selector').change(function(){
      var selectedYear = $(this).val();
      updateMonthlyChart(selectedYear);
    });

    function updateMonthlyChart(year) {
      // Get context with jQuery - using jQuery's .get() method.
      var barChartCanvas = $('#salesbarchart-monthly').get(0).getContext('2d');
      var barChartDataMonthly = {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          datasets: [
    {
        label: 'Towel',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'green',
        pointRadius: true,
        pointColor: '#36A2EB',
        pointStrokeColor: 'rgba(54, 162, 235, 1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(54, 162, 235, 1)',
        data: [28, 48, 40, 19, 86, 27, 90, 19, 86, 27, 23, 64]
    },
    {
        label: 'Soap',
        backgroundColor: 'rgba(153, 102, 255, 0.2)',
        borderColor: 'blue',
        pointRadius: true,
        pointColor: '#36A2EB',
        pointStrokeColor: 'rgba(54, 162, 235, 1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(54, 162, 235, 1)',
        data: [12, 32, 56, 29, 77, 38, 85, 24, 75, 30, 29, 60]
    },
    {
        label: 'Toothpaste',
        backgroundColor: 'rgba(255, 159, 64, 0.2)',
        borderColor: 'red',
        pointRadius: true,
        pointColor: '#36A2EB',
        pointStrokeColor: 'rgba(54, 162, 235, 1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(54, 162, 235, 1)',
        data: [15, 35, 45, 25, 95, 20, 65, 30, 70, 40, 20, 55]
    },
    {
        label: 'Toothbrush',
        backgroundColor: 'rgba(255, 206, 86, 0.2)',
        borderColor: 'yellow',
        pointRadius: true,
        pointColor: '#36A2EB',
        pointStrokeColor: 'rgba(54, 162, 235, 1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(54, 162, 235, 1)',
        data: [5, 45, 25, 35, 75, 15, 85, 25, 60, 35, 25, 50]
    },
    {
        label: 'Shampoo',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'blue',
        pointRadius: true,
        pointColor: '#36A2EB',
        pointStrokeColor: 'rgba(54, 162, 235, 1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(54, 162, 235, 1)',
        data: [10, 40, 20, 30, 70, 10, 60, 20, 55, 25, 15, 45]
    },
    {
        label: 'Pillow Case',
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'pink',
        pointRadius: true,
        pointColor: '#36A2EB',
        pointStrokeColor: 'rgba(54, 162, 235, 1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(54, 162, 235, 1)',
        data: [20, 25, 35, 15, 80, 35, 95, 18, 85, 27, 18, 65]
    },
    {
        label: 'Bed',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'teal',
        pointRadius: true,
        pointColor: '#36A2EB',
        pointStrokeColor: 'rgba(54, 162, 235, 1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(54, 162, 235, 1)',
        data: [30, 50, 40, 20, 90, 28, 100, 22, 88, 29, 22, 70]
    }
]

      };

      var barChartOptionsMonthly = {
          responsive: true,
          maintainAspectRatio: false,
          datasetFill: false
      };

      new Chart(barChartCanvas, {
          type: 'line',
          data: barChartDataMonthly,
          options: barChartOptionsMonthly
      });
    }

    // Initialize the monthly chart with the default year (2024)
    updateMonthlyChart('2024');
  })
</script>
<script>
$(function () {
  
  $('#year-selectorr').change(function(){
    var selectedYear = $(this).val();
    // Gumawa ng POST request gamit ang AJAX
    $.ajax({
      url: "<?php echo base_url('admin/getReservationByYear'); ?>", // Ipalitan ang 'controller_name' sa pangalan ng iyong controller
      method: "POST",
      data: {selectedYear: selectedYear},
      dataType: "json",
      success: function(data) {
        // I-update ang chart gamit ang bagong data ng reservation
        updateMonthlyChart(data.roomreservations);
      }
    });
  });

  // Function para sa pag-update ng chart gamit ang bagong data
  function updateMonthlyChart(data) {
    // Prepare the data for the chart
    var labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var datasets = data;

    var data = [];
    var roomTypes = []; // Array to store unique room types
    var backgroundColors = []; // Array to store unique background colors for each room type
    var borderColor = 'rgba(255, 99, 132, 1)'; // Border color for all datasets

    for (var i = 0; i < datasets.length; i++) {
      var roomTypeIndex = roomTypes.indexOf(datasets[i].RoomType); // Check if room type already exists in the array
      if (roomTypeIndex === -1) {
        // If room type doesn't exist in the array, add it and initialize the corresponding data array
        roomTypes.push(datasets[i].RoomType);

        // Generate a random background color for the room type
        var randomColor = 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 0.2)';
        backgroundColors.push(randomColor);

        data.push({
          label: datasets[i].RoomType,
          data: Array(12).fill(0), // Initialize an array with 12 zeros (one for each month)
          backgroundColor: randomColor,
          borderColor: borderColor,
          borderWidth: 1
        });
        roomTypeIndex = roomTypes.length - 1; // Get the index of the newly added room type
      }
      // Add reservation count to the corresponding month's data array
      data[roomTypeIndex].data[datasets[i].CheckInMonth - 1] = datasets[i].ReservationCount;
    }

    // Get context with jQuery - using jQuery's .get() method.
    var barChartCanvas = $('#room').get(0).getContext('2d');
    var barChartDataMonthly = {
        labels: labels,
        datasets: data
    };

    var barChartOptionsMonthly = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    };

    // Destroy the previous chart instance if it exists
    if (window.barChart) {
      window.barChart.destroy();
    }

    // Create a new chart instance
    window.barChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartDataMonthly,
        options: barChartOptionsMonthly
    });
  }

  // Initialize the monthly chart with the default year (2024)
  updateMonthlyChart(<?php echo json_encode($roomreservations); ?>);
})
</script>


</body>
</html>
