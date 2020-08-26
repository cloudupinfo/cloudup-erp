<?php include_once('include/comman_session.php');
if($_POST){
	$saleman = isset($_REQUEST['saleman']) ? $_REQUEST['saleman'] : '';
	$date_to = isset($_REQUEST['date_to']) ? date("Y-m-d",strtotime($_REQUEST['date_to'])) : '';
	$date_from = isset($_REQUEST['date_from']) ? date("Y-m-d",strtotime($_REQUEST['date_from'])) : '';
	if(!empty($saleman)){
		// saleman sale product
		$salemanProduct = $db->getRows("SELECT * FROM `customer_detail` where `salesman_id`=? AND `created_at` BETWEEN ? AND ? ORDER BY `created_at` DESC",array($saleman,$date_to,$date_from));
		$salesmanDetailFront = $db->getRow("SELECT * FROM `salesman` where `salesman_id`=?",array($saleman));		
	}
}
$atmTotal = 0;
$salesmans = $db->getRows("SELECT * FROM `salesman` ORDER BY `name` ASC",array());
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
					<div class="page-header">
						<h1>Incentive Report</h1>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
			<div class="col-sm-12">
				<form method="post" name="rp_atm" class="rp_atm" id="rp_atm">
					<div class="form-group">
						<h4 class="col-sm-1">Search </h4>
						<div class="col-sm-3">
							<select name="saleman" id="saleman" class="form-control">
								<option value="">Select Sales Man</option>
							<?php !empty($_POST['saleman']) ? $salesmanId=$_POST['saleman'] : $salesmanId="";
							foreach($salesmans as $salesman){?>
								<option value="<?php echo $salesman['salesman_id'];?>" <?php echo $salesmanId==$salesman['salesman_id'] ? 'selected' : '';?>><?php echo $salesman['name'];?></option>
							<?php } ?>
							</select>
						</div>
						<div class="col-sm-2">
							<input type="text" id="date_to" class="form-control date-picker" name="date_to" value="<?php echo isset($_POST['date_to']) ? $_POST['date_to'] : ''?>">
						</div>
						<div class="col-sm-2">
							<input type="text" id="date_from" class="form-control date-picker" name="date_from" value="<?php echo isset($_POST['date_from']) ? $_POST['date_from'] : ''?>">
						</div>
						<input type="submit" id="submit" class="col-sm-1 btn btn-success btn-squared" value="Search">&nbsp&nbsp&nbsp
						<a class="col-sm-1 pull-right btn btn-info btn-squared" href="">Clear</a>
					</div>
				</form>
				<div class="clearfix"></div>
				<hr>
				<!---Result-->
				<div class="col-xm-12">
					<div class="col-xm-3 pull-right">
						<input type="button" class="btn btn-success btn-squared" onclick="printDiv('print-report')" value="print" />
						<input type="button" class="btn btn-success btn-squared" id="incentiveInExcelBTN" value="Upload In Excel" />
					</div>
				</div>
				<div class="col-xm-12 print-report" id="print-report">
					<h4>Salesman Name : <b><?php echo !empty($salesmanDetailFront) ? $salesmanDetailFront['name'] : '';?></b>
					To : <b><?php echo !empty($date_to) ? $date_to : '';?></b>
					From : <b><?php echo !empty($date_from) ? $date_from : '';?></b></h4>
					<table id="incentiveInExcel" class="table col-xm-12" width="100%" border="1">
					<thead>
					  <tr>
						<th>SR No</th>
						<th>Sales Name</th>
						<th>Customer Name</th>
						<th>Mobile</th>
						<th>Model</th>
						<th>Amount</th>
						<th>Discount</th>
						<th>Case/Finance</th>
						<th>Insurance</th>
						<th>Accessories</th>
						<th>AMC</th>
						<th>Warranty</th>
						<th>Date/Time</th>
					  </tr>
					</thead>
					<tbody>
					<!----Cashier Report--->
					<?php if(!empty($salemanProduct)){ 
						$srID = 1;
					?>
					<?php foreach($salemanProduct as $value){
						$salemanDetail = $db->getRow("SELECT * FROM `salesman` where `salesman_id`=?",array($value['salesman_id']));
						$customerDetail = $db->getRow("SELECT * FROM `customer_detail` where `customer_detail_id`=?",array($value['customer_detail_id']));
						$productDetail = $db->getRow("SELECT * FROM `product` where `product_id`=?",array($value['product_id']));
						$productPriceDetail = $db->getRow("SELECT * FROM `product_price` where `product_id`=?",array($productDetail['product_id']));
						$modelDetail = $db->getRow("SELECT * FROM `veihicle` where `veihicle_id`=?",array($productDetail['veihicle_id']));
						$financeDetail = $db->getRow("SELECT * FROM `finance` where `finance_id`=?",array($productDetail['product_id']));
						
						$accessories[] = !empty($productPriceDetail['side_stand']) ? 'Side Stand-Yes' : 'Side Stand-No';
						$accessories[] = !empty($productPriceDetail['foot_rest']) ? 'Foot Rest-Yes' : 'Foot Rest-No';
						$accessories[] = !empty($productPriceDetail['leg_guard']) ? 'Leg Guard-Yes' : 'Leg Guard-No';
						$accessories[] = !empty($productPriceDetail['chrome_set']) ? 'Chrome Set-Yes' : 'Chrome Set-No';
					?>
					<tr>
						<td><?php echo $srID;?></td>
						<td><?php echo $salemanDetail['name'];?></td>
						<td><?php echo $customerDetail['name'];?></td>
						<td><?php echo $customerDetail['mobile'];?></td>
						<td><?php echo $modelDetail['name'];?></td>
						<td><?php echo $productPriceDetail['total'];?></td>
						<td><?php echo $productPriceDetail['discount'];?></td>
						<td><?php echo !empty($financeDetail) ? "Finance" : "Case";?></td>
						<td><?php echo $productPriceDetail['insurance'];?></td>
						<td><?php echo !empty($accessories) ? implode(", ",$accessories) : 'No-Accessories';?></td>
						<td><?php if(empty($productPriceDetail['amc']) || $productPriceDetail['amc']==0){ echo 'No';}else{ echo 'Yes';}?></td>
						<td><?php if(empty($productPriceDetail['ex_warranty']) || $productPriceDetail['ex_warranty']==0){ echo 'No';}else{ echo 'Yes';}?></td>
						<td><?php echo date("d-m-Y h:i A",strtotime($customerDetail['created_at']));?></td>
					</tr>
					<?php $srID++; $accessories = array();} ?>
					<?php } ?>
					</tbody>
				  </table>
				</div>
			</div>
			</div>
		</div>
	</div>
	<!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->
<style>
@media print{
#print-report table td{
	padding:2px 6px !important;
	//font-size:8px;
}
}
#print-report table td{
	padding:2px 6px;
}
</style>
<?php include("include/footer.php");?>
<script src="<?php echo HomeURL;?>assets/js/jquery.table2excel.js"></script>
<script type="text/javascript">
// Upload in excel
$(function() {
	$("#incentiveInExcelBTN").click(function(){
		$("#incentiveInExcel").table2excel({
			exclude: ".noExl",
			name: "Incentive Report",
			filename: "incentive-"+"<?php echo date('d-m-Y h-i-s');?>",
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
$("#date_to, #date_from").datepicker({
	format: "dd-mm-yyyy",
	autoclose: true
});

</script>
<style>
.product-loading {
    margin: 0 auto;
    text-align: center;
    width: 30px;
}
</style>