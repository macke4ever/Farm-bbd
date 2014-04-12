<?php 
	//this needs to be edited. When deleting an element not only this record shoulkd be removed but all other tables records that are connected to this one.
	
	include "../../../dbConfig.php";
	$db->query("DELETE FROM fields WHERE id='".$_POST['id']."' AND farm_id= '".$_SESSION["user_farm"]."'");
	$db->query("DELETE FROM cropscares WHERE field_id='".$_POST['id']."' AND farm_id= '".$_SESSION["user_farm"]."'");
	$db->query("DELETE FROM fieldworks_fields WHERE field_id='".$_POST['id']."'");
	$db->query("DELETE FROM harvestings WHERE field_id='".$_POST['id']."' AND farm_id= '".$_SESSION["user_farm"]."'");
	$db->query("DELETE FROM seedings WHERE field_id='".$_POST['id']."' AND farm_id= '".$_SESSION["user_farm"]."'");

 ?>
