<?php include_once('include/comman_session.php');
include("include/header.php");

$table = "product";
//$select = $db->numRow("SELECT * FROM ".$table." where `qr_imgPath`=?",array(0));
$select = $db->numRow("SELECT * FROM ".$table." where `barcode_imgPath`=?",array(0));
//$type = "qrcode";
$type = "barcode";
//$signleType = "single_qrcode";
$signleType = "single_barcode";
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
							Generate BarCode
						</li>
					</ol>
					<div class="page-header">
						<h1>Generate BarCode (Last Inserted / Single)</h1>
					</div>
					<div id="nestable-menu" class="pull-right">
						<a href="product.php" class="btn btn-primary btn-squared">Single Product Add</a>
						<a href="product_excel.php" class="btn btn-primary btn-squared">Add Excel File</a>
						<a href="product_pdi.php" class="btn btn-primary btn-squared">PDI Add</a>
						<a href="product_list_today.php" class="btn btn-primary btn-squared">Today Add Veihicle List</a>
						<a href="product_list.php" class="btn btn-primary btn-squared">Showroom Veihicle List</a>
					</div>
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
					<!--Barcode Click To download--->
					<?php if(isset($_SESSION['s_count'])){?>
					<div class="alert alert-success">
						<button class="close" data-dismiss="alert">
							X
						</button>
						<i class="fa fa-check-circle"></i>
						<strong>Well done!</strong> <?php echo $_SESSION['s_count'];?>
					</div>
					<?php unset($_SESSION['s_count']);
						}
					?>
					<?php if(isset($_SESSION['e_count'])){?>
						<div class="alert alert-danger">
							<button class="close" data-dismiss="alert">
								X
							</button>
							<i class="fa fa-times-circle"></i>
							<strong>Oh snap!</strong> <?php echo $_SESSION['e_count'];?>
						</div>
					<?php unset($_SESSION['e_count']);
						}
					?>
				</div>
				<div class="col-sm-12">
					<!-- start: TEXT FIELDS PANEL -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>
							Generate BarCode <?php echo $type;?>
							<div class="panel-tools">
								<a class="btn btn-xs btn-link" href=""><i class="fa fa-refresh"></i></a>
								<a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
							</div>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" method="post" action="model/productManage.php" id="product-add-frm" name="product-add-frm" enctype="multipart/form-data">
								<input type="hidden" value="<?php echo $id;?>" name="id">
								<input type="hidden" value="<?php echo $type;?>" name="type">
								
								<div class="form-group">
									<div class="col-sm-2"></div>
									<div class="col-sm-9">
										<h3><strong><?php echo $select;?></strong> <small>new product uploaded generate button to genetare BarCode</small></h3>
									</div>
								</div>
								<?php if(!empty($select)){?>
								<div class="form-group">
									<div class="col-sm-2"></div>
									<div class="col-sm-9">
										<input type="submit" id="product-submit" class="btn btn-success btn-squared" value="Generate BarCode">
									</div>
								</div>
								<?php }else{?>
									<div class="form-group">
										<div class="col-sm-2"></div>
										<div class="col-sm-9">
											<input class="btn btn-danger btn-squared" value="Generate BarCode">
										</div>
									</div>
								<?php } ?>
							</form>
						</div>
					</div>
					<!-- end: TEXT FIELDS PANEL -->
				</div>
			</div>
			<!-- start: PAGE CONTENT Single Qr Code Generated-->
			<div class="row">
				<div class="col-sm-12">
					<!-- start: TEXT FIELDS PANEL -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>
							Generate Single BarCode 
							<div class="panel-tools">
								<a class="btn btn-xs btn-link" href=""><i class="fa fa-refresh"></i></a>
								<a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
							</div>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" method="post" action="model/productManage.php" id="product-single-qrcode" name="product-single-qrcode" enctype="multipart/form-data">
								<input type="hidden" value="<?php echo $signleType;?>" name="type">
								<div class="form-group">
									<div class="col-sm-2"></div>
									<div class="col-sm-6">
										<h3>Enter Chassis No</h3>
										<input type="text" name="single_qrcode" id="single_qrcode" class="form-control">
										<img class="search_loading_img" src="loading.gif" height="45" width="45" style="display:none;">
										<div class="search_result"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-2"></div>
									<div class="col-sm-10">
										<input type="submit" id="single-product-submit" class="btn btn-success btn-squared" value="Generate BarCode">
									</div>
								</div>
							</form>
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
$(document).ready(function(){
	// Search Chassis No
	$("#single_qrcode").keypress(function() {
		var search = $(this).val();
		var type = "veihicle_status_search";
		if(search.length >= 4){
		$.ajax({
			url : "model/veihicleStatusManage.php",
			cache : false,
			data : {
				type : type, search : search
			},
			beforeSend: function() {
				$(".search_loading_img").show();
				$(".search_result").html();
			},
			type : "post",
			success : function(data) {
				$(".search_loading_img").hide();
				if (data) {
					$(".search_result").html(data);
					//$("#admin-add-frm").find("input,textarea").val("");
					//window.location.href = 'admin.php';
					//$("#admin-add-frm").trigger("reset");
					//loadmaincattable();
				}else{
					$(".search_result").html(data);
					//alert("Admin Allready Exists!");
					//$("#admin-add-frm").find("input,textarea").val("");
					//window.location.href = 'admin.php';
				}
			}
		});
		}
	});
});

$(function(){
    $(document).on('click','.veihicle_status_chassis_ul li', function(){
		var search = $(this).text();
		$("#single_qrcode").val(search);
		$(".search_result").html("");
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