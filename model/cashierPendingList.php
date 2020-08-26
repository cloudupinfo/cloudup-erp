<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "customer_detail";
$table1 = "product";
$table2 = "product_price";

$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '0';
$today = "%".date("Y-m-d")."%";

$array = array();
if(!empty($dateTo) && !empty($dateFrom)){
	$row = $db->numRow("SELECT (`product_price_id`) FROM ".$table2." where `pending`>? AND `updated_at` BETWEEN ? AND ?",array(0,$dateTo,$dateFrom));
}else{
	$row = $db->numRow("SELECT (`product_price_id`) FROM ".$table2." where `pending`>?",array(0));
}

if($row > 0)
{	
	if(!empty($dateTo) && !empty($dateFrom)){
		$result = $db->getRows("SELECT * FROM ".$table2." where `pending`>? AND `updated_at` BETWEEN ? AND ?",array(0,$dateTo,$dateFrom));
	}else{
		$result = $db->getRows("SELECT * FROM ".$table2." where `pending`>?",array(0));
	}

	$i = 0; $id=1;
	$main_array = array();

	foreach($result as $key => $value) 
	{
		$array = array();
		// Product Detail Find
		$product = $db->getRow("SELECT `chassis_no`,`model`,`branch_id` FROM ".$table1." where `product_id`=?",array($value['product_id']));
		// Product Detail Find
		$customer = $db->getRow("SELECT * FROM ".$table." where `product_id`=?",array($value['product_id']));
		
		$array['id'] = str_pad($customer['customer_detail_id'], 3, "0", STR_PAD_LEFT);
		// Fetch branch 
		if($product['branch_id']!=0){
			$getBranch = $db->getRow("SELECT * FROM `branch` where `branch_id`=?",array($product['branch_id']));
			$array['branch'] = $getBranch['name'];
		}else{
			$array['branch'] = "Main";
		}
		
		$array['chassis_no'] = $product['chassis_no'];
		$array['model'] = $product['model'];
		
		// Sales Man
		$salesman = $db->getRow("SELECT `name` FROM `salesman` where `salesman_id`=?",array($customer['salesman_id']));
		$array['sales_man'] = $salesman['name'];
		
		$array['name'] = $customer['name'];
		$array['mobile'] = $customer['mobile'];
		$array['city'] = $customer['city'];
		
		// Product Prise Info
		$productPrice = $db->getRow("SELECT `total`,`pending` FROM ".$table2." where `product_id`=?",array($value['product_id']));
		$array['pending'] = $value['pending'];
		$array['remark'] = $customer['remark'];
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 10 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}
?>