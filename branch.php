<?php include_once('include/comman_session.php');
if(isset($_REQUEST['aid'])){
	$id = $_REQUEST['aid'];
}else{
	$id = "";
}

$select = $db->getRow("SELECT `chassis_no`,`branch_id` FROM `product` where `product_id`=?",array($id));
if(!empty($select)){
	$chassis_no = $select['chassis_no'];
}
if($select){
	$type = "edit";
}else{
	$type = "add";
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
							Branch
						</li>
					</ol>
					<div class="page-header">
						<h3>Branch <small class="required-field">* asterisk mark will be compulsory</small></h3>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
				<form class="form-horizontal" method="post" action="model/branchManage.php" id="branch_add_frm" name="branch_add_frm" enctype="multipart/form-data">
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
					<input type="hidden" value="<?php echo !empty($select['branch_id']) ? $select['branch_id'] : '';?>" name="id">
					<input type="hidden" value="<?php echo $type;?>" name="type">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Chassis No. <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<input type="text" placeholder="Chassis No." id="chassis_no" class="form-control" name="chassis_no" value="<?php echo !empty($chassis_no) ? $chassis_no : '';?>">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Branch
							</label>
							<div class="col-sm-7">
								<select class="form-control" name="branch_type" id="branch_type">
									<option value="0"> Main </option>
									<?php
										$getBranch = $db->getRows("SELECT * FROM `branch` where `status`=?",array(1));
										foreach ($getBranch as $value) {
									?>
										<option value="<?php echo $value['branch_id']; ?>" <?php if($value['branch_id']==$select['branch_id']){echo "selected";}?>><?php echo $value['name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<!--<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Remark
							</label>
							<div class="col-sm-7">
								<textarea placeholder="Remark" id="remark" class="form-control" name="remark"><?php echo !empty($select['remark']) ? $select['remark'] : '' ?></textarea>
							</div>
						</div>-->
						
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-9">
								<?php if($type=="add"){?>
								<input type="submit" class="btn btn-success btn-squared" value="Save">
								<?php }else{ ?>
								<input type="submit" class="btn btn-info btn-squared" value="Update">
								<?php }?>
								<a href="branch_list.php" class="btn btn-danger btn-squared">Cancel</a>
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
// Cheque Date
$("#cheque_date, #dd_date").datepicker({
	format: "dd-mm-yyyy",
	//startDate: '1d',
	autoclose: true
});

// Featured Active Deactive Code
$(document).on("click", ".to_featured", function(e) {
	var id = $(this).attr("id");
	var featured1 = $(this).attr("featured");
	var a_featured = "featured";
	if(featured1==1)
		featured_1 = 0;
	else
		featured_1 = 1;
	//alert(id);
	var table = $('#loadmaincat').DataTable();
	var select = $(this).closest('tr');
	select.addClass("selected");

	if (confirm('Are you sure you want to change featured ?')) {
		$.ajax({
			type : "POST",
			url : "model/veihicleManage.php",
			cache : false,
			data : {
				type : a_featured, mid : id , featured : featured_1
			},
			beforeSend: function() {
				$(".loading-div").removeClass('no-display');
				$(".loading-div").addClass('display');
			},
			success : function(result) {
				$(".loading-div").removeClass('display');
				$(".loading-div").addClass('no-display');
				if (result) {
					//alert("Veihicle is featured Successfully");
					table.row('.selected').remove().draw(false);
					//var table1 = $('#loadmaincat').DataTable();
					table.ajax.reload();
				} else {
					alert("Does not change featured : \n" + result);
					select.removeClass('selected');
				}
			}
		});

	} else {
		select.removeClass('selected');
	}
	return false;
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