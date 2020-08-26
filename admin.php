<?php include_once('include/comman_session.php');
include("include/header.php");
$table = "admin";
if(isset($_REQUEST['aid'])){
	$id=$_REQUEST['aid'];
	$type = "edit";
}else{
	$id=0;
	$type = "add";
}
$select = $db->getRow("SELECT * FROM ".$table." where `admin_id`=?",array($id));
if($select){
	$role = $select['role'];
}else{
	$role = "";
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
							Admin
						</li>
					</ol>
					<div class="page-header">
						<h1>Admin Manage </h1>
					</div>
					<div id="nestable-menu" class="pull-right">
						<a href="admin_list.php" class="btn btn-primary btn-squared">Admin List</a>
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
							Admin Add
							<div class="panel-tools">
								<a class="btn btn-xs btn-link" href=""><i class="fa fa-refresh"></i></a>
								<a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
							</div>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" method="post" id="admin-add-frm" name="admin-add-frm">
								<div class="no-display loading-div">
									<img src="loading.gif" height="100" width="100">
								</div>
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
								<input type="hidden" value="<?php echo $type;?>" name="type">
								<input type="hidden" value="<?php echo $id;?>" name="id">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Role
									</label>
									<div class="col-sm-7">
										<select class="form-control cre-role" name="role" id="role">
											<option value="">Select Role</option>
											<option value="subadmin" <?php if($role=="subadmin"){echo "selected";}?>>Sub Admin</option>
											<option value="cashier" <?php if($role=="cashier"){echo "selected";}?>>Cashier</option>
											<option value="billing" <?php if($role=="billing"){echo "selected";}?>>Billing</option>
											<option value="rto" <?php if($role=="rto"){echo "selected";}?>>RTO</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Username
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="Username" id="username" class="form-control" name="username" value="<?php echo !empty($select['username']) ? $select['username'] : '' ?>">
											<span class="input-group-addon"> <i class="clip-user"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Email
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="Email" id="email" class="form-control" name="email" value="<?php echo !empty($select['email']) ? $select['email'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-envelope-o"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">Password</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="password" placeholder="Password" id="password" class="form-control" name="password" value="******">
											<span class="input-group-addon"> <i class="fa fa-key"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">Re-Enter Password</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="password" placeholder="Re-Enter Password" id="password_again" class="form-control" name="password_again" value="******">
											<span class="input-group-addon"> <i class="fa fa-key"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-2"></div>
									<div class="col-sm-7">
										<button type="button" id="admin-submit" class="btn btn-success btn-squared">Save</button>
										<a href="admin_list.php" class="btn btn-danger btn-squared">Cancel</a>
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
	$("#role").change(function(){
		var role = $(this).val();
		if(role==2){
			$(".doctor-role").show();
			$(".patient-role").hide();
		}else if(role==5){
			$(".patient-role").show();
			$(".clinic-role").hide();
			$(".doctor-role").hide();
		}else{
			$(".patient-role").hide();
			$(".clinic-role").hide();
			$(".doctor-role").hide();
		}
	});

	$("#admin-submit").click(function() {
		if(!$("#admin-add-frm").valid()){
			return false;	
		}else{
			var form = document.getElementById("admin-add-frm");
			formdata2 = new FormData(form);
			$.ajax({
				url : "model/addManage.php",
				cache : false,
				contentType : false,
				processData : false,
				data : formdata2,
				beforeSend: function() {
					$(".loading-div").removeClass('no-display');
					$(".loading-div").addClass('display');
				},
				type : "post",
				success : function(data) {
					$(".loading-div").removeClass('display');
					$(".loading-div").addClass('no-display');
					if (data == 1) {
						//$("#admin-add-frm").find("input,textarea").val("");
						window.location.href = 'admin.php';
						//$("#admin-add-frm").trigger("reset");
						//loadmaincattable();
					} else if (data == 2) {
						alert("Admin Allready Exists!");
						//$("#admin-add-frm").find("input,textarea").val("");
						location.reload();
					} else if (data == 0) {
						alert("Some Error Occured Please Try Again...");
						window.location.href = 'admin.php';
					}else if (data == 11) {
						//alert("Admin Update Successfully...");
						window.location.href = 'admin_list.php';
					}else if (data == 00) {
						alert("Admin Update in Problem...");
					}
				}
			});
		}
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