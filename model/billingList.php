<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "billing";
$table1 = "product";
$table2 = "customer_detail";
$type = isset($_POST['type']) ? $_POST['type'] : '';
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$today = "%".date("Y-m-d")."%";

$array = array();
if($type=="today"){
	$row = $db->numRow("SELECT (`billing_id`) FROM ".$table." where `updated_at` LIKE ?",array($today));
}else{
	if(!empty($dateTo) && !empty($dateFrom)){
		$row = $db->numRow("SELECT (`billing_id`) FROM ".$table." where `updated_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
	}else{
		$row = $db->numRow("SELECT (`billing_id`) FROM ".$table."",array());
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
		$array['id'] = str_pad($value['billing_id'], 3, "0", STR_PAD_LEFT);
		
		//Product Detail
		$product = $db->getRow("SELECT * FROM ".$table1." where `product_id`=?",array($value['product_id']));
		// Cutomer Detail
		$customer = $db->getRow("SELECT * FROM ".$table2." where `customer_detail_id`=?",array($value['customer_detail_id']));
		// Sales Man
		$salesman = $db->getRow("SELECT `name` FROM `salesman` where `salesman_id`=?",array($customer['salesman_id']));
		// Customer Payment Detail
		$product_paymnet = $db->getRow("SELECT * FROM `product_price` where `product_id`=?",array($customer['product_id']));
		
		$array['chassis_no'] = $product['chassis_no'];
		$array['model'] = $product['model'];
		$array['color'] = $product['color'];
		$array['sales_man'] = $salesman['name'];
		
		$array['name'] = $customer['name'];
		$array['mobile'] = $customer['mobile'];
		
		//$array['price'] = $product_paymnet['total'];
		
		$array['remark'] = $customer['remark'];
		$array['created_at'] = date("Y-m-d h:i A",strtotime($value['updated_at']));
		
		$array['detail']="<a class='btn btn-success btn-squared' title='Click to Print Customer Detail' target='_blank' href='bill_customer_1.php?aid=".$customer['customer_detail_id']."'>Cus-<i class=\"fa fa-print\"></i></a> <br> <a class='btn btn-success btn-squared' title='Click to Print Customer Service' target='_blank' href='bill_customer_2.php?aid=".$customer['customer_detail_id']."'>Ser-<i class=\"fa fa-print\"></i></a>";
		
		$array['print']="<a class='btn btn-success btn-squared' title='Click to Print Veihicle Invoice' target='_blank' href='invoice/bill-invoice.php?id=".$value['billing_id']."&type=Original'>Vei-<i class=\"fa fa-print\"></i></a> <br> <a class='btn btn-success btn-squared' title='Click to Print Accessories Invoice' target='_blank' href='invoice/bill-acc-invoice.php?id=".$value['billing_id']."&type=Original'>Ass-<i class=\"fa fa-print\"></i></a>";
		
		$array['action']="<a class='btn btn-success btn-squared' title='Click to Edit' href=\"billing_view.php?aid=".$product['chassis_no']."\"><i class=\"fa fa-edit\"></i></a> <br> <a title='Click to Delete' class='to_delete btn btn-danger btn-squared' id=\"".$value['billing_id']."\" href ><i class=\"fa fa-trash-o\"></i></a> <br> <a title='Click to View More Detail' class='btn btn-teal btn-squared' target='_blank' href='billing_detail_view.php?aid=".$value['billing_id']."'><i class=\"clip-note\"></i></a>";
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 13 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}

?>