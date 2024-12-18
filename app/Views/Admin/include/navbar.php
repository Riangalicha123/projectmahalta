<style>
    .notification-scroll {
        max-height: 300px; /* Adjust the height as needed */
        overflow-y: auto; /* Enables vertical scrolling */
        overflow-x: hidden; /* Prevents horizontal scrolling */
    }
    .dropdown-menu {
        width: 350px; /* Adjust the width if needed for better display */
    }
</style>
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
      <!-- Notification Icon with Badge -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" id="notificationDropdown">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" id="notificationBadge">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header" id="notificationHeader">No Notifications</span>
                <div id="notificationItems" class="notification-scroll">
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


<!-- jQuery & AJAX to dynamically load both inventory and reservation notifications -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // Fetch notifications when the page is ready
        fetchAllNotifications();

        function fetchAllNotifications() {
            $.when(fetchInventoryNotifications(), fetchReservationNotifications())
                .done(function (inventoryResponse, reservationResponse) {
                    var notificationBadge = $('#notificationBadge');
                    var notificationHeader = $('#notificationHeader');
                    var notificationItems = $('#notificationItems');

                    // Combine inventory and reservation notifications
                    var inventoryData = inventoryResponse[0];
                    var reservationData = reservationResponse[0];

                    var totalNotifications = inventoryData.length + reservationData.length;

                    // Clear previous notifications
                    notificationItems.empty();

                    if (totalNotifications > 0) {
                        notificationBadge.text(totalNotifications);
                        notificationHeader.text(totalNotifications + ' Notifications');

                        // Add inventory notifications
                        if (inventoryData.length > 0) {
                            inventoryData.forEach(function (item) {
                                notificationItems.append(`
                                    <a href="/admin-inventoryhotel" class="dropdown-item">
                                        <i class="fas fa-exclamation-triangle mr-2"></i> Low stock: ${item.ProductName}
                                        <span class="float-right text-muted text-sm">Quantity: ${item.Quantity}</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                `);
                            });
                        }

                        // Add reservation notifications
                        if (reservationData.length > 0) {
                            reservationData.forEach(function (item) {
                                var link = '';
                                if (item.type === 'room') {
                                    link = '/admin-hotel/reservation/';
                                } else if (item.type === 'restaurant') {
                                    link = '/admin-restaurant/reservation/';
                                } else if (item.type === 'convention') {
                                    link = '/admin-convention/';
                                }

                                notificationItems.append(`
                                    <a href="${link}" class="dropdown-item">
                                        <i class="fas fa-calendar-check mr-2"></i> New ${item.type} reservation 
                                        <span class="float-right text-muted text-sm">Check-in: ${item.CheckInDate}</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                `);
                            });
                        }
                    } else {
                        notificationBadge.text(0);
                        notificationHeader.text('No Notifications');
                    }
                });
        }

        // Fetch inventory notifications
        function fetchInventoryNotifications() {
            return $.ajax({
                url: '<?= base_url('notification/getNotifications') ?>',
                method: 'POST',
                dataType: 'json'
            });
        }

        // Fetch reservation notifications
        function fetchReservationNotifications() {
            return $.ajax({
                url: '<?= base_url('reservation-notifications/getReservationNotifications') ?>',
                method: 'POST',
                dataType: 'json'
            });
        }
    });
</script>
