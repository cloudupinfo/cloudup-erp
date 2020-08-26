<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "expense";
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$array = array();

if(!empty($dateTo) && !empty($dateFrom)){
	$row = $db->numRow("SELECT (`expense_id`) FROM ".$table." where `updated_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
}else{
	$row = $db->numRow("SELECT (`expense_id`) FROM ".$table."",array());
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
		
		if($value['branch_id']!=0){
			$branch = $db->getRow("SELECT * FROM `branch` where `branch_id`=?",array($value['branch_id']));
			$array['branch'] = $branch['name'];
		}else{
			$array['branch'] = "Main";
		}
		
		$array['name'] = $value['person'];
		
		$array['amount'] = $value['amount'];
		$array['purpose'] = $value['purpose'];
		$array['date'] = date("Y-m-d h:i A",strtotime($value['updated_at']));
		
		$array['action']="<a class='btn btn-success btn-squared' title='Click To Edit' href=\"expense.php?aid=".$value['expense_id']."\"><i class=\"fa fa-edit\"></i></a><a title='Click To Delete' class='to_delete btn btn-danger btn-squared' id=\"".$value['expense_id']."\" href ><i class=\"fa fa-trash-o\"></i></a>";
		
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