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

$dealer = $db->getRow("SELECT * FROM `dealer` where `dealer_id`=?",array($id));
$product = $db->getRow("SELECT * FROM `product` where `product_id`=?",array($dealer['product_id']));
if(!empty($product)){
	// Update Main Product page in status 1 mins bill genareted
	$update = $db->updateRow("update `product` set `status`=?,`sale`=?,`updated_at`=NOW() where `product_id`=?",array(3,0,$product['product_id']));
}
$gatepass_id = str_pad($dealer['dealer_id'], 3, "0", STR_PAD_LEFT)."-D";
$created_at = date("d-m-Y h:i A",strtotime($dealer['created_at']));
$name = $dealer['name'];
$mobile = "";
$chassis_no = $product['chassis_no'];
$eng_no = $product['eng_no'];
$model = $product['model'];
$color = $product['color'];
$remark = $dealer['remark'];

$barcode = "../".BARCODE_PATH_DISPLAY.$product['barcode_imgPath'];

$casePrice = $dealer['price']+$dealer['price']*15/100;
$casePrice = number_format($casePrice,2,'.',',');
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
//$pdf->setPrintHeader(false);
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
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('L','A5');
//$pdf->AddPage('A','A4');

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
$var =  "XYZ Moto(Guj.) Pvt. Ltd.";
// Set some content to print
$html = <<<EOD
<h1 style="text-align:center;">GATE PASS - $gatepass_id <img src="$barcode"></h1>
<h5 style="margin:0px;text-align:right;">Date - $created_at</h5>
Name of Dealer : <u>$name</u><br>
Chasis No. : <b><u>$chassis_no</u></b><br>
Engine No. : <u>$eng_no</u><br>
Model - Color : <u>$model - $color</u><br>
Amount : <u>Rs. $casePrice </u><br>
Remark : <u>$remark</u>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('generateGatepass.pdf', 'I');