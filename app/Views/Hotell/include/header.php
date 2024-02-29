    <header header role="banner" style="position: fixed; top: 0; width: 100%; background: linear-gradient(to bottom,  #3085C3,#F4E869,#FAF2D3);color: white; padding: 20px; text-align: center; z-index: 1000;">
      <nav class="navbar navbar-expand-md navbar-dark bg-light">
        <div class="container">
        <a class="navbar-brand" href="<?= route_to('/') ?>"><img src="/guest/images/mahaltalogoo.png"  alt="Logo" class="mr-2"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse " id="navbarsExample05">
            <ul class="navbar-nav ml-auto pl-lg-5 pl-0">
            <li class="nav-item">
                <a class="nav-link <?= (isset($activePage) && $activePage === 'About') ? 'active' : '' ?>" href="<?= route_to('/') ?>" style="color: black; font-size: 20px;" target="_blank">Home</a>
            </li>
              <li class="nav-item">
                <a class="nav-link <?= (isset($activePage) && $activePage === 'Room') ? 'active' : '' ?> " href="<?= route_to('room') ?>" style="color: black; font-size: 20px;">FAQ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= (isset($activePage) && $activePage === 'Room') ? 'active' : '' ?> " href="<?= route_to('room') ?>" style="color: black; font-size: 20px;">Policy</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>