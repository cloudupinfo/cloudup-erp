<?php 
if((isset($_REQUEST['aid']) && !empty($_REQUEST['aid'])) && (isset($_REQUEST['type']) && !empty($_REQUEST['type']))){
	$id = $_REQUEST['aid'];
	$print_type = $_REQUEST['type'];
}else{
	header('Location:../dashboard.php');
	exit();
}

/****************************************************************************
    included files
****************************************************************************/
include('includes/classess/invoicr.php');
include('includes/common-functions.php');
include('includes/thumbnail.php');

include_once('../config/PDO.php');
$db = new db();

// find customer detail
$cashExtra = $db->getRow("SELECT * FROM `cashier` where `cashier_id`=?",array($id));

/****************************************************************************
    header post
****************************************************************************/
$title = 'Cash Reciept';
$invocieNo = str_pad($cashExtra['cashier_id'], 3, "0", STR_PAD_LEFT)."-O";
$billingDate = date("d-m-Y h:i A",strtotime($cashExtra['updated_at']));
$dueDate = date("h:i A",strtotime($cashExtra['updated_at']));


/****************************************************************************
    From post
****************************************************************************/
$frmBizName = 'XYZ Moto (GUJ) Pvt. Ltd.';
$frmAddress1 = '150 Feet Road,';
$frmAddress2 = 'Rajkot, Gujarat - 360003';
$frmPhone = '(0281) 1234567';
$frmEmail = 'vijay.syntego@gmail.com';
$frmAddInfo = isset($_POST['frmAddInfo']) ? $_POST['frmAddInfo'] : '';


/****************************************************************************
    To post
****************************************************************************/
$toBizName = !empty($cashExtra['type']) ? ucfirst($cashExtra['type']) : 'Other';
$toAddress1 = !empty($cashExtra['remark']) ? $cashExtra['remark'] : '';
// Find Exchange Vehicle No Find
if($cashExtra['type']=="exchange"){
	$exchangeData = $db->getRow("SELECT * FROM `exchange` where `product_id`=?",array($cashExtra['product_id']));
	$toAddress2 = $exchangeData['veihicle_no'];
}else{
	$toAddress2 = '';
}
$toPhone = '';
$toEmail = '';
$toAddInfo = '';


/****************************************************************************
    Settings post
****************************************************************************/
$currency = 'Rs.';
$taxformat = isset($_POST['taxformat']) ? $_POST['taxformat'] : 'off';
$discountFormat = isset($_POST['discountFormat']) ? $_POST['discountFormat'] : 'off';
$pdfColor  = isset($_POST['pdfColor']) ? $_POST['pdfColor'] : '#000000';
$subtotal = isset($_POST['subtotal']) ? $_POST['subtotal'] : '';
$totalBill = !empty($cashExtra['amount']) ? $cashExtra['amount'] : '0';




/****************************************************************************
    items listing
****************************************************************************/
$titleName = $proDesc = array();

$titleName[] = $cashExtra['cash_type'];
if($cashExtra['cash_type']=="Cheque"){
	$paymentCase = "Payment Type = ".$cashExtra['cash_type']."<br>";
	$paymentCase .= "Bank Name = ".$cashExtra['bank_name']."<br>";
	$paymentCase .= "Cheque No = ".$cashExtra['cheque_no']."<br>";
	$paymentCase .= "Cheque Date = ".$cashExtra['cheque_date']."<br>";
}else if($cashExtra['cash_type']=="DD"){
	$paymentCase = "Payment Type = ".$cashExtra['cash_type']."<br>";
	$paymentCase .= "Bank Name = ".$cashExtra['dd_bank_name']."<br>";
	$paymentCase .= "DD No = ".$cashExtra['dd_no']."<br>";
	$paymentCase .= "DD Date = ".$cashExtra['dd_date']."<br>";
}else if($cashExtra['cash_type']=="NEFT"){
	$paymentCase = "Payment Type = ".$cashExtra['cash_type']."<br>";
	$paymentCase .= "Bank Name = ".$cashExtra['neft_bank_name']."<br>";
	$paymentCase .= "Account No = ".$cashExtra['neft_ac_no']."<br>";
	$paymentCase .= "IFSC Code = ".$cashExtra['neft_ifsc_code']."<br>";
	$paymentCase .= "Holder Name = ".$cashExtra['neft_holder_name']."<br>";
}else{
	$paymentCase = "Payment Type = ".$cashExtra['cash_type']."<br>";
}
$proDesc[] = $paymentCase;
$amountPay[] = $cashExtra['cash_type'];
$vatPay[] = "no";
$datePay[] = date("d-m-Y",strtotime($cashExtra['created_at']));
$pricePay[] = $cashExtra['amount'];
$discountPay[] = "";
$finalTotal = $cashExtra['amount'];


