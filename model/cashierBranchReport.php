<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "cashier";

$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';


$array = array();

if(!empty($dateTo) && !empty($dateFrom)){
	$row = $db->numRow("SELECT (`cashier_id`) FROM ".$table." where `created_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
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
		
		// Fetch branch 
		if($value['branch_id']!=0){
			$getBranch = $db->getRow("SELECT * FROM `branch` where `branch_id`=?",array($value['branch_id']));
			$nameFull = $getBranch['name'];
		}else{
			$nameFull = "Main";
		}
		$nameFull .= " - ".$value['type'];
		
		$array['amount'] = $value['amount'];
		
		$array['name'] = $nameFull;
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 3 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}
?>