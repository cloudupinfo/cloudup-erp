<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "veihicle";

$array = array();

$row = $db->numRow("SELECT (`veihicle_id`) FROM ".$table."",array());
if($row > 0)
{
	$result = $db->getRows("SELECT * FROM ".$table." ORDER BY `created_at` DESC",array());
	
	$i = 0; $id=1;
	$main_array = array();

	foreach ($result as $key => $value) {
		$array = array();
		$array['id'] = $id;
		
		$array['name'] = $value['name'];
		$array['price'] = $value['price'];
		$array['rto_single'] = $value['rto_single'];
		$array['rto_double'] = $value['rto_double'];
		$array['no_plate_fitting'] = $value['no_plate_fitting'];
		$array['rmc_tax'] = $value['rmc_tax'];
		$array['side_stand'] = $value['side_stand'];
		$array['foot_rest'] = $value['foot_rest'];
		$array['leg_guard'] = $value['leg_guard'];
		$array['chrome_set'] = $value['chrome_set'];
		$array['amc'] = $value['amc'];
		$array['ex_warranty'] = $value['ex_warranty'];
		$array['insurance'] = $value['insurance'];
		$array['2_year_insurance'] = $value['2_year_insurance'];
		$array['3_year_insurance'] = $value['3_year_insurance'];
		$array['weight'] = $value['weight'];
		$array['cc'] = $value['cc'];
		$array['body'] = $value['body'];
		$array['c_of_v'] = $value['c_of_v'];
		$array['remark'] = nl2br($value['remark']);
		
		if($value['status']==1)
			$array['status']="<a class='to_status btn btn-success btn-squared' status='".$value['status']."' id=\"".$value['veihicle_id']."\"  href title='click to deactive'> Active </a>";
		else
			$array['status']="<a class='to_status btn btn-danger btn-squared' status='".$value['status']."' id=\"".$value['veihicle_id']."\" tablename='".$table."' fieldname='status' href title='click to active'> Deactive </a>";
		
		$array['action']="<a class='btn btn-success btn-squared' title='Click To Edit Model' href=\"model.php?aid=".$value['veihicle_id']."\"><i class=\"fa fa-edit\"></i></a>";
		//<a class='btn btn-danger btn-squared' title='Click To Delete Model' class=to_delete id=\"".$value['veihicle_id']."\" href ><i class=\"fa fa-trash-o\"></i></a>
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 23 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}

?>