<?php include_once('include/comman_session.php');
if(isset($_REQUEST['aid'])){
	$id = $_REQUEST['aid'];
}else{
	header('Location:billing.php');
	exit();
}

$table = "product";
$table1 = "customer_detail";
$table2 = "gatepass";
$table3 = "product_price";
$table4 = "billing";
$table5 = "customer_payment";

$product = $db->getRow("SELECT * FROM ".$table." where `chassis_no`=?",array($id));
if(!empty($product['veihicle_id']) && ($product['veihicle_id']!=0)){
	$veihicle = $db->getRow("SELECT * FROM `veihicle` where `veihicle_id`=?",array($product['veihicle_id']));
}
if(!empty($veihicle))
{
	// Customer Detail Add then gatepass generate code
	$customer = $db->getRow("SELECT * FROM ".$table1." where `product_id`=?",array($product['product_id']));
	if(!empty($customer))
	{
		// gatepass generated then go next task othewise go header location
		$gatepass = $db->getRow("SELECT * FROM ".$table2." where `product_id`=?",array($product['product_id']));
		// find salesman name
		$salesman = $db->getRow("SELECT * FROM `salesman` where `salesman_id`=?",array($customer['salesman_id']));
		if(!empty($gatepass)){
			$product_price = $db->getRow("SELECT * FROM ".$table3." where `product_id`=?",array($product['product_id']));
			// find billing data
			$select = $db->getRow("SELECT * FROM ".$table4." where `product_id`=?",array($product['product_id']));
			//find customer payment detail
			$customer_payment = $db->getRows("SELECT * FROM ".$table5." where `customer_detail_id`=?",array($customer['customer_detail_id']));
			// Exchange
			$exchange = $db->getRow("SELECT * FROM `exchange` where `customer_detail_id`=?",array($customer['customer_detail_id']));
			// Finance
			$finance = $db->getRow("SELECT * FROM `finance` where `product_id`=?",array($product['product_id']));
		}else{
			$_SESSION['admin_error'] = "Gate Pass Not Ganerated First Generate Gate Pass Then Bill Contact To Sub-Admin...";
			header('Location:billing.php');
			exit();
		}
	}else{
		$_SESSION['admin_error'] = "Cashier Not Add Detail Then Generate Gate Pass Contact To Cashier...";
		header('Location:billing.php');
		exit();
	}
}else{
	$_SESSION['admin_error'] = "Please Select Model Then Generate Bill Contact Sub-Admin Or Admin...";
	header('Location:billing.php');
	exit();
}
include("include/header.php");
if($select){
	$type = "edit";
	$billId = $select['billing_id'];
	$admin_id = $select['admin_id'];
}else{
	$type = "add";
	$billId = 0;
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
							Billing
						</li>
					</ol>
					<div class="page-header">
						<h3>Vehicle Detail </h3>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
				<a style="margin-left: 16px;" target="_blank" href="product.php?aid=<?php echo $product['product_id'];?>" class="text-right"><i class="fa fa-edit"></i></a>
				<div class="col-sm-12 product-view-main ">
					<div class="product-view-left col-sm-6">
						<div class="col-sm-4 product-view-title"><h4> Model : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product['model']) ? $product['model'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Color : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product['color']) ? $product['color'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Variant : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product['variant']) ? $product['variant'] : '-';?> </h4></div>
					</div>
					<div class="product-view-right col-sm-6">
						<div class="col-sm-4 product-view-title"><h4> Engine No. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product['eng_no']) ? $product['eng_no'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Chassis No. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product['chassis_no']) ? $product['chassis_no'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Key No. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product['key_no']) ? $product['key_no'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Entered Date. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product['created_at']) ? date("d-m-Y h:i A",strtotime($product['created_at'])) : '-';?> </h4></div>
					</div>
				</div>
				
				<!-- Product Price -->
				<?php if(!empty($product_price)){ ?>
				<div class="col-sm-12 product-view-main">
					<div class="page-header">
						<h3>Vehicle Price Detail </h3>
					</div>
					<div class="product-view-left col-sm-6">
						<div class="col-sm-4 product-view-title"><h4> Price : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product_price['price']) ? $product_price['price'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> RTO : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product_price['rto']) ? $product_price['rto'] : '-';?></h4></div>
						<div class="col-sm-4 product-view-title"><h4> No Plate Fitting. :</h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product_price['no_plate_fitting']) ? $product_price['no_plate_fitting'] : '-';?>  </h4></div>
						<?php if(empty($product_price['access_no'])){?>
						<div class="col-sm-4 product-view-title"><h4> Accessories : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> 
						<?php echo empty($product_price['access']) ? 'Done' : 'Pending';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Side Stand : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> 
						<?php echo !empty($product_price['side_stand']) ? $product_price['side_stand'] : 'No';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Foot Rest : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> 
						<?php echo !empty($product_price['foot_rest']) ? $product_price['foot_rest'] : 'No';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Leg Guard : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> 
						<?php echo !empty($product_price['leg_guard']) ? $product_price['leg_guard'] : 'No';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Chrome Set : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> 
						<?php echo !empty($product_price['chrome_set']) ? $product_price['chrome_set'] : 'No';?> </h4></div>
					<?php }else{ ?>
						<div class="col-sm-4 product-view-title"><h4> Accessories : </h4></div>
						<div class="col-sm-8 product-view-data"><h4>no accessories</h4></div>
					<?php } ?>
					</div>
					<div class="product-view-right col-sm-6">
						<div class="col-sm-4 product-view-title"><h4> RMC Tax. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product_price['rmc_tax']) ? $product_price['rmc_tax'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Insurance. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product_price['insurance']) ? $product_price['insurance'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Ex. Warranty. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product_price['ex_warranty']) ? $product_price['ex_warranty'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> AMC : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product_price['amc']) ? $product_price['amc'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Discount : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product_price['discount']) ? $product_price['discount'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Pending. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product_price['pending']) ? $product_price['pending'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Total. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product_price['total']) ? $product_price['total'] : '-';?>  </h4></div>
					</div>
				</div>
				<?php } ?>
				
				<div class="col-sm-12 product-view-main">
					<div class="page-header">
						<h3>Customer Detail </h3>
						<a title="Click to Edit" target="_blank" href="customer_detail_edit.php?aid=<?php echo $customer['customer_detail_id'];?>" class="text-right"><i class="fa fa-edit"></i></a>
					</div>
					<div class="product-view-left col-sm-6">
						<div class="col-sm-4 product-view-title"><h4> Sales Man Name : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($salesman['name']) ? $salesman['name'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Name Of Owner : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($customer['name']) ? $customer['name'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Mobile No : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($customer['mobile']) ? $customer['mobile'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Street Address 1. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($customer['street_add1']) ? $customer['street_add1'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Street Address 2. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($customer['street_add2']) ? $customer['street_add2'] : '-';?>  </h4></div>
					</div>
					<div class="product-view-right col-sm-6">
						<div class="col-sm-4 product-view-title"><h4> City. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($customer['city']) ? $customer['city'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Country. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($customer['country']) ? $customer['country'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Remark : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($customer['remark']) ? $customer['remark'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Date : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($customer['created_at']) ? date("d-m-Y h:i A",strtotime($customer['created_at'])) : '-';?>  </h4></div>
					</div>
				</div>
				
				<div class="col-sm-12">
					<div class="page-header">
						<h3>Customer Payeble Amount</h3>
					</div>
				<?php foreach($customer_payment as $value){?>
					<a title="Click to Edit" target="_blank" href="customer_payment_detail_edit.php?aid=<?php echo $value['customer_payment_id'];?>" class="text-right"><i class="fa fa-edit"></i></a>
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
					<div class="clearfix"></div><br><br>
				<?php } ?>
				</div>
				
				<!-- Branch Start-->
				<?php if($product['branch_id']!=0){
					$branch = $db->getRow("SELECT * FROM `branch` where `branch_id`=?",array($product['branch_id']));
				?>
				<div class="col-sm-12">
					<div class="page-header">
						<h3>Branch ->  <?php echo $branch['name']?> </h3>
					</div>
				</div>
				<?php } ?>
				
				<?php if(!empty($finance)){ ?>
					<div class="col-sm-12">
						<div class="page-header">
							<h3> Finance </h3>
						</div>
						<a target="_blank" href="customer_payment_finance_edit.php?aid=<?php echo $finance['finance_id'];?>" class="text-right"><i class="fa fa-edit"></i></a>
						<div class="product-view-main">
							<div class="product-view-left col-sm-6">
								<div class="col-sm-4 product-view-title"><h4> Finance Amount : </h4></div>
								<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($finance['finance_amount']) ? $finance['finance_amount'] : '-';?> </h4></div>
								<div class="col-sm-4 product-view-title"><h4> DP Amount : </h4></div>
								<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($finance['dp_amount']) ? $finance['dp_amount'] : '-';?> </h4></div>
							</div>
							<div class="product-view-right col-sm-6">
								<div class="col-sm-4 product-view-title"><h4> Bank : </h4></div>
								<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($finance['bank']) ? $finance['bank'] : '-';?> </h4></div>
								<div class="col-sm-4 product-view-title"><h4> Date : </h4></div>
								<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($finance['created_at']) ? date("d-m-Y h:i A",strtotime($finance['created_at'])) : '-';?> </h4></div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				<?php } ?>
				
				<?php if(!empty($exchange)){ ?>
					<div class="col-sm-12">
						<div class="page-header">
							<h3>Exchange</h3>
						</div>
						<a target="_blank" href="customer_payment_exchange_edit.php?aid=<?php echo $exchange['exchange_id'];?>" class="text-right"><i class="fa fa-edit"></i></a>
						<div class="product-view-main">
							<div class="product-view-left col-sm-6">
								<div class="col-sm-4 product-view-title"><h4> Amount : </h4></div>
								<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($exchange['amount']) ? $exchange['amount'] : '-';?> </h4></div>
							</div>
							<div class="product-view-right col-sm-6">
								<div class="col-sm-4 product-view-title"><h4> Vehicle No. : </h4></div>
								<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($exchange['veihicle_no']) ? $exchange['veihicle_no'] : '-';?> </h4></div>
								<div class="col-sm-4 product-view-title"><h4> Date : </h4></div>
								<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($exchange['created_at']) ? date("d-m-Y h:i A",strtotime($exchange['created_at'])) : '-';?> </h4></div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				<?php } ?>
				
				<div class="col-sm-12">
					<div class="page-header">
						<h3>Generate Bill <?php echo $type;?></h3>
					</div>
					<form class="form-horizontal" method="post" action="model/billingManage.php" id="billing_add_frm" name="billing_add_frm" enctype="multipart/form-data">
						<input type="hidden" value="<?php echo $type;?>" name="type">
						<input type="hidden" value="<?php echo $id;?>" name="chassis_no">
						<input type="hidden" value="<?php echo $product['product_id'];?>" name="product_id">
						<input type="hidden" value="<?php echo $admin_id;?>" name="admin_id">
						<input type="hidden" value="<?php echo $gatepass['gatepass_id'];?>" name="gatepass_id">
						<input type="hidden" value="<?php echo !empty($customer['customer_detail_id']) ? $customer['customer_detail_id'] : '0';?>" name="customer_detail_id">
						<input type="hidden" value="<?php echo !empty($billId) ? $billId : '0';?>" name="id">
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Customer Detail
							</label>
							<div class="col-sm-4">
								<a target="_blank" href="bill_customer_1.php?aid=<?php echo $customer['customer_detail_id'];?>" class="btn btn-green btn-squared print">Click Generate Customer Detail</a>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Service Detail
							</label>
							<div class="col-sm-4">
								<a target="_blank" href="bill_customer_2.php?aid=<?php echo $customer['customer_detail_id'];?>" class="btn btn-green btn-squared print">Click Generate Service Detail</a>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Barcode
							</label>
							<div class="col-sm-4">
							<?php $billService = !empty($select['service']) ? $select['service'] : 0;?>
								<select id="service_book" class="form-control" name="service_book">
									<option value="">Select Service Book</option>
									<option value="1" <?php echo $billService==1 ? 'selected' : '';?>>1 Service Book</option>
									<option value="2" <?php echo $billService==2 ? 'selected' : '';?>>2 Service Book</option>
									<option value="3" <?php echo $billService==3 ? 'selected' : '';?>>3 Service Book</option>
									<option value="4" <?php echo $billService==4 ? 'selected' : '';?>>4 Service Book</option>
									<option value="5" <?php echo $billService==5 ? 'selected' : '';?>>5 Service Book</option>
									<option value="6" <?php echo $billService==6 ? 'selected' : '';?>>6 Service Book</option>
									<option value="7" <?php echo $billService==7 ? 'selected' : '';?>>7 Service Book</option>
									<option value="8" <?php echo $billService==8 ? 'selected' : '';?>>8 Service Book</option>
									<option value="9" <?php echo $billService==9 ? 'selected' : '';?>>9 Service Book</option>
									<option value="10" <?php echo $billService==10 ? 'selected' : '';?>>10 Service Book</option>
									<option value="11" <?php echo $billService==11 ? 'selected' : '';?>>11 Service Book</option>
									<option value="12" <?php echo $billService==12 ? 'selected' : '';?>>12 Service Book</option>
								</select>
							</div>
						</div>
						<div class="form-group text-center">
							<div class="col-sm-12">
								<?php if($type=="add"){?>
									<input type="submit" class="btn btn-success btn-squared" value="Generate Bill">
								<?php }else{ ?>
									<input type="submit" class="btn btn-info btn-squared" value="Already Generated">
									<a target="_blank" href="invoice/bill-invoice.php?id=<?php echo $select['billing_id'];?>&type=Original" class="btn btn-green btn-squared print">Vehicle Print</a>
									<a target="_blank" href="invoice/bill-acc-invoice.php?id=<?php echo $select['billing_id'];?>&type=Original" class="btn btn-green btn-squared print">Accessorize Print</a>
								<?php }?>
								<a href="billing_list.php" class="btn btn-danger btn-squared">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->

<?php include("include/footer.php");?>
<script type="text/javascript">
// Cheque Date
$(".cheque_date").datepicker({
	format: "yyyy-mm-dd",
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

<script type="text/javascript">
   $(document).ajaxComplete(function() {
	$(".paginate_button").click(function() {
	 $(".html5lightbox").html5lightbox();
	});
	$(".html5lightbox").html5lightbox();
   });

   $(document).on("click", "#html5-close", function(e) {
	var table = $('#dataTable').DataTable();
	table.ajax.reload();
   });

   $(document).on("click", "#html5-lightbox-overlay", function(e) {
	var table = $('#loadpro').DataTable();
	table.ajax.reload();
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
		ajaxindicatorstart();
		}).ajaxStop(function () {
		//hide ajax indicator
		ajaxindicatorstop();
	});
</script>