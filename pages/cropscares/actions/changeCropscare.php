<?php 
	include_once "../../../dbConfig.php";	

	if (($_POST['name'] != "")) {
		$_POST['consumption'] = str_replace(',', '.', @$_POST['consumption']);
		$db->query("UPDATE `caresets` SET `name`='".@$_POST['name']."', `consumption` = '".@$_POST['consumption']."' WHERE farm_id = ".$_SESSION["user_farm"]." AND id='".@$_POST['id']."'");
	}

 ?>