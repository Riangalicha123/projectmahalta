<div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="<?=base_url()?>admin/dist/img/user.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?= route_to('admin-dashboard') ?>" class="d-block"><?= esc(session()->get('firstname')) ?> <?= esc(session()->get('lastname')) ?></a>
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
            <a class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'dashboard') ? 'active' : '' ?> " href="<?= route_to('admin-dashboard') ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-header">MANAGEMENT</li>
          <li class="nav-item">
            <a  class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'customer') ? 'active' : '' ?> " href="<?= route_to('admin-customer') ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Guest Management
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a  class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'staffAccount') ? 'active' : '' ?> " href="<?= route_to('admin-staffaccounts') ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Staff Management
              </p>
            </a>
          </li>
          <li class="nav-item <?= (isset($adminRoutes) && ($adminRoutes === 'holService' || $adminRoutes === 'restService' || $adminRoutes === 'conService')) ? 'menu-open' : '' ?>">
              <a class="nav-link <?= (isset($adminRoutes) && ($adminRoutes === 'holService' || $adminRoutes === 'restService' || $adminRoutes === 'conService')) ? 'active' : '' ?>" href="#">
                  <i class="nav-icon fab fa-servicestack"></i>
                  <p>
                      Service Management
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'holService') ? 'active' : '' ?> " href="<?= route_to('admin-hotel/service') ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Hotel</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'restService') ? 'active' : '' ?> " href="<?= route_to('admin-restaurant/service') ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Restaurant</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'conService') ? 'active' : '' ?> " href="<?= route_to('admin-convention/service') ?>">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Convention</p>
                      </a>
                  </li>
              </ul>
          </li>
          <li class="nav-item <?= (isset($adminRoutes) && ($adminRoutes === 'holReservation' || $adminRoutes === 'restReservation' || $adminRoutes === 'conReservation')) ? 'menu-open' : '' ?>">
            <a class="nav-link <?= (isset($adminRoutes) && ($adminRoutes === 'holReservation' || $adminRoutes === 'restReservation' || $adminRoutes === 'conReservation')) ? 'active' : '' ?>" href="#">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Reservation M.
                <i class="fas fa-angle-left right "></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'holReservation') ? 'active' : '' ?> " href="<?= route_to('admin-hotel/reservation') ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hotel</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'restReservation') ? 'active' : '' ?> " href="<?= route_to('admin-restaurant/reservation') ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Restaurant</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'conReservation') ? 'active' : '' ?> " href="<?= route_to('admin-convention/reservation') ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Convention</p>
                </a>
            </li>
            </ul>
          </li>
          <li class="nav-item">
            <a  class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'inventoryHotel') ? 'active' : '' ?> " href="<?= route_to('admin-inventoryhotel') ?>">
            <i class="nav-icon fas fa-inventory"></i>
              <p>
                Inventory Management
              </p>
            </a>
          </li>
          <li class="nav-header">REPORT</li>
          <li class="nav-item">
            <a  class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'report') ? 'active' : '' ?> " href="<?= route_to('admin-report') ?>">
            <i class="nav-icon fas fa-print"></i>
              <p>
                Report Generation
              </p>
            </a>
          </li>
          <li class="nav-header"><hr></li>
          <li class="nav-item">
            <a  class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'newsPromotion') ? 'active' : '' ?> " href="<?= route_to('admin-newspromotion') ?>">
            <i class="nav-icon fas fa-newspaper"></i>
              <p>
                News - Promotion
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a  class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'feedback') ? 'active' : '' ?> " href="<?= route_to('admin-feedback') ?>">
              <i class="nav-icon fas fa-comment-alt"></i>
              <p>
                Feedback Analytics
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a  class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'chat') ? 'active' : '' ?> " href="<?= route_to('admin-chat') ?>">
            <i class="nav-icon fas fa-robot"></i>
              <p>
                Chat Bot
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a  class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'qrcode') ? 'active' : '' ?> " href="<?= route_to('admin-qrcode') ?>">
            <i class="nav-icon fas fa-qrcode"></i>
              <p>
                Manage Qr Code
              </p>
            </a>
          </li>
          
          <hr>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex"></div>
          <li class="nav-item" >
            <a class="nav-link <?= (isset($adminRoutes) && $adminRoutes === 'setting') ? 'active' : '' ?> " href="<?= route_to('admin-setting') ?>">
            <i class="nav-icon fas fa-user-cog"></i>
              <p>
                SETTING
              </p>
            </a>
          </li>
          <li class="nav-item" >
            <a class="nav-link" href="<?= route_to('admin-logout') ?>">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                LOG OUT
              </p>
            </a>
          </li>
        </ul>
        <ul>
          
        </ul>
      </nav>
      
      <!-- /.sidebar-menu -->
    </div>