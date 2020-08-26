<?php include_once('include/comman_session.php');
if(isset($_REQUEST['aid'])){
	$id = $_REQUEST['aid'];
}else{
	header('Location:cashier.php');
	exit();
}

$table = "product";
$table1 = "veihicle";
$table2 = "customer_detail";
$table3 = "product_price";
$table4 = "customer_payment";

$product = $db->getRow("SELECT * FROM ".$table." where `chassis_no`=?",array($id));
$salesmans = $db->getRows("SELECT * FROM `salesman` where `status`=?",array(1));
if(!empty($product)){
	if(!empty($product['veihicle_id']) && ($product['veihicle_id']!=0)){
		$veihicle = $db->getRow("SELECT * FROM ".$table1." where `veihicle_id`=?",array($product['veihicle_id']));
	}else{
		$_SESSION['admin_error'] = "Please Select Model Then Casier add Detail Contact Sub-Admin Or Admin...";
		header('Location:cashier.php');
		exit();
	}
	// Check Branch or not
	$branch = $db->getRow("SELECT * FROM `branch` where `product_id`=?",array($product['product_id']));
	// Product Price
	$productPrice = $db->getRow("SELECT * FROM ".$table3." where `product_id`=?",array($product['product_id']));
	$customer = $db->getRow("SELECT * FROM ".$table2." where `product_id`=?",array($product['product_id']));
	if(!empty($customer)){
		$customerPayment = $db->getRows("SELECT * FROM ".$table4." where `customer_detail_id`=?",array($customer['customer_detail_id']));
		// Exchange
		$exchange = $db->getRow("SELECT * FROM `exchange` where `customer_detail_id`=?",array($customer['customer_detail_id']));
		if(!empty($exchange)){
			$exchange_open = "display:block";
		}else{
			$exchange_open = "display:none";
		}
		// Finance
		$finance = $db->getRow("SELECT * FROM `finance` where `product_id`=?",array($product['product_id']));
		if(!empty($finance)){
			$finance_open = "display:block";
		}else{
			$finance_open = "display:none";
		}
	}
}else{
	$_SESSION['admin_error'] = "Chassis No. Not Found Enter Properly...";
	header('Location:cashier.php');
	exit();
}
include("include/header.php");
if($customer){
	$type = "edit";
	$admin_id = $customer['admin_id'];
}else{
	$type = "add";
	$admin_id = $_SESSION['admin_id'];
	$exchange_open = "display:none";
	$finance_open = "display:none";
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
							Veihicle Price Edit
						</li>
					</ol>
					<div class="page-header">
						<h3>Veihicle Price Detail Edit </h3>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
				<form class="form-horizontal" method="post" action="model/cashierManage.php" id="product_price_edit_frm" name="product_price_edit_frm" enctype="multipart/form-data" target="_blank">
					<input type="hidden" value="product_price_detail_edit" name="type">
					<input type="hidden" value="<?php echo !empty($customer['customer_detail_id']) ? $customer['customer_detail_id'] : '0';?>" name="id">
					
					<div class="col-sm-12 product-view-main" >
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
						<div class="col-sm-12" style="border:1px solid #c8c7cc;">
							<div class="page-header">
								<h3>Veihicle Price Detail </h3>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Price : 
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" readonly placeholder="Price" id="vehical_price" class="form-control" name="vehical_price" value="<?php echo !empty($productPrice['price']) ? $productPrice['price'] : $veihicle['price']; ?>">
										<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									RTO Regestration:
								</label>
								<div class="col-sm-7">
								<?php $rtoArray = explode("/",$productPrice['rto']); 
									$rtoType = !empty($rtoArray[0]) ? $rtoArray[0] : 'single';
									$rtoPrice = !empty($rtoArray[1]) ? $rtoArray[1] : $veihicle['rto_single'];
								?>
									<select id="rto" class="form-control" name="rto">
										<option value="no" data-rtoprice="0" <?php echo $rtoType=='no' ? 'selected' : '';?>>No - 0</option>
										<option value="single" <?php echo $rtoType=='single' ? 'selected' : '';?> data-rtoprice="<?php echo $veihicle['rto_single'] ? $veihicle['rto_single'] : '0';?>">Single - <?php echo !empty($veihicle['rto_single']) ? $veihicle['rto_single'] : '0';?></option>
										<option value="double" <?php echo $rtoType=='double' ? 'selected' : '';?> data-rtoprice="<?php echo !empty($veihicle['rto_double']) ? $veihicle['rto_double'] : '0';?>">Double - <?php echo !empty($veihicle['rto_double']) ? $veihicle['rto_double'] : '0';?></option>
									</select>
									<input type="hidden" class="rtoPrice" value="<?php echo $rtoPrice; ?>" name="rtoPrice">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Accessories :
								</label>
								<div class="col-sm-7">
									<input type="checkbox" name="access_no" id="access_no" value="<?php echo $productPrice['access_no']=="no" ? 'no' : 'yes'?>" <?php echo $productPrice['access_no']=="no" ? 'checked' : '';?>> 
										<label class="control-label" for="access_no"> Accessories No </label><br>
									<input type="checkbox" name="side_stand" id="side_stand" value="<?php echo !empty($productPrice['side_stand']) ? $productPrice['side_stand'] : $veihicle['side_stand']?>" <?php echo !empty($productPrice['side_stand']) ? 'checked' : '';?>> 
										<label class="control-label" for="side_stand">Side Stand </label><br>
									<input type="checkbox" name="foot_rest" id="foot_rest" value="<?php echo !empty($productPrice['foot_rest']) ? $productPrice['foot_rest'] : $veihicle['foot_rest'] ?>" <?php echo !empty($productPrice['foot_rest']) ? 'checked' : '';?>> 
										<label class="control-label" for="foot_rest"> Foot Rest </label><br>
									<input type="checkbox" name="leg_guard" id="leg_guard" value="<?php echo !empty($productPrice['leg_guard']) ? $productPrice['leg_guard'] : $veihicle['leg_guard'] ?>" <?php echo !empty($productPrice['leg_guard']) ? 'checked' : '';?>> 
										<label class="control-label" for="leg_guard"> Leg Guard </label><br>
									<input type="checkbox" name="chrome_set" id="chrome_set" value="<?php echo !empty($productPrice['chrome_set']) ? $productPrice['chrome_set'] : $veihicle['chrome_set'] ?>" <?php echo !empty($productPrice['chrome_set']) ? 'checked' : '';?>> 
										<label class="control-label" for="chrome_set"> Chrome Set </label><br>
									
									<!-- Pending Accessories -->
									<input type="checkbox" name="access" id="access" value="<?php echo !empty($productPrice['access']) ? 'Yes' : 'No';?>" <?php echo (!empty($productPrice['access'])=="Yes") ? 'checked' : '';?>> <label class="control-label" for="access"> Accessories Pending </label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Smart No Plate Fitting Charge : 
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="Smart No Plate Fitting Charge" id="no_plate_fitting" class="form-control" name="no_plate_fitting" value="<?php echo !empty($productPrice['no_plate_fitting']) ? $productPrice['no_plate_fitting'] : $veihicle['no_plate_fitting'] ?>">
										<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									AMC :
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="AMC" id="amc" class="form-control" name="amc" value="<?php echo !empty($productPrice['amc']) ? $productPrice['amc'] : $veihicle['amc']; ?>">
										<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									RMC Veheicle Tax. : 
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="RMC Veheicle Tax." id="rmc_tax" class="form-control" name="rmc_tax" value="<?php echo !empty($productPrice['rmc_tax']) ? $productPrice['rmc_tax'] : $veihicle['rmc_tax'] ?>">
										<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Ex. Warranty. :
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="Ex. Warranty" id="ex_warranty" class="form-control" name="ex_warranty" value="<?php echo !empty($productPrice['ex_warranty']) ? $productPrice['ex_warranty'] : $veihicle['ex_warranty'] ?>">
										<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Insurance. : 
								</label>
								<div class="col-sm-7">
								<?php $insuArray = explode("/",$productPrice['insurance']); 
									$insuType = !empty($insuArray[0]) ? $insuArray[0] : '1';
									$insuPrice = !empty($insuArray[1]) ? $insuArray[1] : $veihicle['insurance'];
								?>
									<select id="insurance" class="form-control" name="insurance">
										<option <?php echo $insuType=='1' ? 'selected' : '';?> value="1" data-price="<?php echo !empty($veihicle['insurance']) ? $veihicle['insurance'] : '0';?>">1 Year - <?php echo !empty($veihicle['insurance']) ? $veihicle['insurance'] : '0';?></option>
										<option <?php echo $insuType=='2' ? 'selected' : '';?> value="2" data-price="<?php echo !empty($veihicle['2_year_insurance']) ? $veihicle['2_year_insurance'] : '0';?>">2 Year - <?php echo !empty($veihicle['2_year_insurance']) ? $veihicle['2_year_insurance'] : '0';?></option>
										<option <?php echo $insuType=='3' ? 'selected' : '';?> value="3" data-price="<?php echo !empty($veihicle['3_year_insurance']) ? $veihicle['3_year_insurance'] : '0';?>">3 Year - <?php echo !empty($veihicle['3_year_insurance']) ? $veihicle['3_year_insurance'] : '0';?></option>
									</select>
									<input type="hidden" class="insurancePrice" name="insurancePrice" value="<?php echo $insuPrice;?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Discount : 
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="Discount" id="discount" class="form-control" name="discount" value="<?php echo !empty($productPrice['discount']) ? $productPrice['discount'] : '0' ?>">
										<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Total. : 
								</label>
								<div class="col-sm-7">
									<h4 class="main-total"> <?php echo !empty($productPrice['total']) ? $productPrice['total'] : $veihicle['total'];?>  <i class="fa fa-rupee pull-right"></i></h4>
									<input type="hidden" id="main-total" class="main-total" name="main_total" value="<?php echo !empty($productPrice['total']) ? $productPrice['total'] : $veihicle['total'];?>">
								</div>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-2"></div>
						<div class="col-sm-9">
							<input type="submit" class="btn btn-info btn-squared" value="Update">
							<a onclick="window.close();" class="btn btn-danger btn-squared">Cancel</a>
						</div>
					</div>
				</form>
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
// Convert Amount In Word
$("#price").keypress(function(){
	$("#amount_in_word").val('<?php $db->convert_number_to_words("$('.amount').val()");?>');
});
// Exchange radio Button
$(".exchange").click(function(){
	var exchange = $(this).val();
	if(exchange=="Yes"){
		$(".exchange_open").show();
	}else{
		$(".exchange_open").hide();
	}
});
// Finance 
$(".finance").click(function(){
	var finance = $(this).val();
	if(finance=="Yes"){
		$(".finance_open").show();
	}else{
		$(".finance_open").hide();
	}
});
// Total
$("#rto").change(function(){
	var rtoPrice = $('option:selected', this).attr('data-rtoprice');
	$(".rtoPrice").val(rtoPrice);
	var total = priceTotal();
	$(".main-total").val(total);
	$(".main-total").text(total);
	$("#price").val(total);
});
// all checkbox
$("input[name=access_no]").click(function(){
	if($(this).is(":checked")==true){
		$("#side_stand").removeAttr("checked");
		$("#foot_rest").removeAttr("checked");
		$("#leg_guard").removeAttr("checked");
		$("#chrome_set").removeAttr("checked");
		$("#access").removeAttr("checked");
	}
	var total = priceTotal();
	$(".main-total").val(total);
	$(".main-total").text(total);
	$("#price").val(total);
});

// all checkbox
$("input[name=side_stand], input[name=foot_rest], input[name=leg_guard], input[name=chrome_set]").click(function(){
	// only one check box checked then no access in uncheck otherwise check
	if($("input[name=side_stand]").is(":checked")==true || $("input[name=foot_rest]").is(":checked")==true || $("input[name=leg_guard]").is(":checked")==true || $("input[name=chrome_set]").is(":checked")==true){
		//$("#access_no").removeAttr("checked");
		$("#access_no").prop('checked', false);
	}else if($("input[name=side_stand]").is(":checked")==false && $("input[name=foot_rest]").is(":checked")==false && $("input[name=leg_guard]").is(":checked")==false && $("input[name=chrome_set]").is(":checked")==false){
		$("#access_no").prop('checked', true);
	}
	var total = priceTotal();
	$(".main-total").val(total);
	$(".main-total").text(total);
	$("#price").val(total);
});
$("#insurance").change(function(){
	var insurancePrice = $('option:selected', this).attr('data-price');
	$(".insurancePrice").val(insurancePrice);
	var total = priceTotal();
	$(".main-total").val(total);
	$(".main-total").text(total);
	$("#price").val(total);
});
$(".product-view-main input").keyup(function(){
	var total = priceTotal();
	$(".main-total").val(total);
	$(".main-total").text(total);
	$("#price").val(total);
});

// Exchange Total
$("#exchange_amount").keyup(function(){
	var main_total = $("#main-total").val().length!=0 ? $("#main-total").val() : 0;
	var exchange_amount = $("#exchange_amount").val().length!=0 ? $("#exchange_amount").val() : 0;
	var dp_amount = $("#dp_amount").val().length!=0 ? $("#dp_amount").val() : 0;
	var total = parseInt(main_total)-parseInt(exchange_amount);
	$("#finance_amount").val(0);
	$("#price").val(total);
	$("#dp_amount").val(total);
	$("#pending").val(0);
});

// Deposit Amount Total
$("#dp_amount").keyup(function(){
	var main_total = $("#main-total").val().length!=0 ? $("#main-total").val() : 0;
	var dp_amount = $("#dp_amount").val().length!=0 ? $("#dp_amount").val() : 0;
	var exchange_amount = $("#exchange_amount").val().length!=0 ? $("#exchange_amount").val() : 0;
	$("#finance_amount").val(parseInt(main_total)-parseInt(dp_amount)-parseInt(exchange_amount));
	$("#price").val(dp_amount);
	$("#pending").val(0);
});
// Finance DP Amount Price Total
$("#finance_amount").keyup(function(){
	var main_total = $("#main-total").val().length!=0 ? $("#main-total").val() : 0;
	var exchange_amount = $("#exchange_amount").val().length!=0 ? $("#exchange_amount").val() : 0;
	var finance_amount = $("#finance_amount").val().length!=0 ? $("#finance_amount").val() : 0;
	var total = parseInt(main_total)-parseInt(exchange_amount)-parseInt(finance_amount);
	$("#dp_amount").val(total);
	$("#price").val(total);
	$("#pending").val(0);
});
// Amount Total to pending Amount
$("#price").keyup(function(){
	var price = $(this).val().length!=0 ? $(this).val() : 0;
	var main_total = $("#main-total").val().length!=0 ? $("#main-total").val() : 0;
	var exchange_amount = $("#exchange_amount").val().length!=0 ? $("#exchange_amount").val() : 0;
	var finance_amount = $("#finance_amount").val().length!=0 ? $("#finance_amount").val() : 0;
	var total = parseInt(main_total)-parseInt(price)-parseInt(exchange_amount)-parseInt(finance_amount);
	$("#dp_amount").val(price);
	$("#pending").val(total);
});
// Pending Amount to Price Amount
$("#pending").keyup(function(){
	var pending = $(this).val().length!=0 ? $(this).val() : 0;
	var main_total = $("#main-total").val().length!=0 ? $("#main-total").val() : 0;
	var exchange_amount = $("#exchange_amount").val().length!=0 ? $("#exchange_amount").val() : 0;
	var finance_amount = $("#finance_amount").val().length!=0 ? $("#finance_amount").val() : 0;
	var total = parseInt(main_total)-parseInt(pending)-parseInt(exchange_amount)-parseInt(finance_amount);
	$("#price").val(total);
	$("#dp_amount").val(total);
});

function priceTotal()
{
	var price = $("#vehical_price").val();
	var rtoPrice = $(".rtoPrice").val().length!=0 ? $(".rtoPrice").val() : 0;
	var side_stand = $("#side_stand").is(":checked")==true ? $("#side_stand").val() : 0;
	var foot_rest = $("#foot_rest").is(":checked")==true ? $("#foot_rest").val() : 0;
	var leg_guard = $("#leg_guard").is(":checked")==true? $("#leg_guard").val() : 0;
	var chrome_set = $("#chrome_set").is(":checked")==true ? $("#chrome_set").val() : 0;
	var noPlateFitting = $("#no_plate_fitting").val();
	var amc = $("#amc").val().length!=0 ? $("#amc").val() : 0;
	var rmc_tax = $("#rmc_tax").val();
	var ex_warranty = $("#ex_warranty").val().length!=0 ? $("#ex_warranty").val() : 0;
	var insurancePrice = $(".insurancePrice").val().length!=0 ? $(".insurancePrice").val() : 0;
	var discount = $("#discount").val().length!=0 ? $("#discount").val() : 0;
	
	var total = parseInt(price)+parseInt(rtoPrice)+parseInt(side_stand)+parseInt(foot_rest)+parseInt(leg_guard)+parseInt(chrome_set)+parseInt(noPlateFitting)+parseInt(amc)+parseInt(rmc_tax)+parseInt(ex_warranty)+parseInt(insurancePrice)-parseInt(discount);
	
	// Finance Amount/ DP Amount/ Exchange Amount to be '0'
	$("#finance_amount").val(0);
	$("#exchange_amount").val(0);
	$("#dp_amount").val(0);
	
	return total;
}

// Payment Type Radio Button Click
$("input[name~='case_type']").change(function(){
	var case_type = $(this).val();
	if(case_type=="Cheque"){
		$(".by_case_cheque").show();
		$(".by_case_dd").hide();
		$(".by_case_neft").hide();
	}else if(case_type=="DD"){
		$(".by_case_dd").show();
		$(".by_case_cheque").hide();
		$(".by_case_neft").hide();
	}else if(case_type=="NEFT"){
		$(".by_case_neft").show();
		$(".by_case_dd").hide();
		$(".by_case_cheque").hide();
	}else{
		$(".by_case_dd, .by_case_cheque, .by_case_neft").hide();
	}
});

// Cheque Date
$("#cheque_date, #dd_date").datepicker({
	format: "dd-mm-yyyy",
	startDate: '1d',
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