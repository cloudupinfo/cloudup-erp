<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

if($_POST){
	extract($_POST);
	
	$db = new db();
	$table = "product";
	$table1 = "branch";
	
	if((isset($_POST['type'])) && ($_POST['type']=="add" || $_POST['type']=="edit"))
	{
		$branch_type = isset($_POST['branch_type']) ? $_POST['branch_type'] : '';
		$chassis_no = isset($_POST['chassis_no']) ? $_POST['chassis_no'] : '';
		//$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		
		$product = $db->getRow("SELECT (`product_id`) FROM ".$table." where `chassis_no`=?",array($chassis_no));
		if(!empty($product))
		{
		
			$update = $db->updateRow("update ".$table." set `branch_id`=?,`updated_at`=NOW() where `product_id`=?",array($branch_type,$product['product_id']));
			
			if(!$update){
				$_SESSION['admin_success'] = "Branch Add Successfully...";
				header('Location:../branch_list.php');
				exit();
			}else{
				$_SESSION['admin_error'] = "Branch Add Unsuccessfully...";
				header('Location:../branch_list.php');
				exit();
			}
		}else{
			$_SESSION['admin_error'] = "This Chassis not found.";
			header('Location:../branch_list.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="delete"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		
		$update = $db->updateRow("update ".$table." set `branch_id`=?,`updated_at`=NOW() where `product_id`=?",array(0,$id));
		
		if($update){
			echo 1;
			exit();
		}else{
			echo 0;
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="status"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : '';
		$select = $db->getRow("SELECT * FROM ".$table1." where `branch_id`=?",array($id));
		if(!empty($select))
		{
			// Product On Sale
			$updateProduct = $db->updateRow("update ".$table." set `status`=?,`sale`=?,`updated_at`=NOW() where `product_id`=?",array(4,1,$select['product_id']));
			
			// Branch Update
			$update = $db->updateRow("update ".$table1." set `status`=?,`updated_at`=NOW() where `branch_id`=?",array(1,$id));
			
			if(!$update){
				echo 1;
				exit();
			}else{
				echo 0;
				exit();
			}
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