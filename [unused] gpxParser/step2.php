<?php

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
        echo "Nuskaityta<br>";
        include "step3.php";
    } 
} else {
    exit('Failed to open file: .'.$fileName );
}                
?>



