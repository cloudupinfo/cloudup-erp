<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "customer_payment";

$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';


$array = array();

if(!empty($dateTo) && !empty($dateFrom)){
	$row = $db->numRow("SELECT (`customer_payment_id`) FROM ".$table." where `created_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
}else{
	$row = "";
}

if($row > 0)
{
	if(!empty($dateTo) && !empty($dateFrom)){
		$result = $db->getRows("SELECT * FROM ".$table." where `created_at` BETWEEN ? AND ? ORDER BY `created_at` DESC",array($dateTo,$dateFrom));
	}else{
		$result = "";
	}
	
	$i = 0; $id=1;
	$main_array = array();

	foreach ($result as $key => $value) {
		$array = array();
		$array['id'] = $id;
		
		// Customer info
		$customer = $db->getRow("SELECT * FROM `customer_detail` where `customer_detail_id`=?",array($value['customer_detail_id']));
		// Product info
		$product = $db->getRow("SELECT * FROM `product` where `product_id`=?",array($customer['product_id']));
		
		$array['amount'] = $value['price'];
		$array['name'] = $customer['name'];
		
		if($product['sale']==1){
			$array['status'] = "Sale";
		}else{
			if($product['status']==4){
				$array['status'] = " Bill ";
			}else if($product['status']==3){
				$array['status'] = " Gate ";
			}else if($product['status']==2){
				$array['status'] = " Cash ";
			}else{
				$array['status'] = " Not Sale ";
			}
		}
		$array['receipt_no'] = str_pad($value['customer_detail_id'], 3, "0", STR_PAD_LEFT);
		$array['pay_type'] = $value['case_type'];
		
		// Fetch branch 
		if($product['branch_id']!=0){
			$getBranch = $db->getRow("SELECT * FROM `branch` where `branch_id`=?",array($product['branch_id']));
			$array['branch'] = $getBranch['name'];
		}else{
			$array['branch'] = "Main";
		}
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 8 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}
?>