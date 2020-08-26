<?php include_once('../include/comman_model_session.php');
include_once("../config/PDO.php");

$db = new db();

$table = "product";
$table1 = "veihicle";
$type = isset($_POST['type']) ? $_POST['type'] : '';
$dateTo = isset($_REQUEST['to']) ? date("Y-m-d",strtotime($_REQUEST['to'])) : '';
$dateFrom = isset($_REQUEST['from']) ? date("Y-m-d",strtotime($_REQUEST['from'])) : '';
$today = "%".date("Y-m-d")."%";

$array = array();
if($type=="today"){
	$row = $db->numRow("SELECT (`product_id`) FROM ".$table." where `created_at` LIKE ? AND `delete`=?",array($today,0));
}else{
	if(!empty($dateTo) && !empty($dateFrom)){
		$row = $db->numRow("SELECT (`product_id`) FROM ".$table." where `created_at` BETWEEN ? AND ?",array($dateTo,$dateFrom));
	}else{
		$row = $db->numRow("SELECT (`product_id`) FROM ".$table." where `delete`=?",array(0));
	}
}
if($row > 0)
{
	if($type=="today"){
		$result = $db->getRows("SELECT * FROM ".$table." where `created_at` LIKE ? AND `delete`=? ORDER BY `created_at` DESC",array($today,0));
	}else{
		if(!empty($dateTo) && !empty($dateFrom)){
			$result = $db->getRows("SELECT * FROM ".$table." where `created_at` BETWEEN ? AND ? ORDER BY `created_at` ASC",array($dateTo,$dateFrom));
		}else{
			$result = $db->getRows("SELECT * FROM ".$table." where `delete`=? ORDER BY `created_at` DESC",array(0));
		}
	}
	
	$i = 0; $id=1;
	$main_array = array();

	foreach ($result as $key => $value) {
		$array = array();
		//$array['id'] = $id;
		$array['checkbox'] = '<input type="checkbox" class="select-checkbox" name="product_id[]" id="'.$value['product_id'].'"/><a class="my-file" href="'.BARCODE_PATH_DISPLAY.$value['barcode_imgPath'].'"></a>';
		
		// Fetch branch 
		if($value['branch_id']!=0){
			$getBranch = $db->getRow("SELECT * FROM `branch` where `branch_id`=?",array($value['branch_id']));
			$array['branch'] = $getBranch['name'];
		}else{
			$array['branch'] = "Main";
		}
		$array['chassis_no'] = $value['chassis_no'];
		$array['model_code'] = $value['model_code'];
		$array['color_code'] = $value['color_code'];
		$array['model'] = $value['model'];
		$array['color'] = $value['color'];
		$array['variant'] = $value['variant'];
		/*if((!empty($value['qr_imgPath'])) && ($value['qr_imgPath']!='0'))
			$array['qr_code'] = "<img src='".QRCODE_PATH_DISPLAY.$value['qr_imgPath']."' />";
		else
			$array['qr_code'] = "<a href='generate_qrcode.php'>click to generate</a>";
		*/
		if((!empty($value['barcode_imgPath'])) && ($value['barcode_imgPath']!='0'))
			$array['qr_code'] = "<a title='Click To Download Barcode' href='".BARCODE_PATH_DISPLAY.$value['barcode_imgPath']."' download><span class='btn btn-success btn-squared'><i class='clip-download-2'></i></span></a>";
		else
			$array['qr_code'] = "<a href='generate_qrcode.php'>click to generate</a>";
		
		$veihicle = $db->getRows("SELECT * FROM ".$table1." where `status`=? ORDER BY `created_at` DESC",array(1));
		$veihicleArray = array();
		
		foreach($veihicle as $veihi){
			$veihicleArray[] = "<option value='".$veihi['veihicle_id']."' ". (($veihi['veihicle_id'] == $value['veihicle_id']) ? "selected" : "") .">".$veihi['name']."</option>";
		}
		
		$array['ltov'] = "<div title='Select Model' class='form-group product-select-price-div' data-productid='".$value['product_id']."'><img class='product-loading' src='loading.gif' style='display:none;'>"; 
		$array['ltov'] .= "<select class='form-control search-select select-price-product'><option value=''>Select Price</option>".implode(" ",$veihicleArray)."</select></div>";
		
		$array['date'] = date("Y-m-d h:i A",strtotime($value['created_at']));
		
		// Status Code
		if($value['sale']==1){
			$array['status'] = "<span class='btn btn-danger btn-squared'> SALE </span>";
		}else{
			if($value['status']==4){
				$array['status'] = "<span class='btn btn-info btn-squared'> BILL </span>";
			}else if($value['status']==3){
				$array['status'] = "<span class='btn btn-blue btn-squared'> GATE </span>";
			}else if($value['status']==2){
				$array['status'] = "<span class='btn btn-info btn-squared'> CASH </span>";
			}else{
				$array['status'] = "<span class='btn btn-success btn-squared'> IN STOCK </span>";
			}
		}
		
		$array['action']="<a class='btn btn-success btn-squared' title='Click to Edit' href=\"product.php?aid=".$value['product_id']."\"><i class=\"fa fa-edit\"></i></a><a title='Click to Delete' class='to_delete btn btn-danger btn-squared' id=\"".$value['product_id']."\"><i class=\"fa fa-trash-o\"></i></a>";
		
		$main_array['data'][$i++] = $array;
		$id++;
	}
	$array = json_encode($main_array);
	echo $array;
}
else
{
	for ($i=0; $i < 12 ; $i++) { 
		$main_array['data'][$i++] = $array;
	}	
	$array = json_encode($main_array);
	echo $array;
}

?>