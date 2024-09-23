<div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="<?=base_url()?>admin/dist/img/user.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?= route_to('staff-hotel') ?>" class="d-block"><?= esc(session()->get('firstname')) ?> <?= esc(session()->get('lastname')) ?></a>
        </div>
      </div>
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
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
            <a class="nav-link <?= (isset($currentRoute) && $currentRoute === 'hotelamenities') ? 'active' : '' ?> " href="<?= route_to('staff-hotelreservation-amenities') ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Reservation w/ Amenities
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
          <li class="nav-item">
            <a class="nav-link <?= (isset($currentRoute) && $currentRoute === 'walkin') ? 'active' : '' ?> " href="<?= route_to('staff-walkin') ?>">
              <i class="nav-icon fas fa-walking"></i>
              <p>
                Walk-In
              </p>
            </a>
          </li>
          
          <br>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex"></div>
          <li class="nav-item" >
            <a class="nav-link <?= (isset($currenttRoute) && $currenttRoute === 'hotelsetting') ? 'active' : '' ?> " href="<?= route_to('staff-hotelsetting') ?>">
            <i class="nav-icon fas fa-user-cog"></i>
              <p>
                SETTING
              </p>
            </a>
          </li>
          <li class="nav-item" >
            <a class="nav-link" href="<?= route_to('logout') ?>">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                LOG OUT
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>