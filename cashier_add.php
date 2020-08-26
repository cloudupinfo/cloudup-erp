<?php include_once('include/comman_session.php');
if(isset($_REQUEST['aid'])){
	$id = $_REQUEST['aid'];
}else{
	$id = "";
}
$table = "cashier";
$cashierPayment = $db->getRow("SELECT * FROM ".$table." where `cashier_id`=?",array($id));
if($cashierPayment){
	$type = "cashier_edit";
	if($cashierPayment['type']=="exchange"){ 
		$exchange_type = "display:block";
	}else{
		$exchange_type = "display:none";
	}
}else{
	$type = "cashier_add";
	$exchange_type = "display:none";
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
							Cashier
						</li>
					</ol>
					<div class="page-header">
						<h3>Cashier <small class="required-field">* asterisk mark will be compulsory</small></h3>
					</div>
					<!-- end: PAGE TITLE & BREADCRUMB -->
				</div>
			</div>
			<!-- end: PAGE HEADER -->
			<!-- start: PAGE CONTENT -->
			<div class="row">
				<form target="_blank" class="form-horizontal" method="post" action="model/cashierManage.php" id="cashier_extra_add_frm" name="cashier_extra_add_frm" enctype="multipart/form-data">
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
					<input type="hidden" value="<?php echo !empty($cashierPayment['cashier_id']) ? $cashierPayment['cashier_id'] : '';?>" name="id">
					<input type="hidden" value="<?php echo $type;?>" name="type">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Branch <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<select class="form-control" name="branch" id="branch">
									<option value="0"> Main </option>
								<?php
									$getBranch = $db->getRows("SELECT * FROM `branch` where `status`=?",array(1));
									foreach ($getBranch as $value) {
								?>
									<option value="<?php echo $value['branch_id']; ?>" <?php if($value['branch_id']==$cashierPayment['branch_id']){echo "selected";}?>><?php echo $value['name']; ?></option>
								<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Type <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<select class="form-control" name="payment_type" id="payment_type">
									<option value="">Select Type</option>
									<option value="exchange" <?php echo $cashierPayment['type']=="exchange" ? "selected" : "";?>>Exchange</option>
									<option value="finance" <?php echo $cashierPayment['type']=="finance" ? "selected" : "";?>>Finance</option>
									<option value="other" <?php echo $cashierPayment['type']=="other" ? "selected" : "";?>>Other</option>
								</select>
							</div>
						</div>
						<?php if($cashierPayment['type']=="exchange")
							$product = $db->getRow("SELECT `chassis_no` FROM `product` where `product_id`=?",array($cashierPayment['product_id']));
						?>
						<div class="exchange_open" style="<?php echo $exchange_type;?>">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Chassis No <span class="required-field">*</span>
								</label>
								<div class="col-sm-7">
									<input type="text" placeholder="Chassis No" id="chassis_no" class="form-control" name="chassis_no" value="<?php echo !empty($product) ? $product['chassis_no']: '';?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Payment Type <span class="required-field">*</span>
							</label>
							<div class="col-sm-7">
								<?php !empty($cashierPayment['cash_type']) ? $paymentType = $cashierPayment['cash_type'] : $paymentType="Cash";?>
								<input type="radio" class="case_by_case" name="cash_type" value="Cash" <?php echo $paymentType=="Cash" ? 'checked' : '';?>> By Cash &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<input type="radio" class="case_by_cheque" name="cash_type" value="Cheque" <?php echo $paymentType=="Cheque" ? 'checked' : '';?>> By Cheque &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<input type="radio" class="case_by_dd" name="cash_type" value="DD" <?php echo $paymentType=="DD" ? 'checked' : '';?>> Demand Draft &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<input type="radio" class="case_by_neft" name="cash_type" value="NEFT" <?php echo $paymentType=="NEFT" ? 'checked' : '';?>> NEFT / RTGS
							</div>
						</div>
						<div class="by_case_cheque" style="<?php echo $paymentType=="Cheque" ? 'display:block' : 'display:none';?>;">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Bank Name
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="bank name" id="bank_name" class="form-control" name="bank_name" value="">
										
										<?php //!empty($cashierPayment['bank_name']) ? $bankName = $cashierPayment['bank_name'] : $bankName="";?>
										<!--
										<select id="bank_name" name="bank_name" class="form-control">
											<option value="" >--Select Bank Name --</option>
											<option value="ABHYUDAYA COOPERATIVE BANK LTD" <?php echo $bankName=="ABHYUDAYA COOPERATIVE BANK LTD" ? 'selected' : ''?>>ABHYUDAYA COOPERATIVE BANK LTD</option>
											<option value="ABU DHABI COMMERCIAL BANK" <?php echo $bankName=="ABU DHABI COMMERCIAL BANK" ? 'selected' : ''?>>ABU DHABI COMMERCIAL BANK</option>
											<option value="ALLAHABAD BANK" <?php echo $bankName=="ALLAHABAD BANK" ? 'selected' : ''?>>ALLAHABAD BANK</option>
											<option value="ALMORA URBAN CO.OPERATIVE BANK LTD." <?php echo $bankName=="ALMORA URBAN CO.OPERATIVE BANK LTD." ? 'selected' : ''?>>ALMORA URBAN CO.OPERATIVE BANK LTD.</option>
											<option value="ANDHRA BANK" <?php echo $bankName=="ANDHRA BANK" ? 'selected' : ''?>>ANDHRA BANK</option>
											<option value="APNA SAHAKARI BANK LTD" <?php echo $bankName=="APNA SAHAKARI BANK LTD" ? 'selected' : ''?>>APNA SAHAKARI BANK LTD</option>
											<option value="AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED." <?php echo $bankName=="AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED." ? 'selected' : ''?>>AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED.</option>
											<option value="AXIS BANK" <?php echo $bankName=="AXIS BANK" ? 'selected' : ''?>>AXIS BANK</option>
											<option value="BANK OF AMERICA" <?php echo $bankName=="BANK OF AMERICA" ? 'selected' : ''?>>BANK OF AMERICA</option>
											<option value="BANK OF BAHRAIN AND KUWAIT" <?php echo $bankName=="BANK OF BAHRAIN AND KUWAIT" ? 'selected' : ''?>>BANK OF BAHRAIN AND KUWAIT</option>
											<option value="BANK OF BARODA" <?php echo $bankName=="BANK OF BARODA" ? 'selected' : ''?>>BANK OF BARODA</option>
											<option value="BANK OF CEYLON" <?php echo $bankName=="BANK OF CEYLON" ? 'selected' : ''?>>BANK OF CEYLON</option>
											<option value="BANK OF INDIA" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>BANK OF INDIA</option>
											<option value="BANK OF MAHARASHTRA" <?php echo $bankName=="BANK OF MAHARASHTRA" ? 'selected' : ''?>>BANK OF MAHARASHTRA</option>
											<option value="BANK OF TOKYO MITSUBISHI UFJ LTD." <?php echo $bankName=="BANK OF TOKYO MITSUBISHI UFJ LTD." ? 'selected' : ''?>>BANK OF TOKYO MITSUBISHI UFJ LTD.</option>
											<option value="BARCLAYS BANK PLC" <?php echo $bankName=="BARCLAYS BANK PLC" ? 'selected' : ''?>>BARCLAYS BANK PLC</option>
											<option value="BASSEIN CATHOLIC CO OP BANK LTD" <?php echo $bankName=="BASSEIN CATHOLIC CO OP BANK LTD" ? 'selected' : ''?>>BASSEIN CATHOLIC CO OP BANK LTD</option>
											<option value="BNP PARIBAS" <?php echo $bankName=="BNP PARIBAS" ? 'selected' : ''?>>BNP PARIBAS</option>
											<option value="CANARA BANK" <?php echo $bankName=="CANARA BANK" ? 'selected' : ''?>>CANARA BANK</option>
											<option value="CAPITAL LOCAL AREA BANK LTD." <?php echo $bankName=="CAPITAL LOCAL AREA BANK LTD." ? 'selected' : ''?>>CAPITAL LOCAL AREA BANK LTD.</option>
											<option value="CATHOLIC SYRIAN BANK LTD" <?php echo $bankName=="CATHOLIC SYRIAN BANK LTD" ? 'selected' : ''?>>CATHOLIC SYRIAN BANK LTD</option>
											<option value="CENTRAL BANK OF INDIA" <?php echo $bankName=="CENTRAL BANK OF INDIA" ? 'selected' : ''?>>CENTRAL BANK OF INDIA</option>
											<option value="CHINATRUST COMMERCIAL BANK" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>CHINATRUST COMMERCIAL BANK</option>
											<option value="CITIBANK NA" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>CITIBANK NA</option>
											<option value="CITIZENCREDIT CO.OPERATIVE BANK LTD" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>CITIZENCREDIT CO.OPERATIVE BANK LTD</option>
											<option value="CITY UNION BANK LTD" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>CITY UNION BANK LTD</option>
											<option value="COMMONWEALTH BANK OF AUSTRALIA" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>COMMONWEALTH BANK OF AUSTRALIA</option>
											<option value="CORPORATION BANK" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>CORPORATION BANK</option>
											<option value="CREDIT AGRICOLE CORPORATE AND INVESTEMENT BANK" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>CREDIT AGRICOLE CORPORATE AND INVESTEMENT BANK</option>
											<option value="CREDIT SUISSE AG" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>CREDIT SUISSE AG</option>
											<option value="DBS BANK LTD" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>DBS BANK LTD</option>
											<option value="DENA BANK" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>DENA BANK</option>
											<option value="DEUTSCHE BANK" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>DEUTSCHE BANK</option>
											<option value="DEVELOPMENT CREDIT BANK LIMITED" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>DEVELOPMENT CREDIT BANK LIMITED</option>
											<option value="DHANLAXMI BANK LTD" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>DHANLAXMI BANK LTD</option>
											<option value="DICGC" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>DICGC</option>
											<option value="DOMBIVLI NAGARI SAHAKARI BANK LIMITED" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>DOMBIVLI NAGARI SAHAKARI BANK LIMITED</option>
											<option value="FIRSTRAND BANK LIMITED" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>FIRSTRAND BANK LIMITED</option>
											<option value="GURGAON GRAMIN BANK" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>GURGAON GRAMIN BANK</option>
											<option value="HDFC BANK LTD" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>HDFC BANK LTD</option>
											<option value="HSBC" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>HSBC</option>
											<option value="ICICI BANK LTD" <?php echo $bankName=="ICICI BANK LTD" ? 'selected' : ''?>>ICICI BANK LTD</option>
											<option value="IDBI BANK LTD" <?php echo $bankName=="IDBI BANK LTD" ? 'selected' : ''?>>IDBI BANK LTD</option>
											<option value="INDIAN BANK" <?php echo $bankName=="INDIAN BANK" ? 'selected' : ''?>>INDIAN BANK</option>
											<option value="INDIAN OVERSEAS BANK" <?php echo $bankName=="INDIAN OVERSEAS BANK" ? 'selected' : ''?>>INDIAN OVERSEAS BANK</option>
											<option value="INDUSIND BANK LTD" <?php echo $bankName=="INDUSIND BANK LTD" ? 'selected' : ''?>>INDUSIND BANK LTD</option>
											<option value="ING VYSYA BANK LTD" <?php echo $bankName=="ING VYSYA BANK LTD" ? 'selected' : ''?>>ING VYSYA BANK LTD</option>
											<option value="JALGAON JANATA SAHKARI BANK LTD" <?php echo $bankName=="JALGAON JANATA SAHKARI BANK LTD" ? 'selected' : ''?>>JALGAON JANATA SAHKARI BANK LTD</option>
											<option value="JANAKALYAN SAHAKARI BANK LTD" <?php echo $bankName=="JANAKALYAN SAHAKARI BANK LTD" ? 'selected' : ''?>>JANAKALYAN SAHAKARI BANK LTD</option>
											<option value="JANATA SAHAKARI BANK LTD (PUNE )" <?php echo $bankName=="JANATA SAHAKARI BANK LTD (PUNE )" ? 'selected' : ''?>>JANATA SAHAKARI BANK LTD (PUNE )</option>
											<option value="JP MORGAN CHASE BANK" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>JP MORGAN CHASE BANK</option>
											<option value="KALLAPPANNA AWADE ICH JANATA S BANK" <?php echo $bankName=="KALLAPPANNA AWADE ICH JANATA S BANK" ? 'selected' : ''?>>KALLAPPANNA AWADE ICH JANATA S BANK</option>
											<option value="KAPOLE CO OP BANK" <?php echo $bankName=="KAPOLE CO OP BANK" ? 'selected' : ''?>>KAPOLE CO OP BANK</option>
											<option value="KARNATAKA BANK LTD" <?php echo $bankName=="KARNATAKA BANK LTD" ? 'selected' : ''?>>KARNATAKA BANK LTD</option>
											<option value="KARUR VYSYA BANK" <?php echo $bankName=="KARUR VYSYA BANK" ? 'selected' : ''?>>KARUR VYSYA BANK</option>
											<option value="KOTAK MAHINDRA BANK" <?php echo $bankName=="KOTAK MAHINDRA BANK" ? 'selected' : ''?>>KOTAK MAHINDRA BANK</option>
											<option value="MAHANAGAR CO.OP BANK LTD" <?php echo $bankName=="MAHANAGAR CO.OP BANK LTD" ? 'selected' : ''?>>MAHANAGAR CO.OP BANK LTD</option>
											<option value="MAHARASHTRA STATE CO OPERATIVE BANK" <?php echo $bankName=="MAHARASHTRA STATE CO OPERATIVE BANK" ? 'selected' : ''?>>MAHARASHTRA STATE CO OPERATIVE BANK</option>
											<option value="MASHREQ BANK PSC" <?php echo $bankName=="MASHREQ BANK PSC" ? 'selected' : ''?>>MASHREQ BANK PSC</option>
											<option value="MIZUHO CORPORATE BANK LTD" <?php echo $bankName=="MIZUHO CORPORATE BANK LTD" ? 'selected' : ''?>>MIZUHO CORPORATE BANK LTD</option>
											<option value="MUMBAI DISTRICT CENTRAL CO.OP. BANK LTD." <?php echo $bankName=="MUMBAI DISTRICT CENTRAL CO.OP. BANK LTD." ? 'selected' : ''?>>MUMBAI DISTRICT CENTRAL CO.OP. BANK LTD.</option>
											<option value="NAGPUR NAGRIK SAHAKARI BANK LTD" <?php echo $bankName=="NAGPUR NAGRIK SAHAKARI BANK LTD" ? 'selected' : ''?>>NAGPUR NAGRIK SAHAKARI BANK LTD</option>
											<option value="NEW INDIA CO.OPERATIVE BANK LTD" <?php echo $bankName=="NEW INDIA CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>NEW INDIA CO.OPERATIVE BANK LTD</option>
											<option value="NKGSB CO.OP BANK LTD" <?php echo $bankName=="NKGSB CO.OP BANK LTD" ? 'selected' : ''?>>NKGSB CO.OP BANK LTD</option>
											<option value="NORTH MALABAR GRAMIN BANK" <?php echo $bankName=="NORTH MALABAR GRAMIN BANK" ? 'selected' : ''?>>NORTH MALABAR GRAMIN BANK</option>
											<option value="NUTAN NAGARIK SAHAKARI BANK LTD" <?php echo $bankName=="NUTAN NAGARIK SAHAKARI BANK LTD" ? 'selected' : ''?>>NUTAN NAGARIK SAHAKARI BANK LTD</option>
											<option value="OMAN INTERNATIONAL BANK SAOG" <?php echo $bankName=="OMAN INTERNATIONAL BANK SAOG" ? 'selected' : ''?>>OMAN INTERNATIONAL BANK SAOG</option>
											<option value="ORIENTAL BANK OF COMMERCE" <?php echo $bankName=="ORIENTAL BANK OF COMMERCE" ? 'selected' : ''?>>ORIENTAL BANK OF COMMERCE</option>
											<option value="PARSIK JANATA SAHAKARI BANK LTD" <?php echo $bankName=="PARSIK JANATA SAHAKARI BANK LTD" ? 'selected' : ''?>>PARSIK JANATA SAHAKARI BANK LTD</option>
											<option value="PRATHAMA BANK" <?php echo $bankName=="PRATHAMA BANK" ? 'selected' : ''?>>PRATHAMA BANK</option>
											<option value="PRIME CO OPERATIVE BANK LTD" <?php echo $bankName=="PRIME CO OPERATIVE BANK LTD" ? 'selected' : ''?>>PRIME CO OPERATIVE BANK LTD</option>
											<option value="PUNJAB AND MAHARASHTRA CO OP BANK LTD" <?php echo $bankName=="PUNJAB AND MAHARASHTRA CO OP BANK LTD" ? 'selected' : ''?>>PUNJAB AND MAHARASHTRA CO OP BANK LTD</option>
											<option value="PUNJAB AND SIND BANK" <?php echo $bankName=="PUNJAB AND SIND BANK" ? 'selected' : ''?>>PUNJAB AND SIND BANK</option>
											<option value="PUNJAB NATIONAL BANK" <?php echo $bankName=="PUNJAB NATIONAL BANK" ? 'selected' : ''?>>PUNJAB NATIONAL BANK</option>
											<option value="RABOBANK INTERNATIONAL (CCRB)" <?php echo $bankName=="RABOBANK INTERNATIONAL (CCRB)" ? 'selected' : ''?>>RABOBANK INTERNATIONAL (CCRB)</option>
											<option value="RAJKOT NAGARIK SAHAKARI BANK LTD" <?php echo $bankName=="RAJKOT NAGARIK SAHAKARI BANK LTD" ? 'selected' : ''?>>RAJKOT NAGARIK SAHAKARI BANK LTD</option>
											<option value="RESERVE BANK OF INDIA" <?php echo $bankName=="RESERVE BANK OF INDIA" ? 'selected' : ''?>>RESERVE BANK OF INDIA</option>
											<option value="SBERBANK" <?php echo $bankName=="SBERBANK" ? 'selected' : ''?>>SBERBANK</option>
											<option value="SHINHAN BANK" <?php echo $bankName=="SHINHAN BANK" ? 'selected' : ''?>>SHINHAN BANK</option>
											<option value="SHRI CHHATRAPATI RAJARSHI SHAHU URBAN CO.OP BANK LTD" <?php echo $bankName=="SHRI CHHATRAPATI RAJARSHI SHAHU URBAN CO.OP BANK LTD" ? 'selected' : ''?>>SHRI CHHATRAPATI RAJARSHI SHAHU URBAN CO.OP BANK LTD</option>
											<option value="SOCIETE GENERALE" <?php echo $bankName=="SOCIETE GENERALE" ? 'selected' : ''?>>SOCIETE GENERALE</option>
											<option value="SOUTH INDIAN BANK" <?php echo $bankName=="SOUTH INDIAN BANK" ? 'selected' : ''?>>SOUTH INDIAN BANK</option>
											<option value="STANDARD CHARTERED BANK" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>STANDARD CHARTERED BANK</option>
											<option value="STATE BANK OF BIKANER AND JAIPUR" <?php echo $bankName=="STATE BANK OF BIKANER AND JAIPUR" ? 'selected' : ''?>>STATE BANK OF BIKANER AND JAIPUR</option>
											<option value="STATE BANK OF HYDERABAD" <?php echo $bankName=="STATE BANK OF HYDERABAD" ? 'selected' : ''?>>STATE BANK OF HYDERABAD</option>
											<option value="STATE BANK OF INDIA" <?php echo $bankName=="STATE BANK OF INDIA" ? 'selected' : ''?>>STATE BANK OF INDIA</option>
											<option value="STATE BANK OF MAURITIUS LTD" <?php echo $bankName=="STATE BANK OF MAURITIUS LTD" ? 'selected' : ''?>>STATE BANK OF MAURITIUS LTD</option>
											<option value="STATE BANK OF MYSORE" <?php echo $bankName=="STATE BANK OF MYSORE" ? 'selected' : ''?>>STATE BANK OF MYSORE</option>
											<option value="STATE BANK OF PATIALA" <?php echo $bankName=="STATE BANK OF PATIALA" ? 'selected' : ''?>>STATE BANK OF PATIALA</option>
											<option value="STATE BANK OF TRAVANCORE" <?php echo $bankName=="STATE BANK OF TRAVANCORE" ? 'selected' : ''?>>STATE BANK OF TRAVANCORE</option>
											<option value="SYNDICATE BANK" <?php echo $bankName=="SYNDICATE BANK" ? 'selected' : ''?>>SYNDICATE BANK</option>
											<option value="TAMILNAD MERCANTILE BANK LTD" <?php echo $bankName=="TAMILNAD MERCANTILE BANK LTD" ? 'selected' : ''?>>TAMILNAD MERCANTILE BANK LTD</option>
											<option value="THANE BHARAT SAHAKARI BANK LTD" <?php echo $bankName=="THANE BHARAT SAHAKARI BANK LTD" ? 'selected' : ''?>>THANE BHARAT SAHAKARI BANK LTD</option>
											<option value="THE A.P. MAHESH CO.OP URBAN BANK LTD." <?php echo $bankName=="THE A.P. MAHESH CO.OP URBAN BANK LTD." ? 'selected' : ''?>>THE A.P. MAHESH CO.OP URBAN BANK LTD.</option>
											<option value="THE AHMEDABAD MERCANTILE CO.OPERATIVE BANK LTD" <?php echo $bankName=="THE AHMEDABAD MERCANTILE CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE AHMEDABAD MERCANTILE CO.OPERATIVE BANK LTD</option>
											<option value="THE BANK OF NOVA SCOTIA" <?php echo $bankName=="THE BANK OF NOVA SCOTIA" ? 'selected' : ''?>>THE BANK OF NOVA SCOTIA</option>
											<option value="THE BHARAT CO.OPERATIVE BANK (MUMBAI) LTD" <?php echo $bankName=="THE BHARAT CO.OPERATIVE BANK (MUMBAI) LTD" ? 'selected' : ''?>>THE BHARAT CO.OPERATIVE BANK (MUMBAI) LTD</option>
											<option value="THE COSMOS CO.OPERATIVE BANK LTD" <?php echo $bankName=="THE COSMOS CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE COSMOS CO.OPERATIVE BANK LTD</option>
											<option value="THE FEDERAL BANK LTD" <?php echo $bankName=="THE FEDERAL BANK LTD" ? 'selected' : ''?>>THE FEDERAL BANK LTD</option>
											<option value="THE GREATER BOMBAY CO.OP BANK LTD" <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>THE GREATER BOMBAY CO.OP BANK LTD</option>
											<option value="THE GUJARAT STATE CO.OPERATIVE BANK LTD" <?php echo $bankName=="THE GUJARAT STATE CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE GUJARAT STATE CO.OPERATIVE BANK LTD</option>
											<option value="THE JAMMU AND KASHMIR BANK LTD" <?php echo $bankName=="THE JAMMU AND KASHMIR BANK LTD" ? 'selected' : ''?>>THE JAMMU AND KASHMIR BANK LTD</option>
											<option value="THE KALUPUR COMMERCIAL CO OP BANK LTD" <?php echo $bankName=="THE KALUPUR COMMERCIAL CO OP BANK LTD" ? 'selected' : ''?>>THE KALUPUR COMMERCIAL CO OP BANK LTD</option>
											<option value="THE KALYAN JANATA SAHAKARI BANK LTD" <?php echo $bankName=="THE KALYAN JANATA SAHAKARI BANK LTD" ? 'selected' : ''?>>THE KALYAN JANATA SAHAKARI BANK LTD</option>
											<option value="THE KANGRA CENTRAL CO.OP BANK LIMITED" <?php echo $bankName=="THE KANGRA CENTRAL CO.OP BANK LIMITED" ? 'selected' : ''?>>THE KANGRA CENTRAL CO.OP BANK LIMITED</option>
											<option value="THE KARAD URBAN CO.OP BANK LTD" <?php echo $bankName=="THE KARAD URBAN CO.OP BANK LTD" ? 'selected' : ''?>>THE KARAD URBAN CO.OP BANK LTD</option>
											<option value="THE KARNATAKA STATE APEX COOP. BANK LTD" <?php echo $bankName=="THE KARNATAKA STATE APEX COOP. BANK LTD" ? 'selected' : ''?>>THE KARNATAKA STATE APEX COOP. BANK LTD</option>
											<option value="THE LAKSHMI VILAS BANK LTD" <?php echo $bankName=="THE LAKSHMI VILAS BANK LTD" ? 'selected' : ''?>>THE LAKSHMI VILAS BANK LTD</option>
											<option value="THE MEHSANA URBAN COOPERATIVE BANK LTD" <?php echo $bankName=="THE MEHSANA URBAN COOPERATIVE BANK LTD" ? 'selected' : ''?>>THE MEHSANA URBAN COOPERATIVE BANK LTD</option>
											<option value="THE MUNICIPAL CO OPERATIVE BANK LTD MUMBAI" <?php echo $bankName=="THE MUNICIPAL CO OPERATIVE BANK LTD MUMBAI" ? 'selected' : ''?>>THE MUNICIPAL CO OPERATIVE BANK LTD MUMBAI</option>
											<option value="THE NAINITAL BANK LIMITED" <?php echo $bankName=="THE NAINITAL BANK LIMITED" ? 'selected' : ''?>>THE NAINITAL BANK LIMITED</option>
											<option value="THE NASHIK MERCHANTS CO.OP BANK LTD., NASHIK" <?php echo $bankName=="THE NASHIK MERCHANTS CO.OP BANK LTD., NASHIK" ? 'selected' : ''?>>THE NASHIK MERCHANTS CO.OP BANK LTD., NASHIK</option>
											<option value="THE RAJASTHAN STATE COOPERATIVE BANK LTD." <?php echo $bankName=="THE RAJASTHAN STATE COOPERATIVE BANK LTD." ? 'selected' : ''?>>THE RAJASTHAN STATE COOPERATIVE BANK LTD.</option>
											<option value="THE RATNAKAR BANK LTD" <?php echo $bankName=="THE RATNAKAR BANK LTD" ? 'selected' : ''?>>THE RATNAKAR BANK LTD</option>
											<option value="THE ROYAL BANK OF SCOTLAND NV" <?php echo $bankName=="THE ROYAL BANK OF SCOTLAND NV" ? 'selected' : ''?>>THE ROYAL BANK OF SCOTLAND NV</option>
											<option value="THE SARASWAT CO.OPERATIVE BANK LTD" <?php echo $bankName=="THE SARASWAT CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE SARASWAT CO.OPERATIVE BANK LTD</option>
											<option value="THE SHAMRAO VITHAL CO.OPERATIVE BANK LTD" <?php echo $bankName=="THE SHAMRAO VITHAL CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE SHAMRAO VITHAL CO.OPERATIVE BANK LTD</option>
											<option value="THE SURAT DISTRICT CO OPERATIVE BANK LTD." <?php echo $bankName=="THE SURAT DISTRICT CO OPERATIVE BANK LTD." ? 'selected' : ''?>>THE SURAT DISTRICT CO OPERATIVE BANK LTD.</option>
											<option value="THE SURAT PEOPLES CO.OP BANK LTD" <?php echo $bankName=="THE SURAT PEOPLES CO.OP BANK LTD" ? 'selected' : ''?>>THE SURAT PEOPLES CO.OP BANK LTD</option>
											<option value="THE SUTEX CO.OP. BANK LTD." <?php echo $bankName=="THE SUTEX CO.OP. BANK LTD." ? 'selected' : ''?>>THE SUTEX CO.OP. BANK LTD.</option>
											<option value="THE TAMILNADU STATE APEX COOPERATIVE BANK LIMITED" <?php echo $bankName=="THE TAMILNADU STATE APEX COOPERATIVE BANK LIMITED" ? 'selected' : ''?>>THE TAMILNADU STATE APEX COOPERATIVE BANK LIMITED</option>
											<option value="THE THANE JANATA SAHAKARI BANK LTD" <?php echo $bankName=="THE THANE JANATA SAHAKARI BANK LTD" ? 'selected' : ''?>>THE THANE JANATA SAHAKARI BANK LTD</option>
											<option value="THE VARACHHA CO.OP. BANK LTD." <?php echo $bankName=="THE VARACHHA CO.OP. BANK LTD." ? 'selected' : ''?>>THE VARACHHA CO.OP. BANK LTD.</option>
											<option value="THE WEST BENGAL STATE COOPERATIVE BANK LTD" <?php echo $bankName=="THE WEST BENGAL STATE COOPERATIVE BANK LTD" ? 'selected' : ''?>>THE WEST BENGAL STATE COOPERATIVE BANK LTD</option>
											<option value="TUMKUR GRAIN MERCHANTS COOPERATIVE BANK LTD.," <?php echo $bankName=="BANK OF INDIA" ? 'selected' : ''?>>TUMKUR GRAIN MERCHANTS COOPERATIVE BANK LTD.,</option>
											<option value="UBS AG" <?php echo $bankName=="UBS AG" ? 'selected' : ''?>>UBS AG</option>
											<option value="UCO BANK" <?php echo $bankName=="UCO BANK" ? 'selected' : ''?>>UCO BANK</option>
											<option value="UNION BANK OF INDIA" <?php echo $bankName=="UNION BANK OF INDIA" ? 'selected' : ''?>>UNION BANK OF INDIA</option>
											<option value="UNITED BANK OF INDIA" <?php echo $bankName=="UNITED BANK OF INDIA" ? 'selected' : ''?>>UNITED BANK OF INDIA</option>
											<option value="VIJAYA BANK" <?php echo $bankName=="VIJAYA BANK" ? 'selected' : ''?>>VIJAYA BANK</option>
											<option value="WOORI BANK" <?php echo $bankName=="WOORI BANK" ? 'selected' : ''?>>WOORI BANK</option>
											<option value="YES BANK LTD" <?php echo $bankName=="YES BANK LTD" ? 'selected' : ''?>>YES BANK LTD</option>
									</select>
										-->
										<span class="input-group-addon"> <i class="fa fa-university"></i> </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Cheque No
								</label>
								<div class="col-sm-7">
									<input type="text" placeholder="Cheque No" id="cheque_no" class="form-control" name="cheque_no" value="<?php echo !empty($cashierPayment['cheque_no']) ? $cashierPayment['cheque_no'] : '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Cheque Date
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="Cheque Date" id="cheque_date" class="form-control date-picker" name="cheque_date" value="<?php echo !empty($cashierPayment['cheque_date']) ? date("d-m-Y",strtotime($cashierPayment['cheque_date'])) : '' ?>">
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
										<input type="text" placeholder="dd bank name" id="dd_bank_name" class="form-control" name="dd_bank_name" value="">
										<?php //!empty($customerPayment['dd_bank_name']) ? $ddBankName = $customerPayment['dd_bank_name'] : $ddBankName="";?>
										<!--
										<select id="dd_bank_name" name="dd_bank_name" class="form-control">
											<option value="" >--Select Bank Name --</option>
											<option value="ABHYUDAYA COOPERATIVE BANK LTD" <?php echo $ddBankName=="ABHYUDAYA COOPERATIVE BANK LTD" ? 'selected' : ''?>>ABHYUDAYA COOPERATIVE BANK LTD</option>
											<option value="ABU DHABI COMMERCIAL BANK" <?php echo $ddBankName=="ABU DHABI COMMERCIAL BANK" ? 'selected' : ''?>>ABU DHABI COMMERCIAL BANK</option>
											<option value="ALLAHABAD BANK" <?php echo $ddBankName=="ALLAHABAD BANK" ? 'selected' : ''?>>ALLAHABAD BANK</option>
											<option value="ALMORA URBAN CO.OPERATIVE BANK LTD." <?php echo $ddBankName=="ALMORA URBAN CO.OPERATIVE BANK LTD." ? 'selected' : ''?>>ALMORA URBAN CO.OPERATIVE BANK LTD.</option>
											<option value="ANDHRA BANK" <?php echo $ddBankName=="ANDHRA BANK" ? 'selected' : ''?>>ANDHRA BANK</option>
											<option value="APNA SAHAKARI BANK LTD" <?php echo $ddBankName=="APNA SAHAKARI BANK LTD" ? 'selected' : ''?>>APNA SAHAKARI BANK LTD</option>
											<option value="AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED." <?php echo $ddBankName=="AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED." ? 'selected' : ''?>>AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED.</option>
											<option value="AXIS BANK" <?php echo $ddBankName=="AXIS BANK" ? 'selected' : ''?>>AXIS BANK</option>
											<option value="BANK OF AMERICA" <?php echo $ddBankName=="BANK OF AMERICA" ? 'selected' : ''?>>BANK OF AMERICA</option>
											<option value="BANK OF BAHRAIN AND KUWAIT" <?php echo $ddBankName=="BANK OF BAHRAIN AND KUWAIT" ? 'selected' : ''?>>BANK OF BAHRAIN AND KUWAIT</option>
											<option value="BANK OF BARODA" <?php echo $ddBankName=="BANK OF BARODA" ? 'selected' : ''?>>BANK OF BARODA</option>
											<option value="BANK OF CEYLON" <?php echo $ddBankName=="BANK OF CEYLON" ? 'selected' : ''?>>BANK OF CEYLON</option>
											<option value="BANK OF INDIA" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>BANK OF INDIA</option>
											<option value="BANK OF MAHARASHTRA" <?php echo $ddBankName=="BANK OF MAHARASHTRA" ? 'selected' : ''?>>BANK OF MAHARASHTRA</option>
											<option value="BANK OF TOKYO MITSUBISHI UFJ LTD." <?php echo $ddBankName=="BANK OF TOKYO MITSUBISHI UFJ LTD." ? 'selected' : ''?>>BANK OF TOKYO MITSUBISHI UFJ LTD.</option>
											<option value="BARCLAYS BANK PLC" <?php echo $ddBankName=="BARCLAYS BANK PLC" ? 'selected' : ''?>>BARCLAYS BANK PLC</option>
											<option value="BASSEIN CATHOLIC CO OP BANK LTD" <?php echo $ddBankName=="BASSEIN CATHOLIC CO OP BANK LTD" ? 'selected' : ''?>>BASSEIN CATHOLIC CO OP BANK LTD</option>
											<option value="BNP PARIBAS" <?php echo $ddBankName=="BNP PARIBAS" ? 'selected' : ''?>>BNP PARIBAS</option>
											<option value="CANARA BANK" <?php echo $ddBankName=="CANARA BANK" ? 'selected' : ''?>>CANARA BANK</option>
											<option value="CAPITAL LOCAL AREA BANK LTD." <?php echo $ddBankName=="CAPITAL LOCAL AREA BANK LTD." ? 'selected' : ''?>>CAPITAL LOCAL AREA BANK LTD.</option>
											<option value="CATHOLIC SYRIAN BANK LTD" <?php echo $ddBankName=="CATHOLIC SYRIAN BANK LTD" ? 'selected' : ''?>>CATHOLIC SYRIAN BANK LTD</option>
											<option value="CENTRAL BANK OF INDIA" <?php echo $ddBankName=="CENTRAL BANK OF INDIA" ? 'selected' : ''?>>CENTRAL BANK OF INDIA</option>
											<option value="CHINATRUST COMMERCIAL BANK" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>CHINATRUST COMMERCIAL BANK</option>
											<option value="CITIBANK NA" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>CITIBANK NA</option>
											<option value="CITIZENCREDIT CO.OPERATIVE BANK LTD" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>CITIZENCREDIT CO.OPERATIVE BANK LTD</option>
											<option value="CITY UNION BANK LTD" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>CITY UNION BANK LTD</option>
											<option value="COMMONWEALTH BANK OF AUSTRALIA" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>COMMONWEALTH BANK OF AUSTRALIA</option>
											<option value="CORPORATION BANK" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>CORPORATION BANK</option>
											<option value="CREDIT AGRICOLE CORPORATE AND INVESTEMENT BANK" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>CREDIT AGRICOLE CORPORATE AND INVESTEMENT BANK</option>
											<option value="CREDIT SUISSE AG" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>CREDIT SUISSE AG</option>
											<option value="DBS BANK LTD" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>DBS BANK LTD</option>
											<option value="DENA BANK" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>DENA BANK</option>
											<option value="DEUTSCHE BANK" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>DEUTSCHE BANK</option>
											<option value="DEVELOPMENT CREDIT BANK LIMITED" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>DEVELOPMENT CREDIT BANK LIMITED</option>
											<option value="DHANLAXMI BANK LTD" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>DHANLAXMI BANK LTD</option>
											<option value="DICGC" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>DICGC</option>
											<option value="DOMBIVLI NAGARI SAHAKARI BANK LIMITED" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>DOMBIVLI NAGARI SAHAKARI BANK LIMITED</option>
											<option value="FIRSTRAND BANK LIMITED" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>FIRSTRAND BANK LIMITED</option>
											<option value="GURGAON GRAMIN BANK" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>GURGAON GRAMIN BANK</option>
											<option value="HDFC BANK LTD" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>HDFC BANK LTD</option>
											<option value="HSBC" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>HSBC</option>
											<option value="ICICI BANK LTD" <?php echo $ddBankName=="ICICI BANK LTD" ? 'selected' : ''?>>ICICI BANK LTD</option>
											<option value="IDBI BANK LTD" <?php echo $ddBankName=="IDBI BANK LTD" ? 'selected' : ''?>>IDBI BANK LTD</option>
											<option value="INDIAN BANK" <?php echo $ddBankName=="INDIAN BANK" ? 'selected' : ''?>>INDIAN BANK</option>
											<option value="INDIAN OVERSEAS BANK" <?php echo $ddBankName=="INDIAN OVERSEAS BANK" ? 'selected' : ''?>>INDIAN OVERSEAS BANK</option>
											<option value="INDUSIND BANK LTD" <?php echo $ddBankName=="INDUSIND BANK LTD" ? 'selected' : ''?>>INDUSIND BANK LTD</option>
											<option value="ING VYSYA BANK LTD" <?php echo $ddBankName=="ING VYSYA BANK LTD" ? 'selected' : ''?>>ING VYSYA BANK LTD</option>
											<option value="JALGAON JANATA SAHKARI BANK LTD" <?php echo $ddBankName=="JALGAON JANATA SAHKARI BANK LTD" ? 'selected' : ''?>>JALGAON JANATA SAHKARI BANK LTD</option>
											<option value="JANAKALYAN SAHAKARI BANK LTD" <?php echo $ddBankName=="JANAKALYAN SAHAKARI BANK LTD" ? 'selected' : ''?>>JANAKALYAN SAHAKARI BANK LTD</option>
											<option value="JANATA SAHAKARI BANK LTD (PUNE )" <?php echo $ddBankName=="JANATA SAHAKARI BANK LTD (PUNE )" ? 'selected' : ''?>>JANATA SAHAKARI BANK LTD (PUNE )</option>
											<option value="JP MORGAN CHASE BANK" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>JP MORGAN CHASE BANK</option>
											<option value="KALLAPPANNA AWADE ICH JANATA S BANK" <?php echo $ddBankName=="KALLAPPANNA AWADE ICH JANATA S BANK" ? 'selected' : ''?>>KALLAPPANNA AWADE ICH JANATA S BANK</option>
											<option value="KAPOLE CO OP BANK" <?php echo $ddBankName=="KAPOLE CO OP BANK" ? 'selected' : ''?>>KAPOLE CO OP BANK</option>
											<option value="KARNATAKA BANK LTD" <?php echo $ddBankName=="KARNATAKA BANK LTD" ? 'selected' : ''?>>KARNATAKA BANK LTD</option>
											<option value="KARUR VYSYA BANK" <?php echo $ddBankName=="KARUR VYSYA BANK" ? 'selected' : ''?>>KARUR VYSYA BANK</option>
											<option value="KOTAK MAHINDRA BANK" <?php echo $ddBankName=="KOTAK MAHINDRA BANK" ? 'selected' : ''?>>KOTAK MAHINDRA BANK</option>
											<option value="MAHANAGAR CO.OP BANK LTD" <?php echo $ddBankName=="MAHANAGAR CO.OP BANK LTD" ? 'selected' : ''?>>MAHANAGAR CO.OP BANK LTD</option>
											<option value="MAHARASHTRA STATE CO OPERATIVE BANK" <?php echo $ddBankName=="MAHARASHTRA STATE CO OPERATIVE BANK" ? 'selected' : ''?>>MAHARASHTRA STATE CO OPERATIVE BANK</option>
											<option value="MASHREQ BANK PSC" <?php echo $ddBankName=="MASHREQ BANK PSC" ? 'selected' : ''?>>MASHREQ BANK PSC</option>
											<option value="MIZUHO CORPORATE BANK LTD" <?php echo $ddBankName=="MIZUHO CORPORATE BANK LTD" ? 'selected' : ''?>>MIZUHO CORPORATE BANK LTD</option>
											<option value="MUMBAI DISTRICT CENTRAL CO.OP. BANK LTD." <?php echo $ddBankName=="MUMBAI DISTRICT CENTRAL CO.OP. BANK LTD." ? 'selected' : ''?>>MUMBAI DISTRICT CENTRAL CO.OP. BANK LTD.</option>
											<option value="NAGPUR NAGRIK SAHAKARI BANK LTD" <?php echo $ddBankName=="NAGPUR NAGRIK SAHAKARI BANK LTD" ? 'selected' : ''?>>NAGPUR NAGRIK SAHAKARI BANK LTD</option>
											<option value="NEW INDIA CO.OPERATIVE BANK LTD" <?php echo $ddBankName=="NEW INDIA CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>NEW INDIA CO.OPERATIVE BANK LTD</option>
											<option value="NKGSB CO.OP BANK LTD" <?php echo $ddBankName=="NKGSB CO.OP BANK LTD" ? 'selected' : ''?>>NKGSB CO.OP BANK LTD</option>
											<option value="NORTH MALABAR GRAMIN BANK" <?php echo $ddBankName=="NORTH MALABAR GRAMIN BANK" ? 'selected' : ''?>>NORTH MALABAR GRAMIN BANK</option>
											<option value="NUTAN NAGARIK SAHAKARI BANK LTD" <?php echo $ddBankName=="NUTAN NAGARIK SAHAKARI BANK LTD" ? 'selected' : ''?>>NUTAN NAGARIK SAHAKARI BANK LTD</option>
											<option value="OMAN INTERNATIONAL BANK SAOG" <?php echo $ddBankName=="OMAN INTERNATIONAL BANK SAOG" ? 'selected' : ''?>>OMAN INTERNATIONAL BANK SAOG</option>
											<option value="ORIENTAL BANK OF COMMERCE" <?php echo $ddBankName=="ORIENTAL BANK OF COMMERCE" ? 'selected' : ''?>>ORIENTAL BANK OF COMMERCE</option>
											<option value="PARSIK JANATA SAHAKARI BANK LTD" <?php echo $ddBankName=="PARSIK JANATA SAHAKARI BANK LTD" ? 'selected' : ''?>>PARSIK JANATA SAHAKARI BANK LTD</option>
											<option value="PRATHAMA BANK" <?php echo $ddBankName=="PRATHAMA BANK" ? 'selected' : ''?>>PRATHAMA BANK</option>
											<option value="PRIME CO OPERATIVE BANK LTD" <?php echo $ddBankName=="PRIME CO OPERATIVE BANK LTD" ? 'selected' : ''?>>PRIME CO OPERATIVE BANK LTD</option>
											<option value="PUNJAB AND MAHARASHTRA CO OP BANK LTD" <?php echo $ddBankName=="PUNJAB AND MAHARASHTRA CO OP BANK LTD" ? 'selected' : ''?>>PUNJAB AND MAHARASHTRA CO OP BANK LTD</option>
											<option value="PUNJAB AND SIND BANK" <?php echo $ddBankName=="PUNJAB AND SIND BANK" ? 'selected' : ''?>>PUNJAB AND SIND BANK</option>
											<option value="PUNJAB NATIONAL BANK" <?php echo $ddBankName=="PUNJAB NATIONAL BANK" ? 'selected' : ''?>>PUNJAB NATIONAL BANK</option>
											<option value="RABOBANK INTERNATIONAL (CCRB)" <?php echo $ddBankName=="RABOBANK INTERNATIONAL (CCRB)" ? 'selected' : ''?>>RABOBANK INTERNATIONAL (CCRB)</option>
											<option value="RAJKOT NAGARIK SAHAKARI BANK LTD" <?php echo $ddBankName=="RAJKOT NAGARIK SAHAKARI BANK LTD" ? 'selected' : ''?>>RAJKOT NAGARIK SAHAKARI BANK LTD</option>
											<option value="RESERVE BANK OF INDIA" <?php echo $ddBankName=="RESERVE BANK OF INDIA" ? 'selected' : ''?>>RESERVE BANK OF INDIA</option>
											<option value="SBERBANK" <?php echo $ddBankName=="SBERBANK" ? 'selected' : ''?>>SBERBANK</option>
											<option value="SHINHAN BANK" <?php echo $ddBankName=="SHINHAN BANK" ? 'selected' : ''?>>SHINHAN BANK</option>
											<option value="SHRI CHHATRAPATI RAJARSHI SHAHU URBAN CO.OP BANK LTD" <?php echo $ddBankName=="SHRI CHHATRAPATI RAJARSHI SHAHU URBAN CO.OP BANK LTD" ? 'selected' : ''?>>SHRI CHHATRAPATI RAJARSHI SHAHU URBAN CO.OP BANK LTD</option>
											<option value="SOCIETE GENERALE" <?php echo $ddBankName=="SOCIETE GENERALE" ? 'selected' : ''?>>SOCIETE GENERALE</option>
											<option value="SOUTH INDIAN BANK" <?php echo $ddBankName=="SOUTH INDIAN BANK" ? 'selected' : ''?>>SOUTH INDIAN BANK</option>
											<option value="STANDARD CHARTERED BANK" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>STANDARD CHARTERED BANK</option>
											<option value="STATE BANK OF BIKANER AND JAIPUR" <?php echo $ddBankName=="STATE BANK OF BIKANER AND JAIPUR" ? 'selected' : ''?>>STATE BANK OF BIKANER AND JAIPUR</option>
											<option value="STATE BANK OF HYDERABAD" <?php echo $ddBankName=="STATE BANK OF HYDERABAD" ? 'selected' : ''?>>STATE BANK OF HYDERABAD</option>
											<option value="STATE BANK OF INDIA" <?php echo $ddBankName=="STATE BANK OF INDIA" ? 'selected' : ''?>>STATE BANK OF INDIA</option>
											<option value="STATE BANK OF MAURITIUS LTD" <?php echo $ddBankName=="STATE BANK OF MAURITIUS LTD" ? 'selected' : ''?>>STATE BANK OF MAURITIUS LTD</option>
											<option value="STATE BANK OF MYSORE" <?php echo $ddBankName=="STATE BANK OF MYSORE" ? 'selected' : ''?>>STATE BANK OF MYSORE</option>
											<option value="STATE BANK OF PATIALA" <?php echo $ddBankName=="STATE BANK OF PATIALA" ? 'selected' : ''?>>STATE BANK OF PATIALA</option>
											<option value="STATE BANK OF TRAVANCORE" <?php echo $ddBankName=="STATE BANK OF TRAVANCORE" ? 'selected' : ''?>>STATE BANK OF TRAVANCORE</option>
											<option value="SYNDICATE BANK" <?php echo $ddBankName=="SYNDICATE BANK" ? 'selected' : ''?>>SYNDICATE BANK</option>
											<option value="TAMILNAD MERCANTILE BANK LTD" <?php echo $ddBankName=="TAMILNAD MERCANTILE BANK LTD" ? 'selected' : ''?>>TAMILNAD MERCANTILE BANK LTD</option>
											<option value="THANE BHARAT SAHAKARI BANK LTD" <?php echo $ddBankName=="THANE BHARAT SAHAKARI BANK LTD" ? 'selected' : ''?>>THANE BHARAT SAHAKARI BANK LTD</option>
											<option value="THE A.P. MAHESH CO.OP URBAN BANK LTD." <?php echo $ddBankName=="THE A.P. MAHESH CO.OP URBAN BANK LTD." ? 'selected' : ''?>>THE A.P. MAHESH CO.OP URBAN BANK LTD.</option>
											<option value="THE AHMEDABAD MERCANTILE CO.OPERATIVE BANK LTD" <?php echo $ddBankName=="THE AHMEDABAD MERCANTILE CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE AHMEDABAD MERCANTILE CO.OPERATIVE BANK LTD</option>
											<option value="THE BANK OF NOVA SCOTIA" <?php echo $ddBankName=="THE BANK OF NOVA SCOTIA" ? 'selected' : ''?>>THE BANK OF NOVA SCOTIA</option>
											<option value="THE BHARAT CO.OPERATIVE BANK (MUMBAI) LTD" <?php echo $ddBankName=="THE BHARAT CO.OPERATIVE BANK (MUMBAI) LTD" ? 'selected' : ''?>>THE BHARAT CO.OPERATIVE BANK (MUMBAI) LTD</option>
											<option value="THE COSMOS CO.OPERATIVE BANK LTD" <?php echo $ddBankName=="THE COSMOS CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE COSMOS CO.OPERATIVE BANK LTD</option>
											<option value="THE FEDERAL BANK LTD" <?php echo $ddBankName=="THE FEDERAL BANK LTD" ? 'selected' : ''?>>THE FEDERAL BANK LTD</option>
											<option value="THE GREATER BOMBAY CO.OP BANK LTD" <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>THE GREATER BOMBAY CO.OP BANK LTD</option>
											<option value="THE GUJARAT STATE CO.OPERATIVE BANK LTD" <?php echo $ddBankName=="THE GUJARAT STATE CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE GUJARAT STATE CO.OPERATIVE BANK LTD</option>
											<option value="THE JAMMU AND KASHMIR BANK LTD" <?php echo $ddBankName=="THE JAMMU AND KASHMIR BANK LTD" ? 'selected' : ''?>>THE JAMMU AND KASHMIR BANK LTD</option>
											<option value="THE KALUPUR COMMERCIAL CO OP BANK LTD" <?php echo $ddBankName=="THE KALUPUR COMMERCIAL CO OP BANK LTD" ? 'selected' : ''?>>THE KALUPUR COMMERCIAL CO OP BANK LTD</option>
											<option value="THE KALYAN JANATA SAHAKARI BANK LTD" <?php echo $ddBankName=="THE KALYAN JANATA SAHAKARI BANK LTD" ? 'selected' : ''?>>THE KALYAN JANATA SAHAKARI BANK LTD</option>
											<option value="THE KANGRA CENTRAL CO.OP BANK LIMITED" <?php echo $ddBankName=="THE KANGRA CENTRAL CO.OP BANK LIMITED" ? 'selected' : ''?>>THE KANGRA CENTRAL CO.OP BANK LIMITED</option>
											<option value="THE KARAD URBAN CO.OP BANK LTD" <?php echo $ddBankName=="THE KARAD URBAN CO.OP BANK LTD" ? 'selected' : ''?>>THE KARAD URBAN CO.OP BANK LTD</option>
											<option value="THE KARNATAKA STATE APEX COOP. BANK LTD" <?php echo $ddBankName=="THE KARNATAKA STATE APEX COOP. BANK LTD" ? 'selected' : ''?>>THE KARNATAKA STATE APEX COOP. BANK LTD</option>
											<option value="THE LAKSHMI VILAS BANK LTD" <?php echo $ddBankName=="THE LAKSHMI VILAS BANK LTD" ? 'selected' : ''?>>THE LAKSHMI VILAS BANK LTD</option>
											<option value="THE MEHSANA URBAN COOPERATIVE BANK LTD" <?php echo $ddBankName=="THE MEHSANA URBAN COOPERATIVE BANK LTD" ? 'selected' : ''?>>THE MEHSANA URBAN COOPERATIVE BANK LTD</option>
											<option value="THE MUNICIPAL CO OPERATIVE BANK LTD MUMBAI" <?php echo $ddBankName=="THE MUNICIPAL CO OPERATIVE BANK LTD MUMBAI" ? 'selected' : ''?>>THE MUNICIPAL CO OPERATIVE BANK LTD MUMBAI</option>
											<option value="THE NAINITAL BANK LIMITED" <?php echo $ddBankName=="THE NAINITAL BANK LIMITED" ? 'selected' : ''?>>THE NAINITAL BANK LIMITED</option>
											<option value="THE NASHIK MERCHANTS CO.OP BANK LTD., NASHIK" <?php echo $ddBankName=="THE NASHIK MERCHANTS CO.OP BANK LTD., NASHIK" ? 'selected' : ''?>>THE NASHIK MERCHANTS CO.OP BANK LTD., NASHIK</option>
											<option value="THE RAJASTHAN STATE COOPERATIVE BANK LTD." <?php echo $ddBankName=="THE RAJASTHAN STATE COOPERATIVE BANK LTD." ? 'selected' : ''?>>THE RAJASTHAN STATE COOPERATIVE BANK LTD.</option>
											<option value="THE RATNAKAR BANK LTD" <?php echo $ddBankName=="THE RATNAKAR BANK LTD" ? 'selected' : ''?>>THE RATNAKAR BANK LTD</option>
											<option value="THE ROYAL BANK OF SCOTLAND NV" <?php echo $ddBankName=="THE ROYAL BANK OF SCOTLAND NV" ? 'selected' : ''?>>THE ROYAL BANK OF SCOTLAND NV</option>
											<option value="THE SARASWAT CO.OPERATIVE BANK LTD" <?php echo $ddBankName=="THE SARASWAT CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE SARASWAT CO.OPERATIVE BANK LTD</option>
											<option value="THE SHAMRAO VITHAL CO.OPERATIVE BANK LTD" <?php echo $ddBankName=="THE SHAMRAO VITHAL CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE SHAMRAO VITHAL CO.OPERATIVE BANK LTD</option>
											<option value="THE SURAT DISTRICT CO OPERATIVE BANK LTD." <?php echo $ddBankName=="THE SURAT DISTRICT CO OPERATIVE BANK LTD." ? 'selected' : ''?>>THE SURAT DISTRICT CO OPERATIVE BANK LTD.</option>
											<option value="THE SURAT PEOPLES CO.OP BANK LTD" <?php echo $ddBankName=="THE SURAT PEOPLES CO.OP BANK LTD" ? 'selected' : ''?>>THE SURAT PEOPLES CO.OP BANK LTD</option>
											<option value="THE SUTEX CO.OP. BANK LTD." <?php echo $ddBankName=="THE SUTEX CO.OP. BANK LTD." ? 'selected' : ''?>>THE SUTEX CO.OP. BANK LTD.</option>
											<option value="THE TAMILNADU STATE APEX COOPERATIVE BANK LIMITED" <?php echo $ddBankName=="THE TAMILNADU STATE APEX COOPERATIVE BANK LIMITED" ? 'selected' : ''?>>THE TAMILNADU STATE APEX COOPERATIVE BANK LIMITED</option>
											<option value="THE THANE JANATA SAHAKARI BANK LTD" <?php echo $ddBankName=="THE THANE JANATA SAHAKARI BANK LTD" ? 'selected' : ''?>>THE THANE JANATA SAHAKARI BANK LTD</option>
											<option value="THE VARACHHA CO.OP. BANK LTD." <?php echo $ddBankName=="THE VARACHHA CO.OP. BANK LTD." ? 'selected' : ''?>>THE VARACHHA CO.OP. BANK LTD.</option>
											<option value="THE WEST BENGAL STATE COOPERATIVE BANK LTD" <?php echo $ddBankName=="THE WEST BENGAL STATE COOPERATIVE BANK LTD" ? 'selected' : ''?>>THE WEST BENGAL STATE COOPERATIVE BANK LTD</option>
											<option value="TUMKUR GRAIN MERCHANTS COOPERATIVE BANK LTD.," <?php echo $ddBankName=="BANK OF INDIA" ? 'selected' : ''?>>TUMKUR GRAIN MERCHANTS COOPERATIVE BANK LTD.,</option>
											<option value="UBS AG" <?php echo $ddBankName=="UBS AG" ? 'selected' : ''?>>UBS AG</option>
											<option value="UCO BANK" <?php echo $ddBankName=="UCO BANK" ? 'selected' : ''?>>UCO BANK</option>
											<option value="UNION BANK OF INDIA" <?php echo $ddBankName=="UNION BANK OF INDIA" ? 'selected' : ''?>>UNION BANK OF INDIA</option>
											<option value="UNITED BANK OF INDIA" <?php echo $ddBankName=="UNITED BANK OF INDIA" ? 'selected' : ''?>>UNITED BANK OF INDIA</option>
											<option value="VIJAYA BANK" <?php echo $ddBankName=="VIJAYA BANK" ? 'selected' : ''?>>VIJAYA BANK</option>
											<option value="WOORI BANK" <?php echo $ddBankName=="WOORI BANK" ? 'selected' : ''?>>WOORI BANK</option>
											<option value="YES BANK LTD" <?php echo $ddBankName=="YES BANK LTD" ? 'selected' : ''?>>YES BANK LTD</option>
										</select>
										-->
										<span class="input-group-addon"> <i class="fa fa-university"></i> </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									DD No
								</label>
								<div class="col-sm-7">
									<input type="text" placeholder="DD No" id="dd_no" class="form-control" name="dd_no" value="<?php echo !empty($customerPayment['dd_no']) ? $customerPayment['dd_no'] : '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									DD Date
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="DD Date" id="dd_date" class="form-control date-picker" name="dd_date" value="<?php echo !empty($customerPayment['dd_date']) ? date("d-m-Y",strtotime($customerPayment['dd_date'])) : '' ?>">
										<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
									</div>
								</div>
							</div>
						</div>
						
						<div class="by_case_neft" style="<?php echo $paymentType=="NEFT" ? 'display:block' : 'display:none';?>;">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									Bank Name <span class="required-field">*</span>
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="neft bank name" id="neft_bank_name" class="form-control" name="neft_bank_name" value="">
										<?php !empty($customerPayment['neft_bank_name']) ? $neftBankName = $customerPayment['neft_bank_name'] : $neftBankName="";?>
										<!--
										<select id="neft_bank_name" name="neft_bank_name" class="form-control">
											<option value="" >--Select Bank Name --</option>
											<option value="ABHYUDAYA COOPERATIVE BANK LTD" <?php echo $neftBankName=="ABHYUDAYA COOPERATIVE BANK LTD" ? 'selected' : ''?>>ABHYUDAYA COOPERATIVE BANK LTD</option>
											<option value="ABU DHABI COMMERCIAL BANK" <?php echo $neftBankName=="ABU DHABI COMMERCIAL BANK" ? 'selected' : ''?>>ABU DHABI COMMERCIAL BANK</option>
											<option value="ALLAHABAD BANK" <?php echo $neftBankName=="ALLAHABAD BANK" ? 'selected' : ''?>>ALLAHABAD BANK</option>
											<option value="ALMORA URBAN CO.OPERATIVE BANK LTD." <?php echo $neftBankName=="ALMORA URBAN CO.OPERATIVE BANK LTD." ? 'selected' : ''?>>ALMORA URBAN CO.OPERATIVE BANK LTD.</option>
											<option value="ANDHRA BANK" <?php echo $neftBankName=="ANDHRA BANK" ? 'selected' : ''?>>ANDHRA BANK</option>
											<option value="APNA SAHAKARI BANK LTD" <?php echo $neftBankName=="APNA SAHAKARI BANK LTD" ? 'selected' : ''?>>APNA SAHAKARI BANK LTD</option>
											<option value="AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED." <?php echo $neftBankName=="AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED." ? 'selected' : ''?>>AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED.</option>
											<option value="AXIS BANK" <?php echo $neftBankName=="AXIS BANK" ? 'selected' : ''?>>AXIS BANK</option>
											<option value="BANK OF AMERICA" <?php echo $neftBankName=="BANK OF AMERICA" ? 'selected' : ''?>>BANK OF AMERICA</option>
											<option value="BANK OF BAHRAIN AND KUWAIT" <?php echo $neftBankName=="BANK OF BAHRAIN AND KUWAIT" ? 'selected' : ''?>>BANK OF BAHRAIN AND KUWAIT</option>
											<option value="BANK OF BARODA" <?php echo $neftBankName=="BANK OF BARODA" ? 'selected' : ''?>>BANK OF BARODA</option>
											<option value="BANK OF CEYLON" <?php echo $neftBankName=="BANK OF CEYLON" ? 'selected' : ''?>>BANK OF CEYLON</option>
											<option value="BANK OF INDIA" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>BANK OF INDIA</option>
											<option value="BANK OF MAHARASHTRA" <?php echo $neftBankName=="BANK OF MAHARASHTRA" ? 'selected' : ''?>>BANK OF MAHARASHTRA</option>
											<option value="BANK OF TOKYO MITSUBISHI UFJ LTD." <?php echo $neftBankName=="BANK OF TOKYO MITSUBISHI UFJ LTD." ? 'selected' : ''?>>BANK OF TOKYO MITSUBISHI UFJ LTD.</option>
											<option value="BARCLAYS BANK PLC" <?php echo $neftBankName=="BARCLAYS BANK PLC" ? 'selected' : ''?>>BARCLAYS BANK PLC</option>
											<option value="BASSEIN CATHOLIC CO OP BANK LTD" <?php echo $neftBankName=="BASSEIN CATHOLIC CO OP BANK LTD" ? 'selected' : ''?>>BASSEIN CATHOLIC CO OP BANK LTD</option>
											<option value="BNP PARIBAS" <?php echo $neftBankName=="BNP PARIBAS" ? 'selected' : ''?>>BNP PARIBAS</option>
											<option value="CANARA BANK" <?php echo $neftBankName=="CANARA BANK" ? 'selected' : ''?>>CANARA BANK</option>
											<option value="CAPITAL LOCAL AREA BANK LTD." <?php echo $neftBankName=="CAPITAL LOCAL AREA BANK LTD." ? 'selected' : ''?>>CAPITAL LOCAL AREA BANK LTD.</option>
											<option value="CATHOLIC SYRIAN BANK LTD" <?php echo $neftBankName=="CATHOLIC SYRIAN BANK LTD" ? 'selected' : ''?>>CATHOLIC SYRIAN BANK LTD</option>
											<option value="CENTRAL BANK OF INDIA" <?php echo $neftBankName=="CENTRAL BANK OF INDIA" ? 'selected' : ''?>>CENTRAL BANK OF INDIA</option>
											<option value="CHINATRUST COMMERCIAL BANK" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>CHINATRUST COMMERCIAL BANK</option>
											<option value="CITIBANK NA" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>CITIBANK NA</option>
											<option value="CITIZENCREDIT CO.OPERATIVE BANK LTD" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>CITIZENCREDIT CO.OPERATIVE BANK LTD</option>
											<option value="CITY UNION BANK LTD" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>CITY UNION BANK LTD</option>
											<option value="COMMONWEALTH BANK OF AUSTRALIA" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>COMMONWEALTH BANK OF AUSTRALIA</option>
											<option value="CORPORATION BANK" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>CORPORATION BANK</option>
											<option value="CREDIT AGRICOLE CORPORATE AND INVESTEMENT BANK" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>CREDIT AGRICOLE CORPORATE AND INVESTEMENT BANK</option>
											<option value="CREDIT SUISSE AG" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>CREDIT SUISSE AG</option>
											<option value="DBS BANK LTD" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>DBS BANK LTD</option>
											<option value="DENA BANK" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>DENA BANK</option>
											<option value="DEUTSCHE BANK" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>DEUTSCHE BANK</option>
											<option value="DEVELOPMENT CREDIT BANK LIMITED" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>DEVELOPMENT CREDIT BANK LIMITED</option>
											<option value="DHANLAXMI BANK LTD" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>DHANLAXMI BANK LTD</option>
											<option value="DICGC" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>DICGC</option>
											<option value="DOMBIVLI NAGARI SAHAKARI BANK LIMITED" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>DOMBIVLI NAGARI SAHAKARI BANK LIMITED</option>
											<option value="FIRSTRAND BANK LIMITED" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>FIRSTRAND BANK LIMITED</option>
											<option value="GURGAON GRAMIN BANK" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>GURGAON GRAMIN BANK</option>
											<option value="HDFC BANK LTD" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>HDFC BANK LTD</option>
											<option value="HSBC" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>HSBC</option>
											<option value="ICICI BANK LTD" <?php echo $neftBankName=="ICICI BANK LTD" ? 'selected' : ''?>>ICICI BANK LTD</option>
											<option value="IDBI BANK LTD" <?php echo $neftBankName=="IDBI BANK LTD" ? 'selected' : ''?>>IDBI BANK LTD</option>
											<option value="INDIAN BANK" <?php echo $neftBankName=="INDIAN BANK" ? 'selected' : ''?>>INDIAN BANK</option>
											<option value="INDIAN OVERSEAS BANK" <?php echo $neftBankName=="INDIAN OVERSEAS BANK" ? 'selected' : ''?>>INDIAN OVERSEAS BANK</option>
											<option value="INDUSIND BANK LTD" <?php echo $neftBankName=="INDUSIND BANK LTD" ? 'selected' : ''?>>INDUSIND BANK LTD</option>
											<option value="ING VYSYA BANK LTD" <?php echo $neftBankName=="ING VYSYA BANK LTD" ? 'selected' : ''?>>ING VYSYA BANK LTD</option>
											<option value="JALGAON JANATA SAHKARI BANK LTD" <?php echo $neftBankName=="JALGAON JANATA SAHKARI BANK LTD" ? 'selected' : ''?>>JALGAON JANATA SAHKARI BANK LTD</option>
											<option value="JANAKALYAN SAHAKARI BANK LTD" <?php echo $neftBankName=="JANAKALYAN SAHAKARI BANK LTD" ? 'selected' : ''?>>JANAKALYAN SAHAKARI BANK LTD</option>
											<option value="JANATA SAHAKARI BANK LTD (PUNE )" <?php echo $neftBankName=="JANATA SAHAKARI BANK LTD (PUNE )" ? 'selected' : ''?>>JANATA SAHAKARI BANK LTD (PUNE )</option>
											<option value="JP MORGAN CHASE BANK" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>JP MORGAN CHASE BANK</option>
											<option value="KALLAPPANNA AWADE ICH JANATA S BANK" <?php echo $neftBankName=="KALLAPPANNA AWADE ICH JANATA S BANK" ? 'selected' : ''?>>KALLAPPANNA AWADE ICH JANATA S BANK</option>
											<option value="KAPOLE CO OP BANK" <?php echo $neftBankName=="KAPOLE CO OP BANK" ? 'selected' : ''?>>KAPOLE CO OP BANK</option>
											<option value="KARNATAKA BANK LTD" <?php echo $neftBankName=="KARNATAKA BANK LTD" ? 'selected' : ''?>>KARNATAKA BANK LTD</option>
											<option value="KARUR VYSYA BANK" <?php echo $neftBankName=="KARUR VYSYA BANK" ? 'selected' : ''?>>KARUR VYSYA BANK</option>
											<option value="KOTAK MAHINDRA BANK" <?php echo $neftBankName=="KOTAK MAHINDRA BANK" ? 'selected' : ''?>>KOTAK MAHINDRA BANK</option>
											<option value="MAHANAGAR CO.OP BANK LTD" <?php echo $neftBankName=="MAHANAGAR CO.OP BANK LTD" ? 'selected' : ''?>>MAHANAGAR CO.OP BANK LTD</option>
											<option value="MAHARASHTRA STATE CO OPERATIVE BANK" <?php echo $neftBankName=="MAHARASHTRA STATE CO OPERATIVE BANK" ? 'selected' : ''?>>MAHARASHTRA STATE CO OPERATIVE BANK</option>
											<option value="MASHREQ BANK PSC" <?php echo $neftBankName=="MASHREQ BANK PSC" ? 'selected' : ''?>>MASHREQ BANK PSC</option>
											<option value="MIZUHO CORPORATE BANK LTD" <?php echo $neftBankName=="MIZUHO CORPORATE BANK LTD" ? 'selected' : ''?>>MIZUHO CORPORATE BANK LTD</option>
											<option value="MUMBAI DISTRICT CENTRAL CO.OP. BANK LTD." <?php echo $neftBankName=="MUMBAI DISTRICT CENTRAL CO.OP. BANK LTD." ? 'selected' : ''?>>MUMBAI DISTRICT CENTRAL CO.OP. BANK LTD.</option>
											<option value="NAGPUR NAGRIK SAHAKARI BANK LTD" <?php echo $neftBankName=="NAGPUR NAGRIK SAHAKARI BANK LTD" ? 'selected' : ''?>>NAGPUR NAGRIK SAHAKARI BANK LTD</option>
											<option value="NEW INDIA CO.OPERATIVE BANK LTD" <?php echo $neftBankName=="NEW INDIA CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>NEW INDIA CO.OPERATIVE BANK LTD</option>
											<option value="NKGSB CO.OP BANK LTD" <?php echo $neftBankName=="NKGSB CO.OP BANK LTD" ? 'selected' : ''?>>NKGSB CO.OP BANK LTD</option>
											<option value="NORTH MALABAR GRAMIN BANK" <?php echo $neftBankName=="NORTH MALABAR GRAMIN BANK" ? 'selected' : ''?>>NORTH MALABAR GRAMIN BANK</option>
											<option value="NUTAN NAGARIK SAHAKARI BANK LTD" <?php echo $neftBankName=="NUTAN NAGARIK SAHAKARI BANK LTD" ? 'selected' : ''?>>NUTAN NAGARIK SAHAKARI BANK LTD</option>
											<option value="OMAN INTERNATIONAL BANK SAOG" <?php echo $neftBankName=="OMAN INTERNATIONAL BANK SAOG" ? 'selected' : ''?>>OMAN INTERNATIONAL BANK SAOG</option>
											<option value="ORIENTAL BANK OF COMMERCE" <?php echo $neftBankName=="ORIENTAL BANK OF COMMERCE" ? 'selected' : ''?>>ORIENTAL BANK OF COMMERCE</option>
											<option value="PARSIK JANATA SAHAKARI BANK LTD" <?php echo $neftBankName=="PARSIK JANATA SAHAKARI BANK LTD" ? 'selected' : ''?>>PARSIK JANATA SAHAKARI BANK LTD</option>
											<option value="PRATHAMA BANK" <?php echo $neftBankName=="PRATHAMA BANK" ? 'selected' : ''?>>PRATHAMA BANK</option>
											<option value="PRIME CO OPERATIVE BANK LTD" <?php echo $neftBankName=="PRIME CO OPERATIVE BANK LTD" ? 'selected' : ''?>>PRIME CO OPERATIVE BANK LTD</option>
											<option value="PUNJAB AND MAHARASHTRA CO OP BANK LTD" <?php echo $neftBankName=="PUNJAB AND MAHARASHTRA CO OP BANK LTD" ? 'selected' : ''?>>PUNJAB AND MAHARASHTRA CO OP BANK LTD</option>
											<option value="PUNJAB AND SIND BANK" <?php echo $neftBankName=="PUNJAB AND SIND BANK" ? 'selected' : ''?>>PUNJAB AND SIND BANK</option>
											<option value="PUNJAB NATIONAL BANK" <?php echo $neftBankName=="PUNJAB NATIONAL BANK" ? 'selected' : ''?>>PUNJAB NATIONAL BANK</option>
											<option value="RABOBANK INTERNATIONAL (CCRB)" <?php echo $neftBankName=="RABOBANK INTERNATIONAL (CCRB)" ? 'selected' : ''?>>RABOBANK INTERNATIONAL (CCRB)</option>
											<option value="RAJKOT NAGARIK SAHAKARI BANK LTD" <?php echo $neftBankName=="RAJKOT NAGARIK SAHAKARI BANK LTD" ? 'selected' : ''?>>RAJKOT NAGARIK SAHAKARI BANK LTD</option>
											<option value="RESERVE BANK OF INDIA" <?php echo $neftBankName=="RESERVE BANK OF INDIA" ? 'selected' : ''?>>RESERVE BANK OF INDIA</option>
											<option value="SBERBANK" <?php echo $neftBankName=="SBERBANK" ? 'selected' : ''?>>SBERBANK</option>
											<option value="SHINHAN BANK" <?php echo $neftBankName=="SHINHAN BANK" ? 'selected' : ''?>>SHINHAN BANK</option>
											<option value="SHRI CHHATRAPATI RAJARSHI SHAHU URBAN CO.OP BANK LTD" <?php echo $neftBankName=="SHRI CHHATRAPATI RAJARSHI SHAHU URBAN CO.OP BANK LTD" ? 'selected' : ''?>>SHRI CHHATRAPATI RAJARSHI SHAHU URBAN CO.OP BANK LTD</option>
											<option value="SOCIETE GENERALE" <?php echo $neftBankName=="SOCIETE GENERALE" ? 'selected' : ''?>>SOCIETE GENERALE</option>
											<option value="SOUTH INDIAN BANK" <?php echo $neftBankName=="SOUTH INDIAN BANK" ? 'selected' : ''?>>SOUTH INDIAN BANK</option>
											<option value="STANDARD CHARTERED BANK" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>STANDARD CHARTERED BANK</option>
											<option value="STATE BANK OF BIKANER AND JAIPUR" <?php echo $neftBankName=="STATE BANK OF BIKANER AND JAIPUR" ? 'selected' : ''?>>STATE BANK OF BIKANER AND JAIPUR</option>
											<option value="STATE BANK OF HYDERABAD" <?php echo $neftBankName=="STATE BANK OF HYDERABAD" ? 'selected' : ''?>>STATE BANK OF HYDERABAD</option>
											<option value="STATE BANK OF INDIA" <?php echo $neftBankName=="STATE BANK OF INDIA" ? 'selected' : ''?>>STATE BANK OF INDIA</option>
											<option value="STATE BANK OF MAURITIUS LTD" <?php echo $neftBankName=="STATE BANK OF MAURITIUS LTD" ? 'selected' : ''?>>STATE BANK OF MAURITIUS LTD</option>
											<option value="STATE BANK OF MYSORE" <?php echo $neftBankName=="STATE BANK OF MYSORE" ? 'selected' : ''?>>STATE BANK OF MYSORE</option>
											<option value="STATE BANK OF PATIALA" <?php echo $neftBankName=="STATE BANK OF PATIALA" ? 'selected' : ''?>>STATE BANK OF PATIALA</option>
											<option value="STATE BANK OF TRAVANCORE" <?php echo $neftBankName=="STATE BANK OF TRAVANCORE" ? 'selected' : ''?>>STATE BANK OF TRAVANCORE</option>
											<option value="SYNDICATE BANK" <?php echo $neftBankName=="SYNDICATE BANK" ? 'selected' : ''?>>SYNDICATE BANK</option>
											<option value="TAMILNAD MERCANTILE BANK LTD" <?php echo $neftBankName=="TAMILNAD MERCANTILE BANK LTD" ? 'selected' : ''?>>TAMILNAD MERCANTILE BANK LTD</option>
											<option value="THANE BHARAT SAHAKARI BANK LTD" <?php echo $neftBankName=="THANE BHARAT SAHAKARI BANK LTD" ? 'selected' : ''?>>THANE BHARAT SAHAKARI BANK LTD</option>
											<option value="THE A.P. MAHESH CO.OP URBAN BANK LTD." <?php echo $neftBankName=="THE A.P. MAHESH CO.OP URBAN BANK LTD." ? 'selected' : ''?>>THE A.P. MAHESH CO.OP URBAN BANK LTD.</option>
											<option value="THE AHMEDABAD MERCANTILE CO.OPERATIVE BANK LTD" <?php echo $neftBankName=="THE AHMEDABAD MERCANTILE CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE AHMEDABAD MERCANTILE CO.OPERATIVE BANK LTD</option>
											<option value="THE BANK OF NOVA SCOTIA" <?php echo $neftBankName=="THE BANK OF NOVA SCOTIA" ? 'selected' : ''?>>THE BANK OF NOVA SCOTIA</option>
											<option value="THE BHARAT CO.OPERATIVE BANK (MUMBAI) LTD" <?php echo $neftBankName=="THE BHARAT CO.OPERATIVE BANK (MUMBAI) LTD" ? 'selected' : ''?>>THE BHARAT CO.OPERATIVE BANK (MUMBAI) LTD</option>
											<option value="THE COSMOS CO.OPERATIVE BANK LTD" <?php echo $neftBankName=="THE COSMOS CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE COSMOS CO.OPERATIVE BANK LTD</option>
											<option value="THE FEDERAL BANK LTD" <?php echo $neftBankName=="THE FEDERAL BANK LTD" ? 'selected' : ''?>>THE FEDERAL BANK LTD</option>
											<option value="THE GREATER BOMBAY CO.OP BANK LTD" <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>THE GREATER BOMBAY CO.OP BANK LTD</option>
											<option value="THE GUJARAT STATE CO.OPERATIVE BANK LTD" <?php echo $neftBankName=="THE GUJARAT STATE CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE GUJARAT STATE CO.OPERATIVE BANK LTD</option>
											<option value="THE JAMMU AND KASHMIR BANK LTD" <?php echo $neftBankName=="THE JAMMU AND KASHMIR BANK LTD" ? 'selected' : ''?>>THE JAMMU AND KASHMIR BANK LTD</option>
											<option value="THE KALUPUR COMMERCIAL CO OP BANK LTD" <?php echo $neftBankName=="THE KALUPUR COMMERCIAL CO OP BANK LTD" ? 'selected' : ''?>>THE KALUPUR COMMERCIAL CO OP BANK LTD</option>
											<option value="THE KALYAN JANATA SAHAKARI BANK LTD" <?php echo $neftBankName=="THE KALYAN JANATA SAHAKARI BANK LTD" ? 'selected' : ''?>>THE KALYAN JANATA SAHAKARI BANK LTD</option>
											<option value="THE KANGRA CENTRAL CO.OP BANK LIMITED" <?php echo $neftBankName=="THE KANGRA CENTRAL CO.OP BANK LIMITED" ? 'selected' : ''?>>THE KANGRA CENTRAL CO.OP BANK LIMITED</option>
											<option value="THE KARAD URBAN CO.OP BANK LTD" <?php echo $neftBankName=="THE KARAD URBAN CO.OP BANK LTD" ? 'selected' : ''?>>THE KARAD URBAN CO.OP BANK LTD</option>
											<option value="THE KARNATAKA STATE APEX COOP. BANK LTD" <?php echo $neftBankName=="THE KARNATAKA STATE APEX COOP. BANK LTD" ? 'selected' : ''?>>THE KARNATAKA STATE APEX COOP. BANK LTD</option>
											<option value="THE LAKSHMI VILAS BANK LTD" <?php echo $neftBankName=="THE LAKSHMI VILAS BANK LTD" ? 'selected' : ''?>>THE LAKSHMI VILAS BANK LTD</option>
											<option value="THE MEHSANA URBAN COOPERATIVE BANK LTD" <?php echo $neftBankName=="THE MEHSANA URBAN COOPERATIVE BANK LTD" ? 'selected' : ''?>>THE MEHSANA URBAN COOPERATIVE BANK LTD</option>
											<option value="THE MUNICIPAL CO OPERATIVE BANK LTD MUMBAI" <?php echo $neftBankName=="THE MUNICIPAL CO OPERATIVE BANK LTD MUMBAI" ? 'selected' : ''?>>THE MUNICIPAL CO OPERATIVE BANK LTD MUMBAI</option>
											<option value="THE NAINITAL BANK LIMITED" <?php echo $neftBankName=="THE NAINITAL BANK LIMITED" ? 'selected' : ''?>>THE NAINITAL BANK LIMITED</option>
											<option value="THE NASHIK MERCHANTS CO.OP BANK LTD., NASHIK" <?php echo $neftBankName=="THE NASHIK MERCHANTS CO.OP BANK LTD., NASHIK" ? 'selected' : ''?>>THE NASHIK MERCHANTS CO.OP BANK LTD., NASHIK</option>
											<option value="THE RAJASTHAN STATE COOPERATIVE BANK LTD." <?php echo $neftBankName=="THE RAJASTHAN STATE COOPERATIVE BANK LTD." ? 'selected' : ''?>>THE RAJASTHAN STATE COOPERATIVE BANK LTD.</option>
											<option value="THE RATNAKAR BANK LTD" <?php echo $neftBankName=="THE RATNAKAR BANK LTD" ? 'selected' : ''?>>THE RATNAKAR BANK LTD</option>
											<option value="THE ROYAL BANK OF SCOTLAND NV" <?php echo $neftBankName=="THE ROYAL BANK OF SCOTLAND NV" ? 'selected' : ''?>>THE ROYAL BANK OF SCOTLAND NV</option>
											<option value="THE SARASWAT CO.OPERATIVE BANK LTD" <?php echo $neftBankName=="THE SARASWAT CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE SARASWAT CO.OPERATIVE BANK LTD</option>
											<option value="THE SHAMRAO VITHAL CO.OPERATIVE BANK LTD" <?php echo $neftBankName=="THE SHAMRAO VITHAL CO.OPERATIVE BANK LTD" ? 'selected' : ''?>>THE SHAMRAO VITHAL CO.OPERATIVE BANK LTD</option>
											<option value="THE SURAT DISTRICT CO OPERATIVE BANK LTD." <?php echo $neftBankName=="THE SURAT DISTRICT CO OPERATIVE BANK LTD." ? 'selected' : ''?>>THE SURAT DISTRICT CO OPERATIVE BANK LTD.</option>
											<option value="THE SURAT PEOPLES CO.OP BANK LTD" <?php echo $neftBankName=="THE SURAT PEOPLES CO.OP BANK LTD" ? 'selected' : ''?>>THE SURAT PEOPLES CO.OP BANK LTD</option>
											<option value="THE SUTEX CO.OP. BANK LTD." <?php echo $neftBankName=="THE SUTEX CO.OP. BANK LTD." ? 'selected' : ''?>>THE SUTEX CO.OP. BANK LTD.</option>
											<option value="THE TAMILNADU STATE APEX COOPERATIVE BANK LIMITED" <?php echo $neftBankName=="THE TAMILNADU STATE APEX COOPERATIVE BANK LIMITED" ? 'selected' : ''?>>THE TAMILNADU STATE APEX COOPERATIVE BANK LIMITED</option>
											<option value="THE THANE JANATA SAHAKARI BANK LTD" <?php echo $neftBankName=="THE THANE JANATA SAHAKARI BANK LTD" ? 'selected' : ''?>>THE THANE JANATA SAHAKARI BANK LTD</option>
											<option value="THE VARACHHA CO.OP. BANK LTD." <?php echo $neftBankName=="THE VARACHHA CO.OP. BANK LTD." ? 'selected' : ''?>>THE VARACHHA CO.OP. BANK LTD.</option>
											<option value="THE WEST BENGAL STATE COOPERATIVE BANK LTD" <?php echo $neftBankName=="THE WEST BENGAL STATE COOPERATIVE BANK LTD" ? 'selected' : ''?>>THE WEST BENGAL STATE COOPERATIVE BANK LTD</option>
											<option value="TUMKUR GRAIN MERCHANTS COOPERATIVE BANK LTD.," <?php echo $neftBankName=="BANK OF INDIA" ? 'selected' : ''?>>TUMKUR GRAIN MERCHANTS COOPERATIVE BANK LTD.,</option>
											<option value="UBS AG" <?php echo $neftBankName=="UBS AG" ? 'selected' : ''?>>UBS AG</option>
											<option value="UCO BANK" <?php echo $neftBankName=="UCO BANK" ? 'selected' : ''?>>UCO BANK</option>
											<option value="UNION BANK OF INDIA" <?php echo $neftBankName=="UNION BANK OF INDIA" ? 'selected' : ''?>>UNION BANK OF INDIA</option>
											<option value="UNITED BANK OF INDIA" <?php echo $neftBankName=="UNITED BANK OF INDIA" ? 'selected' : ''?>>UNITED BANK OF INDIA</option>
											<option value="VIJAYA BANK" <?php echo $neftBankName=="VIJAYA BANK" ? 'selected' : ''?>>VIJAYA BANK</option>
											<option value="WOORI BANK" <?php echo $neftBankName=="WOORI BANK" ? 'selected' : ''?>>WOORI BANK</option>
											<option value="YES BANK LTD" <?php echo $neftBankName=="YES BANK LTD" ? 'selected' : ''?>>YES BANK LTD</option>
										</select>
										-->
										<span class="input-group-addon"> <i class="fa fa-university"></i> </span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									NEFT/RTGS Account No <span class="required-field">*</span>
								</label>
								<div class="col-sm-7">
									<input type="text" placeholder="NEFT/RTGS Account No" id="neft_ac_no" class="form-control" name="neft_ac_no" value="<?php echo !empty($customerPayment['neft_ac_no']) ? $customerPayment['neft_ac_no'] : '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									NEFT/RTGS IFSC Code <span class="required-field">*</span>
								</label>
								<div class="col-sm-7">
									<input type="text" placeholder="NEFT/RTGS IFSC Code" id="neft_ifsc_code" class="form-control" name="neft_ifsc_code" value="<?php echo !empty($customerPayment['neft_ifsc_code']) ? $customerPayment['neft_ifsc_code'] : '' ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-field-1">
									NEFT/RTGS Holder Name <span class="required-field">*</span>
								</label>
								<div class="col-sm-7">
									<div class="input-group">
										<input type="text" placeholder="NEFT/RTGS Holder Name" id="neft_holder_name" class="form-control" name="neft_holder_name" value="<?php echo !empty($customerPayment['neft_holder_name']) ? $customerPayment['neft_holder_name'] : '' ?>">
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
									<input type="text" placeholder="Amount" id="amount" class="form-control" name="amount" value="<?php echo !empty($cashierPayment['amount']) ? $cashierPayment['amount'] : '';?>">
									<span class="input-group-addon"> <i class="fa fa-rupee"></i> </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Amount In Word 
							</label>
							<div class="col-sm-7">
								<input type="text" placeholder="Amount In Word" id="amount_in_word" class="form-control" name="amount_in_word" value="<?php echo !empty($cashierPayment['amount_in_word']) ? $cashierPayment['amount_in_word'] : '' ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Remark
							</label>
							<div class="col-sm-7">
								<textarea placeholder="Remark" id="remark" class="form-control" name="remark"><?php echo !empty($cashierPayment['remark']) ? $cashierPayment['remark'] : '' ?></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-9">
								<?php if($type=="cashier_add"){?>
								<input type="submit" class="btn btn-success btn-squared" value="Save">
								<?php }else{ ?>
								<input type="submit" class="btn btn-info btn-squared" value="Update">
								<?php }?>
								<a href="cashier_extra_list.php" class="btn btn-danger btn-squared">Cancel</a>
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
// Main Date
$(".currentDate").datepicker({
	format: "dd-mm-yyyy",
	//startDate: '1d',
	autoclose: true
});

// Exchange Button Click
$("#payment_type").change(function(){
	var exchange = $(this).val();
	if(exchange=="exchange"){
		$(".exchange_open").show();
	}else{
		$(".exchange_open").hide();
	}
});

// Payment Type Radio Button Click
$("input[name='cash_type']").change(function(){
	var cash_type = $(this).val();
	if(cash_type=="Cheque"){
		$(".by_case_cheque").show();
		$(".by_case_dd, .by_case_neft").hide();
	}else if(cash_type=="DD"){
		$(".by_case_dd").show();
		$(".by_case_cheque, .by_case_neft").hide();
	}else if(cash_type=="NEFT"){
		$(".by_case_neft").show();
		$(".by_case_dd, .by_case_cheque").hide();
	}else{
		$(".by_case_dd, .by_case_cheque, .by_case_neft").hide();
	}
});

// Cheque Date
$("#cheque_date, #dd_date").datepicker({
	format: "dd-mm-yyyy",
	//startDate: '1d',
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
// Amount Total to pending Amount
$("#amount").keyup(function(){
	var price = $(this).val().length!=0 ? $(this).val() : 0;
	// word in amount
	$("#amount_in_word").val(test_skill(price));
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