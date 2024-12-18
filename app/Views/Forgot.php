<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?= isset($activePage) ? $activePage : 'New Page Title'; ?></title>
	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?=base_url()?>guest/images/mahaltalogooo.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="<?=base_url()?>guest/images/mahaltalogooo.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>guest/images/mahaltalogooo.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="/reglog/vendors/styles/core.css" />
	<link rel="stylesheet" type="text/css" href="/reglog/vendors/styles/icon-font.min.css" />
	<link rel="stylesheet" type="text/css" href="/reglog/vendors/styles/style.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<style>
		#togglePassword, #toggleConfirmPassword {
			cursor: pointer;
			display: none;
			padding: 0 10px;
			align-items: center;
		}
		.input-group-text {
			display: flex;
			align-items: center;
		}
	</style>
</head>
<body class="login-page" style="background-image: url('/guest/images/3.jpg'); background-size: cover; background-position: center;">
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="/">
					<img src="/guest/images/mahaltalogoo.png" alt="" />
				</a>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-12">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Forgot Password</h2>
						</div>
						<form action="<?= base_url('updatePassword') ?>" method="post">
							<?php if (session()->getFlashdata('success')): ?>
								<div class="alert alert-success">
									<?= session()->getFlashdata('success'); ?>
								</div>
							<?php elseif (session()->getFlashdata('error')): ?>
								<div class="alert alert-danger">
									<?= session()->getFlashdata('error'); ?>
								</div>
							<?php endif; ?>
							<input type="hidden" name="temp_pass" value="<?= $temp_pass ?>">
							<div class="input-group custom">
								<input type="password" class="form-control form-control-lg" id="password" name="password" required placeholder="Password" />
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
									<span class="input-group-text" id="togglePassword" style="display: none;">
										<i class="fa fa-eye"></i>
									</span>
								</div>
							</div>
							<div class="input-group custom">
								<input type="password" class="form-control form-control-lg" id="cpassword" name="cpassword" required placeholder="Confirm Password" />
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
									<span class="input-group-text" id="toggleConfirmPassword" style="display: none;">
										<i class="fa fa-eye"></i>
									</span>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<input class="btn btn-primary btn-lg btn-block" type="submit" value="Update Password">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="/reglog/vendors/scripts/core.js"></script>
	<script src="/reglog/vendors/scripts/script.min.js"></script>
	<script src="/reglog/vendors/scripts/process.js"></script>
	<script src="/reglog/vendors/scripts/layout-settings.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const passwordInput = document.getElementById('password');
			const togglePassword = document.getElementById('togglePassword');
			const confirmPasswordInput = document.getElementById('cpassword');
			const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

			passwordInput.addEventListener('input', function() {
				togglePassword.style.display = this.value ? 'flex' : 'none';
			});

			confirmPasswordInput.addEventListener('input', function() {
				toggleConfirmPassword.style.display = this.value ? 'flex' : 'none';
			});

			togglePassword.addEventListener('click', function() {
				const type = passwordInput.type === 'password' ? 'text' : 'password';
				passwordInput.type = type;
				this.querySelector('i').classList.toggle('fa-eye-slash');
			});

			toggleConfirmPassword.addEventListener('click', function() {
				const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
				confirmPasswordInput.type = type;
				this.querySelector('i').classList.toggle('fa-eye-slash');
			});
		});
	</script>
</body>
</html>
