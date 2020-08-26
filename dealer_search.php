<?php include_once('include/comman_session.php');
if(isset($_REQUEST['aid'])){
	$id = $_REQUEST['aid'];
}else{
	header('Location:dealer.php');
	exit();
}

$table = "product";
$table1 = "dealer";

$product = $db->getRow("SELECT * FROM ".$table." where `chassis_no`=?",array($id));
if(!empty($product['veihicle_id']) && ($product['veihicle_id']!=0)){
	
	$veihicle = $db->getRow("SELECT * FROM `veihicle` where `veihicle_id`=?",array($product['veihicle_id']));
	
	if(!empty($veihicle))
	{
		$select = $db->getRow("SELECT * FROM ".$table1." where `product_id`=?",array($product['product_id']));
	}else{
		$_SESSION['admin_error'] = "Please Select Model Contact Sub-Admin Or Admin...";
		header('Location:dealer.php');
		exit();
	}
}else{
	$_SESSION['admin_error'] = "Please Select Model Then Contact Sub-Admin Or Admin...";
	header('Location:dealer.php');
	exit();
}

include("include/header.php");
if($select){
	$type = "edit";
}else{
	$type = "add";
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
							Dealer
						</li>
					</ol>
					<div class="page-header">
						<h3>Veihicle Detail </h3>
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
						<div class="col-sm-4 product-view-title"><h4> No Plate Fitting. :</h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['no_plate_fitting']) ? $veihicle['no_plate_fitting'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Side Stand : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> 
						<?php echo !empty($veihicle['side_stand']) ? $veihicle['side_stand'] : 'No';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Foot Rest : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> 
						<?php echo !empty($veihicle['foot_rest']) ? $veihicle['foot_rest'] : 'No';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Leg Guard : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> 
						<?php echo !empty($veihicle['leg_guard']) ? $veihicle['leg_guard'] : 'No';?> </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Chrome Set : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> 
						<?php echo !empty($veihicle['chrome_set']) ? $veihicle['chrome_set'] : 'No';?> </h4></div>
					</div>
					<div class="product-view-right col-sm-6">
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
						<div class="col-sm-4 product-view-title"><h4> Total. : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['total']) ? $veihicle['total'] : '-';?>  </h4></div>
						<div class="col-sm-4 product-view-title"><h4> Remark : </h4></div>
						<div class="col-sm-8 product-view-data"><h4> <?php echo !empty($veihicle['remark']) ? nl2br($veihicle['remark']) : '-';?>  </h4></div>
					</div>
				</div>
				<?php } ?>
				
				<div class="col-sm-12">
					<div class="page-header">
						<h3>Chassis  <?php echo $type;?></h3>
					</div>
					<form class="form-horizontal" method="post" action="model/dealerManage.php" id="dealer_add_frm" name="dealer_add_frm" enctype="multipart/form-data">
						<input type="hidden" value="<?php echo $type;?>" name="type">
						<input type="hidden" value="<?php echo $select['dealer_id'];?>" name="id">
						<input type="hidden" value="<?php echo $product['product_id'];?>" name="product_id">
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Dealer Name <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<input type="text" placeholder="Customer Name" id="name" class="form-control" name="name" value="<?php echo !empty($select['name']) ? $select['name'] : ''?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Dealer Address
							</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" placeholder="Address " id="address" class="form-control" name="address" value="<?php echo !empty($select['address']) ? $select['address'] : ''?>">
									<span class="input-group-addon"> <i class="fa fa-map-marker"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Price <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" placeholder="Price" id="price" class="form-control" name="price" value="<?php echo !empty($select['price']) ? $select['price'] : $veihicle['price'];?>">
									<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Remark
							</label>
							<div class="col-sm-7">
								<textarea placeholder="Remark" id="remark" class="form-control" name="remark"><?php echo !empty($customer['remark']) ? $customer['remark'] : '' ?></textarea>
							</div>
						</div>
						
						<div class="form-group text-center">
							<div class="col-sm-12">
								<?php if($type=="add"){?>
									<input type="submit" class="btn btn-success btn-squared" value="Save">
								<?php }else{ ?>
									<input type="submit" class="btn btn-info btn-squared" value="Update">
								<?php }?>
								<a href="dealer_bill_list.php" class="btn btn-danger btn-squared">Cancel</a>
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