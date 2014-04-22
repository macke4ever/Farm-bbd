<?php 
	include_once "../../../dbConfig.php";	

	if (($_POST['name'] != "")) {
		$_POST['consumption'] = str_replace(',', '.', @$_POST['consumption']);

		$chemicals = $db->query("SELECT `caresetcontents`.quantity as quantity, `chemicals`.price as price FROM caresetcontents LEFT OUTER JOIN chemicals ON `caresetcontents`.chemical_id = `chemicals`.id WHERE `caresetcontents`.careset_id = '".@$_POST['id']."'");
		$price = 0;	
		foreach ($chemicals as $key => $chemical) {
			$price += $chemical["quantity"]*$chemical["price"];
		}
		$price = round($price, 2);

		$db->query("UPDATE `caresets` SET `name`='".@$_POST['name']."', `consumption` = '".@$_POST['consumption']."', `price` = '".@$price."' WHERE farm_id = ".$_SESSION["user_farm"]." AND id='".@$_POST['id']."'");
	}

 ?>