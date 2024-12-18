<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=base_url()?>admin/index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#" id="notificationDropdown">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge" id="notificationBadge">0</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header" id="notificationHeader">No Notifications</span>
        <div id="notificationItems">
            <!-- Notifications will be appended here by AJAX -->
        </div>
    </div>
</li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

    </ul>
  </nav>

  <!-- jQuery & AJAX to dynamically load notifications -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // Fetch notifications via AJAX when the page is ready
        fetchNotifications();

        function fetchNotifications() {
            $.ajax({
                url: '<?= base_url('staff-getNotifications') ?>',
                method: 'POST',
                dataType: 'json',
                success: function (response) {
                    var notificationBadge = $('#notificationBadge');
                    var notificationHeader = $('#notificationHeader');
                    var notificationItems = $('#notificationItems');

                    // Clear previous notifications
                    notificationItems.empty();

                    // Check if there are any notifications
                    if (response.length > 0) {
                        notificationBadge.text(response.length);
                        notificationHeader.text(response.length + ' Notifications');

                        // Loop through each notification and add it to the dropdown
                        response.forEach(function (item) {
                            notificationItems.append(`
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> Low stock: ${item.ProductName}
                                    <span class="float-right text-muted text-sm">Quantity: ${item.Quantity}</span>
                                </a>
                                <div class="dropdown-divider"></div>
                            `);
                        });
                    } else {
                        notificationBadge.text(0);
                        notificationHeader.text('No Notifications');
                    }
                }
            });
        }
    });
</script>