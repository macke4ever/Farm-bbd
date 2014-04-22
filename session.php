<?php
session_start();

if( !($_SESSION['active']) ) {
     print "Expired";
}
else {
     print "Active";
}

?>