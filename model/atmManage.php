<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");
if($_POST){
	extract($_POST);
	
	$db = new db();
	$table = "atm";
	
	if(isset($_POST['type']) && ($_POST['type']=="add"))
	{
		$admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : $_SESSION['admin_id'];
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		
		$insert = $db->insertRow("INSERT INTO ".$table." (`admin_id`,`amount`,`remark`,`updated_at`)VALUES(?,?,?,NOW())",array($admin_id,$amount,$remark));
		
		if($insert){
			$_SESSION['admin_success'] = "ATM Add Successfully...";
			header('Location:../atm.php');
			exit();
		}else{
			$_SESSION['admin_error'] = "ATM add in Error...";
			header('Location:../atm.php');
			exit();
		}
	
	}
	else if(isset($_POST['type']) && ($_POST['type']=="edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		
		$admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : $_SESSION['admin_id'];
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		
		$update = $db->updateRow("update ".$table." set `admin_id`=?,`amount`=?,`remark`=?,`updated_at`=NOW() where `atm_id`=?",array($admin_id,$amount,$remark,$id));
		
		if(!$update){
			$_SESSION['admin_success'] = "ATM Update Successfully...";
			header('Location:../atm_list.php');
			exit();
		}else{
			$_SESSION['admin_error'] = "ATM Update in Error...";
			header('Location:../atm_list.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="delete"))
	{
		$id = $_POST['mid'];
		
		$delete = $db->deleteRow("DELETE FROM ".$table." where `atm_id`=?",array($id));
		
		if($delete){
			echo 1;
			exit();
		}else{
			echo 0;
			exit();
		}
	}
	else
	{
		header('Location:../atm_list.php');
		exit();
	}
}else{
	header('Location:../atm_list.php');
	exit();
}
?>