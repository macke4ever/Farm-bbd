<?php 
	//this needs to be edited. When deleting an element not only this record shoulkd be removed but all other tables records that are connected to this one.
	
	include "../../../dbConfig.php";
		$q = "DELETE FROM caresetcontents WHERE `id`='".@$_POST['id']."'";
		$db->query($q);
		var_dump($q);
		// echo "tekstas";
 ?>