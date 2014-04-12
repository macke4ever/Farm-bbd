<?php 

	include "../connection/dbConfig.php";
	include "rdp.php";
      
    $field_id = 89;

	$r = mysql_query("select * from fields where coordinates !='' and id =".$field_id."  and farm_id = 4" );  

	$coordList = array();
	$fields = array();
      while($field = mysql_fetch_assoc($r)){
          $fields[$field['id']] = $field;
      var_dump($field_id);
     
      $lines = explode(';', $field['coordinates']);
      unset($lines[count($lines)-1]);

      //var_dump($lines);

       foreach ($lines as $key => $line) {
       	$oneLine = explode(',', $line);
       	$lat = $oneLine[0];
       	$long = $oneLine[1];
       	$coord["lat"] = $lat;
       	$coord["long"] = $long;

       	array_push($coordList, $coord);
		//echo "Lat: ".$coord['lat']." Long: ".$coord['long']." <br>";
       }

       //var_dump($coordList);
        $rdpResult = RamerDouglasPeucker($coordList, 0.000022);
		var_dump ($rdpResult);

		$string = "";
		foreach ($rdpResult as $key => $coordLine) {
			$string .= $coordLine["lat"].",".$coordLine["long"].";";

		}
	//	echo $string;

		if (!empty($string)){
        $q = "UPDATE fields SET coordinates='".$string."' WHERE id='".$field_id."'";
	    }

	    $rr = mysql_query($q); 

  }

  mysql_close();
 ?>