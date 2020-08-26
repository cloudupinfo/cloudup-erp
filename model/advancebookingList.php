<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "advance";
$table1 = "veihicle";
$table2 = "advance_payment";
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';

$array = array();

if(!empty($dateTo) && !empty($dateFrom)){
	$row = $db->numRow("SELECT (`advance_id`) FROM ".$table." where `created_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
}else{
	$row = $db->numRow("SELECT (`advance_id`) FROM ".$table."",array());
}
if($row > 0)
{
	if(!empty($dateTo) && !empty($dateFrom)){
		$result = $db->getRows("SELECT * FROM ".$table." where `created_at` BETWEEN ? AND ? ORDER BY `created_at` DESC",array($dateTo,$dateFrom));
	}else{
		$result = $db->getRows("SELECT * FROM ".$table." ORDER BY `created_at` DESC",array());
	}
	
	$i = 0; $id=1;
	$main_array = array();

	foreach ($result as $key => $value) 
	{
		$array = $priceDetailEdit = array();
		$array['id'] = str_pad($value['advance_id'], 3, "0", STR_PAD_LEFT)."-AD";
		
		// Model
		$veihicle = $db->getRow("SELECT `name` FROM ".$table1." where `veihicle_id`=?",array($value['model']));
		$array['model'] = $veihicle['name'];
		$array['color'] = $value['color'];
		
		// Sales Man
		$salesman = $db->getRow("SELECT `name` FROM `salesman` where `salesman_id`=?",array($value['salesman_id']));
		$array['sales_man'] = $salesman['name'];
		$array['name'] = $value['name'];
		$array['mobile'] = $value['mobile'];
		$array['city'] = $value['city'];
		$array['country'] = $value['country'];
		// Customer Advance Paymnet
		$advancePayment = $db->getRows("SELECT * FROM ".$table2." where `advance_id`=?",array($value['advance_id']));
		$totalPayment = 0;
		foreach($advancePayment as $advancePaymentValue){
			$totalPayment += $advancePaymentValue['price'];
			$priceDetailEdit[] = "<a target='_blank' href='advance_payment_edit.php?aid=".$advancePaymentValue['advance_payment_id']."'>".$advancePaymentValue['case_type']."-".$advancePaymentValue['price']."</a>";
		}
		$array['price_edit'] = $priceDetailEdit;
		$array['price'] = $totalPayment;
		
		//$array['case_type'] = $value['case_type'];
		/*$array['bank_name'] = $value['bank_name'];
		$array['cheque_no'] = $value['cheque_no'];
		$array['cheque_date'] = $value['cheque_date'];
		$array['dd_bank_name'] = $value['dd_bank_name'];
		$array['dd_no'] = $value['dd_no'];
		$array['dd_date'] = $value['dd_date'];
		$array['neft_ac_no'] = $value['neft_ac_no'];
		$array['neft_bank_name'] = $value['neft_bank_name'];
		$array['neft_ifsc_code'] = $value['neft_ifsc_code'];
		$array['neft_holder_name'] = $value['neft_holder_name'];*/
		
		$array['remark'] = $value['remark'];
		$array['created_at'] = date("Y-m-d h:i A",strtotime($value['created_at']));
		
		if($value['refund']==0){
			$printTag = "Duplicate";
			$array['refund'] = '<span title="click to yes refund" refund="'.$value['refund'].'" class="btn btn-danger btn-squared refund" id="'.$value['advance_id'].'">No</span>';
		}else{
			$printTag = "Duplicate - Refund";
			$array['refund'] = '<span title="click to no refund" refund="'.$value['refund'].'" class="btn btn-success btn-squared refund" id="'.$value['advance_id'].'">Yes</span>';
		}
		
		$array['action']="<a title='Click To Edit' class='btn btn-success btn-squared' href=\"advance_booking.php?aid=".$value['advance_id']."\"><i class=\"fa fa-edit\"></i></a><a title='Click To Delete' class='to_delete btn btn-danger btn-squared' id=\"".$value['advance_id']."\" href ><i class=\"fa fa-trash-o\"></i></a><a class='btn btn-info btn-squared' title='Click to Print Cash Receipt' target='_blank' href='cashReceipt/ABInvoice.php?aid=".$value['advance_id']."&type=".$printTag."'><i class=\"fa fa-print\"></i></a>";
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 14 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}
?>