$proName  = $titleName;
$proDescArray = $proDesc;
$amountArray = $amountPay;
$vatArray = $vatPay;
$priceArray = $datePay;
$discountArray = $discountPay;
$totalArray = $pricePay;

/****************************************************************************
    pdf generate
****************************************************************************/

//Set default date timezone
date_default_timezone_set('Asia/Kolkata');

//Create a new instance
$invoice = new invoicr("A4",$currency,"en");

//Set number format
$invoice->setNumberFormat(',',' ');

//Set tax format
$invoice->setTaxFormat($taxformat);

//Set tax format
$invoice->setDiscountFormat($discountFormat);

//Set your logo
if(isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != '')
{
    $imagePath =  'uploads/'.$_FILES["image"]["name"];
    moveUplaod('uploads');
    $invoice->setLogo($imagePath,180,100);
}
//$imagePath =  "../".BARCODE_PATH_DISPLAY.$product['barcode_imgPath'];
$imagePath =  "uploads/main-logo.png";
$invoice->setLogo($imagePath,120,80);

//Set theme color
$invoice->setColor($pdfColor);

//Set type
$invoice->setType($title);

//Set reference
$invoice->setReference($invocieNo);

//Set date

$billingDate = date('d-m-Y');
$invoice->setDate($billingDate);
//Set  due date
$invoice->setDue(date('h:i A'));

//Set from
$invoice->setFrom(array($frmBizName,$frmAddress1,$frmAddress2,$frmPhone,$frmEmail,$frmAddInfo));

//Set to
$invoice->setTo(array($toBizName,$toAddress1,$toAddress2,$toPhone,$toEmail,$toAddInfo));

foreach( $proName as $key => $productName )
{
	$proDes =$proDescArray[$key];
    $amount =$amountArray[$key];
    $price =$priceArray[$key];
    if(!empty($applyDiscount))
    {
        $discount =$discountArray[$key];
    }
    else
    {
        $discount = false;
    }
    
    $vat = false;
    
    $total =$totalArray[$key];
    $invoice->addItem($productName,$proDes,$amount,$vat,$price,$discount,$total);
}

//Add totals
$invoice->addTotal("Sub Total",$finalTotal);

//add taxes
if(isset($_POST['taxTitle']) || isset($_POST['taxValue']))
{
    $taxTitle  = $_POST['taxTitle'];
    $taxValueArray = $_POST['taxValue'];
    foreach( $taxTitle as $key => $title )
    {
        $taxValue = $taxValueArray[$key];
        $invoice->addTotal($title,$taxValue);
    }
}
// Final Total
$invoice->addTotal("Total",$finalTotal,true);

$addBadge = $print_type;
if($addBadge != ''){
    //Add badge
    $invoice->addBadge($addBadge);
}

//Add signature
$sig_name = "Authorize Person";
$sig_designation = "Cashier";
$invoice->setSigName($sig_name);
$invoice->setSigDesig($sig_designation);

$noteTitle = 'Important Notes';
//Add title
$invoice->addTitle($noteTitle);

$extraNotes = '1. If Booking Will Be Cancelled In Any Circumstances. <br> 2. The Money Will Be Refunded In Cheque From Within 15 Days. <br> 3. Cheque Cancellation Charge Will be Paid by User.';
//Add paragraph
$invoice->addParagraph($extraNotes);

//Set footernote
$invoice->setFooternote("");

//Render
$invoice->render();