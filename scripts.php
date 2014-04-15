<?php header('Content-Type: application/x-javascript'); ?>

function addShowFieldListeners () {
 	<?php

		include "../connection/dbConfig.php";
		$r = mysql_query("SELECT id from fields where farm_id = '".$_SESSION['user_farm']."' and coordinates != ''"); 

		$fields = array();
		while($field = mysql_fetch_assoc($r)){
		   $fields[$field['id']] = $field;
		   echo "google.maps.event.addListener(laukai[".$field['id']."], 'click', showFieldInfo);\n";
		// echo "google.maps.event.addListener(laukas1, 'click', showFieldInfo(1));";
		}

	?> 
}

<!-- function showFieldInfo(event) {
	alert(this.id);
} -->