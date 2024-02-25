<div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="<?=base_url()?>admin/dist/img/user.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?= route_to('inventory') ?>" class="d-block"><?= esc(session()->get('firstname')) ?> <?= esc(session()->get('lastname')) ?></a>
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
        <li class="nav-header">INVENTORY</li>
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a class="nav-link <?= (isset($inventoryRoutes) && $inventoryRoutes === 'home') ? 'active' : '' ?> " href="<?= route_to('staff-inventory') ?>">
              <i class="nav-icon fas fa-hotel"></i>
              <p>
                Home
              </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Stocks / Products
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a class="nav-link <?= (isset($inventoryRoutes) && $inventoryRoutes === 'inhotel') ? 'active' : '' ?> " href="<?= route_to('staff-inventory/hotel') ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hotel</p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= (isset($inventoryRoutes) && $inventoryRoutes === 'inrestaurant') ? 'active' : '' ?> " href="<?= route_to('staff-inventory/restaurant') ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Restaurant</p>
                </a>
              </li>
            </ul>
          </li>
          
          <br>
          <br>
          <li class="nav-item" >
            <a class="nav-link" href="<?= route_to('staff-logout') ?>" >
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                LOG OUT
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>