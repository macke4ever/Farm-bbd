<?php 

	include "../connection/dbConfig.php";
	include "rdp.php";
      
     
      $lines = explode(';', $coordinates);
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
        echo "Paleista Kelti<br>"
        $q = "UPDATE fields SET coordinates='".$string."' WHERE id='91'";
	      $rr = mysql_query($q); 

      }


  }

  mysql_close();
 ?>