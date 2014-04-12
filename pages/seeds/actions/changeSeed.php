<?php 
	include_once "../../../dbConfig.php";	  	

	if ($_POST['name'] != "") {
		$number = str_replace(',', '.', @$_POST['quantity']);
		$db->query("UPDATE `seeds` SET `name`='".@$_POST['name']."', `culture_id`='".@$_POST['culture_id']."', `quantity`='".@$number."' WHERE farm_id = ".$_SESSION["user_farm"]." AND id='".@$_POST['id']."'");
	}

 ?>