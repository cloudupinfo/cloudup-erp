<?php session_start();
if($_POST){
	extract($_POST);
	include_once("../config/PDO.php");

	$db = new db();
	$table = "admin";
	$role = $_POST['role'];
	if($role==2){
		$roleName = "doctor";
	}else if($role==5){
		$roleName = "patient";
	}
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$roleName;
	
	$res = $db->getRow("SELECT * FROM ".$table." where `email`=? or `username`=?",array($email,$username));

	if($res){
		echo 2;
	}else{
		$insert = $db->insertRow("INSERT INTO ".$table." (`email`,`username`,`password`,`role`) VALUES (?,?,?,?) ",array($email,$username,$password,$role));
		$select = $db->getRow("SELECT (`idAdmin`) FROM ".$table." order by `idAdmin` DESC");
		$idAdmin = $select['idAdmin'];
		if($insert){
			$insert1 = $db->insertRow("INSERT INTO ".$roleName." (`idAdmin`) VALUES (?) ",array($idAdmin));
			$_SESSION[$res['unique_id']]['loginCreate'] = "yes";
			echo 1;
		}else{
			echo 0;
		}
	}
}else{
	echo 2;
	}
?>