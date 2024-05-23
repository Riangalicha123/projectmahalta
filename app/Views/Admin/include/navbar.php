<nav class="main-header navbar navbar-expand navbar-white navbar-light" >
    <ul class="navbar-nav">
      <li class="nav-item" >
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block" >
        <a class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'dashboard') ? 'active' : '' ?> " href="<?= route_to('admin-dashboard') ?>">Home</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>