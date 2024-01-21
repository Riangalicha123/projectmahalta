<div class="sidebar" style="background-color:#00abe4;">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="<?=base_url()?>admin/dist/img/user.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block" style="color:white;">Admin</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item" >
            <a class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'dashboard') ? 'active' : '' ?> " href="<?= route_to('admin-dashboard') ?>" style="color:white;">
              <i class="nav-icon fas fa-th" style="color:white;"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a  class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'customer') ? 'active' : '' ?> " href="<?= route_to('admin-customer') ?>" style="color:white;">
              <i class="nav-icon fas fa-user" style="color:white;"></i>
              <p>
                Customer
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="nav-icon fas fa-copy" style="color:white;"></i>
              <p style="color:white;">
                Reservation
                <i class="fas fa-angle-left right " style="color:white;"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'holReservation') ? 'active' : '' ?> " href="<?= route_to('admin-hotel/reservation') ?>" style="color:white;">
                  <i class="far fa-circle nav-icon" style="color:white;"></i>
                  <p>Hotel</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'restReservation') ? 'active' : '' ?> " href="<?= route_to('admin-restaurant/reservation') ?>" style="color:white;">
                  <i class="far fa-circle nav-icon" style="color:white;"></i>
                  <p>Restaurant</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'conReservation') ? 'active' : '' ?> " href="<?= route_to('admin-convention/reservation') ?>" style="color:white;">
                  <i class="far fa-circle nav-icon" style="color:white;"></i>
                  <p>Convention</p>
                </a>
            </li>
            </ul>
          </li>
          <li class="nav-item">
            <a  class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'staffAccount') ? 'active' : '' ?> " href="<?= route_to('admin-staffaccounts') ?>" style="color:white;">
              <i class="nav-icon fas fa-user" style="color:white;"></i>
              <p>
                Staff Accounts
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a  class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'rate') ? 'active' : '' ?> " href="<?= route_to('admin-rate') ?>" style="color:white;">
              <i class="nav-icon fas fa-star" style="color:white;"></i>
              <p>
                Rate Management
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a  class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'feedback') ? 'active' : '' ?> " href="<?= route_to('admin-feedback') ?>" style="color:white;">
              <i class="nav-icon fas fa-comment-alt" style="color:white;"></i>
              <p>
                Feedback Analytics
              </p>
            </a>
          </li>
          
          <br>
          <li class="nav-item" >
            <a class="nav-link" href="<?= route_to('logout') ?>" style="color:white;">
              <i class="nav-icon fas fa-sign-out-alt" style="color:white;"></i>
              <p>
                LOG OUT
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>