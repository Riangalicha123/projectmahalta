<header role="banner">
     
      <nav class="navbar navbar-expand-md navbar-dark bg-light">
        <div class="container">
          <a class="navbar-brand" href="<?= route_to('/') ?>">Mahalta Resorts & Convention</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse navbar-light" id="navbarsExample05">
            <ul class="navbar-nav ml-auto pl-lg-5 pl-0">
              <li class="nav-item ">
                  <a class="nav-link <?= (isset($activePage) && $activePage === 'Home') ? 'active' : '' ?> " href="<?= route_to('/') ?>" >Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= (isset($activePage) && $activePage === 'Room') ? 'active' : '' ?> " href="<?= route_to('room') ?>" >Room</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link <?= (isset($activePage) && $activePage === 'Blog') ? 'active' : '' ?> " href="<?= route_to('blog') ?>" >Blog</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link <?= (isset($activePage) && $activePage === 'Restaurant') ? 'active' : '' ?> " href="<?= route_to('restaurant') ?>" >Restaurant</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link <?= (isset($activePage) && $activePage === 'Convention') ? 'active' : '' ?> " href="<?= route_to('convention') ?>" >Convention</a>
              </li>
                <?php if(session()->get('isLoggedIn')): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="rooms.html" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Accounts</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <a class="dropdown-item" href="<?= route_to('settings') ?>">Settings</a>
                        <a class="dropdown-item" href="<?= route_to('logout') ?>">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= route_to('login') ?>">Log In</a></li>   
                <?php endif; ?>
              
                <?php if(session()->get('isLoggedIn')): ?>
                <li class="nav-item cta">
                <a class="nav-link <?= (isset($activePage) && $activePage === 'Reservation') ? 'active' : '' ?> " href="<?= route_to('bookroom') ?>"><span>Book Now</span></a>
                </li>
                <?php else: ?>
                    <li class="nav-item cta">
                    <a class="nav-link <?= (isset($activePage) && $activePage === 'Login') ? 'active' : '' ?> " href="<?= route_to('login') ?>"><span>Book Now</span></a>
                </li>
                <?php endif; ?>
            </ul>
            
          </div>
        </div>
      </nav>
    </header>