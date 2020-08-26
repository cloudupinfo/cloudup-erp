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
$advanceBooking = $db->getRow("SELECT * FROM `advance` where `advance_id`=?",array($id));
//Vehicle Model
$veihicle = $db->getRow("SELECT * FROM `veihicle` where `veihicle_id`=?",array($advanceBooking['model']));
// find salesman name
$salesman = $db->getRow("SELECT * FROM `salesman` where `salesman_id`=?",array($advanceBooking['salesman_id']));
// Customer Advance Payment
$advancePayment = $db->getRows("SELECT * FROM `advance_payment` where `advance_id`=?",array($advanceBooking['advance_id']));
/****************************************************************************
    header post
****************************************************************************/
$title = 'Cash Reciept';
$invocieNo = str_pad($advanceBooking['advance_id'], 3, "0", STR_PAD_LEFT)."-AD";
$billingDate = date("d-m-Y h:i A",strtotime($advanceBooking['updated_at']));
$dueDate = date("h:i A",strtotime($advanceBooking['updated_at']));


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
$toBizName = !empty($advanceBooking['name']) ? $advanceBooking['name'] : 'Enter Name';
$toAddress1 = !empty($advanceBooking['street_add1']) ? $advanceBooking['street_add1'] : '';
$toAddress2 = !empty($advanceBooking['street_add2']) ? $advanceBooking['street_add2']." , " : '';
$toAddress2 .= !empty($advanceBooking['city']) ? $advanceBooking['city']." , " : '';
$toAddress2 .= !empty($advanceBooking['country']) ? $advanceBooking['country'] : '';
$toPhone = !empty($advanceBooking['mobile']) ? $advanceBooking['mobile'] : 'No found...';
$toEmail = isset($_POST['email']) ? $_POST['email'] : '';
$toAddInfo = isset($_POST['toAddInfo']) ? $_POST['toAddInfo'] : '';


/****************************************************************************
    Settings post
****************************************************************************/
$currency = 'Rs.';
$taxformat = isset($_POST['taxformat']) ? $_POST['taxformat'] : 'off';
$discountFormat = isset($_POST['discountFormat']) ? $_POST['discountFormat'] : 'off';
$pdfColor  = isset($_POST['pdfColor']) ? $_POST['pdfColor'] : '#000000';
$subtotal = isset($_POST['subtotal']) ? $_POST['subtotal'] : '';
$totalBill = !empty($advanceBooking['price']) ? $advanceBooking['price'] : '0';




/****************************************************************************
    items listing
****************************************************************************/
$proDesc = array();
$finalTotal = $totalPaymentFinance = 0;
$ii = 0;
foreach($advancePayment as $customerPay){
	$totalPaymentFinance += $customerPay['price'];
}
foreach($advancePayment as $customerPay)
{
	$titleName[] = $customerPay['case_type'];
	// Add sales Man Name nad Model
	if($ii==0){
		$paymentCase = "Sale Man: ".$salesman['name']."<br>";
		$paymentCase .= "Model : ".$veihicle['name']." ".$advanceBooking['color']."<br>";
	}
	
	if($customerPay['case_type']=="Cheque"){
		$paymentCase .= "Payment Type = ".$customerPay['case_type']."<br>";
		$paymentCase .= "Bank Name = ".$customerPay['bank_name']."<br>";
		$paymentCase .= "Cheque No = ".$customerPay['cheque_no']."<br>";
		$paymentCase .= "Cheque Date = ".$customerPay['cheque_date']."<br>";
	}else if($customerPay['case_type']=="DD"){
		$paymentCase .= "Payment Type = ".$customerPay['case_type']."<br>";
		$paymentCase .= "Bank Name = ".$customerPay['dd_bank_name']."<br>";
		$paymentCase .= "DD No = ".$customerPay['dd_no']."<br>";
		$paymentCase .= "DD Date = ".$customerPay['dd_date']."<br>";
	}else if($customerPay['case_type']=="NEFT"){
		$paymentCase .= "Payment Type = ".$customerPay['case_type']."<br>";
		$paymentCase .= "Bank Name = ".$customerPay['neft_bank_name']."<br>";
		$paymentCase .= "Account No = ".$customerPay['neft_ac_no']."<br>";
		$paymentCase .= "IFSC Code = ".$customerPay['neft_ifsc_code']."<br>";
		$paymentCase .= "Holder Name = ".$customerPay['neft_holder_name']."<br>";
	}else{
		$paymentCase .= "Payment Type = ".$customerPay['case_type']."<br>";
	}
	// Check Amount is Finance Or Not
	if($advanceBooking['finance']=="Yes" || $advanceBooking['finance']=="yes"){
		if($ii==0){
			$paymentCase .= "DP : ".$totalPaymentFinance." Bank Name: ".$advanceBooking['finance_bank'];
		}
	}
	
	$proDesc[] = $paymentCase;
	$amountPay[] = $customerPay['case_type'];
	$vatPay[] = "no";
	$datePay[] = date("d-m-Y",strtotime($customerPay['created_at']));
	$pricePay[] = $customerPay['price'];
	$discountPay[] = "";
	$paymentCase = "";
	$ii++;
	$finalTotal += $customerPay['price'];
}

if($advanceBooking['finance']=="Yes" || $advanceBooking['finance']=="yes"){
	//$finalTotal += 200;
}

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