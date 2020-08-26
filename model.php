<?php include_once('include/comman_session.php');
include("include/header.php");

$table = "veihicle";
if(isset($_REQUEST['aid'])){
	$id=$_REQUEST['aid'];
}else{
	$id=0;
}
$select = $db->getRow("SELECT * FROM ".$table." where `veihicle_id`=?",array($id));
if($select){
	$type = "edit";
}else{
	$type = "add";
}
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
			<!-- start: PAGE HEADER -->
			<div class="row">
				<div class="col-sm-12">
					<!-- start: PAGE TITLE & BREADCRUMB -->
					<ol class="breadcrumb">
						<li>
							<i class="clip-pencil"></i>
							<a href="#">
								Home
							</a>
						</li>
						<li class="active">
							Model
						</li>
					</ol>
					<div class="page-header">
						<h1>Model Manage </h1>
					</div>
					<div id="nestable-menu" class="pull-right">
						<a href="model_list.php" class="btn btn-primary btn-squared">Model List</a>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
				<div class="col-sm-12">
					<!-- start: TEXT FIELDS PANEL -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>
							Model <?php echo $type;?>
							<div class="panel-tools">
								<a class="btn btn-xs btn-link" href=""><i class="fa fa-refresh"></i></a>
								<a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
							</div>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" method="post" action="model/modelManage.php" id="model-add-frm" name="model-add-frm" enctype="multipart/form-data">
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
								<input type="hidden" value="<?php echo $id;?>" name="id">
								<input type="hidden" value="<?php echo $type;?>" name="type">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Model Name
									</label>
									<div class="col-sm-7">
										<input type="text" <?php echo $type=="edit" ? 'readonly disabled' : '';?> placeholder="Model Name..." id="name" class="form-control" name="name" value="<?php echo !empty($select['name']) ? $select['name'] : '' ?>">
									</div>
								</div>
								<h4>Description</h4>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Class Of Vehicle
									</label>
									<div class="col-sm-7">
										<input type="text" placeholder="Class Of Vehicle..." id="c_of_v" class="form-control" name="c_of_v" value="<?php echo !empty($select['c_of_v']) ? $select['c_of_v'] : '' ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Weight
									</label>
									<div class="col-sm-7">
										<input type="text" placeholder="Weight..." id="weight" class="form-control" name="weight" value="<?php echo !empty($select['weight']) ? $select['weight'] : '' ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										CC
									</label>
									<div class="col-sm-7">
										<input type="text" placeholder="CC..." id="cc" class="form-control" name="cc" value="<?php echo !empty($select['cc']) ? $select['cc'] : '' ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Type Of Body
									</label>
									<div class="col-sm-7">
										<input type="text" placeholder="Type Of Body..." id="body" class="form-control" name="body" value="<?php echo !empty($select['body']) ? $select['body'] : '' ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Price
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="Price..." id="price" class="form-control" name="price" value="<?php echo !empty($select['price']) ? $select['price'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										RTO Single Registration Price
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="RTO Single Registration Price..." id="rto_single" class="form-control" name="rto_single" value="<?php echo !empty($select['rto_single']) ? $select['rto_single'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										RTO Double Registration Price
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="RTO Double Registration Price..." id="rto_double" class="form-control" name="rto_double" value="<?php echo !empty($select['rto_double']) ? $select['rto_double'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Smart NO. Plate Fitting Charge
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="NO. Plate Fitting..." id="no_plate_fitting" class="form-control" name="no_plate_fitting" value="<?php echo !empty($select['no_plate_fitting']) ? $select['no_plate_fitting'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										RMC Tax
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="RMC Tax..." id="rmc_tax" class="form-control" name="rmc_tax" value="<?php echo !empty($select['rmc_tax']) ? $select['rmc_tax'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<h4>Accessories</h4>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Side Stand
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="Accessories Side Stand..." id="side_stand" class="form-control" name="side_stand" value="<?php echo !empty($select['side_stand']) ? $select['side_stand'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Foot Rest
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="Accessories Foot Rest..." id="foot_rest" class="form-control" name="foot_rest" value="<?php echo !empty($select['foot_rest']) ? $select['foot_rest'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Leg Guard
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="Accessories Leg Guard..." id="leg_guard" class="form-control" name="leg_guard" value="<?php echo !empty($select['leg_guard']) ? $select['leg_guard'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Chrome Set
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="Accessories Chrome Set..." id="chrome_set" class="form-control" name="chrome_set" value="<?php echo !empty($select['chrome_set']) ? $select['chrome_set'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Model AMC
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="Model AMC..." id="amc" class="form-control" name="amc" value="<?php echo !empty($select['amc']) ? $select['amc'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Ex. Warranty
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="Ex. Warranty..." id="ex_warranty" class="form-control" name="ex_warranty" value="<?php echo !empty($select['ex_warranty']) ? $select['ex_warranty'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										1 Year Insurance
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="1 Year Insurance..." id="insurance" class="form-control" name="insurance" value="<?php echo !empty($select['insurance']) ? $select['insurance'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										2 Years Insurance
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="2 Years Insurance..." id="year_2_insurance" class="form-control" name="year_2_insurance" value="<?php echo !empty($select['2_year_insurance']) ? $select['2_year_insurance'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										3 Years Insurance
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="3 Years Insurance..." id="year_3_insurance" class="form-control" name="year_3_insurance" value="<?php echo !empty($select['3_year_insurance']) ? $select['3_year_insurance'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Description
									</label>
									<div class="col-sm-7">
										<textarea placeholder="Enter Description..." id="remark" class="form-control" name="remark"><?php echo !empty($select['remark']) ? $select['remark'] : '' ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-2"></div>
									<div class="col-sm-7">
										<input type="submit" id="model-submit" class="btn btn-success btn-squared" value="Save">
										<a href="model_list.php" class="btn btn-danger btn-squared">Cancel</a>
									</div>
								</div>
								
							</form>
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