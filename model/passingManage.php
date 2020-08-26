<?php include_once("../config/PDO.php");
if($_POST){
	extract($_POST);
	$db = new db();
	$table = "billing";
	
	if(isset($_POST['type']) && ($_POST['type']=="pass"))
	{
		$id = isset($_POST['mid']) ? $_POST['mid'] : 0;
		$pass = isset($_POST['pass']) ? $_POST['pass'] : 0;
		
		$result1 = $db->updateRow("update ".$table." set `pass`=? where `billing_id`=?",array("1",$id));
		
		if(!$result1){
			$_SESSION['notification_success'] = "Passing Successfully...";
			echo 1;
			exit();
		}else{
			$_SESSION['notification_error'] = "Passing in Error...";
			echo 0;
			exit();
		}
		exit();
	}else{
		$_SESSION['notification_error'] = "Passing in Error...";
		header('Location:../passing_list.php');
		exit();
	}
}else{
	$_SESSION['notification_error'] = "Passing in Error...";
	header('Location:../passing_list.php');
	exit();
}
?>