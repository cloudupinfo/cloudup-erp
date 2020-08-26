<?php session_start();
include_once('config/PDO.php');
$db = new db();
// Include function.php file.
include_once('functions.php');
if(isset($_SESSION['unique_id']) && !empty($_SESSION['unique_id']))
{
	$adminLogin = $db->getRow("SELECT (`unique_id`) FROM `admin` where `unique_id`=? AND `status`=?",array($_SESSION['unique_id'],1));
	if($_SESSION['unique_id']==$adminLogin['unique_id'])
	{
		$pageName = explode("/",$_SERVER['PHP_SELF']);
		$currentPageName = end($pageName);
		// All User Rights in Array
		include_once('rightes.php');
		if(!in_array($currentPageName, $rightsArray)){
			header('Location:dashboard.php');
			exit();
		}
	}else{
		header('Location:index.php');
		exit();
	}
}else{
	header('Location:index.php');
	exit();
}
?>