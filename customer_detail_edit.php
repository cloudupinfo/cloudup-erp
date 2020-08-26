<?php include_once('include/comman_session.php');
if(isset($_REQUEST['aid'])){
	$id = $_REQUEST['aid'];
}else{
	header('Location:dashboard.php');
	exit();
}

$table = "customer_detail";
$table2 = "product";
$table1 = "veihicle";

$customer = $db->getRow("SELECT * FROM ".$table." where `customer_detail_id`=?",array($id));
$salesmans = $db->getRows("SELECT * FROM `salesman` where `status`=?",array(1));
if(!empty($customer)){
	$type = "customer_detail_edit";
	$admin_id = $customer['admin_id'];
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
						<h3>Customer Detail <?php echo "Edit";?> - <small class="required-field">* asterisk mark will be compulsory</small></h3>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
				<form class="form-horizontal" method="post" action="model/editManage.php" id="customer_detail_edit_frm" name="customer_detail_edit_frm" enctype="multipart/form-data">
					<input type="hidden" value="<?php echo $type;?>" name="type">
					<input type="hidden" value="<?php echo $admin_id;?>" name="admin_id">
					<input type="hidden" value="<?php echo !empty($customer['customer_detail_id']) ? $customer['customer_detail_id'] : '0';?>" name="id">
					
					<div class="col-sm-12">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Sales Man Name <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<select name="salesman_id" id="salesman_id" class="form-control">
									<option value="">Select Sales Man</option>
								<?php !empty($customer['salesman_id']) ? $salesmanId=$customer['salesman_id'] : $salesmanId="";
								foreach($salesmans as $salesman){?>
									<option value="<?php echo $salesman['salesman_id'];?>" <?php echo $salesmanId==$salesman['salesman_id'] ? 'selected' : '';?>><?php echo $salesman['name'];?></option>
								<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Customer Name <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<input type="text" placeholder="Customer Name" id="name" class="form-control" name="name" value="<?php echo !empty($customer['name']) ? $customer['name'] : '' ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Customer Mobile No <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" placeholder="Customer Mobile No" id="mobile" class="form-control" name="mobile" value="<?php echo !empty($customer['mobile']) ? $customer['mobile'] : '' ?>">
									<span class="input-group-addon"> <i class="fa fa-mobile"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Street Address 1
							</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" placeholder="Street Address 1" id="street_add1" class="form-control" name="street_add1" value="<?php echo !empty($customer['street_add1']) ? $customer['street_add1'] : '' ?>">
									<span class="input-group-addon"> <i class="fa fa-map-marker"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Street Address 2
							</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" placeholder="Street Address 2" id="street_add2" class="form-control" name="street_add2" value="<?php echo !empty($customer['street_add2']) ? $customer['street_add2'] : '' ?>">
									<span class="input-group-addon"> <i class="fa fa-map-marker"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								District
							</label>
							<div class="col-sm-7">
								<?php !empty($customer['city']) ? $district=$customer['city'] : $district='Rajkot'?>
								<select id="city" class="form-control" name="city">
									<option value="Ahmedabad" <?php echo $district=="Ahmedabad" ? 'selected' : '' ?>>Ahmedabad</option>
									<option value="Amreli" <?php echo $district=="Amreli" ? 'selected' : '' ?>>Amreli</option>
									<option value="Anand" <?php echo $district=="Anand" ? 'selected' : '' ?>>Anand</option>
									<option value="Aravalli" <?php echo $district=="Aravalli" ? 'selected' : '' ?>>Aravalli</option>
									<option value="Banaskantha" <?php echo $district=="Banaskantha" ? 'selected' : '' ?>>Banaskantha</option>
									<option value="Botad" <?php echo $district=="Botad" ? 'selected' : '' ?>>Botad</option>
									<option value="Bharuch" <?php echo $district=="Bharuch" ? 'selected' : '' ?>>Bharuch</option>
									<option value="Bhavnagar" <?php echo $district=="Bhavnagar" ? 'selected' : '' ?>>Bhavnagar</option>
									<option value="Chhota Udaipur" <?php echo $district=="Chhota Udaipur" ? 'selected' : '' ?>>Chhota Udaipur</option>
									<option value="Dahod" <?php echo $district=="Dahod" ? 'selected' : '' ?>>Dahod</option>
									<option value="Devbhoomi Dwarka" <?php echo $district=="Devbhoomi Dwarka" ? 'selected' : '' ?>>Devbhoomi Dwarka</option>
									<option value="Gandhinagar" <?php echo $district=="Gandhinagar" ? 'selected' : '' ?>>Gandhinagar</option>
									<option value="Gir Somnath" <?php echo $district=="Gir Somnath" ? 'selected' : '' ?>>Gir Somnath</option>
									<option value="Jamnagar" <?php echo $district=="Jamnagar" ? 'selected' : '' ?>>Jamnagar</option>
									<option value="Junagadh" <?php echo $district=="Junagadh" ? 'selected' : '' ?>>Junagadh</option>
									<option value="Kheda" <?php echo $district=="Kheda" ? 'selected' : '' ?>>Kheda</option>
									<option value="Kutch" <?php echo $district=="Kutch" ? 'selected' : '' ?>>Kutch</option>
									<option value="Mahisagar" <?php echo $district=="Mahisagar" ? 'selected' : '' ?>>Mahisagar</option>
									<option value="Mahesana" <?php echo $district=="Mahesana" ? 'selected' : '' ?>>Mahesana</option>
									<option value="Mahesana" <?php echo $district=="Mahesana" ? 'selected' : '' ?>>Mahesana</option>
									<option value="Morbi" <?php echo $district=="Morbi" ? 'selected' : '' ?>>Morbi</option>
									<option value="Narmada" <?php echo $district=="Narmada" ? 'selected' : '' ?>>Narmada</option>
									<option value="Navsari" <?php echo $district=="Navsari" ? 'selected' : '' ?>>Navsari</option>
									<option value="Panchmahal" <?php echo $district=="Panchmahal" ? 'selected' : '' ?>>Panchmahal</option>
									<option value="Patan" <?php echo $district=="Patan" ? 'selected' : '' ?>>Patan</option>
									<option value="Porbandar" <?php echo $district=="Porbandar" ? 'selected' : '' ?>>Porbandar</option>
									<option value="Rajkot" <?php echo $district=="Rajkot" ? 'selected' : '' ?>>Rajkot</option>
									<option value="Sabarkantha" <?php echo $district=="Sabarkantha" ? 'selected' : '' ?>>Sabarkantha</option>
									<option value="Surat" <?php echo $district=="Surat" ? 'selected' : '' ?>>Surat</option>
									<option value="Surendranagar" <?php echo $district=="Surendranagar" ? 'selected' : '' ?>>Surendranagar</option>
									<option value="Tapi" <?php echo $district=="Tapi" ? 'selected' : '' ?>>Tapi</option>
									<option value="The Dangs" <?php echo $district=="The Dangs" ? 'selected' : '' ?>>The Dangs</option>
									<option value="Vadodara" <?php echo $district=="Vadodara" ? 'selected' : '' ?>>Vadodara</option>
									<option value="Valsad" <?php echo $district=="Valsad" ? 'selected' : '' ?>>Valsad</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Country
							</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input readonly type="text" placeholder="Country" id="country" class="form-control" name="country" value="<?php echo !empty($customer['country']) ? $customer['country'] : 'India' ?>">
									<span class="input-group-addon"> <i class="clip-world"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Remark
							</label>
							<div class="col-sm-7">
								<textarea placeholder="Remark" id="remark" class="form-control" name="remark"><?php echo !empty($customer['remark']) ? $customer['remark'] : '' ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-9">
								<?php if($type=="add"){?>
								<input type="submit" class="btn btn-success btn-squared" value="Save">
								<?php }else{ ?>
								<input type="submit" class="btn btn-info btn-squared" value="Update">
								<?php }?>
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