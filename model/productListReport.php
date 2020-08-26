<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "product";
$table1 = "veihicle";
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$today = "%".date("Y-m-d")."%";

$array = array();
if($type=="today"){
	$row = $db->numRow("SELECT (`product_id`) FROM ".$table." where `created_at` LIKE ? AND `delete`=?",array($today,0));
}else{
	if(!empty($dateTo) && !empty($dateFrom)){
		$row = $db->numRow("SELECT (`product_id`) FROM ".$table." where `created_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
	}else{
		$row = $db->numRow("SELECT (`product_id`) FROM ".$table." where `delete`=?",array(0));
	}
}
if($row > 0)
{
	if($type=="today"){
		$result = $db->getRows("SELECT * FROM ".$table." where `created_at` LIKE ? AND `delete`=? ORDER BY `created_at` DESC",array($today,0));
	}else{
		if(!empty($dateTo) && !empty($dateFrom)){
			$result = $db->getRows("SELECT * FROM ".$table." where `created_at` BETWEEN ? AND ? ORDER BY `created_at` ASC",array($dateTo,$dateFrom));
		}else{
			$result = $db->getRows("SELECT * FROM ".$table." where `delete`=? ORDER BY `created_at` DESC",array(0));
		}
	}
	
	$i = 0; $id=1;
	$main_array = array();

	foreach ($result as $key => $value) {
		$array = array();
		$array['id'] = $id;
		
		// Fetch branch 
		if($value['branch_id']!=0){
			$getBranch = $db->getRow("SELECT * FROM `branch` where `branch_id`=?",array($value['branch_id']));
			$array['branch'] = $getBranch['name'];
		}else{
			$array['branch'] = "Main";
		}
		// product sale date 
		$customerDetail = $db->getRow("SELECT * FROM `customer_detail` where `product_id`=?",array($value['product_id']));
		
		$array['chassis_no'] = $value['chassis_no'];
		$array['eng'] = $value['eng_no'];
		$array['model_code'] = $value['model_code'];
		$array['color_code'] = $value['color_code'];
		$array['model'] = $value['model'];
		$array['color'] = $value['color'];
		$array['variant'] = $value['variant'];
		
		// Status Code
		if($value['sale']==1){
			$array['status'] = "<span class='btn btn-danger btn-squared'> SALE </span>";
		}else{
			if($value['status']==4){
				$array['status'] = "<span class='btn btn-info btn-squared'> BILL </span>";
			}else if($value['status']==3){
				$array['status'] = "<span class='btn btn-blue btn-squared'> GATE </span>";
			}else if($value['status']==2){
				$array['status'] = "<span class='btn btn-info btn-squared'> CASH </span>";
			}else{
				$array['status'] = "<span class='btn btn-success btn-squared'> IN STOCK </span>";
			}
		}
		$array['p_date'] = date("Y-m-d h:i A",strtotime($value['created_at']));
		if(!empty($customerDetail)){
			$array['s_date'] = date("Y-m-d h:i A",strtotime($customerDetail['created_at']));
		}else{
			$array['s_date'] = 'IN STOCK';
		}
		
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