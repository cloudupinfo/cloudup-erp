<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");
if($_POST){
	extract($_POST);
	$db = new db();
	$table = "expense";
	
	if(isset($_POST['type']) && ($_POST['type']=="add"))
	{
		
		$admin_id = isset($_POST['admin_id']) ? $_POST['admin_id'] : $_SESSION['admin_id'];
		$branch_id = isset($_POST['branch_id']) ? $_POST['branch_id'] : 0;
		$person = isset($_POST['person']) ? $_POST['person'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$purpose = isset($_POST['purpose']) ? $_POST['purpose'] : '';
		
		$result = $db->insertRow("INSERT INTO ".$table." (`branch_id`,`admin_id`,`person`,`amount`,`purpose`,`updated_at`)VALUES(?,?,?,?,?,NOW())",array($branch_id,$admin_id,$person,$amount,$purpose));
		
		if($result){
			$_SESSION['admin_success'] = "Expense Add Successfully...";
			header('Location:../expense.php');
			exit();
		}else{
			$_SESSION['admin_error'] = "Expense add in Error...";
			header('Location:../expense.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$admin_id = isset($_POST['admin_id']) ? $_POST['admin_id'] : $_SESSION['admin_id'];
		$branch_id = isset($_POST['branch_id']) ? $_POST['branch_id'] : 0;
		$person = isset($_POST['person']) ? $_POST['person'] : '';
		$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
		$purpose = isset($_POST['purpose']) ? $_POST['purpose'] : '';
		
		$update = $db->updateRow("update ".$table." set `branch_id`=?,`admin_id`=?,`person`=?, `amount`=?,`purpose`=?,`updated_at`=NOW()  where `expense_id`=?",array($branch_id,$admin_id,$person,$amount,$purpose,$id));
		
		if(!$update){
			$_SESSION['admin_success'] = "Expense Update Successfully...";
			header('Location:../expense_list.php');
			exit();
		}else{
			$_SESSION['admin_error'] = "Expense Update in Error...";
			header('Location:../expense_list.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="delete"))
	{
		$id = $_POST['mid'];
		$delete = $db->deleteRow("DELETE FROM ".$table." where `expense_id`=?",array($id));
		
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
		header('Location:../expense_list.php');
		exit();
	}
}else{
	header('Location:../expense_list.php');
	exit();
}
?>