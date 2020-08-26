<?php include_once('include/comman_session.php');
if(isset($_REQUEST['aid'])){
	$id = $_REQUEST['aid'];
}else{
	header('Location:dashboard.php');
	exit();
}
$table = "exchange";
$exchange = $db->getRow("SELECT * FROM ".$table." where `exchange_id`=?",array($id));
if($exchange){
	$type = "exchange_detail_edit";
}else{
	header('Location:dashboard.php');
	exit();
}
include("include/header.php");
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
							Veihicle
						</li>
					</ol>
					<div class="page-header">
						<h3>Exchange Detail Edit - <small class="required-field">* asterisk mark will be compulsory</small></h3>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
				<form class="form-horizontal" method="post" action="model/editManage.php" id="cashier_exchange_edit_frm" name="cashier_exchange_edit_frm" enctype="multipart/form-data">
					<input type="hidden" value="<?php echo $type;?>" name="type">
					<input type="hidden" value="<?php echo $exchange['exchange_id'];?>" name="id">
					
					<div class="col-sm-12">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Amount <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" placeholder="amount" id="amount" class="form-control" name="amount" value="<?php echo !empty($exchange['amount']) ? $exchange['amount'] : '';?>">
									<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Vehicle No <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<input type="text" placeholder="Vehicle No" id="veihicle_no" class="form-control" name="veihicle_no" value="<?php echo !empty($exchange['veihicle_no']) ? $exchange['veihicle_no'] : '' ?>">
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-9">
								<input type="submit" class="btn btn-info btn-squared" value="Update">
								<a onclick="window.close();" class="btn btn-danger btn-squared">Cancel</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->

<?php include("include/footer.php");?>
<script type="text/javascript">
// Main Date
$(".currentDate").datepicker({
	format: "dd-mm-yyyy",
	//startDate: '1d',
	autoclose: true
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