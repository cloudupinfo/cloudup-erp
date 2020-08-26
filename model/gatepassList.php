<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "gatepass";
$table1 = "product";
$table2 = "customer_detail";
$type = isset($_POST['type']) ? $_POST['type'] : '';
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$today = "%".date("Y-m-d")."%";

$array = array();
if($type=="today"){
	$row = $db->numRow("SELECT (`gatepass_id`) FROM ".$table." where `created_at` LIKE ?",array($today));
}else{
	if(!empty($dateTo) && !empty($dateFrom)){
		$row = $db->numRow("SELECT (`gatepass_id`) FROM ".$table." where `created_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
	}else{
		$row = $db->numRow("SELECT (`gatepass_id`) FROM ".$table."",array());
	}
}
if($row > 0)
{
	if($type=="today"){
		$result = $db->getRows("SELECT * FROM ".$table." where `created_at` LIKE ? ORDER BY `created_at` DESC",array($today));
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
		$array['id'] = str_pad($value['gatepass_id'], 3, "0", STR_PAD_LEFT);
		
		//Product Detail
		$product = $db->getRow("SELECT * FROM ".$table1." where `product_id`=?",array($value['product_id']));
		// Cutomer Detail
		$customer = $db->getRow("SELECT * FROM ".$table2." where `customer_detail_id`=?",array($value['customer_detail_id']));
		// Sales Man
		$salesman = $db->getRow("SELECT `name` FROM `salesman` where `salesman_id`=?",array($customer['salesman_id']));
		// Customer Payment Detail
		$product_paymnet = $db->getRow("SELECT * FROM `product_price` where `product_id`=?",array($customer['product_id']));
		
		$array['chassis_no'] = $product['chassis_no'];
		$array['model'] = $product['model'];
		$array['color'] = $product['color'];
		$array['sales_man'] = $salesman['name'];
		
		$array['name'] = $customer['name'];
		$array['mobile'] = $customer['mobile'];
		
		$array['remark'] = $customer['remark'];
		$array['created_at'] = date("Y-m-d h:i A",strtotime($value['created_at']));
		
		$array['action']="<a class='btn btn-success btn-squared' title='Click to Edit' href=\"gatepass_chassis_view.php?aid=".$product['chassis_no']."\"><i class=\"fa fa-edit\"></i></a>&nbsp <a title='Click to Delete' class='to_delete btn btn-danger btn-squared' id=\"".$value['gatepass_id']."\" href ><i class=\"fa fa-trash-o\"></i></a>&nbsp <a class='btn btn-teal btn-squared' title='Click to View More Detail' target='_blank' href='gatepass_detail_view.php?aid=".$value['gatepass_id']."'><i class=\"clip-note\"></i></a>&nbsp <a class='btn btn-blue btn-squared' title='Click to Print' target='_blank' href='gatepassGenerate/gatepassGenerate.php?aid=".$value['gatepass_id']."&type=Duplicate'><i class=\"fa fa-print\"></i></a>";
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 11 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}
?>