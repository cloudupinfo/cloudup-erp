<?php include_once('include/comman_session.php');
if(isset($_REQUEST['aid'])){
	$id = $_REQUEST['aid'];
}else{
	$id = 0;
}
$table = "advance";
$table1 = "product";
$table2 = "advance_payment";

$select = $db->getRow("SELECT * FROM ".$table." where `advance_id`=?",array($id));
$salesmans = $db->getRows("SELECT * FROM `salesman` where `status`=?",array(1));
include("include/header.php");

if($select){
	$type = "advance_edit";
	// Customer Advance Paymnet
	$advancePayment = $db->getRows("SELECT * FROM ".$table2." where `advance_id`=?",array($select['advance_id']));
	if($select['refund']==0){
		$typePrint = "advance_edit";
	}else{
		$typePrint = "advance_refund_edit";
	}
	$admin_id = $select['admin_id'];
}else{
	$typePrint = "advance_add";
	$type = "advance_add";
	$admin_id = $_SESSION['admin_id'];
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
							Advance Booking
						</li>
					</ol>
					<div class="page-header">
						<h3>Advance Booking Form</h3>
					</div>
					<div id="nestable-menu" class="pull-right">
						<a href="advance_booking_list.php" class="btn btn-primary btn-squared">Advance Booking List</a>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>
							Advance Booking Form
							<div class="panel-tools">
								<a class="btn btn-xs btn-link" href=""><i class="fa fa-refresh"></i></a>
								<a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
							</div>
						</div>
						<div class="panel-body">
						<?php if(!empty($advancePayment)){?>
						<div class="col-sm-12">
							<div class="page-header">
								<h3>Customer Payeble Amount</h3>
							</div>
						<?php foreach($advancePayment as $value){?>
							<a target="_blank" href="advance_payment_edit.php?aid=<?php echo $value['advance_payment_id'];?>" class="text-right"><i class="fa fa-edit"></i></a>
							<div class="product-view-main">
								<div class="product-view-left col-sm-6">
									<div class="col-sm-4 product-view-title"><h4> Cash Type : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['case_type']) ? $value['case_type'] : '-';?> </h4></div>
									<div class="col-sm-4 product-view-title"><h4> Amount : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['price']) ? $value['price'] : '-';?> </h4></div>
									<div class="col-sm-4 product-view-title"><h4> Amount In Word : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['amount_in_word']) ? $value['amount_in_word'] : '-';?> </h4></div>
								</div>
								<div class="product-view-right col-sm-6">
								<?php if($value['case_type']=="Cheque"){?>
									<div class="col-sm-4 product-view-title"><h4> Bank Name : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['bank_name']) ? $value['bank_name'] : '-';?> </h4></div>
									<div class="col-sm-4 product-view-title"><h4> Cheque No. : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['cheque_no']) ? $value['cheque_no'] : '-';?> </h4></div>
									<div class="col-sm-4 product-view-title"><h4> Cheque Date. : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['cheque_date']) ? date("d-m-Y",strtotime($value['cheque_date'])) : '-';?> </h4></div>
								<?php }else if($value['case_type']=="DD"){ ?>
									<div class="col-sm-4 product-view-title"><h4> Bank Name : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['dd_bank_name']) ? $value['dd_bank_name'] : '-';?> </h4></div>
									<div class="col-sm-4 product-view-title"><h4> DD No. : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['dd_no']) ? $value['dd_no'] : '-';?> </h4></div>
									<div class="col-sm-4 product-view-title"><h4> DD Date. : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['dd_date']) ? date("d-m-Y",strtotime($value['dd_date'])) : '-';?> </h4></div>
								<?php }else if($value['case_type']=="NEFT"){ ?>
									<div class="col-sm-4 product-view-title"><h4> Account No. : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['neft_ac_no']) ? $value['neft_ac_no'] : '-';?> </h4></div>
									<div class="col-sm-4 product-view-title"><h4> Bank Name : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['neft_bank_name']) ? $value['neft_bank_name'] : '-';?> </h4></div>
									<div class="col-sm-4 product-view-title"><h4> IFSC Code : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['neft_ifsc_code']) ? $value['neft_ifsc_code'] : '-';?> </h4></div>
									<div class="col-sm-4 product-view-title"><h4> Holder Name : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['neft_holder_name']) ? $value['neft_holder_name'] : '-';?> </h4></div>
								<?php } ?>
									<div class="col-sm-4 product-view-title"><h4> Date : </h4></div>
									<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($value['created_at']) ? date("d-m-Y h:i A",strtotime($value['created_at'])) : '-';?> </h4></div>
								</div>
							</div>
							<div class="clearfix"></div>
						<?php } ?>
						</div>
						<?php } ?>
							<form class="form-horizontal" method="post" action="model/advancebookingManage.php" id="cashier_avdbook_add_frm" name="cashier_avdbook_add_frm" enctype="multipart/form-data" target="_blank">
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
								<input type="hidden" value="<?php echo $admin_id;?>" name="admin_id">
								<div class="form-group">
									<label class="col-sm-2 control-label"></label>
									<div class="col-sm-10">
										<span class="pull-right">Date: <input type="text" name="currentDate" class="currentDate date-picker" value="<?php echo !empty($select['created_at']) ? date("d-m-Y",strtotime($select['created_at'])) : date("d-m-Y"); ?>"></span>
									</div>
								</div>
								<div class="form-group">
								<?php $model = $db->getRows("SELECT * FROM `veihicle` where `status`=?",array(1));	?>
									<label class="col-sm-2 control-label" for="form-field-1">
										Model <span class="required-field">*</span>
									</label>
									<div class="col-sm-7">
										<select class="form-control main-menu-sel" name="model" id="model">
											<option value="" selected>Select Model</option>
										<?php
											foreach ($model as $key => $value) {
										?>
											<option value="<?php echo $value['veihicle_id']; ?>" <?php if($value['veihicle_id']==$select['model']){echo "selected";}?>><?php echo $value['name']; ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Color
									</label>
									<div class="col-sm-7">
										<input type="text" placeholder="Color" id="color" class="form-control" name="color" value="<?php echo !empty($select['color']) ? $select['color'] : '' ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Sales Man Name <span class="required-field">*</span>
									</label>
									<div class="col-sm-7">
										<select name="salesman_id" id="salesman_id" class="form-control">
											<option value="">Select Sales Man</option>
										<?php !empty($select['salesman_id']) ? $salesmanId=$select['salesman_id'] : $salesmanId="";
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
										<input type="text" placeholder="Customer Name" id="name" class="form-control" name="name" value="<?php echo !empty($select['name']) ? $select['name'] : '' ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Customer Mobile No <span class="required-field">*</span>
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="Customer Mobile No" id="mobile" class="form-control" name="mobile" value="<?php echo !empty($select['mobile']) ? $select['mobile'] : '' ?>">
											<span class="input-group-addon"> <i class="fa fa-mobile"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										City
									</label>
									<div class="col-sm-7">
										<?php !empty($select['city']) ? $district=$select['city'] : $district='Rajkot'?>
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
											<input readonly type="text" placeholder="Country" id="country" class="form-control" name="country" value="<?php echo !empty($select['country']) ? $select['country'] : 'India' ?>">
											<span class="input-group-addon"> <i class="clip-world"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Payment Type <span class="required-field">*</span>
									</label>
									<div class="col-sm-7">
										<input type="radio" class="case_by_case" name="case_type" value="Cash" checked > By Cash &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										<input type="radio" class="case_by_cheque" name="case_type" value="Cheque"> By Cheque &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										<input type="radio" class="case_by_dd" name="case_type" value="DD"> Demand Draft &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										<input type="radio" class="case_by_neft" name="case_type" value="NEFT"> NEFT / RTGS
									</div>
								</div>
								<div class="by_case_cheque" style="display:none">
									<div class="form-group">
										<label class="col-sm-2 control-label" for="form-field-1">
											Bank Name
										</label>
										<div class="col-sm-7">
											<div class="input-group">
												<input type="text" placeholder="bank name" id="bank_name" class="form-control" name="bank_name" value="">
												<span class="input-group-addon"> <i class="fa fa-university"></i> </span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="form-field-1">
											Cheque No
										</label>
										<div class="col-sm-7">
											<input type="text" placeholder="Cheque No" id="cheque_no" class="form-control" name="cheque_no" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="form-field-1">
											Cheque Date
										</label>
										<div class="col-sm-7">
											<div class="input-group">
												<input type="text" placeholder="Cheque Date" id="cheque_date" class="form-control date-picker" name="cheque_date" value="">
												<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
											</div>
										</div>
									</div>
								</div>
								<div class="by_case_dd" style="display:none">
									<div class="form-group">
										<label class="col-sm-2 control-label" for="form-field-1">
											Bank Name
										</label>
										<div class="col-sm-7">
											<div class="input-group">
												<input type="text" placeholder="dd bank name" id="dd_bank_name" class="form-control" name="dd_bank_name" value="">
												<span class="input-group-addon"> <i class="fa fa-university"></i> </span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="form-field-1">
											DD No
										</label>
										<div class="col-sm-7">
											<input type="text" placeholder="DD No" id="dd_no" class="form-control" name="dd_no" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="form-field-1">
											DD Date
										</label>
										<div class="col-sm-7">
											<div class="input-group">
												<input type="text" placeholder="DD Date" id="dd_date" class="form-control date-picker" name="dd_date" value="">
												<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
											</div>
										</div>
									</div>
								</div>
								<div class="by_case_neft" style="display:none">
									<div class="form-group">
										<label class="col-sm-2 control-label" for="form-field-1">
											Bank Name <span class="required-field">*</span>
										</label>
										<div class="col-sm-7">
											<div class="input-group">
												<input type="text" placeholder="neft bank name" id="neft_bank_name" class="form-control" name="neft_bank_name" value="">
												<span class="input-group-addon"> <i class="fa fa-university"></i> </span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="form-field-1">
											NEFT/RTGS Account No <span class="required-field">*</span>
										</label>
										<div class="col-sm-7">
											<input type="text" placeholder="NEFT/RTGS Account No" id="neft_ac_no" class="form-control" name="neft_ac_no" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="form-field-1">
											NEFT/RTGS IFSC Code <span class="required-field">*</span>
										</label>
										<div class="col-sm-7">
											<input type="text" placeholder="NEFT/RTGS IFSC Code" id="neft_ifsc_code" class="form-control" name="neft_ifsc_code" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="form-field-1">
											NEFT/RTGS Holder Name <span class="required-field">*</span>
										</label>
										<div class="col-sm-7">
											<div class="input-group">
												<input type="text" placeholder="NEFT/RTGS Holder Name" id="neft_holder_name" class="form-control" name="neft_holder_name" value="">
												<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Amount <span class="required-field">*</span>
									</label>
									<div class="col-sm-7">
										<div class="input-group">
											<input type="text" placeholder="Amount..." id="price" class="form-control" name="price" value="">
											<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Finance 
									</label>
									<div class="col-sm-7">
										<input type="checkbox" id="finance" class="finance" name="finance" value="Yes" <?php echo $select['finance']=="Yes" ? "checked" : ''?>> Yes &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
									</div>
								</div>
								<div class="finance_open" style="<?php echo $select['finance']=="Yes" ? 'display:block' : 'display:none';?>;">
									<div class="form-group">
										<label class="col-sm-2 control-label" for="form-field-1">
											Finance Bank
										</label>
										<div class="col-sm-7">
											<input type="text" placeholder="Finance Bank" id="finance_bank" class="form-control" name="finance_bank" value="<?php echo !empty($select['finance_bank']) ? $select['finance_bank'] : '' ?>">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Amount In Word <span class="required-field">*</span>
									</label>
									<div class="col-sm-7">
										<input type="text" placeholder="Amount In Word" id="amount_in_word" class="form-control" name="amount_in_word" value="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Print Type <span class="required-field">*</span>
									</label>
									<div class="col-sm-7">
										<select class="form-control" name="print_type" id="print_type">
											<option value="Original">Original</option>
											<option value="Duplicate">Duplicate</option>
											<option value="Duplicate-Refund">Duplicate-Refund</option>
										</select>
									</div>
								</div>
								<!--<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Test Ride 
									</label>
									<div class="col-sm-7">
										<input type="checkbox" id="test_ride" name="test_ride" <?php echo ($select['test_ride']=="on") ? 'checked' : '' ?>>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Book Type <span class="required-field">*</span>
									</label>
									<div class="col-sm-7">
										<input type="radio" name="book_type" value="Hot" <?php echo $select['book_type']=="Hot" ? 'checked' : '';?>> Hot &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										<input type="radio" name="book_type" value="Warm" <?php echo $select['book_type']=="Warm" ? 'checked' : '';?>> Warm &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										<input type="radio" name="book_type" value="Cold" <?php echo $select['book_type']=="Cold" ? 'checked' : '';?>> Cold &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
										<input type="radio" name="book_type" value="Booked" <?php echo $select['book_type']=="Booked" ? 'checked' : '';?>> Booked 
									</div>
								</div>-->
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Remark
									</label>
									<div class="col-sm-7">
										<textarea placeholder="Remark" id="remark" class="form-control" name="remark"><?php echo !empty($select['remark']) ? $select['remark'] : '' ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-2"></div>
									<div class="col-sm-9">
										<?php if($type=="advance_add"){?>
										<input type="submit" class="btn btn-success btn-squared" value="Save">
										<?php }else{ ?>
										<input type="submit" class="btn btn-info btn-squared" value="Save">
										<?php }?>
										<a href="advance_booking_list.php" class="btn btn-danger btn-squared">Cancel</a>
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
// Main Date
$(".currentDate").datepicker({
	format: "dd-mm-yyyy",
	//startDate: '1d',
	autoclose: true
});

// Advance Finance 
$("#finance").click(function(){
	if($(this).is(":checked")==true){
		$(".finance_open").show();
	}else{
		$(".finance_open").hide();
	}
});

// Payment Type Radio Button Click
$("input[name~='case_type']").change(function(){
	var case_type = $(this).val();
	if(case_type=="Cheque"){
		$(".by_case_cheque").show();
		$(".by_case_dd, .by_case_neft").hide();
	}else if(case_type=="DD"){
		$(".by_case_dd").show();
		$(".by_case_cheque, .by_case_neft").hide();
	}else if(case_type=="NEFT"){
		$(".by_case_neft").show();
		$(".by_case_dd, .by_case_cheque").hide();
	}else{
		$(".by_case_dd, .by_case_cheque, .by_case_neft").hide();
	}
});

// Cheque Date
$("#cheque_date, #dd_date").datepicker({
	format: "yyyy-mm-dd",
	//startDate: '1d',
	autoclose: true
});

// Amount Total to pending Amount
$("#price").keyup(function(){
	var price = $(this).val().length!=0 ? $(this).val() : 0;
	$("#amount_in_word").val(test_skill(price));
});

// Amount in word
function test_skill(junkVal) {
   // var junkVal=document.getElementById('rupees').value;
    var junkVal = junkVal;
    junkVal = Math.floor(junkVal);
    var obStr = new String(junkVal);
    numReversed = obStr.split("");
    actnumber=numReversed.reverse();

    if(Number(junkVal) >=0){
        //do nothing
    }
    else{
        alert('wrong Number cannot be converted');
        return false;
    }
    if(Number(junkVal)==0){
        //return obStr+''+'Rupees Zero Only';
        return obStr+''+'Rupees Zero Only';
        return false;
    }
    if(actnumber.length>9){
        alert('Oops!!!! the Number is too big to covertes');
        return false;
    }

    var iWords=["Zero", " One", " Two", " Three", " Four", " Five", " Six", " Seven", " Eight", " Nine"];
    var ePlace=['Ten', ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen', ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'];
    var tensPlace=['dummy', ' Ten', ' Twenty', ' Thirty', ' Forty', ' Fifty', ' Sixty', ' Seventy', ' Eighty', ' Ninety' ];

    var iWordsLength=numReversed.length;
    var totalWords="";
    var inWords=new Array();
    var finalWord="";
    j=0;
    for(i=0; i<iWordsLength; i++){
        switch(i)
        {
        case 0:
            if(actnumber[i]==0 || actnumber[i+1]==1 ) {
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            inWords[j]=inWords[j]+' Only';
            break;
        case 1:
            tens_complication();
            break;
        case 2:
            if(actnumber[i]==0) {
                inWords[j]='';
            }
            else if(actnumber[i-1]!=0 && actnumber[i-2]!=0) {
                inWords[j]=iWords[actnumber[i]]+' Hundred and';
            }
            else {
                inWords[j]=iWords[actnumber[i]]+' Hundred';
            }
            break;
        case 3:
            if(actnumber[i]==0 || actnumber[i+1]==1) {
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            if(actnumber[i+1] != 0 || actnumber[i] > 0){
                inWords[j]=inWords[j]+" Thousand";
            }
            break;
        case 4:
            tens_complication();
            break;
        case 5:
            if(actnumber[i]==0 || actnumber[i+1]==1) {
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            if(actnumber[i+1] != 0 || actnumber[i] > 0){
                inWords[j]=inWords[j]+" Lakh";
            }
            break;
        case 6:
            tens_complication();
            break;
        case 7:
            if(actnumber[i]==0 || actnumber[i+1]==1 ){
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            inWords[j]=inWords[j]+" Crore";
            break;
        case 8:
            tens_complication();
            break;
        default:
            break;
        }
        j++;
    }

    function tens_complication() {
        if(actnumber[i]==0) {
            inWords[j]='';
        }
        else if(actnumber[i]==1) {
            inWords[j]=ePlace[actnumber[i-1]];
        }
        else {
            inWords[j]=tensPlace[actnumber[i]];
        }
    }
    inWords.reverse();
    for(i=0; i<inWords.length; i++) {
        finalWord+=inWords[i];
    }
    //return obStr+'  '+finalWord;
    return finalWord;
}
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