
<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>Mahalta Admin</title>

		<!-- Site favicon -->
		<!-- <link
			rel="apple-touch-icon"
			sizes="180x180"
			href="<?=base_url()?>admin/vendors/images/apple-touch-icon.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="<?=base_url()?>admin/vendors/images/favicon-32x32.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="<?=base_url()?>admin/vendors/images/favicon-16x16.png"
		/> -->

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>admin/vendors/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="<?=base_url()?>admin/vendors/styles/icon-font.min.css"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="<?=base_url()?>admin/src/plugins/datatables/css/dataTables.bootstrap4.min.css"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="<?=base_url()?>admin/src/plugins/datatables/css/responsive.bootstrap4.min.css"
		/>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>admin/vendors/styles/style.css" />

		
	</head>
	<body>
		<!-- <div class="pre-loader">
			<div class="pre-loader-box">
				<div class="loader-logo">
					<img src="vendors/images/deskapp-logo.svg" alt="" />
				</div>
				<div class="loader-progress" id="progress_div">
					<div class="bar" id="bar1"></div>
				</div>
				<div class="percent" id="percent1">0%</div>
				<div class="loading-text">Loading...</div>
			</div>
		</div> -->


		<?php include 'include/header.php'?>
		<?php include 'include/sidebar.php'?>

		<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20">
							<h4 class="text-blue h4">Room Booking</h4>
							
						</div>
						<div class="pb-20">
							<table class="data-table table stripe hover nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">Check In</th>
										<th>Check Out</th>
										<th>Status</th>
										<th>Contact</th>
                                        <th>Full Name</th>
                                        <th>Room Type</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
                                <?php foreach($reservations as $reservation):?>
									<tr>
										<td class="table-plus"><?=$reservation['check_in']?></td>
										<td><?=$reservation['check_out']?></td>
										<td><?=$reservation['status']?></td>
										<td><?=$reservation['contact']?></td>
                                        <td><?=$reservation['FullName']?></td>
                                        <td><?=$reservation['room_type']?></td>
										<td>
											<div class="dropdown">
												<a
													class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
													href="#"
													role="button"
													data-toggle="dropdown"
												>
													<i class="dw dw-more"></i>
												</a>
												<div
													class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
												>
													<a class="dropdown-item" href="#"
														><i class="dw dw-edit2"></i> Edit</a
													>
													<a class="dropdown-item" href="#"
														><i class="dw dw-delete-3"></i> Delete</a
													>
												</div>
											</div>
										</td>
									</tr>
                                <?php endforeach;?>
								</tbody>
							</table>
						</div>
					</div>
					<!-- Simple Datatable End -->


				</div>
				<!-- <div class="footer-wrap pd-20 mb-20 card-box">
					DeskApp - Bootstrap 4 Admin Template By
					<a href="https://github.com/dropways" target="_blank"
						>Ankit Hingarajiya</a
					>
				</div> -->
			</div>
		</div>

		<!-- js -->
		<script src="<?=base_url()?>admin/vendors/scripts/core.js"></script>
		<script src="<?=base_url()?>admin/vendors/scripts/script.min.js"></script>
		<script src="<?=base_url()?>admin/vendors/scripts/process.js"></script>
		<script src="<?=base_url()?>admin/vendors/scripts/layout-settings.js"></script>
		<script src="<?=base_url()?>admin/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
		<script src="<?=base_url()?>admin/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
		<script src="<?=base_url()?>admin/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
		<script src="<?=base_url()?>admin/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
		<!-- buttons for Export datatable -->
		<script src="<?=base_url()?>admin/src/plugins/datatables/js/dataTables.buttons.min.js"></script>
		<script src="<?=base_url()?>admin/src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
		<script src="<?=base_url()?>admin/src/plugins/datatables/js/buttons.print.min.js"></script>
		<script src="<?=base_url()?>admin/src/plugins/datatables/js/buttons.html5.min.js"></script>
		<script src="<?=base_url()?>admin/src/plugins/datatables/js/buttons.flash.min.js"></script>
		<script src="<?=base_url()?>admin/src/plugins/datatables/js/pdfmake.min.js"></script>
		<script src="<?=base_url()?>admin/src/plugins/datatables/js/vfs_fonts.js"></script>
		<!-- Datatable Setting js -->
		<script src="<?=base_url()?>admin/vendors/scripts/datatable-setting.js"></script>
		
	</body>
</html>
