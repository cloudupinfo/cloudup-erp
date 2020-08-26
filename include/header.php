<?php //define('HomeURL',"../admin/");
define('HomeURL',"");?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<title>Two Wheeler Showroom Management</title>
	<!-- start: META -->
	<meta charset="utf-8" />
	<!-- start: MAIN CSS -->
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/plugins/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/fonts/style.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/css/main.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/css/main-responsive.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/plugins/iCheck/skins/all.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/css/theme_light.css" type="text/css" id="skin_color">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/css/print.css" type="text/css" media="print"/>
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/plugins/select2/select2.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/plugins/datepicker/css/datepicker.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/plugins/jQuery-Tags-Input/jquery.tagsinput.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/plugins/summernote/build/summernote.css">
	<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
	<!-- DataTable -->
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/datatable/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/datatable/css/jquery.dataTables_themeroller.css">
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/datatable/css/buttons.dataTables.min.css">
	<link rel="icon" href="favicon.ico" type="image/x-icon" sizes="16x16">
	<!--Custom CSS-->
	<link rel="stylesheet" href="<?php echo HomeURL;?>assets/css/custom.css">
	</head>
		<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<!-- start: TOP NAVIGATION CONTAINER -->
			<div class="container">
				<div class="navbar-header">
					<!-- start: RESPONSIVE MENU TOGGLER -->
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="clip-list-2"></span>
					</button>
					<!-- end: RESPONSIVE MENU TOGGLER -->
					<!-- start: LOGO -->
					<a href="dashboard.php" class="navbar-brand">
						TS-MGMT
						<!--<img src="images/main-logo.png" class="img-responsive" style="width=50%;">-->
					</a>
					<!-- end: LOGO -->
				</div>
				<div class="navbar-tools">
					<!-- start: TOP NAVIGATION MENU -->
					<ul class="nav navbar-right">
						<!-- start: USER DROPDOWN -->
						<li class="dropdown current-user">
							<a href="#" data-close-others="true" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
								<img alt="" class="circle-img" src="images/user.png">
								<span class="username"><?php echo isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'login to continue...';?></span>
								<i class="clip-chevron-down"></i>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="profile.php?aid=<?php echo $_SESSION['admin_id'];?>">
										<i class="clip-user-2"></i>
										&nbsp;Update Profile
									</a>
								</li>
								<li>
									<a href="logout.php">
										<i class="clip-exit"></i>
										&nbsp;Log Out
									</a>
								</li>
							</ul>
						</li>
						<!-- end: USER DROPDOWN -->
					</ul>
					<!-- end: TOP NAVIGATION MENU -->
				</div>
			</div>
			<!-- end: TOP NAVIGATION CONTAINER -->
		</div>