
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
                  <i class="fas fa-chart-pie mr-1"></i>
                  Reservation Reports
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#reservation-weekly" data-toggle="tab">Weekly</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#reservation-monthly" data-toggle="tab">Monthly</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#reservation-yearly" data-toggle="tab">Yearly</a>
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="reservation-weekly"
                       style="position: relative; height: 300px;">
                      <canvas id="reservationbarchart-weekly" height="300" style="height: 300px;"></canvas>
                   </div>
                  <div class="chart tab-pane" id="reservation-monthly" style="position: relative; height: 300px;">
                    <canvas id="reservationbarchart-monthly" height="300" style="height: 300px;"></canvas>
                  </div>
                  <div class="chart tab-pane" id="reservation-yearly" style="position: relative; height: 300px;">
                    <canvas id="reservationbarchart-yearly" height="300" style="height: 300px;"></canvas>
                  </div>
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Sales Reports
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#sales-weekly" data-toggle="tab">Weekly</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#sales-monthly" data-toggle="tab">Monthly</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#sales-yearly" data-toggle="tab">Yearly</a>
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="sales-weekly"
                       style="position: relative; height: 300px;">
                      <canvas id="salesbarchart-weekly" height="300" style="height: 300px;"></canvas>
                   </div>
                  <div class="chart tab-pane" id="sales-monthly" style="position: relative; height: 300px;">
                    <canvas id="salesbarchart-monthly" height="300" style="height: 300px;"></canvas>
                  </div>
                  <div class="chart tab-pane" id="sales-yearly" style="position: relative; height: 300px;">
                    <canvas id="salesbarchart-yearly" height="300" style="height: 300px;"></canvas>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        




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

<script src="<?=base_url()?>admin/plugins/jquery/jquery.min.js"></script>
<script src="<?=base_url()?>admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url()?>admin/plugins/chart.js/Chart.min.js"></script>
<script src="<?=base_url()?>admin/dist/js/adminlte.min.js"></script>
<script>
  $(function () {
    //--------------
    //- Reservation Bar CHART weekly -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var barChartCanvas = $('#reservationbarchart-weekly').get(0).getContext('2d');
    var barChartDataWeekly = {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'], // Updated labels to reflect weeks
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
                data: [0, 48, 40, 19, 86] // Adjusted data for weekly basis
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
                data: [28, 48, 40, 19, 86] // Adjusted data for weekly basis
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
                data: [28, 48, 40, 19, 86] // Adjusted data for weekly basis
            },
        ]
    };

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    };

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartDataWeekly,
        options: barChartOptions
    });

        //--------------
    //- Reservation Bar CHART monthly -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var barChartCanvasMonthly = $('#reservationbarchart-monthly').get(0).getContext('2d');
    var barChartDataMonthly = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September','October','November','December'],
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
                data: [0, 48, 40, 19, 86, 27, 90, 19, 86, 27, 23, 100]
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
                data: [28, 48, 40, 19, 86, 27, 90, 19, 86, 27, 23, 64]
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
                data: [28, 48, 40, 19, 86, 27, 90, 19, 86, 27, 23, 64]
            },
        ]
    };

    var barChartOptionsMonthly = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    };

    new Chart(barChartCanvasMonthly, {
        type: 'bar',
        data: barChartDataMonthly,
        options: barChartOptionsMonthly
    });
    
        //--------------
    //- Reservation Bar CHART yearly -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var barChartCanvasYearly = $('#reservationbarchart-yearly').get(0).getContext('2d');
    var barChartDataYearly = {
        labels: ['2024', '2025', '2026', '2027'], // Updated labels to reflect years
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
                data: [0, 48, 40, 19] // Adjusted data for yearly basis
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
                data: [28, 48, 40, 19] // Adjusted data for yearly basis
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
                data: [28, 48, 40, 19] // Adjusted data for yearly basis
            },
        ]
    };

    var barChartOptionsYearly = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    };

    new Chart(barChartCanvasYearly, {
        type: 'bar',
        data: barChartDataYearly,
        options: barChartOptionsYearly
    });
  })
</script>

<script>
  $(function () {
    //--------------
    //- sales Bar CHART weekly -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    /* var barChartCanvas = $('#salesbarchart-weekly').get(0).getContext('2d');
    var barChartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September','October','November','December'],
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
                data: [0, 48, 40, 19, 86, 27, 90, 19, 86, 27, 23, 100]
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
                data: [28, 48, 40, 19, 86, 27, 90, 19, 86, 27, 23, 64]
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
                data: [28, 48, 40, 19, 86, 27, 90, 19, 86, 27, 23, 64]
            },
        ]
    };
    var temp0 = barChartData.datasets[0];
    var temp1 = barChartData.datasets[1];
    barChartData.datasets[0] = temp1;
    barChartData.datasets[1] = temp0;

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    };

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    }); */

        //--------------
    //- sales Bar CHART monthly -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    /* var barChartCanvas = $('#salesbarchart-monthly').get(0).getContext('2d');
    var barChartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September','October','November','December'],
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
                data: [0, 48, 40, 19, 86, 27, 90, 19, 86, 27, 23, 100]
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
                data: [28, 48, 40, 19, 86, 27, 90, 19, 86, 27, 23, 64]
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
                data: [28, 48, 40, 19, 86, 27, 90, 19, 86, 27, 23, 64]
            },
        ]
    };

    // Swap datasets
    var temp0 = barChartData.datasets[0];
    var temp1 = barChartData.datasets[1];
    barChartData.datasets[0] = temp1;
    barChartData.datasets[1] = temp0;

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    };

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    }); */
        //--------------
    //- sales Bar CHART yearly -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    /* var barChartCanvas = $('#salesbarchart-yearly').get(0).getContext('2d');
    var barChartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September','October','November','December'],
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
                data: [0, 48, 40, 19, 86, 27, 90, 19, 86, 27, 23, 100]
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
                data: [28, 48, 40, 19, 86, 27, 90, 19, 86, 27, 23, 64]
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
                data: [28, 48, 40, 19, 86, 27, 90, 19, 86, 27, 23, 64]
            },
        ]
    };

    // Swap datasets
    var temp0 = barChartData.datasets[0];
    var temp1 = barChartData.datasets[1];
    barChartData.datasets[0] = temp1;
    barChartData.datasets[1] = temp0;

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
    };

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    }); */
  })
</script>
</body>
</html>
