<?php 


include "../dbConfig.php";

	$db->query("UPDATE fields SET coordinates = NULL WHERE id='".@$_POST['id']."'");

?>