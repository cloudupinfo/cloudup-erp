<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

if($_POST){
	extract($_POST);
	
	$db = new db();
	include('../include/functions.php');
	$table = "product";
	$table1 = "gatepass";
	$table2 = "customer_detail";
	
	if(isset($_POST['type']) && ($_POST['type']=="gatepass_search"))
	{
		$search = isset($_POST['search']) ? $_POST['search'] : '';
		$echoJson = "";
		if(!empty($search))
		{
			$search = "%".$search."%";
			$select = $db->getRows("SELECT (`chassis_no`) FROM ".$table." where `chassis_no` LIKE ?",array($search));
			if(count($select)>0)
			{	
				$echoJson .= '<ul class="gatepass_chassis_ul">';
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
			header('Location:../gatepass_chassis_view.php?aid='.$select['chassis_no'].'');
			exit();
		}else{
			$_SESSION['admin_error'] = "Chassis no not found please enter properly...";
			header('Location:../gatepass.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="add"))
	{
		$admin_id = isset($_POST['admin_id']) ? $_POST['admin_id'] : '';
		$customer_detail_id = isset($_POST['customer_detail_id']) ? $_POST['customer_detail_id'] : '';
		$chassis_no = isset($_POST['chassis_no']) ? $_POST['chassis_no'] : '';
		$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
		
		$product = $db->getRow("SELECT (`product_id`) FROM ".$table." where `chassis_no`=?",array($chassis_no));
		if(!empty($product))
		{
			$select = $db->getRow("SELECT * FROM ".$table1." where `product_id`=?",array($product['product_id']));
			if(empty($select))
			{
				$insert = $db->insertRow("INSERT INTO ".$table1." (`admin_id`,`product_id`,`customer_detail_id`,`created_at`,`updated_at`)VALUES(?,?,?,NOW(),NOW())",array($admin_id,$product_id,$customer_detail_id));
				
				$update = $db->updateRow("update ".$table." set `status`=? where `chassis_no`=?",array(3,$chassis_no));
				
				if($insert){
					$_SESSION['admin_success'] = "Gatepass Done...";
					header('Location:../gatepassGenerate/gatepassGenerate.php?aid='.$insert.'&type='.$_POST['print_type']);
					exit();
				}else{
					$_SESSION['admin_error'] = "Gatepass not done...";
					header('Location:../gatepass.php');
					exit();
				}
			}else{
				$_SESSION['admin_error'] = "Gatepass not done...";
				header('Location:../gatepass.php');
				exit();
			}
		}else{
			$_SESSION['admin_error'] = "This Chassis No. not found. Chassis NO is = ".$chassis_no."";
			header('Location:../gatepass.php');
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		
		$customer_detail_id = isset($_POST['customer_detail_id']) ? $_POST['customer_detail_id'] : '';
		$chassis_no = isset($_POST['chassis_no']) ? $_POST['chassis_no'] : '';
		$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
		
		$update = $db->updateRow("update ".$table1." set `customer_detail_id`=?,`product_id`=?,`created_at`=NOW(),`updated_at`=NOW() where `gatepass_id`=?",array($customer_detail_id,$product_id,$id));
		
		if(!$update){
			$_SESSION['admin_success'] = "Gatepass Update Sussessfully...";
			header('Location:../gatepassGenerate/gatepassGenerate.php?aid='.$id.'&type='.$_POST['print_type']);
			exit();
		}else{
			$_SESSION['admin_error'] = "Gatepass Update in error...";
			header('Location:../gatepass.php');
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="gatepass_delete"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		// Find Gatepass 
		$select = $db->getRow("SELECT * FROM ".$table1." where `gatepass_id`=?",array($id));
		if(!empty($select))
		{
			// store data in deleted
			deletedRecord('gatepass',$id,'');
			// bill find
			$billSelect = $db->getRow("SELECT * FROM `billing` where `gatepass_id`=?",array($select['gatepass_id']));
			if(!empty($billSelect))
			{
				// store data in deleted
				deletedRecord('billing',$billSelect['billing_id'],'');
				// Product service find in 
				$serviceSelect = $db->getRows("SELECT * FROM `product_service` where `product_id`=?",array($billSelect['product_id']));
				if(!empty($serviceSelect))
				{
					foreach($serviceSelect as $value)
					{
						// Service Delete
						$serviceDelete = $db->deleteRow("DELETE FROM `product_service` where `product_service_id`=?",array($value['product_service_id']));
					}
				}
				// Bill Delete
				$billDelete = $db->deleteRow("DELETE FROM `billing` where `gatepass_id`=?",array($select['gatepass_id']));
			}
			// Update Main Product page in status 2 mins bill genareted
			$update = $db->updateRow("update ".$table." set `status`=?,`sale`=?,`updated_at`=NOW() where `product_id`=?",array(2,0,$select['product_id']));
			// RTO Delete
			$rtoDelete = $db->deleteRow("DELETE FROM `rto` where `product_id`=?",array($select['product_id']));
			// Delete Gatepss
			$delete = $db->deleteRow("DELETE FROM ".$table1." where `gatepass_id`=?",array($id));
			if($delete){
				echo 1;
				exit();
			}else{
				echo 0;
				exit();
			}
		}
		echo 1;
		exit();
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