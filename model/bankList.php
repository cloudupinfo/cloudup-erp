<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "bank";
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$array = array();

if(!empty($dateTo) && !empty($dateFrom)){
	$row = $db->numRow("SELECT (`bank_id`) FROM ".$table." where `updated_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
}else{
	$row = $db->numRow("SELECT (`bank_id`) FROM ".$table."",array());
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
		
		$array['type'] = ucfirst($value['cash_type']);
		$array['price'] = $value['price'];
		$array['bank_name'] = $value['bank_name'];
		$array['cheque_no'] = $value['cheque_no'];
		$array['cheque_date'] = $value['cheque_date'];
		$array['dd_bank_name'] = $value['dd_bank_name'];
		$array['dd_no'] = $value['dd_no'];
		$array['dd_date'] = $value['dd_date'];
		
		$array['remark'] = $value['remark'];
		$array['date'] = date("Y-m-d h:i A",strtotime($value['updated_at']));
		
		$array['action']="<a title='Click To Edit' class='btn btn-success btn-squared' href=\"bank.php?aid=".$value['bank_id']."\"><i class=\"fa fa-edit\"></i></a><a title='Click to Delete' class='to_delete btn btn-danger btn-squared' id=\"".$value['bank_id']."\" href ><i class=\"fa fa-trash-o\"></i></a>";
		
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