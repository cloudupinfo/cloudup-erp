<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");
if($_POST){
	extract($_POST);
	
	$db = new db();
	$table = "salesman";
	
	if(isset($_POST['type']) && ($_POST['type']=="add"))
	{
		$name = isset($_POST['name']) ? $db->string_format($_POST['name'],true,'upper') : '';
		$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
		$address = isset($_POST['address']) ? $_POST['address'] : '';
		
		$res = $db->getRow("SELECT * FROM ".$table." where `name`=?",array($name));
		
		if($res)
		{
			$_SESSION['admin_error'] = "Sales Man All Ready Exisest...";
			header('Location:../salesman.php');
			exit();
		}
		else
		{
			$result = $db->insertRow("INSERT INTO ".$table." (`name`,`mobile`,`address`,`created_at`,`updated_at`)VALUES(?,?,?,NOW(),NOW())",array($name,$mobile,$address));
			
			if($result){
				$_SESSION['admin_success'] = "Sales Man Add Successfully...";
				header('Location:../salesman.php');
				exit();
			}else{
				$_SESSION['admin_error'] = "Sales Man add in Error...";
				header('Location:../salesman.php');
				exit();
			}
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		
		$name = isset($_POST['name']) ? $db->string_format($_POST['name'],true,'upper') : '';
		$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
		$address = isset($_POST['address']) ? $_POST['address'] : '';
		
		$update = $db->updateRow("update ".$table." set `name`=?,`mobile`=?,`address`=?,`updated_at`=NOW() where `salesman_id`=?",array($name,$mobile,$address,$id));
		
		if(!$update){
			$_SESSION['admin_success'] = "Sales Man Update Successfully...";
			header('Location:../salesman_list.php');
			exit();
		}else{
			$_SESSION['admin_error'] = "Sales Man Update in Error...";
			header('Location:../salesman_list.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="delete"))
	{
		$id = $_POST['mid'];
		
		$delete = $db->deleteRow("DELETE FROM ".$table." where `salesman_id`=?",array($id));
		
		if($delete){
			echo 1;
			exit();
		}else{
			echo 0;
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="status"))
	{
		$id = $_POST['mid'];
		$status = $_POST['status'];
		$update = $db->updateRow("update ".$table." set `status`=? where `salesman_id`=?",array($status,$id));
		
		if($update){
			echo 1;
			exit();
		}else{
			echo 0;
			exit();
		}
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