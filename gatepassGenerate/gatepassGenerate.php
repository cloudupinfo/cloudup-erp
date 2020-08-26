<?php
if((isset($_REQUEST['aid']) && !empty($_REQUEST['aid'])) && (isset($_REQUEST['type']) && !empty($_REQUEST['type']))){
	$id = $_REQUEST['aid'];
	$print_type = $_REQUEST['type'];
}else{
	header('Location:../gatepass.php');
	exit();
}
include_once('../config/PDO.php');
$db = new db();

$gatepass = $db->getRow("SELECT * FROM `gatepass` where `gatepass_id`=?",array($id));
if(!empty($gatepass))
{
	$product = $db->getRow("SELECT * FROM `product` where `product_id`=?",array($gatepass['product_id']));
	if(!empty($product))
	{
		// Branch Start Check Branch or not
		if($product['branch_id']!=0){
			$branch = $db->getRow("SELECT * FROM `branch` where `branch_id`=?",array($product['branch_id']));
		}
		$customer = $db->getRow("SELECT * FROM `customer_detail` where `product_id`=?",array($gatepass['product_id']));
		if(!empty($customer))
		{
			$salesman = $db->getRow("SELECT * FROM `salesman` where `salesman_id`=?",array($customer['salesman_id']));
			$customerPayment = $db->getRows("SELECT * FROM `customer_payment` where `customer_detail_id`=?",array($gatepass['customer_detail_id']));
			// product price
			$productPrice = $db->getRow("SELECT * FROM `product_price` where `product_id`=?",array($gatepass['product_id']));
			// advance booking price
			$advancePrice = $db->getRow("SELECT * FROM `advance` where `advance_id`=?",array($productPrice['advance_id']));
			// Advance Booking Payment
			$advancePayment = $db->getRows("SELECT * FROM `advance_payment` where `advance_id`=?",array($advancePrice['advance_id']));
			$advancePaymentPrice = 0;
			foreach($advancePayment as $advancePaymentValue){
				$advancePaymentPrice += $advancePaymentValue['price'];
			}
			// exchange amount
			$exchange = $db->getRow("SELECT * FROM `exchange` where `customer_detail_id`=?",array($customer['customer_detail_id']));
			// finance amount
			$finance = $db->getRow("SELECT * FROM `finance` where `product_id`=?",array($customer['product_id']));
		}else{
			header('Location:../dashboard.php');
		}
	}else{
		header('Location:../dashboard.php');
	}
}else{
	header('Location:../dashboard.php');
}
// Product Price Add
$rto = explode("/",$productPrice['rto']);
$ins = explode("/",$productPrice['insurance']);

if(!empty($exchange)){
	$exchangePrint = '';
	$exchangePrint .= "Exchange - : Rs. ".$exchange['amount'];
	$exchangePrint .= " - ".$exchange['veihicle_no'];
	$exchangePrint .= '<br>';
}else{
	$exchangePrint = '';
}
if(!empty($finance)){
	$financePrint = "Finance Rs. ".$finance['finance_amount'];
	$financePrint .= " DP Rs. ".$finance['dp_amount']." / HTP 200";
	$financePrint .= " ".$finance['bank'];
	$financePrint .= "<br>";
}else{
	$financePrint = '';
}
// No RTO Add 550 CRTM
if(strtolower($rto[0])=="no"){
	$noRTOPrint = "CRTM : 550 <br>";
}else{
	$noRTOPrint = "";
}
$gatepass_id = str_pad($gatepass['gatepass_id'], 3, "0", STR_PAD_LEFT);
$created_at = date("d-m-Y h:i A",strtotime($gatepass['created_at']));
$name = $customer['name'];
$address = $customer['street_add1']." ".$customer['street_add2'];
$mobile = $customer['mobile'];
$chassis_no = $product['chassis_no'];
$eng_no = $product['eng_no'].", Key No-".$product['key_no'];
$model = $product['model'];
$color = $product['color'];
$remark = $customer['remark'];
$sale_name = $salesman['name'];
$barcode = "../".BARCODE_PATH_DISPLAY.$product['barcode_imgPath'];
// Branch
if(!empty($branch)){
	$branchPrint = '';
	$branchPrint .= "Branch : ".$branch['name'];
	$branchPrint .= '<br>';
}else{
	$branchPrint = '';
}
if($productPrice['discount']>1){
	$discount = "Discount Rs. ".$productPrice['discount'];
	$discount .= "<br>";
}else{
	$discount = "";
}
$customer_detail_id = str_pad($customer['customer_detail_id'], 3, "0", STR_PAD_LEFT);
$caseType = "";
$casePrice = 0;
foreach($customerPayment as $value){
	$caseType .= $value['case_type']."-";
	if($value['case_type']=="Cheque"){
		$caseType .= $value['bank_name']." ".$value['cheque_no']." ".$value['cheque_date'];
	}else if($value['case_type']=="DD"){
		$caseType .= $value['dd_bank_name']." ".$value['dd_no']." ".$value['dd_date'];
	}else if($value['case_type']=="NEFT"){
		$caseType .= $value['neft_ac_no']." ".$value['neft_bank_name']." ".$value['neft_holder_name'];
	}
	$casePrice += $value['price'];
}
$finalTotal = 0;
$finalTotal = $finalTotal+$productPrice['price'];
// Add Vat And tax
$vat = 15;
$add = 2.5;
$vatPriceTotal = explode('.',($finalTotal*$vat)/100);
//$addPriceTotal = ($finalTotal*$add)/100;

