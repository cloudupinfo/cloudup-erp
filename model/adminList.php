<?php include_once('../include/comman_model_session.php');
ob_start();
include_once("../config/PDO.php");

error_reporting(E_ALL);

$db = new db();

$table = "admin";
$array = array();

$row = $db->numRow("SELECT (`admin_id`) FROM ".$table." where `role`!=? and `delete`=?",array("main",0));

if($row > 0)
{
	$result = $db->getRows("SELECT * FROM ".$table." where `role`!=? and `delete`=?",array("main",0));
	$i = 0; $id=1;
	$main_array = array();

	foreach ($result as $key => $value) {
		$array = array();
		$array['id'] = $id;
		$array['username'] = $value['username'];
		$array['email'] = $value['email'];
		$array['password'] = $value['password'];
		
		if($value['role']=="cashier"){
			$array['role']="<button class=' btn btn-primary btn-squared' role='".$value['role']."' id=\"".$value['admin_id']."\" tablename='".$table."' fieldname='role' href > Cashier </button>";
		}else if($value['role']=="billing"){
			$array['role']="<button class=' btn btn-blue btn-squared' role='".$value['role']."' id=\"".$value['admin_id']."\" tablename='".$table."' fieldname='role' href > Billing </button>";
		}else if($value['role']=="rto"){
			$array['role']="<button class=' btn btn-teal btn-squared' role='".$value['role']."' id=\"".$value['admin_id']."\" tablename='".$table."' fieldname='role' href > RTO </button>";
		}else{
			$array['role']="<button class='btn btn-info btn-squared' role='".$value['role']."' id=\"".$value['admin_id']."\"> Sub Admin </button>";
		}
		if($value['status']==1){
			$array['status']="<a class='to_status btn btn-success btn-squared' status='".$value['status']."' id=\"".$value['admin_id']."\"  href title='click to Deactive'> Active </a>";
		}else{
			$array['status']="<a class='to_status btn btn-danger btn-squared' status='".$value['status']."' id=\"".$value['admin_id']."\" tablename='".$table."' fieldname='status' href title='click to active'> Deactive </a>";
		}
		
		$array['action']="<a title='Click To Edit' class='btn btn-success btn-squared' href=\"admin.php?aid=".$value['admin_id']."\"><i class=\"fa fa-edit\"></i></a> <a title='Click To Delete' class='to_delete btn btn-danger btn-squared' id=\"".$value['admin_id']."\" href ><i class=\"fa fa-trash-o\"></i></a>";
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 7 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}

?>