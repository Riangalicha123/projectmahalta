<?php include 'include/headr.php'?><!-- 
		<div class="pre-loader">
			<div class="pre-loader-box">
				<div class="loader-logo">
					<img src="<?=base_url()?>admin/vendors/images/deskapp-logo.svg" alt="" />
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
					
					<!-- Export Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20">
							<h4 class="text-blue h4">Rooms</h4>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#saveProductModal">
                    Add New Room
                </button>
						</div>
						<div class="pb-20">
							<table
								class="table hover multiple-select-row data-table-export nowrap"
							>
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">Room Type</th>
										<th>Price</th>
                                        <th>Description</th>
										<th>Status</th>
                                        <th>Image</th>
									</tr>
								</thead>
								<tbody>
                                <?php foreach($products as $product):?>
									<tr>
										<td class="table-plus"><?=$product['room_type']?></td>
										<td>₱<?=$product['price']?></td>
										<td><?=$product['description']?></td>
										<td><?=$product['status']?></td>
										<td><img src="<?=base_url('guest/images/'.$product['image']);?>." alt="#"/></td>
										
									</tr>
                                    <?php endforeach;?>
								</tbody>
							</table>
						</div>
					</div>
					<!-- Export Datatable End -->
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
