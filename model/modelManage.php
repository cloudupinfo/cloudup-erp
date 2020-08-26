<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");
if($_POST){
	extract($_POST);
	
	$db = new db();
	$table = "veihicle";
	
	if(isset($_POST['type']) && ($_POST['type']=="add"))
	{
		$name = isset($_POST['name']) ? $db->string_format($_POST['name'],true,'upper') : '';
		$price = isset($_POST['price']) ? $_POST['price'] : '';
		$weight = isset($_POST['weight']) ? $_POST['weight'] : '';
		$cc = isset($_POST['cc']) ? $_POST['cc'] : '';
		$body = isset($_POST['body']) ? $db->string_format($_POST['body'],true,'upper') : '';
		$c_of_v = isset($_POST['c_of_v']) ? $db->string_format($_POST['c_of_v'],true,'upper') : '';
		$rto_single = isset($_POST['rto_single']) ? $_POST['rto_single'] : '';
		$rto_double = isset($_POST['rto_double']) ? $_POST['rto_double'] : '';
		$insurance = isset($_POST['insurance']) ? $_POST['insurance'] : '';
		$no_plate_fitting = isset($_POST['no_plate_fitting']) ? $_POST['no_plate_fitting'] : '';
		$rmc_tax = isset($_POST['rmc_tax']) ? $_POST['rmc_tax'] : '';
		$side_stand = isset($_POST['side_stand']) ? $_POST['side_stand'] : '';
		$foot_rest = isset($_POST['foot_rest']) ? $_POST['foot_rest'] : '';
		$leg_guard = isset($_POST['leg_guard']) ? $_POST['leg_guard'] : '';
		$chrome_set = isset($_POST['chrome_set']) ? $_POST['chrome_set'] : '';
		$amc = isset($_POST['amc']) ? $_POST['amc'] : '';
		$ex_warranty = isset($_POST['ex_warranty']) ? $_POST['ex_warranty'] : '';
		$year_2_insurance = isset($_POST['year_2_insurance']) ? $_POST['year_2_insurance'] : '';
		$year_3_insurance = isset($_POST['year_3_insurance']) ? $_POST['year_3_insurance'] : '';
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		
		$res = $db->getRow("SELECT * FROM ".$table." where `name`=?",array($name));
		if($res)
		{
			$_SESSION['admin_error'] = "Model All Ready Exisest...";
			header('Location:../model.php');
			exit();
		}
		else
		{
			$result = $db->insertRow("INSERT INTO ".$table." (`name`,`c_of_v`,`weight`,`cc`,`body`,`price`,`rto_single`,`rto_double`,`insurance`,`no_plate_fitting`,`rmc_tax`,`side_stand`,`foot_rest`,`leg_guard`,`chrome_set`,`amc`,`ex_warranty`,`2_year_insurance`,`3_year_insurance`,`remark`,`created_at`,`updated_at`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())",array($name,$c_of_v,$weight,$cc,$body,$price,$rto_single,$rto_double,$insurance,$no_plate_fitting,$rmc_tax,$side_stand,$foot_rest,$leg_guard,$chrome_set,$amc,$ex_warranty,$year_2_insurance,$year_3_insurance,$remark));
			
			if($result){
				$_SESSION['admin_success'] = "Model Add Successfully...";
				header('Location:../model.php');
				exit();
			}else{
				$_SESSION['admin_error'] = "Model add in Error...";
				header('Location:../model.php');
				exit();
			}
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="edit"))
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		
		//$name = isset($_POST['name']) ? $_POST['name'] : '';
		$price = isset($_POST['price']) ? $_POST['price'] : '';
		$weight = isset($_POST['weight']) ? $_POST['weight'] : '';
		$cc = isset($_POST['cc']) ? $_POST['cc'] : '';
		$body = isset($_POST['body']) ? $db->string_format($_POST['body'],true,'upper') : '';
		$c_of_v = isset($_POST['c_of_v']) ? $db->string_format($_POST['c_of_v'],true,'upper') : '';
		$rto_single = isset($_POST['rto_single']) ? $_POST['rto_single'] : '';
		$rto_double = isset($_POST['rto_double']) ? $_POST['rto_double'] : '';
		$insurance = isset($_POST['insurance']) ? $_POST['insurance'] : '';
		$no_plate_fitting = isset($_POST['no_plate_fitting']) ? $_POST['no_plate_fitting'] : '';
		$rmc_tax = isset($_POST['rmc_tax']) ? $_POST['rmc_tax'] : '';
		$side_stand = isset($_POST['side_stand']) ? $_POST['side_stand'] : '';
		$foot_rest = isset($_POST['foot_rest']) ? $_POST['foot_rest'] : '';
		$leg_guard = isset($_POST['leg_guard']) ? $_POST['leg_guard'] : '';
		$chrome_set = isset($_POST['chrome_set']) ? $_POST['chrome_set'] : '';
		$amc = isset($_POST['amc']) ? $_POST['amc'] : '';
		$ex_warranty = isset($_POST['ex_warranty']) ? $_POST['ex_warranty'] : '';
		$year_2_insurance = isset($_POST['year_2_insurance']) ? $_POST['year_2_insurance'] : '';
		$year_3_insurance = isset($_POST['year_3_insurance']) ? $_POST['year_3_insurance'] : '';
		$remark = isset($_POST['remark']) ? $_POST['remark'] : '';
		
		$update = $db->updateRow("update ".$table." set `c_of_v`=?,`weight`=?,`cc`=?,`body`=?,`price`=?,`rto_single`=?,`rto_double`=?,`insurance`=?,`no_plate_fitting`=?,`rmc_tax`=?,`side_stand`=?,`foot_rest`=?,`leg_guard`=?,`chrome_set`=?,`amc`=?,`ex_warranty`=?,`2_year_insurance`=?,`3_year_insurance`=?,`remark`=? where `veihicle_id`=?",array($c_of_v,$weight,$cc,$body,$price,$rto_single,$rto_double,$insurance,$no_plate_fitting,$rmc_tax,$side_stand,$foot_rest,$leg_guard,$chrome_set,$amc,$ex_warranty,$year_2_insurance,$year_3_insurance,$remark,$id));
		
		if(!$update){
			$_SESSION['admin_success'] = "Model Update Successfully...";
			header('Location:../model_list.php');
			exit();
		}else{
			$_SESSION['admin_error'] = "Model Update in Error...";
			header('Location:../model_list.php');
			exit();
		}
	}
	else if(isset($_POST['type']) && ($_POST['type']=="delete"))
	{
		$id = $_POST['mid'];
		
		$delete = $db->deleteRow("DELETE FROM ".$table." where `veihicle_id`=?",array($id));
		
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
		$update = $db->updateRow("update ".$table." set `status`=? where `veihicle_id`=?",array($status,$id));
		
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