<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "customer_payment";
$table1 = "product";
$table2 = "product_price";
$table3 = "customer_detail";
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$today = "%".date("Y-m-d")."%";

$array = array();
if($type=="today"){
	$row = $db->numRow("SELECT (`customer_payment_id`) FROM ".$table." where `updated_at` LIKE ?",array($today));
}else{
	if(!empty($dateTo) && !empty($dateFrom)){
		$row = $db->numRow("SELECT (`customer_payment_id`) FROM ".$table." where `created_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
	}else{
		$row = $db->numRow("SELECT (`customer_payment_id`) FROM ".$table."",array());
	}
}
if($row > 0)
{
	if($type=="today")
	{
		$result = $db->getRows("SELECT * FROM ".$table." where `updated_at` LIKE ? ORDER BY `created_at` DESC",array($today));
	}else{
		if(!empty($dateTo) && !empty($dateFrom)){
			$result = $db->getRows("SELECT * FROM ".$table." where `created_at` BETWEEN ? AND ? ORDER BY `created_at` DESC",array($dateTo,$dateFrom));
		}else{
			$result = $db->getRows("SELECT * FROM ".$table." ORDER BY `created_at` DESC",array());
		}
	}
	
	$i = 0; $id=1;
	$main_array = array();

	foreach ($result as $key => $value) {
		$array = array();
		// Customer Detail info
		$customer = $db->getRow("SELECT * FROM ".$table3." where `customer_detail_id`=?",array($value['customer_detail_id']));
		// Product info
		$product = $db->getRow("SELECT * FROM ".$table1." where `product_id`=?",array($customer['product_id']));
		// Product Prise Info
		$productPrice = $db->getRow("SELECT `total`,`pending` FROM ".$table2." where `product_id`=?",array($customer['product_id']));
		// Sales Man info
		$salesman = $db->getRow("SELECT `name` FROM `salesman` where `salesman_id`=?",array($customer['salesman_id']));

		$array['id'] = str_pad($customer['customer_detail_id'], 3, "0", STR_PAD_LEFT);
		$array['sub_id'] = str_pad($value['customer_payment_id'], 3, "0", STR_PAD_LEFT);
		
		// Fetch branch 
		if($product['branch_id']!=0){
			$getBranch = $db->getRow("SELECT * FROM `branch` where `branch_id`=?",array($product['branch_id']));
			$array['branch'] = $getBranch['name'];
		}else{
			$array['branch'] = "Main";
		}
		$array['chassis_no'] = $product['chassis_no'];
		$array['model'] = $product['model'];
		$array['sales_man'] = $salesman['name'];
		$array['name'] = $customer['name'];
		$array['mobile'] = $customer['mobile'];
		$array['city'] = $customer['city'];
		
		$array['total'] = $value['price'];
		//$array['pending'] = $productPrice['pending'];
		//$array['discount'] = $productPrice['discount'];
		$array['remark'] = $value['remark'];
		
		$array['date'] = date("Y-m-d h:i A",strtotime($value['updated_at']));
		
		$array['action']="<a class='btn btn-success btn-squared' title='click to edit' href=\"cashier_chassis_view.php?aid=".$product['chassis_no']."\"><i class=\"fa fa-edit\"></i></a> <br> <a title='Click to Delete' class='to_delete btn btn-danger btn-squared' id=\"".$customer['customer_detail_id']."\" href ><i class=\"fa fa-trash-o\"></i></a> <br> <a class='btn btn-blue btn-squared' title='click to view full detail' target='_blank' href=\"cashier_detail_view.php?aid=".$customer['customer_detail_id']."\"><i class=\"clip-note\"></i></a> <br> <a class='btn btn-info btn-squared' title='Click to Print Veihicle Cash Receipt' target='_blank' href='cashReceipt/cashReceipt.php?aid=".$customer['customer_detail_id']."&type=Duplicate'><i class=\"fa fa-print\"></i></a>";
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 12 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}

?>