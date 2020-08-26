<?php include_once('include/comman_session.php');
include("include/header.php");

$table = "product";
$type = "upload_excel";
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
							Product
						</li>
					</ol>
					<div class="page-header">
						<h1>Excel File Upload extention(.csv)</h1>
					</div>
					<div id="nestable-menu" class="pull-right">
						<a href="product.php" class="btn btn-primary btn-squared">Single Product Add</a>
						<a href="generate_qrcode.php" class="btn btn-primary btn-squared">Generate QR Code</a>
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
					<!-- start: TEXT FIELDS PANEL -->
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>
							Product Upload CSV
							<div class="panel-tools">
								<a class="btn btn-xs btn-link" href=""><i class="fa fa-refresh"></i></a>
								<a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
							</div>
						</div>
						<div class="panel-body">
							<div class="alert alert-block alert-warning">
								<h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Warning!</h4>
								<h4>Only Excel File Uploaded file extention is (.csv) compalsary.</h4>
								<h4>Excel file heading will be following compalsary.</h4>
								1) Company Model Code | 2) Model | 3) Variant | 4) Company Color Code | 5) Color | 6) Chassis No 7) Engine No
							</div>
							<form class="form-horizontal" method="post" action="model/productManage.php" id="upload_csv-add-frm" name="upload_csv-add-frm" enctype="multipart/form-data">
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
								<input type="hidden" value="<?php echo $id;?>" name="id">
								<input type="hidden" value="<?php echo $type;?>" name="type">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-field-1">
										Select File
									</label>
									<div class="col-sm-5">
										<div class="fileupload fileupload-new" data-provides="fileupload">
											<div class="input-group">
												<div class="form-control uneditable-input">
													<i class="fa fa-file fileupload-exists"></i>
													<span class="fileupload-preview"></span>
												</div>
												<div class="input-group-btn">
													<div class="btn btn-light-grey btn-file">
														<span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Select .CSV file</span>
														<span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Change</span>
														<input type="file" name="image" class="file-input">
													</div>
													<a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
														<i class="fa fa-times"></i> Remove
													</a>
												</div>
											</div>
											<span class="label label-danger">upload Only ( .csv ) file</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-2"></div>
									<div class="col-sm-9">
										<input type="submit" id="product-submit" class="btn btn-success btn-squared" value="Upload">
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
$(document).ready(function() {
	// Product Single Image Delete
	$(document).on("click", ".product-image-delete-span", function(e) {
		if (confirm('Are you sure you want to delete image ?')){
			var id = $(this).attr("id");
			var currentThis = $(this);
			var type = "product_delete_img";
			$.ajax({
			  url : "model/productManage.php",
			  data : 'mid='+id+'&type='+type,
			  type : 'post',
			  beforeSend : function(){
			},
			  success : function(data) {
				  if(data == 1){
					$(currentThis).parent().addClass("no-display");
				  }else{
					alert("Delete in Problem...");  
				  }
			  },
			});
		}else {
			return false;
		}
	});
	
	$("#product-submi").click(function() {
		//form.validate();
		if(!$("#product-add-frm").valid()){
			return false;	
		}else{
			var form = document.getElementById("product-add-frm");
			formdata2 = new FormData(form);
			$.ajax({
				url : "model/productManage.php",
				cache : false,
				contentType : false,
				processData : false,
				data : formdata2,
				beforeSend: function() {
					$(".loading-div").removeClass('no-display');
					$(".loading-div").addClass('display');
				},
				type : "post",
				success : function(data) {
					$(".loading-div").removeClass('display');
					$(".loading-div").addClass('no-display');
					if (data == 1) {
						//alert("Product Successfully Added");
						//$("#product-add-frm")[0].reset();
						$("#product-add-frm").trigger("reset");
					} else if (data == 2) {
						alert("Product Allready Exists!");
					} else if (data == 0) {
						alert("Some Error Occured Please Try Again...");
					}else if (data == 11) {
						alert("Product Update Successfully");
						window.location.href = 'product_list.php';
					}
				}
			});
		}
	});
});
// Single Image Delete Code
$(document).on("click", ".image-delete-span", function(e) {
	if (confirm('Are you sure you want to delete image ?')){
		var imageName = $(this).parent().attr("data-name");
		$(".appned-image").append(imageName+",");
		var appendImage = $(".appned-image").html();
		$(".old_imgpath_delete").val(appendImage);
		$(this).parent().addClass("no-display");
	}else {
		return false;
	}
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