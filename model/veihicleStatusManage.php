<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

if($_POST){
	extract($_POST);
	
	$db = new db();
	$table = "product";
	
	if(isset($_POST['type']) && ($_POST['type']=="veihicle_status_search"))
	{
		$search = isset($_POST['search']) ? $_POST['search'] : '';
		$echoJson = "";
		if(!empty($search))
		{
			$search = "%".$search."%";
			$select = $db->getRows("SELECT (`chassis_no`) FROM ".$table." where `chassis_no` LIKE ?",array($search));
			if(count($select)>0)
			{	
				$echoJson .= '<ul class="veihicle_status_chassis_ul">';
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
		
		$select = $db->getRow("SELECT `chassis_no`,`status` FROM ".$table." where `chassis_no`=?",array($search));
		
		if($select)
		{
			if($select['status']==2)
				$productStatus = "Customer Select And Deposite The Cash Amount ";
			else if($select['status']==3)
				$productStatus = "Gate Pass will be generated ";
			else if($select['status']==4)
				$productStatus = "Bill will be generated ";
			else
				$productStatus = "In Showroom ";
			$_SESSION['admin_success'] = "Chassis No view full Detail in below... Status is = ".$productStatus."";
			header('Location:../veihicle_status.php?aid='.$select['chassis_no'].'');
			exit();
		}else{
			$_SESSION['admin_error'] = "Chassis no not found please enter properly...";
			header('Location:../veihicle_status.php');
			exit();
		}
	}
	else
	{
		$_SESSION['admin_error'] = "Somethings is error...";
		header('Location:../veihicle_status.php');
		exit();
	}
}else{
	echo 0;
	exit();
}
?>