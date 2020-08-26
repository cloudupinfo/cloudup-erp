<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "product_service";
$table1 = "product";

$type = isset($_POST['type']) ? $_POST['type'] : '';
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$today = "%".date("Y-m-d")."%";

$array = array();
if($type=="today"){
	$row = $db->numRow("SELECT (`product_service_id`) FROM ".$table." where `updated_at` LIKE ? AND `product_id`!=?",array($today,0));
}else{
	if(!empty($dateTo) && !empty($dateFrom)){
		$row = $db->numRow("SELECT (`product_service_id`) FROM ".$table." where `updated_at` BETWEEN ? AND ? AND `product_id`!=?",array($dateTo,$dateFrom,0));
	}else{
		$row = $db->numRow("SELECT (`product_service_id`) FROM ".$table." where `product_id`!=?",array(0));
	}
}
if($row > 0)
{
	if($type=="today"){
		$result = $db->getRows("SELECT * FROM ".$table." where `updated_at` LIKE ? AND `product_id`!=? ORDER BY `updated_at` DESC",array($today,0));		
	}else{
		if(!empty($dateTo) && !empty($dateFrom)){
			$result = $db->getRows("SELECT * FROM ".$table." where `updated_at` BETWEEN ? AND ?  AND `product_id`!=? ORDER BY `updated_at` DESC",array($dateTo,$dateFrom,0));
		}else{
			$result = $db->getRows("SELECT * FROM ".$table." where `product_id`!=? ORDER BY `updated_at` DESC",array(0));
		}
	}
	$i = 0; $id=1;
	$main_array = array();

	foreach ($result as $key => $value) {
		$array = array();
		$array['id'] = str_pad($value['product_service_id'], 3, "0", STR_PAD_LEFT);
		
		$product = $db->getRow("SELECT * FROM ".$table1." where `product_id`=?",array($value['product_id']));
		
		$array['chassis_no'] = substr($value['service_barcode'],0,17);
		$array['model'] = $product['model'];
		$array['color'] = $product['color'];
		$array['service_no'] = $value['service_barcode'];
		
		if((!empty($value['service_barcode_imgPath'])) && ($value['service_barcode_imgPath']!='0')){
			$array['download'] = "<a title='Click To Download Service Barcode' href='".BARCODE_SERVICE_PATH_DISPLAY.$value['service_barcode_imgPath']."' download><span class='btn btn-success btn-squared'><i class='clip-download-2'></i></span></a>";
		}else{
			$array['download'] = "no generate...";
		}
		$array['date'] = date("Y-m-d h:i A",strtotime($value['updated_at']));
		
		$array['action']="<a title='Click to Delete' class='to_delete btn btn-danger btn-squared' id=\"".$value['product_service_id']."\" href ><i class=\"fa fa-trash-o\"></i></a>";
		
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