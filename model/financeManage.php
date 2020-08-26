<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

if($_POST){
	extract($_POST);
	
	$db = new db();
	$table = "finance";
	if(isset($_POST['type']) && ($_POST['type']=="delete"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		$select = $db->getRow("SELECT * FROM ".$table." where `finance_id`=?",array($id));
		if(!empty($select))
		{
			// upadate product price table in pending amount
			$productPrice = $db->getRow("SELECT (`pending`) FROM `product_price` where `product_id`=?",array($select['product_id']));
			$update = $db->updateRow("update `product_price` set `pending`=?,`updated_at`=NOW() where `product_id`=?",array($productPrice['pending']+$select['finance_amount'],$select['product_id']));
			
			$delete = $db->deleteRow("DELETE FROM ".$table." where `finance_id`=?",array($id));
		
			if($delete){
				echo 1;
				exit();
			}else{
				echo 0;
				exit();
			}
		}else{
			echo 0;
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="status"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
	
		$update = $db->updateRow("update ".$table." set `status`=? where `finance_id`=?",array(1,$id));
		
		if($update){
			echo 1;
			exit();
		}else{
			echo 0;
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