<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");
	
if($_POST){
	extract($_POST);
	
	$db = new db();
	$table = "product";
	$table1 = "billing";
	$table2 = "customer_detail";
	$table3 = "gatepass";
	$table4 = "product_service";
	$table5 = "rto";
	
	if(isset($_POST['type']) && ($_POST['type']=="rto_search"))
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
			header('Location:../rto_view.php?aid='.$select['chassis_no'].'');
			exit();
		}else{
			$_SESSION['admin_error'] = "Chassis no not found please enter properly...";
			header('Location:../rto.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="add"))
	{
		$admin_id = isset($_POST['admin_id']) ? $_POST['admin_id'] : $_SESSION['admin_id'];
		$chassis_no = isset($_POST['chassis_no']) ? $_POST['chassis_no'] : '';
		
		$product = $db->getRow("SELECT `product_id`,`chassis_no` FROM ".$table." where `chassis_no`=?",array($chassis_no));
		if(!empty($product))
		{
			$select = $db->getRow("SELECT * FROM ".$table5." where `product_id`=?",array($product['product_id']));
			if(empty($select))
			{
				// billing generate or not check
				$billing = $db->getRow("SELECT (`billing_id`) FROM ".$table1." where `product_id`=?",array($product['product_id']));
				if(!empty($billing))
				{
					$insert = $db->insertRow("INSERT INTO ".$table5." (`admin_id`,`product_id`,`billing_id`,`updated_at`)VALUES(?,?,?,NOW())",array($admin_id,$product['product_id'],$billing['billing_id']));
					
					if($insert){
						$_SESSION['admin_success'] = "RTO Done Successfully... ";
						header('Location:../rto_list.php');
						exit();
					}else{
						$_SESSION['admin_error'] = "RTO not done Something Error Please Type Anther Time...";
						header('Location:../rto.php');
						exit();
					}
				}else{
					$_SESSION['admin_error'] = "Bill Not Generated Generate Bill then Continue...";
					header('Location:../rto.php');
					exit();
				}
			}else{
				$_SESSION['admin_error'] = "RTO Generated Generated Go to list and check...";
				header('Location:../rto_list.php');
				exit();
			}
		}else{
			$_SESSION['admin_error'] = "This Chassis No. not found. Chassis NO is = ".$chassis_no."";
			header('Location:../rto.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$admin_id = isset($_POST['admin_id']) ? $_POST['admin_id'] : $_SESSION['admin_id'];
		$chassis_no = isset($_POST['chassis_no']) ? $_POST['chassis_no'] : '';
		
		$product = $db->getRow("SELECT `product_id`,`chassis_no` FROM ".$table." where `chassis_no`=?",array($chassis_no));
		if(!empty($product))
		{
			// billing generate or not check
			$billing = $db->getRow("SELECT (`billing_id`) FROM ".$table1." where `product_id`=?",array($product['product_id']));
			if(!empty($billing))
			{
				// Check RTO Inserted Or Not
				$select = $db->getRow("SELECT * FROM ".$table5." where `product_id`=?",array($product['product_id']));
				if(!empty($select))
				{
					$update = $db->updateRow("update ".$table5." set `admin_id`=?,`product_id`=?,`billing_id`=?,`updated_at`=NOW() where `rto_id`=?",array($admin_id,$product['product_id'],$billing['billing_id'],$id));
					
					if(!$update){
						$_SESSION['admin_success'] = "RTO Update Sussessfully...";
						header('Location:../rto_list.php');
						exit();
					}else{
						$_SESSION['admin_error'] = "RTO Update in error...";
						header('Location:../rto_list.php');
						exit();
					}
				}else{
					$_SESSION['admin_error'] = "RTO Not Generated Go to rto search and add...";
					header('Location:../rto.php');
					exit();
				}
			}else{
				$_SESSION['admin_error'] = "Bill Not Generated Generate Bill then Continue...";
				header('Location:../rto.php');
				exit();
			}
		}else{
			$_SESSION['admin_error'] = "This Chassis No. not found. Chassis NO is = ".$chassis_no."";
			header('Location:../billing.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="delete"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		// RTO find
		$select = $db->getRow("SELECT * FROM ".$table5." where `rto_id`=?",array($id));
		if(!empty($select))
		{
			// RTO Delete
			$delete = $db->deleteRow("DELETE FROM ".$table5." where `rto_id`=?",array($id));
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
		header('Location:../rto.php');
		exit();
	}
}else{
	header('Location:../rto.php');
	exit();
}
?>