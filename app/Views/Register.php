
<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title><?= isset($activePage) ? $activePage : 'New Page Title'; ?></title>

		<!-- Site favicon -->
		<!-- <link
			rel="apple-touch-icon"
			sizes="180x180"
			href="vendors/images/apple-touch-icon.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="vendors/images/favicon-32x32.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="vendors/images/favicon-16x16.png"
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
		<link rel="stylesheet" type="text/css" href="/reglog/vendors/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="/reglog/vendors/styles/icon-font.min.css"
		/>
		<link rel="stylesheet" type="text/css" href="/reglog/vendors/styles/style.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

	</head>
	<body class="login-page" style="background-image: url('/guest/images/3.jpg'); background-size: cover; background-position: center;">
		<div class="login-header box-shadow">
			<div
				class="container-fluid d-flex justify-content-between align-items-center"
			>
				<div class="brand-logo">
					<a href="login.html">
						<img src="/guest/images/mahaltalogoo.png" alt="" />
					</a>
				</div>
					<div class="login-menu">
		<ul>
			<li><a href="<?= route_to('login') ?>"><i class="fas fa-sign-in-alt"></i> Login</a></li>
		</ul>
	</div>

			</div>
		</div>
		<div
			class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
		>
			<div class="container">
				<div class="row align-items-center">
					<!-- <div class="col-md-6 col-lg-7">
						<img src="/guest/images/4.jpg" alt="" />
					</div> -->
					<div class="col-md-12 col-lg-12">
						<div class="login-box bg-white box-shadow border-radius-10">
							<div class="login-title">
								<h2 class="text-center text-primary">Create Account</h2>
							</div>
							<form action="/registerAuth" method="post">
								<div class="select-role">
									
								</div>
								
								<div class="row">
								<div class="col-md-6">
								<div class="input-group custom">
									<input
										type="text"
										class="form-control form-control-lg" name="FirstName" 
										placeholder="First Name" value="<?= set_value('FirstName')?>"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-user1"></i
										></span>
									</div>
								</div>
								</div>
								<div class="col-md-6">
								<div class="input-group custom">
									<input
										type="text"
										class="form-control form-control-lg" name="LastName"
										placeholder="Last Name" value="<?= set_value('LastName')?>"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-user1"></i
										></span>
									</div>
								</div>
								</div>
								</div>
								
								<div class="input-group custom">
									<input
										type="text"
										class="form-control form-control-lg" name="ContactNumber" 
										placeholder="Contact Number" value="<?= set_value('ContactNumber')?>"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-phone-call"></i
										></span>
									</div>
								</div>
								<div class="input-group custom">
									<input
										type="text"
										class="form-control form-control-lg" name="Address" 
										placeholder="Address" value="<?= set_value('Address')?>"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-pin-1"></i
										></span>
									</div>
								</div>
								<div class="input-group custom">
									<input
										type="email"
										class="form-control form-control-lg" name="Email"
										placeholder="Email" value="<?= set_value('Email')?> "
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-user1"></i
										></span>
									</div>
								</div>
								<div class="row">
								<div class="col-md-6">
								<div class="input-group custom">
									<input
										type="password"
										class="form-control form-control-lg" name="Password"
										placeholder="Password"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="dw dw-padlock1"></i
										></span>
									</div>
								</div>
								</div>
								<div class="col-md-6">
								<div class="input-group custom">
									<input
										type="password"
										class="form-control form-control-lg" name="confirmPassword"
										placeholder="Confirm Password"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="dw dw-padlock1"></i
										></span>
									</div>
								</div>
								</div>
								</div>
								
								<div class="row">
									<div class="col-lg-12">
										<div class="input-group mb-0">
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign Up">
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
		
	</body>
</html>
