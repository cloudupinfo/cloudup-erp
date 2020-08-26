<?php include_once('include/comman_session.php');
if($_POST){
	$date_to = isset($_REQUEST['date_to']) ? date("Y-m-d",strtotime($_REQUEST['date_to'])) : '';
	$date_from = isset($_REQUEST['date_from']) ? date("Y-m-d",strtotime($_REQUEST['date_from'])) : '';
		
	// Expense Collect Stock
	$expense = $db->getRows("SELECT * FROM `expense` where `created_at` BETWEEN ? AND ? ORDER BY `created_at` DESC",array($date_to,$date_from));
}
$expenseTotal = 0;
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
						<h1>Expense Report</h1>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
				<div class="col-sm-12">
				<form method="post" name="rp_expense" class="rp_expense" id="rp_expense">
					<div class="form-group">
						<h4 class="col-sm-1">Search </h4>
						<div class="col-sm-3">
							<input type="text" id="date_to" class="form-control date-picker" name="date_to" value="<?php echo isset($_POST['date_to']) ? $_POST['date_to'] : ''?>">
						</div>
						<div class="col-sm-3">
							<input type="text" id="date_from" class="form-control date-picker" name="date_from" value="<?php echo isset($_POST['date_from']) ? $_POST['date_from'] : ''?>">
						</div>
						<input type="submit" id="submit" class="col-sm-1 btn btn-success btn-squared" value="Search">&nbsp&nbsp&nbsp
						<a class="col-sm-1 pull-right btn btn-info btn-squared" href="">Clear</a>
					</div>
				<div class="clearfix"></div>
				<hr>
				</form>
				<!---Result-->
				<div class="col-xs-12">
					<div class="col-xs-1 pull-right">
						<input type="button" class="btn btn-success btn-squared" onclick="printDiv('print-report')" value="print" />
					</div>
				</div>
				<div class="col-xm-12 print-report" id="print-report">
					<h4>To : <b><?php echo !empty($date_to) ? $date_to : '';?></b>
					From : <b><?php echo !empty($date_from) ? $date_from : '';?></b></h4>
					<table class="table col-xm-12" width="100%">
					<thead>
					  <tr>
						<th>Total</th>
						<th>Person</th>
						<th>Purpose</th>
						<th>Date/Time</th>
					  </tr>
					</thead>
					<tbody>
					<!----Cashier Report--->
					<?php if(!empty($expense)){ ?>
					<?php foreach($expense as $value){
						$expenseTotal += $value['amount'];
					?>
					<tr>
						<td><?php echo $value['amount'];?></td>
						<td><?php echo $value['person'];?></td>
						<td><?php echo $value['purpose'];?></td>
						<td><?php echo date("d-m-Y h:i A",strtotime($value['created_at']));?></td>
					</tr>
					<?php } ?>
					<?php } ?>
					</tbody>
				  </table>
				  <h3>Total Cash <?php echo $expenseTotal;?></h3>
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
}
}
#print-report table td{
	padding:2px 6px;
}
</style>
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
// Search To And From Date
$("#date_to, #date_from").datepicker({
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