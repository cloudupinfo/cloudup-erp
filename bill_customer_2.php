<?php include_once('include/comman_session.php');
$table1 = "product";
$table2 = "customer_detail";

if(isset($_REQUEST['aid']) && !empty($_REQUEST['aid']))
{
	$id = $_REQUEST['aid'];
	$select = $db->getRow("SELECT * FROM `customer_detail` where `customer_detail_id`=?",array($id));
	
	if(!empty($select))
	{
		$product = $db->getRow("SELECT * FROM ".$table1." where `product_id`=?",array($select['product_id']));
		if(empty($product))
		{
			header('Location:billing.php');exit();
		}
	}else{
		header('Location:billing.php');exit();
	}
}else{
	header('Location:billing.php');exit();
}

include("include/header.php");
?>
<div class="main-container">
	<div class="main-content">
		<div class="container">
			<!-- start: PAGE CONTENT -->
			<div class="row">
				<div class="col-sm-12 customer-detail-barcode" id="customer-detail-barcode" style="width:750px;padding: 15px;font-weight: 900; background-color:#ffffff; font-family: sans-serif !important;">
					<label class="col-sm-12">Service On : </label>
					<div class="col-sm-6 customer-detail-barcode-left" style="padding-left: 0px; padding-top: 0px;">	
						<label class="col-sm-4"><b>Sold On: </b></label><label class="col-sm-8"><?php echo date("d-m-Y",strtotime($select['updated_at']))?></label>
						<div class="clearfix"></div>
						<label class="col-sm-4"><b>Service At: </b></label>
						<div class="clearfix"></div>
						<label class="col-sm-4"><b>Chs No: </b></label><label class="col-sm-8"><?php echo $product['chassis_no']?></label>
					</div>
					<div class="col-sm-6 customer-detail-barcode-right" style="padding-top: 0px; padding-left: 0px;">
						<label class="col-sm-5"><b>Dealer Code: </b></label><label class="col-sm-7"><?php echo "GJ040003"?> </label>
						<div class="clearfix"></div>
						<label class="col-sm-5"><b>Kms. </b></label>
						<div class="clearfix"></div>
					</div>
				</div>
				<div id="print-detail">
					<img class="dadadadddada" src="">
				</div>
			</div>
		</div>
	</div>
	<!-- end: PAGE -->
</div>
<!-- end: MAIN CONTAINER -->
<style>
body {
    background-color: #000000 !important;
    opacity: 0.05;
}
.navbar{
	display:none !important;
}
.footer{
	display:none !important;
}
.customer-detail-barcode label {
    font-size: 16px;
    font-weight: 900;
    padding-right: 0;
}
.customer-detail-barcode-left .col-sm-8{
    padding: 0;
}
.customer-detail-barcode-right .col-sm-7{
	padding: 0;
}

</style>
<?php include("include/footer.php");?>
<script src="assets/html2canvas.js"></script>
<script type="text/javascript">

$(document).ready(function(){
html2canvas([document.getElementById('customer-detail-barcode')], {
	onrendered: function(canvas) {
		var data = canvas.toDataURL('image/jpeg');
		$(".dadadadddada").attr("src",data);
		var printContents = document.getElementById('print-detail').innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
		window.close();
	/*
		$.ajax({
			type : "POST",
			url : "create_barcode_customer_detail.php",
			cache : false,
			data : {type : data,text : '<?php echo $product['chassis_no'];?>'},
			success : function(result) {
				//window.close();
			}
		});*/
	}
});
});
</script>