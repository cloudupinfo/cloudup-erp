<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "product";
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$array = array();

if(!empty($dateTo) && !empty($dateFrom)){
	$row = $db->numRow("SELECT (`branch_id`) FROM ".$table." where `branch_id`!=? AND `updated_at` BETWEEN ? AND ?",array(0,$dateTo,$dateFrom));
}else{
	$row = $db->numRow("SELECT (`branch_id`) FROM ".$table." where `branch_id`!=?",array(0));
}
if($row > 0)
{
	if(!empty($dateTo) && !empty($dateFrom)){
		$result = $db->getRows("SELECT * FROM ".$table." where `branch_id`!=? AND `updated_at` BETWEEN ? AND ? ORDER BY `updated_at` DESC",array(0,$dateTo,$dateFrom));
	}else{
		$result = $db->getRows("SELECT * FROM ".$table." where `branch_id`!=? ORDER BY `updated_at` DESC",array(0));
	}
	
	$i = 0; $id=1;
	$main_array = array();

	foreach ($result as $key => $value) {
		$array = array();
		$array['id'] = str_pad($value['product_id'], 3, "0", STR_PAD_LEFT)."-B";
		
		$branch = $db->getRow("SELECT * FROM `branch` where `branch_id`=?",array($value['branch_id']));
		$array['name'] = $branch['name'];
		
		$array['chassis_no'] = $value['chassis_no'];
		//to_status
		if($value['sale']==1)
			$array['status'] = "<span title='Click To Credited' class=' btn btn-success btn-squared' id=\"".$value['product_id']."\"> Sale </span>";
		else
			$array['status'] = "<span title='Click To Debited' class=' btn btn-danger btn-squared' id=\"".$value['product_id']."\"> Unsale </span>";
		
		
		$array['print'] = "<a target='_blank' href='gatepassGenerate/branchGatepassGenerate.php?aid=".$value['chassis_no']."&type=Original' title='Click To Genarete Gatepass' class='btn btn-success btn-squared' > Generate Gatepass </a>";
		
		$array['date'] = date("Y-m-d h:i A",strtotime($value['updated_at']));
		
		$array['action']="<a class='btn btn-success btn-squared' href=\"branch.php?aid=".$value['product_id']."\"><i class=\"fa fa-edit\"></i></a> &nbsp <a class='to_delete btn btn-danger btn-squared' id=\"".$value['product_id']."\" href ><i class=\"fa fa-trash-o\"></i></a>";
		
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