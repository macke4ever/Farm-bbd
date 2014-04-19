<?php 


include "../dbConfig.php";

	$number = round((@$_POST['area']/10000), 2);
	$db->query("UPDATE fields SET area = '".$number."' WHERE id='".@$_POST['id']."'");

?>