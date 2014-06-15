<?php 
		include_once "../../../dbConfig.php";
		include_once "../../../class.text.php";

		$fieldworkAreas = $db->query("SELECT `fields`.area as area, `fields`.name as name, `fields`.coordinates as coordinates, `fields`.id as id FROM fieldworks_fields LEFT OUTER JOIN `fields` ON `fieldworks_fields`.`field_id` = `fields`.id  WHERE fieldwork_id = ".$_GET["id"]." ORDER BY `fields`.name ASC;"); 
		
		$area = 0;
		foreach ($fieldworkAreas as $key => $value) {
			$area += $value["area"];
		}

	$fieldsReturn = "";

	$fieldsReturn .= "<h2>".$Text->getText("done_fields")."</h2>";	
	$fieldsReturn .= "<table class='fieldsList'>";	
	foreach ($fieldworkAreas as $key => $field) {
		$coord = "";
		if ($field["coordinates"] == ""){
			$coord = "color: red;";
		}
		if ($color == 1) {
			$color = 2;
			$fieldsReturn .= '<tr>';
			$fieldsReturn .= '    <td class="tableSingle show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
			$fieldsReturn .= '	  <td class="tableSingle" style="text-align: right; width: 20px;">';
			$fieldsReturn .= '<td>';
			$fieldsReturn .= '</tr>';
		} else {
			$color = 1;
			$fieldsReturn .= '<tr>';
			$fieldsReturn .= '    <td class="tableSingle second show" data-field="'.$field["id"].'"><a href="" class="aStyle" style="'.$coord.'">'.$field['name'].'</a></td>';
			$fieldsReturn .= '	  <td class="tableSingle second" style="text-align: right; width: 20px;">';
			$fieldsReturn .= '<td>';
			$fieldsReturn .= '</tr>';
		}				
	}

	$fieldsReturn .= "<tr><td class='tableSingle second' style='padding-top: 20px; font-weight: bold;'>".$Text->getText("fieldworks_area").": ".$area." ha</td><td class='tableSingle second'></td></tr>";
	$fieldsReturn .= "<tr><td class='tableSingle second' style='padding-top: 5px; font-weight: bold;'>".$Text->getText("works_fuel_total").": ".$area*@$_GET['consumption']." l</td><td class='tableSingle second'></td></tr>";
	$fieldsReturn .= "</table>";

	$array = array('fieldsReturn' => $fieldsReturn, 'area' => $area);

	echo json_encode($array);
 ?>