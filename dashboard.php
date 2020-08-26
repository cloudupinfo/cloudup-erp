<?php include_once('include/comman_session.php');
include("include/header.php");

$table = "admin";
$table1 = "veihicle";
$today = "%".date("Y-m-d")."%";

$subAdmin = $db->numRow("SELECT (`role`) FROM ".$table." where `role`=?",array("subadmin"));	
$cashier = $db->numRow("SELECT (`role`) FROM ".$table." where `role`=?",array("cashier"));	
$modelA = $db->numRow("SELECT (`veihicle_id`) FROM ".$table1." where `status`=?",array(1));	
$modelI = $db->numRow("SELECT (`veihicle_id`) FROM ".$table1." where `status`=?",array(0));	
$showroomVeihicle = $db->numRow("SELECT (`veihicle_id`) FROM `product` where `status`=?",array(1));	
$showroomVeihicleToday = $db->numRow("SELECT (`product_id`) FROM `product` where `created_at` LIKE ?",array($today));
?>
<div class="main-container">
	<div class="navbar-content">
		<!-- start: SIDEBAR -->
		<div class="main-navigation navbar-collapse collapse">
			<!-- start: MAIN MENU TOGGLER BUTTON -->
			<div class="navigation-toggler">
				<i class="clip-chevron-left"></i>
				<i class="clip-chevron-right"></i>
			</div>
			<!-- end: MAIN MENU TOGGLER BUTTON -->
			<?php include("include/sidebar.php");?>
			
			
		</div>
		<!-- end: SIDEBAR -->
	</div>
	<!-- start: PAGE -->
	<div class="main-content">
		<!-- start: PANEL CONFIGURATION MODAL FORM -->
		<div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">Panel Configuration</h4>
					</div>
					<div class="modal-body">
						Here will be a configuration form
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							Close
						</button>
						<button type="button" class="btn btn-primary">
							Save changes
						</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
		<!-- end: SPANEL CONFIGURATION MODAL FORM -->
		<div class="container">
			
			<div class="row">
				<div class="col-sm-12">
					<!-- start: TEXT FIELDS PANEL -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>
							Dashboard Manage
							<div class="panel-tools">
								<a class="btn btn-xs btn-link" href=""><i class="fa fa-refresh"></i></a>
								<a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
							</div>
						</div>
						<div class="panel-body">
							<div class="row">
							<?php if(isset($_SESSION['admin_success'])){?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert">
									X
								</button>
								<i class="fa fa-check-circle"></i>
								<strong>Well done!</strong> <?php echo $_SESSION['admin_success'];?>
							</div>
							<?php 
								unset($_SESSION['admin_success']);
								}
							?>
							<?php if(isset($_SESSION['admin_error'])){?>
								<div class="alert alert-danger">
									<button class="close" data-dismiss="alert">
										X
									</button>
									<i class="fa fa-times-circle"></i>
									<strong>Oh snap!</strong> <?php echo $_SESSION['admin_error'];?>
								</div>
							<?php 
								unset($_SESSION['admin_error']);
								}
							?>
							<?php if($_SESSION['admin_role']=="main"){?>
								<div class="col-lg-12">
									<h3 class="text-primary">Adminitrator</h3>
									<div class="col-sm-2">
										<button class="btn btn-icon btn-block button-click">
											<i class="clip-plus-circle"></i>
											Sub Admin <span class="badge badge-primary"> <?php echo $subAdmin ? $subAdmin : 0;?> </span>
										</button>
									</div>
									<div class="col-sm-2">
										<button class="btn btn-icon btn-block button-click">
											<i class="clip-plus-circle"></i>
											Cashier <span class="badge badge-primary"> <?php echo $cashier ? $cashier : 0;?> </span>
										</button>
									</div>
								</div>
							<?php } ?>
							<div class="clearfix"></div>
							<?php if($_SESSION['admin_role']=="main" || $_SESSION['admin_role']=="subadmin"){?>
								<div class="col-lg-12">
									<h3 class="text-primary">Model Type</h3>
									<div class="col-sm-2">
										<button class="btn btn-icon btn-block model-click">
											<i class="clip-plus-circle"></i>
											Active <span class="badge badge-primary"> <?php echo $modelA ? $modelA : 0;?> </span>
										</button>
									</div>
									<div class="col-sm-2">
										<button class="btn btn-icon btn-block model-click">
											<i class="clip-plus-circle"></i>
											Inactive <span class="badge badge-primary"> <?php echo $modelI ? $modelI : 0;?> </span>
										</button>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-lg-12">
									<h3 class="text-primary">Showroom Veihicles</h3>
									<div class="col-sm-2">
										<button class="btn btn-icon btn-block show-veihicle-today">
											<i class="clip-plus-circle"></i>
											Today Veihicle <span class="badge badge-primary"> <?php echo $showroomVeihicleToday ? $showroomVeihicleToday : 0;?> </span>
										</button>
									</div>
									<div class="col-sm-2">
										<button class="btn btn-icon btn-block show-veihicle-all">
											<i class="clip-plus-circle"></i>
											All Veihicle <span class="badge badge-primary"> <?php echo $showroomVeihicle ? $showroomVeihicle : 0;?> </span>
										</button>
									</div>
								</div>
							<?php } ?>
							</div>
						</div>
					</div>
					<!-- end: TEXT FIELDS PANEL -->
				</div>
			</div>
		</div>
	</div>
	<!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->

<?php include("include/footer.php");?>
<script type="text/javascript">
$(document).ready(function() {
	//Admin Click
	$(".button-click").click(function() {
		window.location.href = "admin_list.php";
	});
	// Model Click
	$(".model-click").click(function() {
		window.location.href = "model_list.php";
	});
	// Showrrom All Veihicles Click
	$(".show-veihicle-all").click(function() {
		window.location.href = "product_list.php";
	});
	// Showrrom Today Veihicles Click
	$(".show-veihicle-today").click(function() {
		window.location.href = "product_list_today.php";
	});
});
function ajaxindicatorstart()
{
	if(jQuery('body').find('#resultLoading').attr('id') != 'resultLoading'){
	jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src="Loading.GIF"></div><div class="bg"></div></div>');
	}

	jQuery('#resultLoading').css({
		'width':'100%',
		'height':'100%',
		'position':'fixed',
		'z-index':'10000000',
		'top':'0',
		'left':'0',
		'right':'0',
		'bottom':'0',
		'margin':'auto'
	});

	jQuery('#resultLoading .bg').css({
		'background':'#000000',
		'opacity':'0.7',
		'width':'100%',
		'height':'100%',
		'position':'absolute',
		'top':'0'
	});

	jQuery('#resultLoading>div:first').css({
		'width': '250px',
		'height':'75px',
		'text-align': 'center',
		'position': 'fixed',
		'top':'0',
		'left':'0',
		'right':'0',
		'bottom':'0',
		'margin':'auto',
		'font-size':'16px',
		'z-index':'10',
		'color':'#ffffff'

	});

	jQuery('#resultLoading .bg').height('100%');
	   jQuery('#resultLoading').fadeIn(300);
	jQuery('body').css('cursor', 'wait');
}
function ajaxindicatorstop()
{
	jQuery('#resultLoading .bg').height('100%');
	   jQuery('#resultLoading').fadeOut(300);
	jQuery('body').css('cursor', 'default');
}
jQuery(document).ajaxStart(function () {
	//show ajax indicator
	//ajaxindicatorstart();
	}).ajaxStop(function () {
	//hide ajax indicator
	ajaxindicatorstop();
});
</script>