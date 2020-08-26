<?php
// this function used to deleted recored store in table
// first => table
// second => deleted id (table increment id)
// third => msg
function deletedRecord($table,$increment_id,$msg){
	$db = new db();
	$admin_id = $_SESSION['admin_id'];
	$name = $_SESSION['admin_email'];
	$remark = "Name => ".$name." Table => ".$table." Table ID => ".$increment_id." Msg => ".$msg;
	
	$deletedInsert = $db->insertRow("INSERT INTO `record_delete` (`type`,`number`,`admin_id`,`name`,`remark`)VALUES(?,?,?,?,?)",array($table,$increment_id,$admin_id,$name,$remark));
}
?>