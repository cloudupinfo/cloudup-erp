<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "rto";
$table1 = "product";
$table2 = "customer_detail";
$type = isset($_POST['type']) ? $_POST['type'] : '';
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$today = "%".date("Y-m-d")."%";

$array = array();
if($type=="today"){
	$row = $db->numRow("SELECT (`rto_id`) FROM ".$table." where `updated_at` LIKE ?",array($today));
}else{
	if(!empty($dateTo) && !empty($dateFrom)){
		$row = $db->numRow("SELECT (`rto_id`) FROM ".$table." where `updated_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
	}else{
		$row = $db->numRow("SELECT (`rto_id`) FROM ".$table."",array());
	}
}
if($row > 0)
{
	if($type=="today"){
		$result = $db->getRows("SELECT * FROM ".$table." where `updated_at` LIKE ? ORDER BY `updated_at` DESC",array($today));
	}else{
		if(!empty($dateTo) && !empty($dateFrom)){
			$result = $db->getRows("SELECT * FROM ".$table." where `updated_at` BETWEEN ? AND ? ORDER BY `updated_at` DESC",array($dateTo,$dateFrom));
		}else{
			$result = $db->getRows("SELECT * FROM ".$table." ORDER BY `updated_at` DESC",array());
		}
	}
	$i = 0; $id=1;
	$main_array = array();

	foreach ($result as $key => $value) {
		$array = array();
		$array['id'] = str_pad($value['rto_id'], 3, "0", STR_PAD_LEFT)."-R";
		
		//Product Detail
		$product = $db->getRow("SELECT * FROM ".$table1." where `product_id`=?",array($value['product_id']));
		// Cutomer Detail
		$customer = $db->getRow("SELECT * FROM ".$table2." where `product_id`=?",array($value['product_id']));
		// Sales Man
		$salesman = $db->getRow("SELECT `name` FROM `salesman` where `salesman_id`=?",array($customer['salesman_id']));
		// Finance Detail
		$finance = $db->getRow("SELECT * FROM `finance` where `product_id`=?",array($value['product_id']));
		
		$array['chassis_no'] = $product['chassis_no'];
		$array['model'] = $product['model'];
		$array['color'] = $product['color'];
		$array['sales_man'] = $salesman['name'];
		
		if(!empty($finance)){
			$array['finance'] = "Yes";
		}else{
			$array['finance'] = "No";
		}
		$array['name'] = $customer['name'];
		$array['mobile'] = $customer['mobile'];
		
		$array['remark'] = $customer['remark'];
		$array['date'] = date("Y-m-d h:i A",strtotime($value['updated_at']));
		
		$array['print']="<a class='btn btn-success btn-squared' title='Click to Print Vehicle Invoice' target='_blank' href='invoice/rto-invoice.php?id=".$value['rto_id']."&type=Original'>INVOICE <i class=\"fa fa-print\"></i></a> <br> <a class='btn btn-success btn-squared' title='Click to Print FORM 21' target='_blank' href='invoice/rto-form21-invoice.php?id=".$value['rto_id']."&type=Original'>FORM 21 <i class=\"fa fa-print\"></i></a>";
		
		$array['action']="<a class='btn btn-success btn-squared' title='Click to Edit' href=\"rto_view.php?aid=".$product['chassis_no']."\"><i class=\"fa fa-edit\"></i></a> <br> <a title='Click to Delete' class='to_delete btn btn-danger btn-squared' id=\"".$value['rto_id']."\" href ><i class=\"fa fa-trash-o\"></i></a>";
		
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