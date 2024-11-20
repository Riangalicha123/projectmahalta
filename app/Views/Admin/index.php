
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mahalta Admin</title>
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
  <?php include('include/navbar.php') ?>
  <aside class="main-sidebar sidebar-dark-primary elevation-4" >
    <?php include('include/logo.php') ?>
    <?php include('include/sidebar.php') ?>
  </aside>
  <div class="content-wrapper">
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
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
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
          <div class="col-lg-3 col-6">
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
          <div class="col-lg-3 col-6">
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
          <div class="col-lg-3 col-6">
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
        </div>
        <div class="row">
          <section class="col-lg-6 connectedSortable">
            <div class="card">
              <div class="card-header">
                  <h3 class="card-title">
                      <i class="fas fa-chart-bar mr-1"></i>
                      Reservation Reports
                  </h3>
                  <div class="card-tools">
                    <select class="form-control" id="yearSelect">
                        <?php
                        $currentYear = date('Y');
                        $startYear = 2024; 
                        $endYear = $currentYear + 5;
                        for ($year = $startYear; $year <= $endYear; $year++) {
                            echo "<option value='$year'>$year</option>";
                        }
                        ?>
                    </select>
                  </div>
              </div>
              <div class="card-body">
                  <div class="tab-content p-0">
                      <div class="chart tab-pane active" id="reservation-monthly"
                          style="position: relative; height: 300px;">
                          <canvas id="reservationbarchart-monthly" height="300" style="height: 300px;"></canvas>
                      </div>
                  </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Sentiment Analysis
                </h3>
              </div>
              <div class="card-body">
                <canvas id="sentimental-analysis" height="300" style="height: 300px;"></canvas>
              </div>
            </div>
          </section>
          <section class="col-lg-6 connectedSortable">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-1"></i>
                    Inventory Report
                </h3>
                <div class="card-tools">
                    <div class="input-group">
                        <select class="custom-select" id="year-sselectorr">
                            <?php
                            $currentYear = date('Y');
                            $startYear = 2024; 
                            $endYear = $currentYear + 5;
                            for ($year = $startYear; $year <= $endYear; $year++) {
                                echo "<option value='$year'>$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="reservation-monthly"
                         style="position: relative; height: 300px;">
                        <canvas id="inventoryreportchart-monthly" height="300" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
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
                      $currentYear = date('Y');
                      $startYear = 2024; 
                      $endYear = $currentYear + 5; 
                      for ($year = $startYear; $year <= $endYear; $year++) {
                          echo "<option value='$year'>$year</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="tab-content p-0">
                  <div class="chart tab-pane active" id="reservation-monthly"
                      style="position: relative; height: 300px;">
                      <canvas id="room" height="300" style="height: 300px;"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </section>
  </div>

  <?php include('include/footer.php') ?>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
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
                display: true, 
                position: 'bottom', 
                labels: {
                    boxWidth: 20, 
                    fontSize: 12, 
                    padding: 20 
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
      function fetchData(year) {
          $.ajax({
              url: '<?php echo base_url('admin/getReservationData'); ?>', 
              method: 'POST',
              data: { year: year },
              success: function (response) {
                  var reservations = JSON.parse(response);
                  var hotelReservations = [];
                  var restaurantReservations = [];
                  var conventionReservations = [];

                  reservations.forEach(function(reservation) {
                      if (reservation.Status === 'Confirm') { 
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
                                  beginAtZero: true, 
                                  suggestedMin: 0 
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
      var currentYear = new Date().getFullYear();
      fetchData(currentYear);
      $('#yearSelect').change(function() {
          var selectedYear = $(this).val();
          fetchData(selectedYear);
      });
  });
</script>

<script>
    $(function () {
        let chartInstance; // Keep track of the current chart instance

        $('#year-sselectorr').change(function () {
            var selectedYear = $(this).val();
            updateMonthlyChart(selectedYear);
        });

        function updateMonthlyChart(year) {
            $.ajax({
                url: '<?= base_url('admin/getMonthlyData') ?>',
                type: 'POST',
                data: { year: year },
                dataType: 'json',
                success: function (data) {
                    var productNames = [];
                    var monthlyData = {};
                    data.forEach(function (item) {
                        if (!monthlyData[item.ProductName]) {
                            monthlyData[item.ProductName] = Array(12).fill(0);
                        }
                        monthlyData[item.ProductName][item.ReservationMonth - 1] = item.TotalQuantity;
                    });

                    var datasets = [];
                    for (var productName in monthlyData) {
                        productNames.push(productName);
                        datasets.push({
                            label: productName,
                            borderColor: getRandomColor(),
                            borderWidth: 2, // Make the lines thicker for better visibility
                            fill: false, // Avoid filling the area under the line
                            data: monthlyData[productName]
                        });
                    }

                    var barChartDataMonthly = {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        datasets: datasets
                    };

                    var barChartOptionsMonthly = {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    boxWidth: 20
                                }
                            }
                        }
                    };

                    // Clear the previous chart instance if it exists
                    if (chartInstance) {
                        chartInstance.destroy();
                    }

                    // Create a new chart instance
                    var barChartCanvas = $('#inventoryreportchart-monthly').get(0).getContext('2d');
                    chartInstance = new Chart(barChartCanvas, {
                        type: 'line',
                        data: barChartDataMonthly,
                        options: barChartOptionsMonthly
                    });
                }
            });
        }

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Initialize with default year
        updateMonthlyChart('2024');
    });
</script>

<script>
$(function () {
  
  $('#year-selectorr').change(function() {
    var selectedYear = $(this).val();
    $.ajax({
      url: "<?php echo base_url('admin/getReservationByYear'); ?>",
      method: "POST",
      data: { selectedYear: selectedYear },
      dataType: "json",
      success: function(data) {
        updateMonthlyChart(data.roomreservations);
      }
    });
  });

  function updateMonthlyChart(data) {
    var labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var datasets = data;

    var chartData = [];
    var roomTypes = []; 
    var backgroundColors = []; 

    for (var i = 0; i < datasets.length; i++) {
      var roomTypeIndex = roomTypes.indexOf(datasets[i].RoomType);
      if (roomTypeIndex === -1) {
        roomTypes.push(datasets[i].RoomType);
        var randomColor = 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 0.6)';
        backgroundColors.push(randomColor);

        chartData.push({
          label: datasets[i].RoomType,
          data: Array(12).fill(0),
          backgroundColor: randomColor,
          borderWidth: 0 // Removed border color
        });
        roomTypeIndex = roomTypes.length - 1; 
      }
      chartData[roomTypeIndex].data[datasets[i].CheckInMonth - 1] = datasets[i].ReservationCount;
    }

    var barChartCanvas = $('#room').get(0).getContext('2d');
    var barChartDataMonthly = {
      labels: labels,
      datasets: chartData
    };

    var barChartOptionsMonthly = {
      responsive: true,
      maintainAspectRatio: false,
      datasetFill: false
    };

    if (window.barChart) {
      window.barChart.destroy();
    }
    window.barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartDataMonthly,
      options: barChartOptionsMonthly
    });
  }

  // Initial chart update with existing data
  updateMonthlyChart(<?php echo json_encode($roomreservations); ?>);
});
</script>
</body>
</html>
