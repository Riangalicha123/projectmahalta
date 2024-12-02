
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mahalta Admin</title>
    <!-- Site favicon -->
		<link
			rel="apple-touch-icon"
			sizes="180x180"
			href="<?=base_url()?>guest/images/mahaltalogooo.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="<?=base_url()?>guest/images/mahaltalogooo.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="<?=base_url()?>guest/images/mahaltalogooo.png"
		/>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>admin/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?=base_url()?>admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url()?>admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url()?>admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>admin/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

  <style>
  .selected {
    background-color: #d3d3d3; /* Change to your preferred selection color */
  }
  .selectable-row {
    cursor: pointer;
  }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
<?php include('include/loader.php'); ?>
  <?php include('include/navbar.php'); ?>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php include('include/logo.php'); ?>
    <?php include('include/sidebar.php'); ?>
  </aside>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Reports</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Report</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="text-center mb-3">
          <div class="btn-group" role="group">
            <button class="btn btn-primary" onclick="showHotel()">Hotel</button>
            <button class="btn btn-primary" onclick="showRestaurant()">Restaurant</button>
            <button class="btn btn-primary" onclick="showConvention()">Convention</button>
            <button class="btn btn-success" id="previewSelectedBtn" disabled onclick="showPreview()">Preview Selected</button>
          </div>
          <div class="text-center">
            <input type="text" class="form-control" id="dateRange" placeholder="Check-In-Date to Check-Out-Date" required />
          </div>
        </div>
<!-- Modal Structure -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="previewModalLabel">Preview Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <div id="pdfPreview">
          <!-- PDF Header -->
          <div class="text-center mb-4">
            <h3>Hotel, Restaurant, and Convention Report</h3>
            <p>Generated on: <span id="reportDate"></span></p>
          </div>
          <!-- PDF Table Content -->
          <div>
            <table class="table table-bordered">
              <thead id="pdfTableHeader"></thead>
              <tbody id="pdfTableBody"></tbody>
            </table>
          </div>
        </div>
        <div id="pdfPreviewContent" style="display:none;">
          <!-- This will be filled with PDF preview content once 'Print' is clicked -->
        </div>
      </div>
      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="printPDF()">Preview PDF Content</button>
        <button class="btn btn-success" onclick="downloadExcel()">Download as Excel</button>
      </div>
    </div>
  </div>
</div>

        <!-- Hotel Report Table -->
        <table id="hotelreportTable" class="table table-bordered" style="display: block;">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Address</th>
              <th>Room Number</th>
              <th>Room Type</th>
              <th>Arrival</th>
              <th>Departure</th>
              <th>Adult</th>
              <th>Child</th>
              <th>Payment Option</th>
              <th>Reference No.</th>
              <th>Down or Full Payment</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($hotelrevs as $hotelrev): ?>
            <tr class="selectable-row">
              <td><?=$hotelrev['FirstName'] ?></td>
              <td><?=$hotelrev['LastName'] ?></td>
              <td><?=$hotelrev['Address'] ?></td>
              <td><?=$hotelrev['RoomNumber'] ?></td>
              <td><?=$hotelrev['RoomType'] ?></td>
              <td><?=$hotelrev['CheckInDate'] ?></td>
              <td><?=$hotelrev['CheckOutDate'] ?></td>
              <td><?=$hotelrev['Adult'] ?></td>
              <td><?=$hotelrev['Child'] ?></td>
              <td><?=$hotelrev['PaymentOption'] ?></td>
              <td><?=$hotelrev['ReferenceNumber'] ?></td>
              <td><?=$hotelrev['downorfullPayment'] ?></td>
              <td class="project-state">
                <span class="badge <?=$hotelrev['Status'] == 'Confirm' ? 'badge-success' : ($hotelrev['Status'] == 'Pending' ? 'badge-warning' : 'badge-danger') ?>"><?=$hotelrev['Status'] ?></span>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <!-- Restaurant Report Table -->
        <table id="restaurantreportTable" class="table table-bordered" style="display: none;">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Address</th>
              <th>Venue</th>
              <th>Arrival</th>
              <th>Note</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($restrevs as $restrev): ?>
            <tr class="selectable-row">
              <td><?=$restrev['FirstName'] ?></td>
              <td><?=$restrev['LastName'] ?></td>
              <td><?=$restrev['Address'] ?></td>
              <td><?=$restrev['VenueName']?></td>
              <td><?=$restrev['CheckInDate']?></td>
              <td><?=$restrev['Note']?></td>
              <td class="project-state">
                <span class="badge <?= $restrev['Status'] == 'Confirm' ? 'badge-success' : ($restrev['Status'] == 'Pending' ? 'badge-warning' : 'badge-danger') ?>"><?= $restrev['Status'] ?></span>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <!-- Convention Report Table -->
        <table id="conventionreportTable" class="table table-bordered" style="display: none;">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Address</th>
              <th>Venue Name</th>
              <th>Event Type</th>
              <th>Preferred Date</th>
              <th>Departure Date</th>
              <th>Number of Guests</th>
              <th>Payment Option</th>
              <th>Reference Number</th>
              <th>Down or Full Payment</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reevents as $reevent): ?>
            <tr class="selectable-row">
              <td><?=$reevent['FirstName'] ?></td>
              <td><?=$reevent['LastName'] ?></td>
              <td><?=$reevent['Address'] ?></td>
              <td><?=$reevent['conVenueName']?></td>
              <td><?=$reevent['EventType']?></td>
              <td><?=$reevent['CheckInDate']?></td>
              <td><?=$reevent['CheckOutDate']?></td>
              <td><?=$reevent['NumberOfGuests']?></td>
              <td><?=$reevent['PaymentOption']?></td>
              <td><?=$reevent['ReferenceNumber']?></td>
              <td><?=$reevent['downorfullPayment']?></td>
              <td class="project-state">
                <span class="badge <?= $reevent['Status'] == 'Confirm' ? 'badge-success' : ($reevent['Status'] == 'Pending' ? 'badge-warning' : 'badge-danger') ?>"><?= $reevent['Status'] ?></span>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
