<?php include_once('include/comman_session.php');
if($_POST){
	$vehicle_to = isset($_REQUEST['vehicle_to']) ? date("Y-m-d",strtotime($_REQUEST['vehicle_to'])) : '';
	$vehicle_from = isset($_REQUEST['vehicle_from']) ? date("Y-m-d",strtotime($_REQUEST['vehicle_from'])) : '';$advance_to = isset($_REQUEST['advance_to']) ? date("Y-m-d",strtotime($_REQUEST['advance_to'])) : '';
	$advance_from = isset($_REQUEST['advance_from']) ? date("Y-m-d",strtotime($_REQUEST['advance_from'])) : '';
	$branch_to = isset($_REQUEST['branch_to']) ? date("Y-m-d",strtotime($_REQUEST['branch_to'])) : '';
	$branch_from = isset($_REQUEST['branch_from']) ? date("Y-m-d",strtotime($_REQUEST['branch_from'])) : '';
	$expence_to = isset($_REQUEST['expence_to']) ? date("Y-m-d",strtotime($_REQUEST['expence_to'])) : '';
	$expence_from = isset($_REQUEST['expence_from']) ? date("Y-m-d",strtotime($_REQUEST['expence_from'])) : '';
	$atm_to = isset($_REQUEST['atm_to']) ? date("Y-m-d",strtotime($_REQUEST['atm_to'])) : '';
	$atm_from = isset($_REQUEST['atm_from']) ? date("Y-m-d",strtotime($_REQUEST['atm_from'])) : '';
	$bank_to = isset($_REQUEST['bank_to']) ? date("Y-m-d",strtotime($_REQUEST['bank_to'])) : '';
	$bank_from = isset($_REQUEST['bank_from']) ? date("Y-m-d",strtotime($_REQUEST['bank_from'])) : '';
	
	// Cashier Collect Vehicle Amount On Case
	$cashier = $db->getRows("SELECT * FROM `customer_payment` where `case_type`=? AND `updated_at` BETWEEN ? AND ?",array('Cash',$vehicle_to,$vehicle_from));
	// Cashier Collect Vehicle Amount On Cheque
	$cashierCheque = $db->getRows("SELECT * FROM `customer_payment` where `case_type`!=? AND `updated_at` BETWEEN ? AND ?",array('Cash',$vehicle_to,$vehicle_from));
	// Advance Collect Vehicle Amount On Cash
	$advancePayment = $db->getRows("SELECT * FROM `advance_payment` where `case_type`=? AND `updated_at` BETWEEN ? AND ?",array('Cash',$advance_to,$advance_from));
	// Advance Collect Vehicle Amount On Cheque
	$advancePaymentCheque = $db->getRows("SELECT * FROM `advance_payment` where `case_type`!=? AND `updated_at` BETWEEN ? AND ?",array('Cash',$advance_to,$advance_from));
	// Branch Amount Collect
	$branch = $db->getRows("SELECT * FROM `cashier` where `created_at` BETWEEN ? AND ?",array($branch_to,$branch_from));
	// Expense Cashier Amount
	$expense = $db->getRows("SELECT * FROM `expense` where `created_at` BETWEEN ? AND ?",array($expence_to,$expence_from));
	// ATM Cashier Amount
	$atm = $db->getRows("SELECT * FROM `atm` where `created_at` BETWEEN ? AND ?",array($atm_to,$atm_from));
	// Bank Cashier Amount
	$bank = $db->getRows("SELECT * FROM `bank` where `created_at` BETWEEN ? AND ?",array($bank_to,$bank_from));
	// Deleted Reciept
	$recordDelete = $db->getRows("SELECT * FROM `record_delete`",array());
}
$branchTotal = $cashierTotal = $chequeTotal = $advanceChequeTotal = $expenseTotal = $atmTotal = $bankTotal = $advanceTotal = 0;
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
							Report
						</li>
					</ol>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
				<div class="col-sm-12">
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
					<h2>Creadit </h2>
				<form method="post" name="rp_total" class="rp_total" id="rp_total">
					<div class="form-group">
						<h4 class="col-sm-2">Vehicle Search </h4>
						<div class="col-sm-3">
							<input type="text" id="vehicle_to" class="form-control date-picker" name="vehicle_to" value="<?php echo isset($_POST['vehicle_to']) ? $_POST['vehicle_to'] : ''?>">
						</div>
						<div class="col-sm-3">
							<input type="text" id="vehicle_from" class="form-control date-picker" name="vehicle_from" value="<?php echo isset($_POST['vehicle_from']) ? $_POST['vehicle_from'] : ''?>">
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<h4 class="col-sm-2">Advance Search </h4>
						<div class="col-sm-3">
							<input type="text" id="advance_to" class="form-control date-picker" name="advance_to" value="<?php echo isset($_POST['advance_to']) ? $_POST['advance_to'] : ''?>">
						</div>
						<div class="col-sm-3">
							<input type="text" id="advance_from" class="form-control date-picker" name="advance_from" value="<?php echo isset($_POST['advance_from']) ? $_POST['advance_from'] : ''?>">
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<h4 class="col-sm-2">Branch Search </h4>
						<div class="col-sm-3">
							<input type="text" id="branch_to" class="form-control date-picker" name="branch_to" value="<?php echo isset($_POST['branch_to']) ? $_POST['branch_to'] : ''?>">
						</div>
						<div class="col-sm-3">
							<input type="text" id="branch_from" class="form-control date-picker" name="branch_from" value="<?php echo isset($_POST['branch_from']) ? $_POST['branch_from'] : ''?>">
						</div>
					</div>
					<div class="clearfix"></div>
					<hr>
					<h2>Debit </h2>
					<div class="form-group">
						<h4 class="col-sm-2">Expence Search </h4>
						<div class="col-sm-3">
							<input type="text" id="expence_to" class="form-control date-picker" name="expence_to" value="<?php echo isset($_POST['expence_to']) ? $_POST['expence_to'] : ''?>">
						</div>
						<div class="col-sm-3">
							<input type="text" id="expence_from" class="form-control date-picker" name="expence_from" value="<?php echo isset($_POST['expence_from']) ? $_POST['expence_from'] : ''?>">
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<h4 class="col-sm-2">ATM Search </h4>
						<div class="col-sm-3">
							<input type="text" id="atm_to" class="form-control date-picker" name="atm_to" value="<?php echo isset($_POST['atm_to']) ? $_POST['atm_to'] : ''?>">
						</div>
						<div class="col-sm-3">
							<input type="text" id="atm_from" class="form-control date-picker" name="atm_from" value="<?php echo isset($_POST['atm_from']) ? $_POST['atm_from'] : ''?>">
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<h4 class="col-sm-2">Bank Search </h4>
						<div class="col-sm-3">
							<input type="text" id="bank_to" class="form-control date-picker" name="bank_to" value="<?php echo isset($_POST['bank_to']) ? $_POST['bank_to'] : ''?>">
						</div>
						<div class="col-sm-3">
							<input type="text" id="bank_from" class="form-control date-picker" name="bank_from" value="<?php echo isset($_POST['bank_from']) ? $_POST['bank_from'] : ''?>">
						</div>
					</div>
					<div class="clearfix"></div><hr>
					<div class="form-group">
						<div class="col-sm-2"></div>
						<input type="submit" id="submit" class="col-sm-1 btn btn-success btn-squared" value="Search">
					</div>
				</form>
				<div class="clearfix"></div><hr>
				<!---Result-->
				<div class="col-xs-12">
					<div class="col-xs-3 pull-right">
						<input type="button" class="btn btn-success btn-squared" onclick="printDiv('print-report')" value="print" />
						<input type="button" class="btn btn-success btn-squared" id="totalInExcelBTN" value="Upload In Excel" />
					</div>
				</div>
				<div class="col-xm-12 print-report" id="print-report">
					<h4>To : <b><?php echo !empty($vehicle_to) ? $vehicle_to : '';?></b>
					From : <b><?php echo !empty($vehicle_from) ? $vehicle_from : '';?></b></h4>
				<h3>Cash Income</h3>
				<table class="table col-xm-12" width="100%">
					<thead>
					  <tr>
						<th>Amt.</th>
						<th>Custmer Name</th>
						<th>Status</th>
						<th>Receipt No</th>
						<th>Payment Type</th>
					  </tr>
					</thead>
					<tbody>
					<!----Cashier Report--->
					<?php if(!empty($cashier)){ ?>
					<?php foreach($cashier as $value){
						// Check Receipt no is multiple or not
						$main_customer_receipt = $db->getRows("SELECT * FROM `customer_payment` where `customer_detail_id`=?",array($value['customer_detail_id']));
						// Customer info
						$customer = $db->getRow("SELECT * FROM `customer_detail` where `customer_detail_id`=?",array($value['customer_detail_id']));
						// Product info
						$product = $db->getRow("SELECT * FROM `product` where `product_id`=?",array($customer['product_id']));
						$cashierTotal += $value['price'];
						if($product['sale']==1){
							$cashierStatus = "Sale";
						}else{
							if($product['status']==4){
								$cashierStatus = " Bill ";
							}else if($product['status']==3){
								$cashierStatus = " Gate ";
							}else if($product['status']==2){
								$cashierStatus = " Cash ";
							}else{
								$cashierStatus = " Not Sale ";
							}
						}
					?>
					<tr>
						<td><?php echo $value['price'];?></td>
						<td><?php echo $customer['name'];?></td>
						<td><?php echo $cashierStatus;?></td>
						<td><?php 
							echo str_pad($value['customer_detail_id'], 3, "0", STR_PAD_LEFT);
							if(count($main_customer_receipt)>1){
								echo "(sub-receipt-no ".$value['customer_payment_id'].")";
							}
						?></td>
						<td><?php echo $value['case_type'];?> (<?php echo date("Y-m-d",strtotime($value['created_at']));?>)</td>
					</tr>
					<?php } ?>
					<tr style="font-size: 18px;">
						<td><b><?php echo $cashierTotal;?></b></td>
						<td><b>Vehicle Cash Income</b></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
				<h3>Advance Booking Income</h3>
				<table class="table col-xm-12" width="100%">
					<tbody>
					<!----Advance Wise Amount Collect--->
					<?php if(!empty($advancePayment)){ ?>
					<?php foreach($advancePayment as $value){
						// Check Receipt no is multiple or not
						$main_advance_receipt = $db->getRows("SELECT * FROM `advance_payment` where `advance_id`=?",array($value['advance_id']));
						$advance = $db->getRow("SELECT * FROM `advance` where `refund`=? AND `advance_id`=?",array(0,$value['advance_id']));
						if(!empty($advance)){
						if($advance['status']==0){
							$advanceTotal += $value['price'];
						}
					?>
					<tr>
						<td><?php echo $value['price'];?></td>
						<td><?php echo $advance['name'];?></td>
						<td><?php echo date("Y-m-d",strtotime($value['created_at']));?></td>
						<!--<td><?php //echo $advance['status']==0 ? "Paid" : "Select";?></td>-->
						<td><?php 
							echo str_pad($value['advance_id'], 3, "0", STR_PAD_LEFT)."-AD";
							if(count($main_advance_receipt)>1){
								echo "(sub-receipt-no ".$value['advance_payment_id'].")";
							}
						?></td>
						<td><?php echo $value['case_type'];?></td>
					</tr>
					<?php } } ?>
					<tr style="font-size: 18px;">
						<td><b><?php echo $advanceTotal;?></b></td>
						<td><b>Advance Booking Cash Income</b></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
				<h3>Branch Income</h3>
				<table class="table col-xm-12" width="100%">
					<tbody>
					<!----Branch Wise Amount Collect--->
					<?php if(!empty($branch)){?>
					<?php foreach($branch as $value){
						// Fetch branch 
						if($value['branch_id']!=0){
							$getBranch = $db->getRow("SELECT * FROM `branch` where `branch_id`=?",array($value['branch_id']));
							$nameFull = $getBranch['name'];
						}else{
							$nameFull = "Main";
						}
						$nameFull .= " - ".$value['type'];
						$branchTotal += $value['amount'];
					?>
					<tr>
						<td><?php echo $value['amount'];?></td>
						<td><?php echo $nameFull;?></td>
						<td><?php echo date("Y-m-d",strtotime($value['created_at']));?></td>
						<td><?php echo str_pad($value['cashier_id'], 3, "0", STR_PAD_LEFT)."-O"?></td>
						<td><?php echo $value['cash_type'];?></td>
					</tr>
					<?php } ?>
					<tr style="font-size: 18px;">
						<td><b><?php echo $branchTotal;?></b></td>
						<td><b>Branch Cash Income</b></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
				<h3>Expence</h3>
				<table class="table col-xm-12" width="100%">
					<tbody>
					<!---- Expense Wise Amount Debit--->
					<?php if(!empty($expense)){ ?>
					<?php foreach($expense as $value){
						$expenseTotal += $value['amount'];
					?>
					<tr>
						<td><?php echo $value['amount'];?></td>
						<td><?php echo $value['purpose']." ".$value['person'];?></td>
						<td><?php echo date("Y-m-d",strtotime($value['created_at']));?></td>
						<td></td>
						<td></td>
					</tr>
					<?php } ?>
					<tr style="font-size: 18px;">
						<td><b><?php echo $expenseTotal;?></b></td>
						<td><b>Total Expence</b></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
				<h3>ATM</h3>
				<table class="table col-xm-12" width="100%">
					<tbody>
					<!----ATM Wise Amount debit--->
					<?php if(!empty($atm)){ ?>
					<?php foreach($atm as $value){
						$atmTotal += $value['amount'];
					?>
					<tr>
						<td><?php echo $value['amount'];?></td>
						<td><?php echo "Yesbank ATM ".$value['remark'];?></td>
						<td><?php echo date("Y-m-d",strtotime($value['created_at']));?></td>
						<td></td>
						<td></td>
					</tr>
					<?php } ?>
					<tr style="font-size: 18px;">
						<td><b><?php echo $atmTotal;?></b></td>
						<td><b>ATM Total</b></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
				<h3>Bank</h3>
				<table class="table col-xm-12" width="100%">
					<tbody>
					<!----Bank Wise Amount debit--->
					<?php if(!empty($bank)){ ?>
					<?php foreach($bank as $value){
						$bankTotal += $value['price'];
					?>
					<tr>
						<td><?php echo $value['price'];?></td>
						<td><?php echo $value['cash_type']." - ".$value['bank_name']." ".$value['cheque_no']." ".$value['cheque_date']." ".$value['dd_bank_name']." ".$value['dd_no']." ".$value['dd_date'];?></td>
						<td><?php echo date("Y-m-d",strtotime($value['created_at']));?></td>
						<td>-</td>
						<td><?php echo $value['remark'];?></td>
					</tr>
					<?php } ?>
					<tr style="font-size: 18px;">
						<td><b><?php echo $bankTotal;?></b></td>
						<td><b>Bank Total</b></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
				<h3>Cheque</h3>
				<!----Cheque Wise Amount Collect--->
				<table class="table col-xm-12" width="100%">
					<tbody>
				<?php if(!empty($cashierCheque)){ ?>
					<?php foreach($cashierCheque as $value){
						// Check Receipt no is multiple or not
						$main_customer_receipt = $db->getRows("SELECT * FROM `customer_payment` where `customer_detail_id`=?",array($value['customer_detail_id']));
						// Customer info
						$customer = $db->getRow("SELECT * FROM `customer_detail` where `customer_detail_id`=?",array($value['customer_detail_id']));
						// Product info
						$product = $db->getRow("SELECT * FROM `product` where `product_id`=?",array($customer['product_id']));
						$chequeTotal += $value['price'];
						if($product['sale']==1){
							$cashierStatus = "Sale";
						}else{
							if($product['status']==4){
								$cashierStatus = " Bill ";
							}else if($product['status']==3){
								$cashierStatus = " Gate ";
							}else if($product['status']==2){
								$cashierStatus = " Cash ";
							}else{
								$cashierStatus = " Not Sale ";
							}
						}
					?>
					<tr>
						<td><?php echo $value['price'];?></td>
						<td><?php 
							echo $customer['name'];
							if($value['case_type']=='Cheque'){
								echo ' ('.$value['cheque_no'].')';
							}else if($value['case_type']=='DD'){
								echo ' ('.$value['dd_no'].')';
							}
							?>
						</td>
						<td><?php echo $cashierStatus;?></td>
						<td><?php 
							echo str_pad($value['customer_detail_id'], 3, "0", STR_PAD_LEFT);
							if(count($main_customer_receipt)>1){
								echo "(sub-receipt-no ".$value['customer_payment_id'].")";
							}
						?></td>
						<td><?php echo $value['case_type'];?> (<?php echo date("Y-m-d",strtotime($value['created_at']));?>)</td>
					</tr>
					<?php } ?>
				<?php } ?>
				<!----Advance Cheque Wise Amount Collect--->
				<?php if(!empty($advancePaymentCheque)){ ?>
					<?php foreach($advancePaymentCheque as $value){
						// Check Receipt no is multiple or not
						$main_advance_receipt = $db->getRows("SELECT * FROM `advance_payment` where `advance_id`=?",array($value['advance_id']));
						$advance = $db->getRow("SELECT * FROM `advance` where `refund`=? AND `advance_id`=?",array(0,$value['advance_id']));
						if(!empty($advance)){
						if($advance['status']==0){
							$advanceChequeTotal += $value['price'];
						}
					?>
					<tr>
						<td><?php echo $value['price'];?></td>
						<td><?php 
							echo $advance['name'];
							if($value['case_type']=='Cheque'){
								echo ' ('.$value['cheque_no'].')';
							}else if($value['case_type']=='DD'){
								echo ' ('.$value['dd_no'].')';
							}
							?>
						</td>
						<td><?php echo $value['case_type'];?></td>
						<td><?php 
							echo str_pad($value['advance_id'], 3, "0", STR_PAD_LEFT)."-AD";
							if(count($main_advance_receipt)>1){
								echo "(sub-receipt-no ".$value['advance_payment_id'].")";
							}
						?></td>
						<td><?php echo $value['case_type'];?> (<?php echo date("Y-m-d",strtotime($value['created_at']));?>)</td>
					</tr>
					<?php } ?>
					<?php } ?>
				<?php } ?>
				<tr style="font-size: 18px;">
						<td><b><?php echo $chequeTotal+$advanceChequeTotal;?></b></td>
						<td><b>Total Cheque Income</b></td>
					</tr>
					</tbody>
				</table>
				<h3>Deleted Record</h3>
				<table class="table col-xm-12" width="100%">
					<tbody>
					<!----Bank Wise Amount debit--->
					<?php if(!empty($recordDelete)){ ?>
					<?php foreach($recordDelete as $value){ ?>
					<?php if($value['type']=="cashier" || $value['type']=="advance") {?>
					<tr>
						<td><?php echo $value['type'];?></td>
						<td><?php echo $value['name'];?></td>
						<td><?php echo date("Y-m-d h:i:s",strtotime($value['created_at']));?></td>
						<td><?php echo $value['number'];?></td>
						<td><?php echo $value['remark'];?></td>
					</tr>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					</tbody>
				</table>
				  <h4>Total Cash Income => <b><?php echo $branchTotal+$cashierTotal+$advanceTotal;?></b></h3>
				  <h4>Total Expence => <b><?php echo $expenseTotal;?></b></h3>
				  <h4>Total Cheque => <b><?php echo $chequeTotal+$advanceChequeTotal;?></b></h3>
				  <h4>Closing Balance => <b><?php echo $branchTotal+$cashierTotal+$advanceTotal-$expenseTotal;?></b></h3>
				</div>
			</div>
		</div>
	</div>
	<!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->
<style>
#print-report table tbody tr td{
	padding:2px 6px;
}
</style>
<?php include("include/footer.php");?>
<script src="<?php echo HomeURL;?>assets/js/jquery.table2excel.js"></script>
<script type="text/javascript">
// Upload in excel
$(function() {
	$("#totalInExcelBTN").click(function(){
		$("#print-report").table2excel({
			exclude: ".noExl",
			name: "End of the day Report",
			filename: "daily-total-"+"<?php echo date('d-m-Y h-i-s');?>",
			fileext: ".xls",
			exclude_img: true,
			exclude_links: true,
			exclude_inputs: true
		});		
	});
});
// html2canvas print docate
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}
// Search To And From Date
$("#vehicle_to, #vehicle_from, #branch_to, #branch_from, #expence_to, #expence_from, #atm_to, #atm_from, #bank_to, #bank_from, #advance_to, #advance_from").datepicker({
	format: "dd-mm-yyyy",
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
<style>
.product-loading {
    margin: 0 auto;
    text-align: center;
    width: 30px;
}
</style>