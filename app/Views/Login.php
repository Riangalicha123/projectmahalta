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
		#togglePassword {
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
			<div class="login-menu">
				<ul>
					<li><a href="<?= route_to('register') ?>" style="color: skyblue;">  Register</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-12">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Login</h2>
						</div>
						<form action="/loginAuth" method="post">
						<?php if(session()->has('success')): ?>
							<div class="alert alert-success">
								<?php echo session()->get('success'); ?>
							</div>
						<?php endif; ?>
						<?php if(session()->getFlashdata('msg')):?>
							<div class="alert alert-warning">
								<?=session()->getFlashdata('msg');?>
							</div>
						<?php endif;?>
							<div class="input-group custom">
								<input
									type="email"
									class="form-control form-control-lg" name="Email"
									placeholder="Email" value="<?= set_value('Email')?> "
								/>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="icon-copy dw dw-email1"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input
									type="password"
									class="form-control form-control-lg" name="Password"
									placeholder="**********" id="password"
								/>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
									<span class="input-group-text" id="togglePassword" style="display: none;">
										<i class="fa fa-eye"></i>
									</span>
								</div>
							</div>
							<div class="input-group custom">
								<p class="mb-1">
									<b><a href="<?= route_to('recover') ?>">I forgot my password</a></b>
								</p>
							</div>
							
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
									</div>
									<div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">
										OR
									</div>
									<div class="input-group mb-0">
										<a class="btn btn-outline-primary btn-lg btn-block" href="<?= route_to('register') ?>">Register To Create Account</a>
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
		// JavaScript for toggling password visibility
		const password = document.querySelector('#password');
		const togglePassword = document.querySelector('#togglePassword');
		const togglePasswordIcon = togglePassword.querySelector('i');

		password.addEventListener('input', function() {
			if (password.value.length > 0) {
				togglePassword.style.display = 'flex';
			} else {
				togglePassword.style.display = 'none';
			}
		});

		togglePassword.addEventListener('click', function () {
			// toggle the type attribute
			const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
			password.setAttribute('type', type);
			// toggle the eye icon
			togglePasswordIcon.classList.toggle('fa-eye');
			togglePasswordIcon.classList.toggle('fa-eye-slash');
		});
	</script>
</body>
</html>
