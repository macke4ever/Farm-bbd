<?php
	$allowedExts = array("gpx");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
	if ( ($_FILES["file"]["size"] < 200000) && in_array($extension, $allowedExts))
	  {
	  if ($_FILES["file"]["error"] > 0)
	    {
	    }
	  else
	    {

	    if (file_exists("upload/" . $_FILES["file"]["name"]))
	      {
	      }
	    else
	      {
	      // move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
	      // $fileName =  $_FILES["file"]["name"];
	      $fileName =  $_FILES["file"]["tmp_name"];
	      
	      //starting file reading
	      $coordinates = "";
	     

			if (file_exists($fileName)) {
			    $xml = simplexml_load_file($fileName);
			    foreach( $xml->children() AS $child ) {
			        $name = $child->getName();
			        if ($name == 'wpt') {
			            //print_r($name.'    ');
			            //echo $child['lat'].' '.$child['lon'].'  ';
			            $name = $child->children()->getName();
			            if ($name = 'ele') {
			               // echo $child->children().'<br/>';
			            }
			        }
			        if ($name == 'trk') {
			            foreach( $child->children() AS $grandchild ) {
			                $grandname = $grandchild->getName();
			                if ($grandname == 'name') {
			                   // echo $grandchild.'<br/>'; //Prints trk name element
			                }
			                if ($grandname == 'trkseg') {
			                    foreach( $grandchild->children() AS $greatgrandchild ) {
			                        $greatgrandname = $greatgrandchild->getName();
			                        //print_r($greatgrandname.'  ');
			                        //echo '<br/>';
			                        if ($greatgrandname == 'trkpt') {
			                           // echo $greatgrandchild['lat'].' '.$greatgrandchild['lon']; 
			                            $coordinates .= (string)$greatgrandchild['lat'].",".(string)$greatgrandchild['lon'].";";
			                            foreach( $greatgrandchild->children() AS $elegreatgrandchild ) {
			                               // echo $elegreatgrandchild.'<br/>';
			                            }
			                        }
			                        if ($greatgrandname == 'ele') {
			                            //print_r($greatgrandchild);
			                        }   
			                    }
			                }
			            }
			        } 
			    }
			    if (!empty($coordinates)){
			    	//starting minimisation 

			    		include "../dbConfig.php";
						include "rdp.php";
					      $coordList = array();
					     //var_dump($coordinates);
					      $lines = explode(';', $coordinates);
					      unset($lines[count($lines)-1]);


					       foreach ($lines as $key => $line) {
					       	$oneLine = explode(',', $line);
					       	$lat = $oneLine[0];
					       	$long = $oneLine[1];
					       	$coord["lat"] = $lat;
					       	$coord["long"] = $long;
					       //	var_dump($coord);
					       	array_push($coordList, $coord);
					       }

					       //sitoj vietoj galima atlikti ploto skaiciavima su $coordList masyvu (zaliom koordinatem)
					       //arba $rdpResult - jau pamazintu optimizuotu masyvu


					        $rdpResult = RamerDouglasPeucker($coordList, 0.000022);
							//var_dump ($rdpResult);


					        // $areaCalc = $coordList;
					        // array_push($areaCalc, $areaCalc[0]);
					        // $xx = 0;
					        // $yy = 0;
					        // $finalArea = 0;

					        // for ($i=0; $i < sizeof($areaCalc)-2; $i++) { 
					        // 	// $finalArea += ($areaCalc[$i]["lat"]*$areaCalc[$i+1]["long"] - $areaCalc[$i]["long"]*$areaCalc[$i+1]["lat"])*1000000;
					        	
					        // 	$xx += $areaCalc[$i]["lat"]*$areaCalc[$i+1]["long"];
					        // 	$yy += $areaCalc[$i]["long"]*$areaCalc[$i+1]["lat"];

					        // 	// echo $finalArea."<br>";
					        // 	echo $areaCalc[$i]["lat"]." ".$areaCalc[$i]["long"]." ".$areaCalc[$i+1]["lat"]." ".$areaCalc[$i+1]["long"]."<br>";
					        // }
					        // $finalArea = (($xx - $yy)*1000000) / 2;

							$string = "";
							foreach ($rdpResult as $key => $coordLine) {
								$string .= $coordLine["lat"].",".$coordLine["long"].";";

							}

							if (!empty($string)){
					        //echo $string;
					        $q = "UPDATE fields SET coordinates='".$string."' WHERE id='".@$_POST['id']."'";
						    $rr = mysql_query($q); 

					        echo "Koordinatės įkeltos";
					        // var_dump($finalArea);
					        // var_dump($xx);
					        // var_dump($yy);
					        // echo var_dump($rr);

					      }
					  }
					  mysql_close();
					  unlink($fileName);

					  

			} else {
			    echo 'Nepavyko atidaryti failo: .'.$fileName ;
			    include "connection.php";

			} 

	      }
	    }
	  }
	else
	  {
	  echo "Netinkamas failas";
	  include "connection.php";
	  }
?>