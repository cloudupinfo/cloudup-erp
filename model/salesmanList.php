<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "salesman";

$array = array();

$row = $db->numRow("SELECT (`salesman_id`) FROM ".$table."",array());
if($row > 0)
{
	$result = $db->getRows("SELECT * FROM ".$table." ORDER BY `created_at` DESC",array());
	
	$i = 0; $id=1;
	$main_array = array();

	foreach ($result as $key => $value) {
		$array = array();
		$array['id'] = $id;
		
		$array['name'] = $value['name'];
		$array['mobile'] = $value['mobile'];
		$array['address'] = $value['address'];
		
		if($value['status']==1)
			$array['status']="<a class='to_status btn btn-success btn-squared' status='".$value['status']."' id=\"".$value['salesman_id']."\"  href title='click to deactive'> Active </a>";
		else
			$array['status']="<a class='to_status btn btn-danger btn-squared' status='".$value['status']."' id=\"".$value['salesman_id']."\" tablename='".$table."' fieldname='status' href title='click to active'> Deactive </a>";
		
		$array['action']="<a class='btn btn-success btn-squared' title='Click To Edit' href=\"salesman.php?aid=".$value['salesman_id']."\"><i class=\"fa fa-edit\"></i></a> &nbsp <a class='btn btn-danger btn-squared' title='Click To Delete' class=to_delete id=\"".$value['salesman_id']."\" href ><i class=\"fa fa-trash-o\"></i></a>";
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 6 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}

?>