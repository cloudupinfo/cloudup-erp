<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

if($_POST){
	extract($_POST);
	
	$db = new db();
	$table = "exchange";
	if(isset($_POST['type']) && ($_POST['type']=="delete"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		$select = $db->getRow("SELECT * FROM ".$table." where `exchange_id`=?",array($id));
		if(!empty($select))
		{
			// upadate product price table in pending amount
			$productPrice = $db->getRow("SELECT (`pending`) FROM `product_price` where `product_id`=?",array($select['product_id']));
			$update = $db->updateRow("update `product_price` set `pending`=?,`updated_at`=NOW() where `product_id`=?",array($productPrice['pending']+$select['amount'],$select['product_id']));
			
			$delete = $db->deleteRow("DELETE FROM ".$table." where `exchange_id`=?",array($id));
			if($delete){
				echo 1;
				exit();
			}else{
				echo 0;
				exit();
			}
		}else{
			echo 1;
			exit();
		}
	}
	else
	{
		echo 0;
		exit();
	}
}else{
	echo 0;
	exit();
}
?>