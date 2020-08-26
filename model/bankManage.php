<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

if($_POST){
	extract($_POST);
	
	$db = new db();
	$table = "bank";
	
	if(isset($_POST['type']) && ($_POST['type']=="add"))	
	{
		$admin_id = isset($_POST['admin_id']) ? $_SESSION['admin_id'] : $_SESSION['admin_id'];
		$cash_type = isset($_POST['cash_type']) ? $_POST['cash_type'] : '';
			
		$bank_name = isset($_POST['bank_name']) ? $_POST['bank_name'] : '';
		$cheque_no = isset($_POST['cheque_no']) ? $_POST['cheque_no'] : '';
		$cheque_date = isset($_POST['cheque_date']) ? $_POST['cheque_date'] : '';
		$dd_bank_name = isset($_POST['dd_bank_name']) ? $_POST['dd_bank_name'] : '';
		$dd_no = isset($_POST['dd_no']) ? $_POST['dd_no'] : '';
		$dd_date = isset($_POST['dd_date']) ? $_POST['dd_date'] : '';
			
		$price = isset($_POST['price']) ? $_POST['price'] : '';
		$in_word = isset($_POST['in_word']) ? $_POST['in_word'] : '';
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		
		$insert = $db->insertRow("INSERT INTO ".$table." (`admin_id`,`cash_type`,`price`,`in_word`,`bank_name`,`cheque_no`,`cheque_date`,`dd_bank_name`,`dd_no`,`dd_date`,`remark`,`updated_at`)VALUES(?,?,?,?,?,?,?,?,?,?,?,NOW())",array($admin_id,$cash_type,$price,$in_word,$bank_name,$cheque_no,$cheque_date,$dd_bank_name,$dd_no,$dd_date,$remark));

		if($insert){
			$_SESSION['admin_success'] = "Bank Price Add Done...";
			header('Location:../bank.php');
			exit();
		}else{
			$_SESSION['admin_error'] = "Bank Price Add not done...";
			header('Location:../bank.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		
		$admin_id = isset($_POST['admin_id']) ? $_SESSION['admin_id'] : $_SESSION['admin_id'];
		$cash_type = isset($_POST['cash_type']) ? $_POST['cash_type'] : '';
			
		$bank_name = isset($_POST['bank_name']) ? $_POST['bank_name'] : '';
		$cheque_no = isset($_POST['cheque_no']) ? $_POST['cheque_no'] : '';
		$cheque_date = isset($_POST['cheque_date']) ? $_POST['cheque_date'] : '';
		$dd_bank_name = isset($_POST['dd_bank_name']) ? $_POST['dd_bank_name'] : '';
		$dd_no = isset($_POST['dd_no']) ? $_POST['dd_no'] : '';
		$dd_date = isset($_POST['dd_date']) ? $_POST['dd_date'] : '';
			
		$price = isset($_POST['price']) ? $_POST['price'] : '';
		$in_word = isset($_POST['in_word']) ? $_POST['in_word'] : '';
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		
		$update = $db->updateRow("update ".$table." set `admin_id`=?,`cash_type`=?,`price`=?,`bank_name`=?,`cheque_no`=?,`cheque_date`=?,`dd_bank_name`=?,`dd_no`=?,`dd_date`=?,`in_word`=?,`remark`=?,`updated_at`=NOW() where `bank_id`=?",array($admin_id,$cash_type,$price,$bank_name,$cheque_no,$cheque_date,$dd_bank_name,$dd_no,$dd_date,$in_word,$remark,$id));
		
		if(!$update){
			$_SESSION['admin_success'] = "Bank Price Update Sussessfully...";
			header('Location:../bank_list.php');
			exit();
		}else{
			$_SESSION['admin_error'] = "Bank Price Update in error...";
			header('Location:../bank_list.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="delete"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		
		// Delete cashier
		$delete = $db->deleteRow("DELETE FROM ".$table." where `bank_id`=?",array($id));
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
		echo 0;
		exit();
	}
}else{
	echo 0;
	exit();
}
?>