</section>
  </div>

  <?php include('include/footer.php'); ?>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="<?=base_url()?>admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>admin/dist/js/adminlte.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?=base_url()?>admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url()?>admin/plugins/jszip/jszip.min.js"></script>
<script src="<?=base_url()?>admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=base_url()?>admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  flatpickr("#dateRange", {
    mode: "range",
    dateFormat: "Y-m-d",
    onClose: function(selectedDates, dateStr, instance) {
      let startDate = selectedDates[0].toISOString().split('T')[0];
      let endDate = new Date(selectedDates[1]);
      endDate.setDate(endDate.getDate() + 2);
      endDate = endDate.toISOString().split('T')[0];

      let dataType = getSelectedDataType();

      $.ajax({
        url: '/admin-report/fetch-report-data',
        method: 'POST',
        dataType: 'json',
        data: { start_date: startDate, end_date: endDate, data_type: dataType },
        success: function(response) {
          updateTable(response, dataType);
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }
  });
});

function updateTable(data, dataType) {
  let tableBody;
  if (dataType === 'hotel') {
    tableBody = $('#hotelreportTable tbody');
    $('#restaurantreportTable').hide();
    $('#conventionreportTable').hide();
  } else if (dataType === 'restaurant') {
    tableBody = $('#restaurantreportTable tbody');
    $('#hotelreportTable').hide();
    $('#conventionreportTable').hide();
  } else if (dataType === 'convention') {
    tableBody = $('#conventionreportTable tbody');
    $('#hotelreportTable').hide();
    $('#restaurantreportTable').hide();
  }
  tableBody.empty();

  // Loop through the data and populate the table rows
  data.forEach(function(item) {
    let row = $('<tr class="selectable-row">');
    if (dataType === 'hotel') {
      row.append($('<td>').text(item.FirstName));
      row.append($('<td>').text(item.LastName));
      row.append($('<td>').text(item.Address));
      row.append($('<td>').text(item.RoomNumber));
      row.append($('<td>').text(item.RoomType));
      row.append($('<td>').text(item.CheckInDate));
      row.append($('<td>').text(item.CheckOutDate));
      row.append($('<td>').text(item.Adult));
      row.append($('<td>').text(item.Child));
      row.append($('<td>').text(item.PaymentOption));
      row.append($('<td>').text(item.ReferenceNumber));
      row.append($('<td>').text(item.downorfullPayment));
      let statusBadgeClass = item.Status == 'Confirm' ? 'badge-success' : (item.Status == 'Pending' ? 'badge-warning' : 'badge-danger');
      let statusBadge = $('<span>').addClass('badge ' + statusBadgeClass).text(item.Status);
      row.append($('<td>').append(statusBadge));
    } else if (dataType === 'restaurant') {
      row.append($('<td>').text(item.FirstName));
      row.append($('<td>').text(item.LastName));
      row.append($('<td>').text(item.Address));
      row.append($('<td>').text(item.VenueName));
      row.append($('<td>').text(item.CheckInDate));
      row.append($('<td>').text(item.Note));
      let statusBadgeClass = item.Status == 'Confirm' ? 'badge-success' : (item.Status == 'Pending' ? 'badge-warning' : 'badge-danger');
      let statusBadge = $('<span>').addClass('badge ' + statusBadgeClass).text(item.Status);
      row.append($('<td>').append(statusBadge));
    } else if (dataType === 'convention') {
      row.append($('<td>').text(item.FirstName));
      row.append($('<td>').text(item.LastName));
      row.append($('<td>').text(item.Address));
      row.append($('<td>').text(item.conVenueName));
      row.append($('<td>').text(item.EventType));
      row.append($('<td>').text(item.CheckInDate));
      row.append($('<td>').text(item.CheckOutDate));
      row.append($('<td>').text(item.NumberOfGuests));
      row.append($('<td>').text(item.PaymentOption));
      row.append($('<td>').text(item.ReferenceNumber));
      row.append($('<td>').text(item.downorfullPayment));
      let statusBadgeClass = item.Status == 'Confirm' ? 'badge-success' : (item.Status == 'Pending' ? 'badge-warning' : 'badge-danger');
      let statusBadge = $('<span>').addClass('badge ' + statusBadgeClass).text(item.Status);
      row.append($('<td>').append(statusBadge));
    }
    tableBody.append(row);
  });

  // Reapply the row click event listener after updating the table
  applyRowSelection();
}

