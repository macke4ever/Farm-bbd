<?php
//include('simple_html_dom.php');
include "../connection/dbConfig.php";

$coordinates = "";

if (file_exists('gpx.gpx')) {
    $xml = simplexml_load_file('gpx.gpx');
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
        $q = "UPDATE fields SET coordinates='".$coordinates."' WHERE id='48'";
        //var_dump($q);
    }
    $r = mysql_query($q);  
} else {
    exit('Failed to open gpx.gpx.');
}                
?>



