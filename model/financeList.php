<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "finance";
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$array = array();

if(!empty($dateTo) && !empty($dateFrom)){
	$row = $db->numRow("SELECT (`finance_id`) FROM ".$table." where `updated_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
}else{
	$row = $db->numRow("SELECT (`finance_id`) FROM ".$table."",array());
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
		$array['id'] = $id;
		
		$product = $db->getRow("SELECT `chassis_no` FROM `product` where `product_id`=?",array($value['product_id']));
		$array['chassis_no'] = $product['chassis_no'];
		
		$array['bank'] = $value['bank'];
		$array['dp'] = $value['dp_amount'];
		$array['finance'] = $value['finance_amount'];
		
		if($value['status']==1)
			$array['status']="<span class='btn btn-success btn-squared' title='Pay Complete'> Pay </span>";
		else
			$array['status']="<span class='btn btn-danger btn-squared' title='Pay Not Complete'> Not Pay </span>";
			
		$array['date'] = date("Y-m-d h:i A",strtotime($value['updated_at']));
		
		if($value['status']==1)
			$array['save'] = "<span title='Click To Credited' class='to_status btn btn-success btn-squared' id=\"".$value['finance_id']."\"> Debit </span>";
		else
			$array['save'] = "<span title='Click To Debited' class='to_status btn btn-danger btn-squared' id=\"".$value['finance_id']."\"> Credit </span>";
		
		$array['action']="<a title='Click To Delete' class='to_delete btn btn-danger btn-squared' id=\"".$value['finance_id']."\" href ><i class=\"fa fa-trash-o\"></i></a>";
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 7 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}

?>