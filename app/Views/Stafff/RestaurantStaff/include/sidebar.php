<div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="<?=base_url()?>admin/dist/img/user.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?= route_to('staff-restaurant') ?>" class="d-block"><?= esc(session()->get('firstname')) ?> <?= esc(session()->get('lastname')) ?></a>
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
            <a class="nav-link <?= (isset($currenttRoute) && $currenttRoute === 'home') ? 'active' : '' ?> " href="<?= route_to('staff-restaurant') ?>">
              <i class="nav-icon fas fa-store"></i>
              <p>
                Home
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= (isset($currenttRoute) && $currenttRoute === 'restaurant') ? 'active' : '' ?> " href="<?= route_to('staff-restaurant-reservation') ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Reservations
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= (isset($currenttRoute) && $currenttRoute === 'venue') ? 'active' : '' ?> " href="<?= route_to('staff-restaurant-venue') ?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Venue
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= (isset($currenttRoute) && $currenttRoute === 'menu') ? 'active' : '' ?> " href="<?= route_to('staff-restaurant-menu') ?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Menu
              </p>
            </a>
          </li>
          
          <br>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex"></div>
          <li class="nav-item" >
            <a class="nav-link <?= (isset($currenttRoute) && $currenttRoute === 'ressetting') ? 'active' : '' ?> " href="<?= route_to('staff-ressetting') ?>">
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