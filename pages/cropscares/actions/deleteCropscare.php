<?php 
	//this needs to be edited. When deleting an element not only this record shoulkd be removed but all other tables records that are connected to this one.
	
	include_once "../../../dbConfig.php";
	
	$db->query("DELETE FROM caresets WHERE id='".$_POST['id']."' AND farm_id= ".$_SESSION["user_farm"]."");
	// $db->query("DELETE FROM fieldworks_fields WHERE fieldwork_id='".$_POST['id']."'");
 ?>
