<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "product_pdi";
$table1 = "product";
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : '0';
$today = "%".date("Y-m-d")."%";

$array = array();
if($type=="today"){
	$row = $db->numRow("SELECT (`product_pdi_id`) FROM ".$table." where `created_at` LIKE ?",array($today));
}else{
	if(!empty($dateTo) && !empty($dateFrom)){
		$row = $db->numRow("SELECT (`product_pdi_id`) FROM ".$table." where `created_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
	}else{
		$row = $db->numRow("SELECT (`product_pdi_id`) FROM ".$table."",array());
	}
}
if($row > 0)
{
	if($type=="today"){
		$result = $db->getRows("SELECT * FROM ".$table." where `created_at` LIKE ? ORDER BY `created_at` DESC",array($today));
		
	}else{
		if(!empty($dateTo) && !empty($dateFrom)){
			$result = $db->getRows("SELECT * FROM ".$table." where `created_at` BETWEEN ? AND ? ORDER BY `created_at` DESC",array($dateTo,$dateFrom));
		}else{
			$result = $db->getRows("SELECT * FROM ".$table." ORDER BY `created_at` DESC",array());
		}
	}
	$i = 0; $id=1;
	$main_array = array();

	foreach ($result as $key => $value) {
		$array = array();
		$array['id'] = $id;
		
		$product = $db->getRow("SELECT * FROM ".$table1." where `product_id`=?",array($value['product_id']));
		
		$array['chassis_no'] = $product['chassis_no'];
		$array['model'] = $product['model'];
		$array['color'] = $product['color'];
		
		$array['sari_gard'] = "<input type='checkbox' class='sari_gard_".$value['product_pdi_id']."' name='sari_gard' value='".$value['sari_gard']."' ".(($value['sari_gard'] == "1") ? "checked" : "")." />";
		$array['mirror'] = "<input type='checkbox' name='mirror' class='mirror_".$value['product_pdi_id']."' value='".$value['mirror']."' ".(($value['mirror'] == "1") ? "checked" : "")." />";
		$array['oil_level'] = "<input type='checkbox' class='oil_level_".$value['product_pdi_id']."' name='oil_level' value='".$value['oil_level']."' ".(($value['oil_level'] == "1") ? "checked" : "")." />";
		$array['breaking'] = "<input type='checkbox' name='breaking' class='breaking_".$value['product_pdi_id']."' value='".$value['breaking']."' ".(($value['breaking'] == "1") ? "checked" : "")." />";
		$array['jumper'] = "<input type='checkbox' name='jumper' class='jumper_".$value['product_pdi_id']."' value='".$value['jumper']."' ".(($value['jumper'] == "1") ? "checked" : "")." />";
		$array['chain'] = "<input type='checkbox' name='chain' class='chain_".$value['product_pdi_id']."' value='".$value['chain']."' ".(($value['chain'] == "1") ? "checked" : "")." />";
		$array['air_pressure'] = "<input type='checkbox' name='air_pressure' class='air_pressure_".$value['product_pdi_id']."' value='".$value['air_pressure']."' ".(($value['air_pressure'] == "1") ? "checked" : "")." />";
		
		$array['date'] = date("Y-m-d h:i A",strtotime($value['created_at']));
		
		$array['action']="<img src='loading.gif' height='45' width='45' style='display:none;'><button class='btn btn-success btn-squared product-pdi-save' id='".$value['product_pdi_id']."'>Save</button>";
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 14 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}

?>