$finalTotal = $finalTotal+$vatPriceTotal[0];

// Add finance tax finanly remove
if(!empty($finance)){
	$finalTotal = $finalTotal+200;
}

if($rto[1]<=0){
	//$finalTotal = $finalTotal+550;
}
$finalTotal = $finalTotal+$rto[1]+$ins[1];

$finalTotal = $finalTotal+$productPrice['amc']+$productPrice['no_plate_fitting']+$productPrice['rmc_tax']+$productPrice['ex_warranty'];

$assesiriusTotal = $productPrice['side_stand']+$productPrice['foot_rest']+$productPrice['leg_guard']+$productPrice['chrome_set']+0;

$vatAssTotal = explode('.',($assesiriusTotal*$vat)/100);
//$addAssTotal = ($assesiriusTotal*$add)/100;

$assFullTotal = $assesiriusTotal+$vatAssTotal[0];
// accesiry vat
$finalTotal = $finalTotal+$assFullTotal;

// Minus exchange amount
if(strtolower($productPrice['exchange_finance'])=="yes"){
	$finalTotal = $finalTotal;
}else{
	if(!empty($exchange)){
		$finalTotal = $finalTotal-$exchange['amount'];
	}
}
// Minus DD Finance amount
if(strtolower($productPrice['dd_finance'])=="yes"){
	$finalTotal = $finalTotal;
}else{
	// Minus finance amount
	if(!empty($finance)){
		$finalTotal = $finalTotal-$finance['finance_amount'];
	}
}
// Advance Booking is DP then dont minus advance price
if(strtolower($productPrice['advance_dp'])!="yes")
{
	// Minus advance amount
	if(!empty($advancePrice)){
		$finalTotal = $finalTotal-$advancePaymentPrice;
	}
}
// Discount
$finalTotal -= $productPrice['discount'];

// Pending 
$finalTotal -= $productPrice['pending'];

$finalTotal = number_format($finalTotal,2,'.',',');
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('XYZ Moto(Guj.) Pvt. Ltd.');
$pdf->SetTitle('XYZ Moto(Guj.) Pvt. Ltd.');
$pdf->SetSubject('GATE PASS');
//$pdf->SetKeywords('Gate Pass, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(false);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, "20", PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,0,0), array(0,0,0));
$pdf->setFooterData(array(0,0,0), array(0,0,0));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(false, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists('lang/eng.php')) {
	require_once('lang/eng.php');
	$pdf->setLanguageArray($l);
}

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 12, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('L','A5');
//$pdf->AddPage('A','A4');

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
$var =  "XYZ Moto(Guj.) Pvt. Ltd.";
// Set some content to print
$html = <<<EOD
<h2 style="text-align:center;margin:0pt;">GATE PASS - $gatepass_id <img src="$barcode"/></h2>
<h5 style="margin:0px;text-align:right;">Date - $created_at</h5>
$branchPrint
Name of Customer : <u>$name</u><br>
Address : $address<br>
Mobile No. : <u>$mobile</u><br>
Salesman Name. : <u>$sale_name</u><br>
Chasis No. : <b><u>$chassis_no</u></b><br>
Engine No. : <u>$eng_no</u>
Model - Color : <u>$model - $color</u><br>
$exchangePrint
$financePrint
$discount
$noRTOPrint
Cash/credit Amount/Cheque : <u>$caseType</u><br>
Amount : <u>Rs. $finalTotal </u><br>
Cash Receipt No. : <u>$customer_detail_id</u> 
Remark : <u>$remark</u>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('generateGatepass.pdf', 'I');