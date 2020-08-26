<?php include_once('include/comman_session.php');
if($_POST){
	$product_to = isset($_REQUEST['product_to']) ? date("Y-m-d",strtotime($_REQUEST['product_to'])) : '';
	$product_from = isset($_REQUEST['product_from']) ? date("Y-m-d",strtotime($_REQUEST['product_from'])) : '';
		
	// Product Collect Vehicle Stock
	$product = $db->getRows("SELECT * FROM `product` where `created_at` BETWEEN ? AND ?",array($product_to,$product_from));
	$cont = 0;
	$notSale = $cash = $gatePass = $bill = 0;
	if(!empty($product))
	{	
		foreach($product as $value){
			$modelName[strtoupper($value['model'])][strtoupper($value['color'])][] = $value['status'];
		}
		
		foreach($modelName as $key=>$value)
		{
			foreach($value as $key1=>$value1)
			{
				$totalCount = $inshowroom = $cash = $gatepass = $sale = 0;
				foreach($value1 as $key2=>$value2)
				{
					if($value2=="1"){
						$inshowroom++;
					}else if($value2=="2"){
						$cash++;
					}else if($value2=="3"){
						$gatepass++;
					}else{
						$sale++;
					}
				$totalCount++;
				}
				$modelCount[$key][$key1]['total'] = $totalCount;
				$modelCount[$key][$key1]['inshowroom'] = $inshowroom;
				$modelCount[$key][$key1]['cash'] = $cash;
				$modelCount[$key][$key1]['gatepass'] = $gatepass;
				$modelCount[$key][$key1]['sale'] = $sale;
			}
		}
	}else{
		$modelCount = $modelName = array();
	}
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
				<form method="post" name="rp_stock" class="rp_stock" id="rp_stock">
					<div class="form-group">
						<h4 class="col-sm-2">Stock Search </h4>
						<div class="col-sm-3">
							<input type="text" id="product_to" class="form-control date-picker" name="product_to" value="<?php echo isset($_POST['product_to']) ? $_POST['product_to'] : ''?>">
						</div>
						<div class="col-sm-3">
							<input type="text" id="product_from" class="form-control date-picker" name="product_from" value="<?php echo isset($_POST['product_from']) ? $_POST['product_from'] : ''?>">
						</div>
					</div>
					<div class="clearfix"></div>
					<hr>
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
						<input type="button" class="btn btn-success btn-squared" id="stockInExcelBTN" value="Upload In Excel" />
					</div>
				</div>
				<div class="col-xm-12 print-report" id="print-report">
					<h4>To : <b><?php echo !empty($product_to) ? $product_to : '';?></b>
					From : <b><?php echo !empty($product_from) ? $product_from : '';?></b></h4>
					<table id="stockInExcel" class="table col-xm-12" width="100%" border="1">
					<thead>
					  <tr>
						<th>Model Name</th>
						<th>Total</th>
						<th>In Stock</th>
						<th>Cash</th>
						<th>Gatepass</th>
						<th>Sale</th>
					  </tr>
					</thead>
					<tbody>
					<!----Cashier Report--->
					<?php if(!empty($modelCount)){ 
					$totalCount = $inshowroom = $cash = $gatepass = $sale = 0;
					?>
					<?php foreach($modelCount as $key=>$value){?>
					<?php foreach($value as $key1=>$value1){?>
					<tr>
						<td><b><?php echo $key?></b> => <?php echo $key1?></td>
						<td><?php echo $value1['total']; $totalCount += $value1['total'];?></td>
						<td><?php echo $value1['inshowroom']; $inshowroom += $value1['inshowroom'];?></td>
						<td><?php echo $value1['cash']; $cash += $value1['cash'];?></td>
						<td><?php echo $value1['gatepass']; $gatepass += $value1['gatepass'];?></td>
						<td><?php echo $value1['sale']; $sale += $value1['sale'];?></td>
					</tr>
					<?php } ?>
					<?php } ?>
					<tr style="font-size:22px;">
						<td>Total Stock</td>
						<td><?php echo $totalCount;?></td>
						<td><?php echo $inshowroom;?></td>
						<td><?php echo $cash;?></td>
						<td><?php echo $gatepass;?></td>
						<td><?php echo $sale;?></td>
					</tr>
					<?php } ?>
					</tbody>
				  </table>
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
	$("#stockInExcelBTN").click(function(){
		$("#stockInExcel").table2excel({
			exclude: ".noExl",
			name: "Stock Report",
			filename: "stock-"+"<?php echo date('d-m-Y h-i-s');?>",
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
$("#product_to, #product_from").datepicker({
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