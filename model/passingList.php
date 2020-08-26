<?php include_once("../config/PDO.php");
$db = new db();
$table = "billing";
$array = array();
$startDate = "1970-01-01";
$endDate = date("Y-m-d",strtotime("-5 days"));

$row = $db->numRow("SELECT * FROM ".$table." where `pass`=? AND `created_at` BETWEEN ? AND ?",array(0,$startDate,$endDate));

if($row > 0)
{
	$result = $db->getRows("SELECT * FROM ".$table." where `pass`=? AND `created_at` BETWEEN ? AND ?",array(0,$startDate,$endDate));
	$i = 0; $id = 1;
	$main_array = array();

	foreach ($result as $key => $value) {
		$array = array();
		$array['id'] = $id;
		$product = $db->getRow("SELECT * FROM `product` where product_id=?",array($value['product_id']));
		$contactDetail = $db->getRow("SELECT * FROM `customer_detail` where `product_id`=?",array($value['product_id']));
		$array['chassis']=$product['chassis_no'];
		$array['name']=$contactDetail['name'];
		$array['number']=$contactDetail['mobile'];
		$array['date']=$value['created_at'];
		
		
		if($value['pass']==1){
			$array['action']="<span class='to_pass btn btn-success btn-squared' pass='".$value['pass']."' id=\"".$value['billing_id']."\" title='click to deactive this pass'>Active Pass</span>";
		}else{
			$array['action']="<span class='to_pass btn btn-success btn-squared' pass='".$value['pass']."' id=\"".$value['billing_id']."\" title='click to passing this chassis'>Not Passing</span>";
		}
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 5 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}
?>