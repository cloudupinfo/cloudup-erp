<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "dealer";
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$array = array();

if(!empty($dateTo) && !empty($dateFrom)){
	$row = $db->numRow("SELECT (`dealer_id`) FROM ".$table." where `updated_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
}else{
	$row = $db->numRow("SELECT (`dealer_id`) FROM ".$table."",array());
}
if($row > 0)
{
	if(!empty($dateTo) && !empty($dateFrom)){
		$result = $db->getRows("SELECT * FROM ".$table." where `updated_at` BETWEEN ? AND ? ORDER BY `updated_at` DESC",array($dateTo,$dateFrom));
	}else{
		$result = $db->getRows("SELECT * FROM ".$table." ORDER BY `updated_at` DESC",array());
	}
	
	$i = 0; $id=1;
	$main_array = array();

	foreach ($result as $key => $value) {
		$array = array();
		$array['id'] = str_pad($value['dealer_id'], 3, "0", STR_PAD_LEFT)."-D";;
		
		$product = $db->getRow("SELECT * FROM `product` where `product_id`=?",array($value['product_id']));
		
		$array['chassis_no'] = $product['chassis_no'];
		$array['name'] = $value['name'];
		$array['price'] = $value['price'];
		$array['address'] = $value['address'];
		$array['remark'] = nl2br($value['remark']);
		
		
		$array['status'] = "<a target='_blank' href='invoice/bill-dealer-invoice.php?id=".$value['dealer_id']."&type=Original' title='Click To Gatepass Bill' class='btn btn-success btn-squared'> Generate Bill </a>";
		
		
		$array['date'] = date("Y-m-d h:i A",strtotime($value['updated_at']));
		
		$array['action']="<a title='Click To Edit' class='btn btn-success btn-squared' href=\"dealer_search.php?aid=".$product['chassis_no']."\"><i class=\"fa fa-edit\"></i></a> <a title='Click To Delete' class='to_delete btn btn-danger btn-squared' id=\"".$value['dealer_id']."\" href ><i class=\"fa fa-trash-o\"></i></a>";
		
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