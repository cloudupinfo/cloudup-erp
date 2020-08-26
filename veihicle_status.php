<?php include_once('include/comman_session.php');
include("include/header.php");

$table = "product";
$table1 = "veihicle";
$table2 = "customer_detail";
$table3 = "product_price";
$table4 = "customer_payment";
$table5 = "gatepass";
$table6 = "billing";
$product = $veihicle = $customer = $exchange = $finance = $product_price = $customer_payment = $salesman = $gatepass = $billing = "";

if(isset($_REQUEST['aid'])){
	$id = $_REQUEST['aid'];
	$product = $db->getRow("SELECT * FROM ".$table." where `chassis_no`=?",array($id));
	if(!empty($product['veihicle_id']) && ($product['veihicle_id']!=0)){
		$veihicle = $db->getRow("SELECT * FROM ".$table1." where `veihicle_id`=?",array($product['veihicle_id']));
	}
	if(!empty($product)){
		$customer = $db->getRow("SELECT * FROM ".$table2." where `product_id`=?",array($product['product_id']));
		// Exchange
		$exchange = $db->getRow("SELECT * FROM `exchange` where `customer_detail_id`=?",array($customer['customer_detail_id']));
		// Finance
		$finance = $db->getRow("SELECT * FROM `finance` where `product_id`=?",array($product['product_id']));
		$product_price = $db->getRow("SELECT * FROM ".$table3." where `product_id`=?",array($product['product_id']));
		$customer_payment = $db->getRows("SELECT * FROM ".$table4." where `customer_detail_id`=?",array($customer['customer_detail_id']));
		$salesman = $db->getRow("SELECT * FROM `salesman` where `salesman_id`=?",array($customer['salesman_id']));
		$gatepass = $db->getRow("SELECT * FROM ".$table5." where `product_id`=?",array($product['product_id']));
		$billing = $db->getRow("SELECT * FROM ".$table6." where `product_id`=?",array($product['product_id']));
	}
}else{
	$id = "";
}
if(!empty($id)){
	
}else{
	
}
?>
<link rel="stylesheet" href="<?php echo HomeURL;?>assets/css/custom.css" type="text/css" media="print"/>

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
				<div class="col-xs-12">
					<!-- start: PAGE TITLE & BREADCRUMB -->
					<ol class="breadcrumb">
						<li>
							<i class="clip-pencil"></i>
							<a href="#">
								Home
							</a>
						</li>
						<li class="active">
							Vehicle Status
						</li>
					</ol>
					<div class="page-header">
						<h3>Vehicle Status </h3>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<div class="row">
				<div class="col-xs-12">
					<!-- start: TEXT FIELDS PANEL -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>
							Vehicle Status
							<div class="panel-tools">
								<a class="btn btn-xs btn-link" href=""><i class="fa fa-refresh"></i></a>
								<a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
							</div>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" method="post" action="model/veihicleStatusManage.php" id="veihicle_status_search" name="veihicle_status_search" enctype="multipart/form-data">
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
								<input type="hidden" value="search" name="type">
								
								<div class="form-group">
									<div class="col-xs-2"></div>
									<div class="col-xs-6">
										<h3>Enter Chassis No</h3>
										<input type="text" name="search" id="search" class="form-control">
										<img class="search_loading_img" src="loading.gif" height="45" width="45" style="display:none;">
										<div class="search_result"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-2"></div>
									<div class="col-xs-10">
										<img src="loading.gif" height="45" width="45" style="display:none;">
										<input type="submit" id="veihicle-status-search" class="btn btn-success btn-squared" value="Search">
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- end: TEXT FIELDS PANEL -->
				</div>
				<div class="col-xs-12">
					<div class="col-xs-1 pull-right">
						<input type="button" class="btn btn-success btn-squared" onclick="printDiv('print-docate')" value="print" />
					</div>
				</div>
				<!--- Print Docate Start-->
				<div id="print-docate" class="print-docate">
				<!-- Branch Start-->
				<?php if(!empty($product) && $product['branch_id']!=0){
					$branch = $db->getRow("SELECT * FROM `branch` where `branch_id`=?",array($product['branch_id']));
				?>
				<div class="col-xs-12 text-center">
					<h3>Branch ->  <?php echo $branch['name']?> </h3>
				</div>
				<?php } ?>
				<?php if(!empty($product)){ ?>
				<div class="col-xs-12 product-view-main">
					<h3>Vehicle Detail </h3>
					<div class="product-view-left col-xs-6">
						<div class="col-xs-4 product-view-title"><h4>Model :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product['model']) ? $product['model'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Color :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product['color']) ? $product['color'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Variant :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product['variant']) ? $product['variant'] : '-';?> </h4></div>
					</div>
					<div class="product-view-right col-xs-6">
						<div class="col-xs-4 product-view-title"><h4>ENG No:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product['eng_no']) ? $product['eng_no'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Chassis No:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product['chassis_no']) ? $product['chassis_no'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Key No:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product['key_no']) ? $product['key_no'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4> Date:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product['created_at']) ? date("d-m-Y h:i A",strtotime($product['created_at'])) : '-';?> </h4></div>
					</div>
				</div>
				<?php } ?>
				
				<?php if(!empty($veihicle)){ ?>
				<div class="col-xs-12 product-view-main">
					<h3>Vehicle Price Detail </h3>
					<div class="product-view-left col-xs-6">
						<div class="col-xs-4 product-view-title"><h4> Name : </h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['name']) ? $veihicle['name'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Price :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['price']) ? $veihicle['price'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>RTO Single:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['rto_single']) ? $veihicle['rto_single'] : '-';?></h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>RTO Double:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['rto_double']) ? $veihicle['rto_double'] : '-';?></h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Side Stand:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['side_stand']) ? $veihicle['side_stand'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Foot Rest:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['foot_rest']) ? $veihicle['foot_rest'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Leg Guard:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['leg_guard']) ? $veihicle['leg_guard'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Chrome Set:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['chrome_set']) ? $veihicle['chrome_set'] : '-';?> </h4></div>
					</div>
					<div class="product-view-right col-xs-6">
						<!--<div class="col-xs-4 product-view-title"><h4>No Plate:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['no_plate_fitting']) ? $veihicle['no_plate_fitting'] : '-';?>  </h4></div>
						<div class="clearfix"></div>-->
						<div class="col-xs-4 product-view-title"><h4>RMC Tax:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['rmc_tax']) ? $veihicle['rmc_tax'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>1 Year Ins.:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['insurance']) ? $veihicle['insurance'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>2 Year Ins.:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['2_year_insurance']) ? $veihicle['2_year_insurance'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>3 Year Ins.:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['3_year_insurance']) ? $veihicle['3_year_insurance'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Ex.Warranty:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['ex_warranty']) ? $veihicle['ex_warranty'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>AMC :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['amc']) ? $veihicle['amc'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Remark:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($veihicle['remark']) ? nl2br($veihicle['remark']) : '-';?>  </h4></div>
					</div>
				</div>
				<?php } ?>
				
				<!-- Product Price -->
				<?php if(!empty($product_price)){ ?>
				<div class="col-xs-12 product-view-main">
					<h3>Cashier Price Detail </h3>
					<div class="product-view-left col-xs-6">
						<div class="col-xs-4 product-view-title"><h4>Price :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product_price['price']) ? $product_price['price'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>RTO :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product_price['rto']) ? $product_price['rto'] : '-';?></h4></div>
						<div class="clearfix"></div>
						<!--<div class="col-xs-4 product-view-title"><h4>No Plate:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product_price['no_plate_fitting']) ? $product_price['no_plate_fitting'] : '-';?>  </h4></div>
						<div class="clearfix"></div>-->
						<?php if(empty($product_price['access_no'])){?>
						<div class="col-xs-4 product-view-title"><h4>Accessories:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> 
						<?php echo empty($product_price['access']) ? 'Done' : 'Pending';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Side Stand:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> 
						<?php echo !empty($product_price['side_stand']) ? $product_price['side_stand'] : 'No';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Foot Rest:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> 
						<?php echo !empty($product_price['foot_rest']) ? $product_price['foot_rest'] : 'No';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Leg Guard:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> 
						<?php echo !empty($product_price['leg_guard']) ? $product_price['leg_guard'] : 'No';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Chrome Set:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> 
						<?php echo !empty($product_price['chrome_set']) ? $product_price['chrome_set'] : 'No';?> </h4></div>
					<?php }else{ ?>
						<div class="col-xs-4 product-view-title"><h4>Accessories :</h4></div>
						<div class="col-xs-8 product-view-data"><h4>Not Accessories</h4></div>
					<?php } ?>
					</div>
					<div class="product-view-right col-xs-6">
						<div class="col-xs-4 product-view-title"><h4>RMC Tax:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product_price['rmc_tax']) ? $product_price['rmc_tax'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Insurance:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product_price['insurance']) ? $product_price['insurance'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Ex. Warranty:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product_price['ex_warranty']) ? $product_price['ex_warranty'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>AMC:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product_price['amc']) ? $product_price['amc'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Discount:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product_price['discount']) ? $product_price['discount'] : '-';?> </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Total:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product_price['total']) ? $product_price['total'] : '-';?>  </h4></div>
					</div>
				</div>
				<?php } ?>
				
				<?php if(!empty($customer)){ ?>
				<div class="col-xs-12 product-view-main">
					<h3>Customer Detail </h3>
					<div class="product-view-left col-xs-6">
						<div class="col-xs-4 product-view-title"><h4>Sales Man:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($salesman['name']) ? $salesman['name'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Name :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($customer['name']) ? $customer['name'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Mobile No:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($customer['mobile']) ? $customer['mobile'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Add 1 :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($customer['street_add1']) ? $customer['street_add1'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Add 2 :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($customer['street_add2']) ? $customer['street_add2'] : '-';?>  </h4></div>
					</div>
					<div class="product-view-right col-xs-6">
						<div class="col-xs-4 product-view-title"><h4>City:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($customer['city']) ? $customer['city'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Country:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($customer['country']) ? $customer['country'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Pending :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product_price['pending']) ? $product_price['pending'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Total :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($product_price['total']) ? $product_price['total'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Remark :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($customer['remark']) ? $customer['remark'] : '-';?>  </h4></div>
						<div class="clearfix"></div>
						<div class="col-xs-4 product-view-title"><h4>Date :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($customer['created_at']) ? date("d-m-Y h:i A",strtotime($customer['created_at'])) : '-';?>  </h4></div>
					</div>
				</div>
				<?php } ?>
				
				<?php if(!empty($customer_payment)){ ?>
				<div class="col-xs-12">
					<h3>Customer Payeble Amount</h3>
				<?php foreach($customer_payment as $value){?>
					<div class="product-view-main">
						<div class="product-view-left col-xs-6">
							<div class="col-xs-4 product-view-title"><h4>Cash Type:</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['case_type']) ? $value['case_type'] : '-';?> </h4></div>
							<div class="clearfix"></div>
							<div class="col-xs-4 product-view-title"><h4>Amount:</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['price']) ? $value['price'] : '-';?> </h4></div>
							<div class="clearfix"></div>
							<div class="col-xs-4 product-view-title"><h4>In Word:</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['amount_in_word']) ? $value['amount_in_word'] : '-';?> </h4></div>
						</div>
						<div class="product-view-right col-xs-6">
						<?php if($value['case_type']=="Cheque"){?>
							<div class="col-xs-4 product-view-title"><h4>Bank Name :</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['bank_name']) ? $value['bank_name'] : '-';?> </h4></div>
							<div class="clearfix"></div>
							<div class="col-xs-4 product-view-title"><h4>Cheque No.:</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['cheque_no']) ? $value['cheque_no'] : '-';?> </h4></div>
							<div class="clearfix"></div>
							<div class="col-xs-4 product-view-title"><h4>Cheque Date.:</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['cheque_date']) ? date("d-m-Y",strtotime($value['cheque_date'])) : '-';?> </h4></div>
						<?php }else if($value['case_type']=="DD"){ ?>
							<div class="col-xs-4 product-view-title"><h4>Bank Name:</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['dd_bank_name']) ? $value['dd_bank_name'] : '-';?> </h4></div>
							<div class="clearfix"></div>
							<div class="col-xs-4 product-view-title"><h4>DD No.:</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['dd_no']) ? $value['dd_no'] : '-';?> </h4></div>
							<div class="clearfix"></div>
							<div class="col-xs-4 product-view-title"><h4>DD Date.:</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['dd_date']) ? date("d-m-Y",strtotime($value['dd_date'])) : '-';?> </h4></div>
						<?php }else if($value['case_type']=="NEFT"){ ?>
							<div class="col-xs-4 product-view-title"><h4>A/C No. :</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['neft_ac_no']) ? $value['neft_ac_no'] : '-';?> </h4></div>
							<div class="clearfix"></div>
							<div class="col-xs-4 product-view-title"><h4>Bank Name :</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['neft_bank_name']) ? $value['neft_bank_name'] : '-';?> </h4></div>
							<div class="clearfix"></div>
							<div class="col-xs-4 product-view-title"><h4>IFSC Code :</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['neft_ifsc_code']) ? $value['neft_ifsc_code'] : '-';?> </h4></div>
							<div class="clearfix"></div>
							<div class="col-xs-4 product-view-title"><h4>Holder Name :</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['neft_holder_name']) ? $value['neft_holder_name'] : '-';?> </h4></div>
							<div class="clearfix"></div>
						<?php } ?>
							<div class="col-xs-4 product-view-title"><h4>Date :</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($value['created_at']) ? date("d-m-Y h:i A",strtotime($value['created_at'])) : '-';?> </h4></div>
						</div>
					</div>
					<div class="clearfix"></div><br>
				<?php } ?>
				</div>
				<?php } ?>
				
				<?php if(!empty($finance)){	?>
				<div class="col-xs-12">
						<h3> Finance </h3>
					<div class="product-view-main">
						<div class="product-view-left col-xs-6">
							<div class="col-xs-4 product-view-title"><h4>Finance :</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($finance['finance_amount']) ? $finance['finance_amount'] : '-';?> </h4></div>
							<div class="col-xs-4 product-view-title"><h4>DP Amount :</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($finance['dp_amount']) ? $finance['dp_amount'] : '-';?> </h4></div>
						</div>
						<div class="product-view-right col-xs-6">
							<div class="col-xs-4 product-view-title"><h4>Bank :</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($finance['bank']) ? $finance['bank'] : '-';?> </h4></div>
							<div class="col-xs-4 product-view-title"><h4>Date :</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($finance['created_at']) ? date("d-m-Y h:i A",strtotime($finance['created_at'])) : '-';?> </h4></div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<?php } ?>
				
				<?php if(!empty($exchange)){?>
				<div class="col-xs-12">
					<h3>Exchange</h3>
					<div class="product-view-main">
						<div class="product-view-left col-xs-6">
							<div class="col-xs-4 product-view-title"><h4>Amount :</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($exchange['amount']) ? $exchange['amount'] : '-';?> </h4></div>
						</div>
						<div class="product-view-right col-xs-6">
							<div class="col-xs-4 product-view-title"><h4>Vehicle No.:</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($exchange['veihicle_no']) ? $exchange['veihicle_no'] : '-';?> </h4></div>
							<div class="clearfix"></div>
							<div class="col-xs-4 product-view-title"><h4>Date :</h4></div>
							<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($exchange['created_at']) ? date("d-m-Y h:i A",strtotime($exchange['created_at'])) : '-';?> </h4></div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<?php } ?>
				
				<?php if(!empty($gatepass)){ ?>
				<div class="col-xs-12 product-view-main">
					<h3>Gate Pass Detail </h3>
					<div class="product-view-left col-xs-6">
						<div class="col-xs-4 product-view-title"><h4>Gatepass No:</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($gatepass['gatepass_id']) ? str_pad($gatepass['gatepass_id'], 3, "0", STR_PAD_LEFT) : '-';?>  </h4></div>
					</div>
					<div class="product-view-right col-xs-6">
						<div class="col-xs-4 product-view-title"><h4>Date. :</h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($gatepass['created_at']) ? date("d-m-Y h:i A",strtotime($gatepass['created_at'])) : '-';?>  </h4></div>
					</div>
				</div>
				<?php } ?>
				
				<?php if(!empty($billing)){ ?>
				<div class="col-xs-12 product-view-main">
					<h3>Bill Detail </h3>
					<div class="product-view-left col-xs-6">
						<div class="col-xs-4 product-view-title"><h4> Bill No : </h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($billing['billing_id']) ? str_pad($billing['billing_id'], 3, "0", STR_PAD_LEFT) : '-';?>  </h4></div>
					</div>
					<div class="product-view-right col-xs-6">
						<div class="col-xs-4 product-view-title"><h4> Date. : </h4></div>
						<div class="col-xs-8 product-view-data"><h4> <?php echo !empty($billing['updated_at']) ? date("d-m-Y h:i A",strtotime($billing['updated_at'])) : '-';?>  </h4></div>
					</div>
				</div>
				<?php } ?>
				</div>
				<!--- Print Docate End-->
			</div>
			<br><br>
		</div>
	</div>
	<!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->

<?php include("include/footer.php");?>
<script type="text/javascript">
// html2canvas print docate
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}
$(document).ready(function(){
// Search Chassis No
$("#search").keypress(function() {
	var search = $(this).val();
	var type = "veihicle_status_search";
	if(search.length >= 4){
	$.ajax({
		url : "model/veihicleStatusManage.php",
		cache : false,
		data : {
			type : type, search : search
		},
		beforeSend: function() {
			$(".search_loading_img").show();
			$(".search_result").html();
		},
		type : "post",
		success : function(data) {
			$(".search_loading_img").hide();
			if (data) {
				$(".search_result").html(data);
				//$("#admin-add-frm").find("input,textarea").val("");
				//window.location.href = 'admin.php';
				//$("#admin-add-frm").trigger("reset");
				//loadmaincattable();
			}else{
				$(".search_result").html(data);
				//alert("Admin Allready Exists!");
				//$("#admin-add-frm").find("input,textarea").val("");
				//window.location.href = 'admin.php';
			}
		}
	});
	}
});
});

$(function(){
    $(document).on('click','.veihicle_status_chassis_ul li', function(){
		var search = $(this).text();
		$("#search").val(search);
		$(".search_result").html("");
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