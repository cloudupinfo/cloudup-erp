<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "cashier";
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$array = array();

if(!empty($dateTo) && !empty($dateFrom)){
	$row = $db->numRow("SELECT (`cashier_id`) FROM ".$table." where `updated_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
}else{
	$row = $db->numRow("SELECT (`cashier_id`) FROM ".$table."",array());
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
		$array['id'] = str_pad($value['cashier_id'], 3, "0", STR_PAD_LEFT)."-O";
		
		// Fetch branch 
		if($value['branch_id']!=0){
			$getBranch = $db->getRow("SELECT * FROM `branch` where `branch_id`=?",array($value['branch_id']));
			$array['branch'] = $getBranch['name'];
		}else{
			$array['branch'] = "Main";
		}
		
		$array['type'] = ucfirst($value['type']);
		$array['cash_type'] = $value['cash_type'];
		$array['amount'] = $value['amount'];
		$array['bank_name'] = $value['bank_name'];
		$array['cheque_no'] = $value['cheque_no'];
		$array['cheque_date'] = $value['cheque_date'];
		$array['dd_bank_name'] = $value['dd_bank_name'];
		$array['dd_no'] = $value['dd_no'];
		$array['dd_date'] = $value['dd_date'];
		$array['neft_ac_no'] = $value['neft_ac_no'];
		$array['neft_bank_name'] = $value['neft_bank_name'];
		$array['neft_ifsc_code'] = $value['neft_ifsc_code'];
		$array['neft_holder_name'] = $value['neft_holder_name'];
		
		$array['remark'] = $value['remark'];
		$array['date'] = date("Y-m-d h:i A",strtotime($value['updated_at']));
		
		$array['action']="<a title='Click To Edit' class='btn btn-success btn-squared' href=\"cashier_add.php?aid=".$value['cashier_id']."\"><i class=\"fa fa-edit\"></i></a><a title='Click to Delete' class='to_delete btn btn-danger btn-squared' id=\"".$value['cashier_id']."\" href ><i class=\"fa fa-trash-o\"></i></a><a class='btn btn-info btn-squared' title='Click to Print Invoice' target='_blank' href='cashReceipt/receipt.php?aid=".$value['cashier_id']."&type=Duplicate'><i class=\"fa fa-print\"></i></a>";
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 17 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}

?>