<?php include_once('include/comman_session.php');
include("include/header.php");

$table = "admin";
$table1 = "veihicle";
$today = "%".date("Y-m-d")."%";

$product = $db->getRow("SELECT * FROM `product` where `product_id`=?",array(2));
$customer = $db->getRow("SELECT * FROM `customer_detail` where `customer_detail_id`=?",array(2));
?>
<link rel="stylesheet" href="<?php echo HomeURL;?>assets/css/print.css">
<link rel="stylesheet" media="print" href="<?php echo HomeURL;?>assets/css/print.css">
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
			
			<div class="row">
				<div class="col-sm-12">
					<!-- start: TEXT FIELDS PANEL -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>
							Cash Invoice
							<div class="panel-tools">
								<a class="btn btn-xs btn-link" href=""><i class="fa fa-refresh"></i></a>
								<a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
							</div>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="invoice-main-div" id="invoice-main-div">
									<div class="invoice-main-header">
										<img src="images/cash-invoice-header.png">
									</div>
									<div class="invoice-main-inner-div">
										<div class="invoice-row">
											<span class="invoice-row-col" style="width: 48%;">
												<span class="invoice-row-title"> Sales Man Name: </span>
												<span class="invoice-row-text" style="width: 65%"> <?php echo $customer['sales_man']?> </span>
											</span>
											<span class="invoice-row-col" style="width: 25%;">
												<span class="invoice-row-title"> Receipt No: </span>
												<span class="invoice-row-text" style="width: 55%"> <?php echo $customer['customer_detail_id']?> </span>
											</span>
											<span class="invoice-row-col" style="width: 25%;">
												<span class="invoice-row-title"> Date: </span>
												<span class="invoice-row-text" style="width: 65%"> <?php echo $customer['created_at']?> </span>
											</span>
										</div>
										<div class="invoice-row">
											<span class="invoice-row-col" style="width: 98%;">
												<span class="invoice-row-title"> Received with thanks from Mr. / Ms. / M/s  </span>
												<span class="invoice-row-text" style="width: 60%;"> <?php echo $customer['name']?> </span>
											</span>
										</div>
										<div class="invoice-row">
											<span class="invoice-row-col" style="width: 65%;">
												<span class="invoice-row-title"> as Payment / Advance towards model  </span>
												<span class="invoice-row-text" style="width: 42%;"> <?php echo $product['model']?> </span>
											</span>
											<span class="invoice-row-col" style="width: 32%;">
												<span class="invoice-row-title"> Color  </span>
												<span class="invoice-row-text" style="width: 78%;"> <?php echo $product['color']?> </span>
											</span>
										</div>
										<div class="invoice-row">
											<span class="invoice-row-col" style="width: 98%;">
												<span class="invoice-row-title"> for vehicle / Accessories / Insurance / Registration. </span>
												<span class="invoice-row-text" style="width: 50%;"> <?php //echo $customer['color']?> </span>
											</span>
										</div>
										<div class="invoice-row">
											<span class="invoice-row-col" style="width: 98%;">
												<span class="invoice-row-title"> HPA / HYPO with </span>
												<span class="invoice-row-text" style="width: 82%;"> <?php echo $customer['case_type']?> </span>
											</span>
										</div>
										<div class="invoice-row">
											<span class="invoice-row-col" style="width: 98%;">
												<span class="invoice-row-title"> Amount in words </span>
												<span class="invoice-row-text" style="width: 82%;"> <?php echo $customer['amount_in_word']?> </span>
											</span>
										</div>
										<div class="invoice-row">
											<span class="invoice-row-col" style="width: 98%;">
												<span class="invoice-row-text" style="width: 98%;">  </span>
											</span>
										<div class="invoice-row">
											<span class="invoice-row-col" style="width: 40%;">
												<span class="invoice-row-title"> Cheque / DD / Cash / </span>
												<span class="invoice-row-text" style="width: 52%;"> <?php echo $customer['cheque_no']?> </span>
											</span>
											<span class="invoice-row-col" style="width: 28%;">
												<span class="invoice-row-title"> Dated </span>
												<span class="invoice-row-text" style="width: 78%;"> <?php echo $customer['cheque_date']?> </span>
											</span>
											<span class="invoice-row-col" style="width: 28%;">
												<span class="invoice-row-title"> Drawn on </span>
												<span class="invoice-row-text" style="width: 66%;"> <?php echo $customer['cheque_date']?> </span>
											</span>
										</div>
										<div class="invoice-row text-right">
											<span class="invoice-row-title-small"> For, XYZ Honda Pvt. Ltd. </span>
										</div>
										<div class="invoice-row">
											<div class="invoice-row-box" style="width: 25%;">
												<span class="invoice-row-box-title"> Rs. </span>
												<span class="invoice-row-box-text"> <?php echo $customer['price']?> /-</span>
											</div>
											<div class="invoice-row-box" style="width: 35%;">
												<span class="invoice-row-box-title"> Mo.: </span>
												<span class="invoice-row-box-text"> +91 <?php echo $customer['mobile']?> </span>
											</div>
										</div>
										<div class="invoice-row">
											<span class="invoice-row-col" style="width: 48%;">
												<span class="invoice-row-title-small"> * Subject to realisation of cheque. </span>
											</span>
											<span class="invoice-row-col text-right" style="width: 40%;">
												<span class="invoice-row-title"> Autorize Person </span>
											</span>
										</div>
									</div>
								</div>
								<div class="invoice-main-footer">
									<div class="invoice-row">
										<span class="invoice-row-title-small"> If Booking Wiil Be Cancelled In Any Curcumstances. The Money Will Be Refunded In Cheque From Within 15 Day's.<br>
										Cheque Cancellaction Cherge Will be Paid by User.</span>
									</div>
								</div>
							</div>
							<input type="button" onclick="printDiv('invoice-main-div')" value="print a div!" />
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
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
$(document).ready(function() {
	//Admin Click
	$(".button-click").click(function() {
		window.location.href = "admin_list.php";
	});
	// Veihicles Click
	$(".veihicle-click").click(function() {
		window.location.href = "veihicle_list.php";
	});
	// Showrrom All Veihicles Click
	$(".show-veihicle-all").click(function() {
		window.location.href = "product_list.php";
	});
	// Showrrom Today Veihicles Click
	$(".show-veihicle-today").click(function() {
		window.location.href = "product_list_today.php";
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