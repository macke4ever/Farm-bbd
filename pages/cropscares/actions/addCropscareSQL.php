<?php 

	include_once "../../../dbConfig.php";	
	
	if ($_POST['name'] != "") {
		// $_POST['consumption'] = str_replace(',', '.', @$_POST['consumption']);
		$db->query("INSERT INTO `caresets`(`name`, `season_id`, `farm_id`)  VALUES ('".@$_POST['name']."', '".$_SESSION["user_season"]."', ".$_SESSION["user_farm"].")");
 	}
 ?>