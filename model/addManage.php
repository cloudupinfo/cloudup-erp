<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");
if($_POST){
	extract($_POST);
	$db = new db();
	$table = "admin";
	
	if(isset($_POST['type']) && ($_POST['type']=="delete"))
	{
		$id = $_POST['mid'];
		
		$update = $db -> updateRow("update ".$table." set `delete`=?,`updated_at`=NOW() where `admin_id`=?",array(1,$id));
			
		if(!$update){
			$_SESSION['admin_success'] = "Delete Successfully...";
			echo 1;
			exit();
		}else{
			$_SESSION['admin_error'] = "Delete in Error...";
			echo 0;
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="status"))
	{
		$id = $_POST['mid'];
		$status = $_POST['status'];
		$update = $db->updateRow("update ".$table." set `status`=? where `admin_id`=?",array($status,$id));
		
		if($update){
			echo 1;
			exit();
		}else{
			echo 0;
			exit();
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="add"))
	{
		$role = $_POST['role'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$unique = $db->generateRandomString();
		
		$res = $db->getRow("SELECT * FROM ".$table." where (`role`=?) AND (`email`=? or `username`=?)",array($role,$email,$username));
		
		if($res){
			$_SESSION['admin_error'] = "All Ready Exisest...";
			echo 2;
			exit();
		}else
		{
			$limits = $db->getRows("SELECT * FROM ".$table." where `role`=?",array($role));
			if(!empty($limits))
			{
				$_SESSION['admin_error'] = "You Not Add More Same Roll This Ready Exisest Contact Main Admin...";
				echo 2;
				exit();
			}else{
				$insert = $db->insertRow("INSERT INTO ".$table." (`unique_id`,`email`,`username`,`password`,`role`,`created_at`,`updated_at`) VALUES (?,?,?,?,?,NOW(),NOW())",array($unique,$email,$username,$db->passwordEncrypt($password),$role));
				
				$admin_id = $insert;
				if($insert){
					if($role == 'subadmin'){
						$db->insertRow("INSERT INTO `admin_setting` (`admin_id`,`model`,`dealer`,`sales_man`,`branch`,`showroom`,`cashier`,`expence`,`exchange`,`finance`,`atm`,`bank`,`gatepass`,`billing`,`rto`,`report`,`re_passing`,`re_total`,`re_stock`,`re_incentive`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($admin_id,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
					}else if($role == 'cashier'){
						$db->insertRow("INSERT INTO `admin_setting` (`admin_id`,`cashier`,`expence`,`exchange`,`finance`,`atm`,`bank`,`report`,`re_total`) VALUES (?,?,?,?,?,?,?,?,?)",array($admin_id,1,1,1,1,1,1,1,1));
					}else if($role == 'billing'){
						$db->insertRow("INSERT INTO `admin_setting` (`admin_id`,`billing`) VALUES (?,?)",array($admin_id,1));
					}else if($role == 'rto'){
						$db->insertRow("INSERT INTO `admin_setting` (`admin_id`,`rto`) VALUES (?,?)",array($admin_id,1));
					}

					$_SESSION['admin_success'] = "Add Successfully...";
					echo 1;
					exit();
				}else{
					$_SESSION['admin_error'] = "Add in Problem...";
					echo 0;
					exit();
				}
			}
		}
		exit();
	}
	else if(isset($_POST['type']) && ($_POST['type']=="edit"))
	{	
		$id = $_POST['id'];
		$role = $_POST['role'];
		//$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		if($password == '******'){
			$update = $db -> updateRow("update ".$table." set `email`=?,`role`=?,`updated_at`=NOW() where `admin_id`=?",array($email,$role,$id));
		}else{
			$update = $db -> updateRow("update ".$table." set `email`=?,`password`=?,`role`=?,`updated_at`=NOW() where `admin_id`=?",array($email,$db->passwordEncrypt($password),$role,$id));
		}
			
		if(!$update){
			$_SESSION['admin_success'] = "Update Successfully...";
			echo 11;
			exit();
		}else{
			$_SESSION['admin_error'] = "Update in Error...";
			echo 00;
			exit();
		}
		echo 00;
		exit();	
	}else{
		echo 0;
		exit();
	}
}else{
	echo 0;
	exit();
}
?>