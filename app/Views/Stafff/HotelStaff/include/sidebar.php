<div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <img src="<?=base_url()?>admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        </div>
        <div class="info">
          <a href="<?= route_to('staff-hotel') ?>" class="d-block"><?= esc(session()->get('firstname')) ?> <?= esc(session()->get('lastname')) ?></a>
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
          <li class="nav-item">
            <a class="nav-link <?= (isset($currentRoute) && $currentRoute === 'home') ? 'active' : '' ?> " href="<?= route_to('staff-hotel') ?>">
              <i class="nav-icon fas fa-hotel"></i>
              <p>
                Home
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= (isset($currentRoute) && $currentRoute === 'hotel') ? 'active' : '' ?> " href="<?= route_to('staff-hotelreservation') ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Reservation
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= (isset($currentRoute) && $currentRoute === 'room') ? 'active' : '' ?> " href="<?= route_to('staff-hotelroom') ?>">
              <i class="nav-icon fas fa-bed"></i>
              <p>
                Room
              </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Inventory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a class="nav-link <?= (isset($currentRoute) && $currentRoute === '') ? 'active' : '' ?> " href="<?= route_to('staff-hotel') ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stock / Product</p>
                </a>
              </li>
            </ul>
          </li>
          <br>
          <br>
          <li class="nav-item" >
            <a class="nav-link" href="<?= route_to('logout') ?>" >
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