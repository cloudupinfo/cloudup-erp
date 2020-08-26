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
$customerDetail = $db->getRow("SELECT * FROM `customer_detail` where `customer_detail_id`=?",array($id));
if(!empty($customerDetail))
{
	// find salesman name
	$salesman = $db->getRow("SELECT * FROM `salesman` where `salesman_id`=?",array($customerDetail['salesman_id']));
	// find product detail
	$product = $db->getRow("SELECT * FROM `product` where `product_id`=?",array($customerDetail['product_id']));
	if(!empty($product))
	{
		// find product price
		$productPrice = $db->getRow("SELECT * FROM `product_price` where `product_id`=?",array($customerDetail['product_id']));
		// advance booking price
		$advancePrice = $db->getRow("SELECT * FROM `advance` where `advance_id`=?",array($productPrice['advance_id']));
		// Advance Booking Payment
		$advancePayment = $db->getRows("SELECT * FROM `advance_payment` where `advance_id`=?",array($advancePrice['advance_id']));
		$advancePaymentPrice = 0;
		foreach($advancePayment as $advancePaymentValue){
			$advancePaymentPrice += $advancePaymentValue['price'];
		}
		// find Payment detail
		$customerPayment = $db->getRows("SELECT * FROM `customer_payment` where `customer_detail_id`=?",array($customerDetail['customer_detail_id']));
		// exchange amount
		$exchange = $db->getRow("SELECT * FROM `exchange` where `customer_detail_id`=?",array($customerDetail['customer_detail_id']));
		// finance detail
		$finance = $db->getRow("SELECT * FROM `finance` where `product_id`=?",array($customerDetail['product_id']));
	}else{
		header('Location:../dashboard.php');
	}
}else{
	header('Location:../dashboard.php');
}

// Product Price Add
$rto = explode("/",$productPrice['rto']);
$ins = explode("/",$productPrice['insurance']);

/****************************************************************************
    header post
****************************************************************************/
$title = 'Cash Reciept';
$invocieNo = str_pad($customerDetail['customer_detail_id'], 3, "0", STR_PAD_LEFT);
$billingDate = date("d-m-Y h:i A",strtotime($customerDetail['updated_at']));
$dueDate = date("h:i A",strtotime($customerDetail['updated_at']));


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
$toBizName = !empty($customerDetail['name']) ? $customerDetail['name'] : 'Enter Name';
$toAddress1 = !empty($customerDetail['street_add1']) ? $customerDetail['street_add1'] : '';
$toAddress2 = !empty($customerDetail['street_add2']) ? $customerDetail['street_add2']." , " : '';
$toAddress2 .= !empty($customerDetail['city']) ? $customerDetail['city']." , " : '';
$toAddress2 .= !empty($customerDetail['country']) ? $customerDetail['country'] : '';
$toPhone = !empty($customerDetail['mobile']) ? $customerDetail['mobile'] : 'No found...';
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
$totalBill = '0';

/****************************************************************************
    items listing
****************************************************************************/
$titleName = $proDesc = array();
$paymentCase  = "";
$finalTotal = 0;
$ii = 0;

foreach($customerPayment as $customerPay)
{
	$titleName[] = $customerPay['case_type']." - ".str_pad($customerPay['customer_payment_id'], 3, "0", STR_PAD_LEFT);
	// Add sales Man Name nad Model
	if($ii==0){
		$paymentCase .= "Sale Man: ".$salesman['name']."<br>";
		$paymentCase .= "Model : ".$product['model']." ".$product['color']."<br>";
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
	// exchange add data
	if(!empty($exchange)){
		if($ii==0){
			$paymentCase .= "Exchange : ".$exchange['amount']." - ".$exchange['veihicle_no']."<br>";
		}
	}
	// finance add data
	if(!empty($finance)){
		if($ii==0){
			$hpa = "HPA : 200";
			$paymentCase .= "Finance : ".$finance['finance_amount']." - DP:  ".$finance['dp_amount']." / ".$hpa." ".$finance['bank']."<br>";
		}
	}
	// No RTO Add 550 CRTM
	if(strtolower($rto[0])=="no"){
		if($ii==0){
			$paymentCase .= "CRTM = 550 <br>";
		}
	}
	// advance add data
	if(!empty($advancePrice)){
		if($ii==0){
			$paymentCase .= "Advance Receipt No : ".str_pad($advancePrice['advance_id'], 3, "0", STR_PAD_LEFT)." - Rs. ".$advancePaymentPrice;
		}
	}
	
	$proDesc[] = $paymentCase;
	$amountPay[] = $customerPay['case_type'];
	$vatPay[] = "no";
	$datePay[] = date("d-m-Y",strtotime($customerPay['created_at']));
	$pricePay[] = $customerPay['price'];
	$discountPay[] = "";
	$paymentCase = "";
	//$finalTotal += $customerPay['price'];

	$ii++;
}

$finalTotal = $finalTotal + $productPrice['price'];
// Add Vat And tax
$vat = 15;
//$add = 2.5;
$vatPriceTotal = explode('.',($finalTotal*$vat)/100);
//$addPriceTotal = ($finalTotal*$add)/100;
//$vatPriceTotal = explode('.',$vatPriceTotal);

$finalTotal = $finalTotal+$vatPriceTotal[0];

// Add finace tax HPA Finaly Remove
if(!empty($finance)){
	$finalTotal = $finalTotal+200;
}
// RTO
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

// Minus exchange / Finance amount
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
$finalTotal = $finalTotal-$productPrice['discount'];
$finalTotal = $finalTotal-$productPrice['pending'];

$proName  = $titleName;
$proDescArray = $proDesc;
$amountArray = $amountPay;
$vatArray = $vatPay;
$priceArray = $datePay;
$discountArray = $discountPay;
$totalArray = $pricePay;
$hsn = "demo";

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
$imagePath =  "../".BARCODE_PATH_DISPLAY.$product['barcode_imgPath'];
$invoice->setLogo($imagePath,220,80);

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
    
    $total = $totalArray[$key];
    $invoice->addItem($productName,$proDes,$amount,$vat,$price,$discount,$total);
}

//$invoice->addItem($proName,$proDescArray,$amountArray,$vatArray,$priceArray,$discountArray,$totalArray,$hsn);

//Add totals
$invoice->addTotal("Sub Total",$finalTotal);
//$invoice->addTotal("Sub Total",$subtotal);

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
//$invoice->addTotal("Total",$totalBill,true);
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
if(!empty($exchange)){
	//$extraNotes = 'Exchange Amount - '.$exchange['amount'].'Rs. Veihicle No - '.$exchange['veihicle_no'].'<br>';
	$extraNotes = '';
}else{
	$extraNotes = '';
}
$extraNotes .= '1. If Booking Will Be Cancelled In Any Circumstances. <br> 2. The Money Will Be Refunded In Cheque From Within 15 Days. <br> 3. Cheque Cancellation Charge Will be Paid by User.';
//Add paragraph
$invoice->addParagraph($extraNotes);

//Set footernote
$invoice->setFooternote("");

//Render
$invoice->render();