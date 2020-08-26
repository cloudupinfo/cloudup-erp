<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

if($_POST){
	extract($_POST);
	
	$db = new db();
	$table = "product";
	$table1 = "dealer";
	
	if(isset($_POST['type']) && ($_POST['type']=="dealer_search"))
	{
		$search = isset($_POST['search']) ? $_POST['search'] : '';
		$echoJson = "";
		if(!empty($search))
		{
			$search = "%".$search."%";
			$select = $db->getRows("SELECT (`chassis_no`) FROM ".$table." where `chassis_no` LIKE ?",array($search));
			if(count($select)>0)
			{	
				$echoJson .= '<ul class="chasier_chassis_ul">';
				foreach($select as $value){
					$echoJson .= '<li>'.$value['chassis_no'].'</li>';
				}
				$echoJson .= '</ul>';
			}
		}
		echo $echoJson;
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="search"))
	{
		$search = isset($_POST['search']) ? $_POST['search'] : '';
		$select = $db->getRow("SELECT (`chassis_no`) FROM ".$table." where `chassis_no`=?",array($search));
		if($select){
			//$_SESSION['admin_success'] = "Generate Unsuccessfully...";
			header('Location:../dealer_search.php?aid='.$select['chassis_no'].'');
			exit();
		}else{
			$_SESSION['admin_error'] = "Chassis no not found please enter properly...";
			header('Location:../dealer.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="add"))
	{
		$admin_id = isset($_POST['admin_id']) ? $_SESSION['admin_id'] : $_SESSION['admin_id'];
		$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$address = isset($_POST['address']) ? $_POST['address'] : '';
		$price = isset($_POST['price']) ? $_POST['price'] : '';
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		
		$product = $db->getRow("SELECT * FROM ".$table." where `product_id`=?",array($product_id));
		if(!empty($product))
		{
			//Insert Code
			$insert = $db->insertRow("INSERT INTO ".$table1." (`admin_id`,`product_id`,`name`,`address`,`price`,`remark`,`updated_at`)VALUES(?,?,?,?,?,?,NOW())",array($admin_id,$product['product_id'],$name,$address,$price,$remark));
			
			if($insert){
				$_SESSION['admin_success'] = "Add Successfully...";
				header('Location:../dealer.php');
				exit();
			}else{
				$_SESSION['admin_error'] = "Add not done...";
				header('Location:../dealer.php');
				exit();
			}
		}else{
			$_SESSION['admin_error'] = "This Chassis not found.";
			header('Location:../dealer.php');
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		
		$admin_id = isset($_POST['admin_id']) ? $_SESSION['admin_id'] : $_SESSION['admin_id'];
		$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$address = isset($_POST['address']) ? $_POST['address'] : '';
		$price = isset($_POST['price']) ? $_POST['price'] : '';
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		
		$product = $db->getRow("SELECT * FROM ".$table." where `product_id`=?",array($product_id));
		if(!empty($product))
		{
			$update = $db->updateRow("update ".$table1." set `product_id`=?,`name`=?,`address`=?,`price`=?,`remark`=?,`updated_at`=NOW() where `dealer_id`=?",array($product_id,$name,$address,$price,$remark,$id));
			
			if(!$update){
				$_SESSION['admin_success'] = "Update Successfully...";
				header('Location:../dealer.php');
				exit();
			}else{
				$_SESSION['admin_error'] = "Update not done...";
				header('Location:../dealer.php');
				exit();
			}
		}else{
			$_SESSION['admin_error'] = "This Chassis not found.";
			header('Location:../dealer.php');
			exit();
		}
		
	}
	else if(isset($_POST['type']) && ($_POST['type']=="delete"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		// Find Cashier 
		$select = $db->getRow("SELECT * FROM ".$table1." where `dealer_id`=?",array($id));
		if(!empty($select))
		{
			$product = $db->getRow("SELECT * FROM `product` where `product_id`=?",array($select['product_id']));
			if(!empty($product))
			{
				// Update Main Product page in status 1 mins bill genareted
				$update = $db->updateRow("update `product` set `status`=?,`sale`=?,`updated_at`=NOW() where `product_id`=?",array(1,0,$product['product_id']));
				// Delete cashier
				$delete = $db->deleteRow("DELETE FROM ".$table1." where `dealer_id`=?",array($id));
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