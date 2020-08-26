<?php include_once('include/comman_session.php');
if(isset($_REQUEST['aid'])){
	$id = $_REQUEST['aid'];
}else{
	header('Location:billing.php');
	exit();
}

$table = "billing";
$table1 = "product";
$table2 = "customer_detail";
$table3 = "product_price";
$table4 = "customer_payment";

$billing = $db->getRow("SELECT * FROM ".$table." where `billing_id`=?",array($id));
if(!empty($billing['billing_id']) && ($billing['billing_id']!=0)){
	$product = $db->getRow("SELECT * FROM ".$table1." where `product_id`=?",array($billing['product_id']));
}
if(!empty($product))
{
	$veihicle = $db->getRow("SELECT * FROM `veihicle` where `veihicle_id`=?",array($product['veihicle_id']));
	if(!empty($veihicle))
	{
		$customer = $db->getRow("SELECT * FROM ".$table2." where `product_id`=?",array($product['product_id']));$product_price = $db->getRow("SELECT * FROM ".$table3." where `product_id`=?",array($product['product_id']));
		$salesman = $db->getRow("SELECT * FROM `salesman` where `salesman_id`=?",array($customer['salesman_id']));
		$customer_payment = $db->getRows("SELECT * FROM ".$table4." where `customer_detail_id`=?",array($customer['customer_detail_id']));
	}else{
		$_SESSION['admin_error'] = "Please Select Model Then Generate Bill Contact Sub-Admin Or Admin...";
		header('Location:billing.php');
		exit();
	}
}else{
	$_SESSION['admin_error'] = "Chassis No. Not Found Enter Properly...";
	header('Location:billing.php');
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
						<h3>Veihicle Detail <a onclick = "window.close();" class="btn btn-danger pull-right btn-squared">Cancel</a></h3>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
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
				<?php if(!empty($veihicle)){ ?>
				<div class="col-sm-12 product-view-main">
					<div class="page-header">
						<h3>Veihicle Price Detail </h3>
					</div>
					<div class="product-view-left col-sm-6">
						<div class="col-sm-4 product-view-title"><h4> Name : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['name']) ? $veihicle['name'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Price : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['price']) ? $veihicle['price'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> RTO Single : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['rto_single']) ? $veihicle['rto_single'] : '-';?></h4></div>
						<div class="col-sm-4 product-view-title"><h4> RTO Double : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['rto_double']) ? $veihicle['rto_double'] : '-';?></h4></div>
						<div class="col-sm-4 product-view-title"><h4> Acce.Side Stand : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['side_stand']) ? $veihicle['side_stand'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Acce.Foot Rest : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['foot_rest']) ? $veihicle['foot_rest'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Acce.Leg Guard : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['leg_guard']) ? $veihicle['leg_guard'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Acce.Chrome Set : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['chrome_set']) ? $veihicle['chrome_set'] : '-';?> </h4></div>
					</div>
					<div class="product-view-right col-sm-6">
						<div class="col-sm-4 product-view-title"><h4> No Plate Fitting. :</h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['no_plate_fitting']) ? $veihicle['no_plate_fitting'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> RMC Tax. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['rmc_tax']) ? $veihicle['rmc_tax'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> 1 Year Insurance. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['insurance']) ? $veihicle['insurance'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> 2 Year Insurance. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['2_year_insurance']) ? $veihicle['2_year_insurance'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> 3 Year Insurance. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['3_year_insurance']) ? $veihicle['3_year_insurance'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Ex. Warranty. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['ex_warranty']) ? $veihicle['ex_warranty'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> AMC : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['amc']) ? $veihicle['amc'] : '-';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Remark : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['remark']) ? nl2br($veihicle['remark']) : '-';?>  </h4></div>
					</div>
				</div>
				<?php } ?>
				<!-- Product Price -->
				<?php if(!empty($product_price)){ ?>
				<div class="col-sm-12 product-view-main">
					<div class="page-header">
						<h3>Cashier Price Detail </h3>
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
						<div class="col-sm-4 product-view-title"><h4> Total. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product_price['total']) ? $product_price['total'] : '-';?>  </h4></div>
					</div>
				</div>
				<?php } ?>
				
				<div class="col-sm-12 product-view-main">
					<div class="page-header">
						<h3>Owner Detail </h3>
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
						<div class="col-sm-4 product-view-title"><h4> Pending : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product_price['pending']) ? $product_price['pending'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Total : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($product_price['total']) ? $product_price['total'] : '-';?>  </h4></div>
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
				
				<div class="col-sm-12">
					<div class="page-header"></div>
					<div class="form-group text-center">
						<div class="col-sm-12">
							<a onclick = "window.close();" class="btn btn-danger btn-squared">Cancel</a><br><br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->

<?php include("include/footer.php");?>
<script type="text/javascript">

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