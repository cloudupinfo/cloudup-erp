<?php include_once('include/comman_session.php');
if(isset($_REQUEST['aid'])){
	$id = $_REQUEST['aid'];
}else{
	$id = "";
}
$table = "bank";
$select = $db->getRow("SELECT * FROM ".$table." where `bank_id`=?",array($id));
if($select){
	$type = "edit";
}else{
	$type = "add";
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
							Bank
						</li>
					</ol>
					<div class="page-header">
						<h3>Bank <small class="required-field">* asterisk mark will be compulsory</small></h3>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
				<form class="form-horizontal" method="post" action="model/bankManage.php" id="bank_add_frm" name="bank_add_frm" enctype="multipart/form-data">
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
					<input type="hidden" value="<?php echo !empty($select['bank_id']) ? $select['bank_id'] : '';?>" name="id">
					<input type="hidden" value="<?php echo $type;?>" name="type">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Payment Type <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<?php !empty($select['cash_type']) ? $paymentType = $select['cash_type'] : $paymentType="Cash";?>
								<input type="radio" class="case_by_case" name="cash_type" value="Cash" <?php echo $paymentType=="Cash" ? 'checked' : '';?>> By Cash &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<input type="radio" class="case_by_cheque" name="cash_type" value="Cheque" <?php echo $paymentType=="Cheque" ? 'checked' : '';?>> By Cheque &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<input type="radio" class="case_by_dd" name="cash_type" value="DD" <?php echo $paymentType=="DD" ? 'checked' : '';?>> Demand Draft
							</div>
						</div>
						<div class="by_case_cheque" style="<?php echo $paymentType=="Cheque" ? 'display:block' : 'display:none';?>;">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Bank Name
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="bank name" id="bank_name" class="form-control" name="bank_name" value="<?php echo !empty($select['bank_name']) ? $select['bank_name'] : '';?>">
										<span class="input-group-addon"> <i class="fa fa-university"></i> </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Cheque No
								</label>
								<div class="col-sm-7">
									<input type="text" placeholder="Cheque No" id="cheque_no" class="form-control" name="cheque_no" value="<?php echo !empty($select['cheque_no']) ? $select['cheque_no'] : '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Cheque Date
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="Cheque Date" id="cheque_date" class="form-control date-picker" name="cheque_date" value="<?php echo !empty($select['cheque_date']) ? date("d-m-Y",strtotime($select['cheque_date'])) : '' ?>">
										<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
									</div>
								</div>
							</div>
						</div>
						
						<div class="by_case_dd" style="<?php echo $paymentType=="DD" ? 'display:block' : 'display:none';?>;">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Bank Name <span class="required-field">*</span>
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="dd bank name" id="dd_bank_name" class="form-control" name="dd_bank_name" value="<?php echo !empty($select['dd_bank_name']) ? $select['dd_bank_name'] : '' ?>">
										<span class="input-group-addon"> <i class="fa fa-university"></i> </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									DD No
								</label>
								<div class="col-sm-7">
									<input type="text" placeholder="DD No" id="dd_no" class="form-control" name="dd_no" value="<?php echo !empty($select['dd_no']) ? $select['dd_no'] : '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									DD Date
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="DD Date" id="dd_date" class="form-control date-picker" name="dd_date" value="<?php echo !empty($select['dd_date']) ? date("d-m-Y",strtotime($select['dd_date'])) : '' ?>">
										<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Amount <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<div class="input-group">
									<input type="text" placeholder="Amount" id="price" class="form-control" name="price" value="<?php echo !empty($select['price']) ? $select['price'] : '';?>">
									<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Amount In Word 
							</label>
							<div class="col-sm-7">
								<input type="text" placeholder="Amount In Word" id="in_word" class="form-control" name="in_word" value="<?php echo !empty($select['in_word']) ? $select['in_word'] : '' ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Remark
							</label>
							<div class="col-sm-7">
								<textarea placeholder="Remark" id="remark" class="form-control" name="remark"><?php echo !empty($select['remark']) ? $select['remark'] : '' ?></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-9">
								<?php if($type=="add"){?>
								<input type="submit" class="btn btn-success btn-squared" value="Save">
								<?php }else{ ?>
								<input type="submit" class="btn btn-info btn-squared" value="Update">
								<?php }?>
								<a href="bank_list.php" class="btn btn-danger btn-squared">Cancel</a>
							</div>
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
// Payment Type Radio Button Click
$("input[name='cash_type']").change(function(){
	var cash_type = $(this).val();
	if(cash_type=="Cheque"){
		$(".by_case_cheque").show();
		$(".by_case_dd").hide();
	}else if(cash_type=="DD"){
		$(".by_case_dd").show();
		$(".by_case_cheque").hide();
	}else{
		$(".by_case_dd, .by_case_cheque").hide();
	}
});

// Cheque Date
$("#cheque_date, #dd_date").datepicker({
	format: "dd-mm-yyyy",
	//startDate: '1d',
	autoclose: true
});

// Amount Total to pending Amount
$("#price").keyup(function(){
	var price = $(this).val().length!=0 ? $(this).val() : 0;
	// word in amount
	$("#in_word").val(test_skill(price));
});

// Amount in word
function test_skill(junkVal) {
   // var junkVal=document.getElementById('rupees').value;
    var junkVal = junkVal;
    junkVal = Math.floor(junkVal);
    var obStr = new String(junkVal);
    numReversed = obStr.split("");
    actnumber=numReversed.reverse();

    if(Number(junkVal) >=0){
        //do nothing
    }
    else{
        alert('wrong Number cannot be converted');
        return false;
    }
    if(Number(junkVal)==0){
        //return obStr+''+'Rupees Zero Only';
        return obStr+''+'Rupees Zero Only';
        return false;
    }
    if(actnumber.length>9){
        alert('Oops!!!! the Number is too big to covertes');
        return false;
    }

    var iWords=["Zero", " One", " Two", " Three", " Four", " Five", " Six", " Seven", " Eight", " Nine"];
    var ePlace=['Ten', ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen', ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'];
    var tensPlace=['dummy', ' Ten', ' Twenty', ' Thirty', ' Forty', ' Fifty', ' Sixty', ' Seventy', ' Eighty', ' Ninety' ];

    var iWordsLength=numReversed.length;
    var totalWords="";
    var inWords=new Array();
    var finalWord="";
    j=0;
    for(i=0; i<iWordsLength; i++){
        switch(i)
        {
        case 0:
            if(actnumber[i]==0 || actnumber[i+1]==1 ) {
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            inWords[j]=inWords[j]+' Only';
            break;
        case 1:
            tens_complication();
            break;
        case 2:
            if(actnumber[i]==0) {
                inWords[j]='';
            }
            else if(actnumber[i-1]!=0 && actnumber[i-2]!=0) {
                inWords[j]=iWords[actnumber[i]]+' Hundred and';
            }
            else {
                inWords[j]=iWords[actnumber[i]]+' Hundred';
            }
            break;
        case 3:
            if(actnumber[i]==0 || actnumber[i+1]==1) {
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            if(actnumber[i+1] != 0 || actnumber[i] > 0){
                inWords[j]=inWords[j]+" Thousand";
            }
            break;
        case 4:
            tens_complication();
            break;
        case 5:
            if(actnumber[i]==0 || actnumber[i+1]==1) {
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            if(actnumber[i+1] != 0 || actnumber[i] > 0){
                inWords[j]=inWords[j]+" Lakh";
            }
            break;
        case 6:
            tens_complication();
            break;
        case 7:
            if(actnumber[i]==0 || actnumber[i+1]==1 ){
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            inWords[j]=inWords[j]+" Crore";
            break;
        case 8:
            tens_complication();
            break;
        default:
            break;
        }
        j++;
    }

    function tens_complication() {
        if(actnumber[i]==0) {
            inWords[j]='';
        }
        else if(actnumber[i]==1) {
            inWords[j]=ePlace[actnumber[i-1]];
        }
        else {
            inWords[j]=tensPlace[actnumber[i]];
        }
    }
    inWords.reverse();
    for(i=0; i<inWords.length; i++) {
        finalWord+=inWords[i];
    }
    //return obStr+'  '+finalWord;
    return finalWord;
}

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