// Function to reapply the row selection event
function applyRowSelection() {
  document.querySelectorAll('.selectable-row').forEach(row => {
    row.addEventListener('click', function() {
      this.classList.toggle('selected');
    });
  });
}

function getSelectedDataType() {
  return document.querySelector('.btn-group .btn-primary.active')?.textContent.toLowerCase() || 'hotel';
}

// Row selection style
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('selectable-row')) {
    e.target.classList.toggle('selected');
  }
});

    function getSelectedDataType() {
        if ($('#hotelreportTable').is(':visible')) {
            return 'hotel';
        } else if ($('#restaurantreportTable').is(':visible')) {
            return 'restaurant';
        } else if ($('#conventionreportTable').is(':visible')) {
            return 'convention';
        }
    }

    function showHotel() {
        document.getElementById("hotelreportTable").style.display = "table";
        document.getElementById("restaurantreportTable").style.display = "none";
        document.getElementById("conventionreportTable").style.display = "none";
      }
      function showRestaurant() {
        document.getElementById("hotelreportTable").style.display = "none";
        document.getElementById("restaurantreportTable").style.display = "table";
        document.getElementById("conventionreportTable").style.display = "none";
      }
      function showConvention() {
        document.getElementById("hotelreportTable").style.display = "none";
        document.getElementById("restaurantreportTable").style.display = "none";
        document.getElementById("conventionreportTable").style.display = "table";
      }
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    applyRowSelection();

    // Enable Preview Button on Row Selection
    document.addEventListener('click', function (e) {
      if (e.target.closest('.selectable-row')) {
        updatePreviewButtonState();
      }
    });
  });

  function updatePreviewButtonState() {
    const selectedRows = document.querySelectorAll('.selectable-row.selected');
    const previewBtn = document.getElementById('previewSelectedBtn');
    previewBtn.disabled = selectedRows.length === 0;
  }

  function showPreview() {
  const selectedRows = Array.from(document.querySelectorAll('.selectable-row.selected'));
  const pdfTableHeader = document.getElementById('pdfTableHeader');
  const pdfTableBody = document.getElementById('pdfTableBody');
  const reportDate = document.getElementById('reportDate');
  const dataType = getSelectedDataType(); // Identify current type: Hotel, Restaurant, or Convention

  pdfTableHeader.innerHTML = ''; // Clear header
  pdfTableBody.innerHTML = ''; // Clear body
  reportDate.textContent = new Date().toLocaleDateString(); // Add date

  if (selectedRows.length === 0) {
    pdfTableBody.innerHTML = '<tr><td colspan="100%" class="text-center">No data selected.</td></tr>';
    return;
  }

  // Define Table Headers Based on Data Type
  let headers = [];
  if (dataType === 'hotel') {
    headers = ['First Name', 'Last Name', 'Address', 'Room Number', 'Room Type', 'Arrival', 'Departure', 'Adult', 'Child', 'Payment Option', 'Reference No.', 'Down/Full Payment', 'Status'];
  } else if (dataType === 'restaurant') {
    headers = ['First Name', 'Last Name', 'Address', 'Venue', 'Arrival', 'Note', 'Status'];
  } else if (dataType === 'convention') {
    headers = ['First Name', 'Last Name', 'Address', 'Venue Name', 'Event Type', 'Preferred Date', 'Departure Date', 'Number of Guests', 'Payment Option', 'Reference No.', 'Down/Full Payment', 'Status'];
  }

  // Populate Table Header
  pdfTableHeader.innerHTML = `<tr>${headers.map(header => `<th>${header}</th>`).join('')}</tr>`;

  // Populate Table Body
  selectedRows.forEach(row => {
    const rowData = Array.from(row.children).map(cell => cell.textContent);
    const tableRow = document.createElement('tr');
    rowData.forEach(data => {
      const cell = document.createElement('td');
      cell.textContent = data;
      tableRow.appendChild(cell);
    });
    pdfTableBody.appendChild(tableRow);
  });

  // Show the Modal
  const modal = new bootstrap.Modal(document.getElementById('previewModal'));
  modal.show();
}
  function printPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
      orientation: "landscape",
      unit: "mm",
      format: "a4",
    });

    // Header
    doc.setFontSize(20);
    doc.text("Mahalta Resorts and Convention Center", 148, 15, { align: "center" });
    doc.setFontSize(12);
    doc.setFont("Times New Roman", "normal"); // Use Lucida Calligraphy
    doc.text("Parang, Calapan City, Oriental Mindoro", 148, 20, { align: "center" });
    // Table Data
    const table = document.querySelector("#pdfTableBody");
    const tableData = [...table.rows].map(row => 
      [...row.cells].map(cell => cell.innerText.trim())
    );

    const tableHeader = [...document.querySelector("#pdfTableHeader").rows[0].cells].map(
      header => header.innerText.trim()
    );

    // Create the table in the PDF
    doc.autoTable({
      head: [tableHeader],
      body: tableData,
      startY: 35,
      theme: "grid",
    });

    // Add Footer Information
    const footerText = `Mahalta Resorts and Convention Center
    Brgy. Parang, Calapan City, Oriental Mindoro, 5200 – Philippines
    Mobile Nos: +63 96812480320, Email: mahaltaresorts@gmail.com`;

    const pageCount = doc.internal.getNumberOfPages();

    for (let i = 1; i <= pageCount; i++) {
      doc.setPage(i);
      doc.setFontSize(9);

      // Attempting to use Lucida Calligraphy
      doc.setFont("times", "italic"); // Fallback for Lucida Calligraphy

      // Footer text position and alignment
      const footerLines = footerText.split("\n");
      footerLines.forEach((line, index) => {
        doc.text(line, 148, 199 + index * 5, { align: "center" });
      });
    }
    // Generate the preview content as a Blob
    const pdfBlob = doc.output("blob");

    // Show the preview content
    const previewDiv = document.getElementById("pdfPreviewContent");
    previewDiv.style.display = "block"; // Make the div visible
    previewDiv.innerHTML = ''; // Clear any previous content

    const iframe = document.createElement("iframe");
    iframe.src = URL.createObjectURL(pdfBlob);
    iframe.style.width = "100%";
    iframe.style.height = "500px";
    iframe.frameBorder = "0";
    previewDiv.appendChild(iframe);
  }
  function applyRowSelection() {
    document.querySelectorAll('.selectable-row').forEach(row => {
      row.style.cursor = 'pointer'; // Set pointer cursor
      row.addEventListener('click', function () {
        this.classList.toggle('selected');
      });
    });
  }
  function downloadExcel() {
    // Create a new workbook
    const wb = XLSX.utils.book_new();
    
    // Prepare data for Excel
    const worksheetData = [
        ["Mahalta Resorts and Convention Center"],  // Resort name
        ["Calapan City, Oriental Mindoro"],        // Resort location
        [" "],                                    // Empty row for spacing
        ["Report Summary"],                       // Report title
        [" "],                                    // Empty row for spacing
    ];

    // Get table data from the modal
    const tableHeader = document.querySelector("#pdfTableHeader");
    const tableBody = document.querySelector("#pdfTableBody");
    
    // Extract header data (from table)
    const headers = [...tableHeader.rows[0].cells].map(cell => cell.innerText.trim());
    
    // Extract body data (from table)
    const data = [...tableBody.rows].map(row => 
        [...row.cells].map(cell => cell.innerText.trim())
    );
    
    // Combine resort info, title, and table data into worksheet data
    worksheetData.push(headers, ...data);
    
    // Create a worksheet
    const ws = XLSX.utils.aoa_to_sheet(worksheetData);
    
    // Add worksheet to the workbook
    XLSX.utils.book_append_sheet(wb, ws, "Report");
    
    // Generate Excel file and trigger download
    XLSX.writeFile(wb, "Report.xlsx");
}

</script>

<style>
  #pdfPreview {
    padding: 20px;
    border: 1px solid #ddd;
    background-color: #fff;
    font-family: Arial, sans-serif;
  }
  #pdfPreview h3 {
    margin-bottom: 10px;
  }
  #pdfPreview p {
    font-size: 14px;
    margin-bottom: 20px;
  }
  .table th, .table td {
    font-size: 12px;
    padding: 8px;
  }
</style>
</body>
</html>
