<?php include_once('include/comman_session.php');
if(isset($_REQUEST['aid'])){
	$id=$_REQUEST['aid'];
}else{
	header('Location:cashier_list.php');
	exit();
}

$table = "customer_detail";
$table1 = "product";
$table2 = "product_price";
$table3 = "customer_payment";

$select = $db->getRow("SELECT * FROM ".$table." where `customer_detail_id`=?",array($id));
if(!empty($select)){
	$product = $db->getRow("SELECT * FROM ".$table1." where `product_id`=?",array($select['product_id']));
	$product_price = $db->getRow("SELECT * FROM ".$table2." where `product_id`=?",array($select['product_id']));
	$customer_payment = $db->getRows("SELECT * FROM ".$table3." where `customer_detail_id`=?",array($select['customer_detail_id']));
}else{
	header('Location:cashier_list.php');
	exit();
}
$type = "View";
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
							Customer Detail
						</li>
					</ol>
					<div class="page-header">
						<h1>Customer Detail </h1>
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
							Customer Detail <?php echo $type;?>
							<div class="panel-tools">
								<a class="btn btn-xs btn-link" href=""><i class="fa fa-refresh"></i></a>
								<a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
							</div>
						</div>
						<div class="panel-body">
							<a class="col-sm-1 btn btn-danger btn-squared pull-right" onclick = "window.close();"> Close</a>
							<div class="clearfix"></div><br>
							<table style="clear: both" class="table table-bordered table-striped" id="user">
								<tbody>
									<tr>
										<td class="column-left">Chassis No. </td>
										<td class="column-right"><?php echo !empty($product['chassis_no']) ? $product['chassis_no'] : 'No Chassis No Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">Model: </td>
										<td class="column-right"><?php echo !empty($product['model']) ? $product['model'] : 'No Model Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">Color: </td>
										<td class="column-right"><?php echo !empty($product['color']) ? $product['color'] : 'No Color Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">Engine No. </td>
										<td class="column-right"><?php echo !empty($product['eng_no']) ? $product['eng_no'] : 'No Engine No. Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left"><h4>Customer Detail </h4></td>
									</tr>
									<tr>
										<td class="column-left">Sales Man </td>
										<td class="column-right"><?php 
											$salesman = $db->getRow("SELECT * FROM `salesman` where `salesman_id`=?",array($select['salesman_id']));
											echo !empty($salesman['name']) ? $salesman['name'] : 'No Sales Man Entered...' ?>
										</td>
									</tr>
									<tr>
										<td class="column-left">Customer Name </td>
										<td class="column-right"><?php echo !empty($select['name']) ? $select['name'] : 'No Customer Name Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">Mobile No. </td>
										<td class="column-right"><?php echo !empty($select['mobile']) ? $select['mobile'] : 'No Mobile No. Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">Street Address 1 </td>
										<td class="column-right"><?php echo !empty($select['street_add1']) ? $select['street_add1'] : 'No Street Address 1 Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">Street Address 2 </td>
										<td class="column-right"><?php echo !empty($select['street_add2']) ? $select['street_add2'] : 'No Street Address 2 Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">City </td>
										<td class="column-right"><?php echo !empty($select['city']) ? $select['city'] : 'No City Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">Country </td>
										<td class="column-right"><?php echo !empty($select['country']) ? $select['country'] : 'No Country Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left"><h4>Customer Payment Detail </h4></td>
									</tr>
								<?php foreach($customer_payment as $cusPayment){?>
									<tr>
										<td class="column-left">Payment Type </td>
										<td class="column-right"><?php echo !empty($cusPayment['case_type']) ? $cusPayment['case_type'] : 'No Payment Type Entered...' ?></td>
									</tr>
									<?php if($cusPayment['case_type']=="Cheque"){?>
									<tr>
										<td class="column-left"></td>
										<td class="column-right">Bank Name -> <?php echo !empty($cusPayment['bank_name']) ? $select['bank_name'] : 'No Bank Name Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left"></td>
										<td class="column-right">Cheque No. -> <?php echo !empty($cusPayment['cheque_no']) ? $cusPayment['cheque_no'] : 'No Cheque No. Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left"></td>
										<td class="column-right">Cheque Date -> <?php echo !empty($cusPayment['cheque_date']) ? date("d-m-Y",strtotime($cusPayment['cheque_date'])) : 'No Cheque Date Entered...' ?></td>
									</tr>
									<?php } ?>
									<?php if($cusPayment['case_type']=="DD"){?>
									<tr>
										<td class="column-left"></td>
										<td class="column-right">DD Bank Name -> <?php echo !empty($cusPayment['dd_bank_name']) ? $cusPayment['dd_bank_name'] : 'No DD Bank Name Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left"></td>
										<td class="column-right">DD No. -> <?php echo !empty($cusPayment['dd_no']) ? $cusPayment['dd_no'] : 'No DD No. Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left"></td>
										<td class="column-right">DD Date -> <?php echo !empty($select['dd_date']) ? date("d-m-Y",strtotime($select['dd_date'])) : 'No DD Date Entered...' ?></td>
									</tr>
									<?php } ?>
									<?php if($cusPayment['case_type']=="NEFT"){?>
									<tr>
										<td class="column-left"></td>
										<td class="column-right">Account No. -> <?php echo !empty($cusPayment['neft_ac_no']) ? $cusPayment['neft_ac_no'] : 'Account No. Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left"></td>
										<td class="column-right">Bank Name -> <?php echo !empty($cusPayment['neft_bank_name']) ? $cusPayment['neft_bank_name'] : 'Bank Name Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left"></td>
										<td class="column-right">IFSC Code -> <?php echo !empty($cusPayment['neft_ifsc_code']) ? $cusPayment['neft_ifsc_code'] : 'IFSC Code Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left"></td>
										<td class="column-right">Holder Name -> <?php echo !empty($cusPayment['neft_holder_name']) ? $cusPayment['neft_holder_name'] : 'Holder Name Entered...' ?></td>
									</tr>
									<?php } ?>
									<tr>
										<td class="column-left"></td>
										<td class="column-right">Your Entered Price -> <b><?php echo !empty($cusPayment['price']) ? $cusPayment['price'] : 'No Price Entered...' ?></b></td>
									</tr>
									<tr>
										<td class="column-left"></td>
										<td class="column-right">Amount In Word -> <?php echo !empty($cusPayment['amount_in_word']) ? $cusPayment['amount_in_word'] : 'No Amount In Word Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left"></td>
										<td class="column-right">Date -> <?php echo !empty($select['created_at']) ? date("d-m-Y",strtotime($select['created_at'])) : 'Date Entered...' ?></td>
									</tr>
								<?php } ?>
									<tr>
										<td class="column-left"><h4>Product Price Detail </h4></td>
									</tr>
									<tr>
										<td class="column-left">Original Price </td>
										<td class="column-right"><?php echo !empty($product_price['price']) ? $product_price['price'] : 'No Original Price Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">RTO </td>
										<td class="column-right"><?php echo !empty($product_price['rto']) ? $product_price['rto'] : 'No RTO Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">No. Plate Fitting </td>
										<td class="column-right"><?php echo !empty($product_price['no_plate_fitting']) ? $product_price['no_plate_fitting'] : 'No No. Plate Fitting Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">RMC Tax </td>
										<td class="column-right"><?php echo !empty($product_price['rmc_tax']) ? $product_price['rmc_tax'] : 'No RMC Tax Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">Accessories </td>
										<td class="column-right"><?php 
											 if(empty($product_price['access_no'])){
												echo 'Side Stand - '.$product_price['side_stand']."<br>";
												echo 'Foot Rest - '.$product_price['foot_rest']."<br>";
												echo 'Leg Guard - '.$product_price['leg_guard']."<br>";
												echo 'Chrome Set - '.$product_price['chrome_set']."<br>";
											 }else{
												echo 'No Access - <br>';
											 }
											 echo empty($product_price['access']) ? 'Accessories -> Done' : 'Accessories -> Pending';
										?></td>
									</tr>
									<tr>
										<td class="column-left">AMC </td>
										<td class="column-right"><?php echo !empty($product_price['amc']) ? $product_price['amc'] : 'No Accessories Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">Ex. Warranty </td>
										<td class="column-right"><?php echo !empty($product_price['ex_warranty']) ? $product_price['ex_warranty'] : 'No Ex. Warranty Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">Insurance </td>
										<td class="column-right"><?php echo !empty($product_price['insurance']) ? $product_price['insurance'] : 'No Insurance Entered...' ?></td>
									</tr>
									<tr>
										<td class="column-left">Discount </td>
										<td class="column-right"><?php echo !empty($product_price['discount']) ? $product_price['discount'] : ' 0 ' ?></td>
									</tr>
									<tr>
										<td class="column-left">Final Total </td>
										<td class="column-right"><strong><?php echo !empty($product_price['total']) ? $product_price['total'] : 'No Final Total Entered...' ?></strong></td>
									</tr>
									<tr>
										<td class="column-left">Remark </td>
										<td class="column-right"><?php echo !empty($select['remark']) ? nl2br($select['remark']) : '- -' ?></td>
									</tr>
									<tr>
										<td class="column-left"> </td>
										<td class="column-right"><a class="btn btn-danger btn-squared" onclick = "window.close();"> Close</a></td>
									</tr>
								</tbody>
							</table>
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