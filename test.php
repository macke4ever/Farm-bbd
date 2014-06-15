<?php 
	session_start();
	
	include "class.text.php";


	echo "testas<br>";
	// $oText = new Text;
	echo $Text->getText("test")."<br>";
	$Text->changeLanguage("lt");
	echo $Text->getText("test")."<br>";
	echo $Text->getText("check")."<br>";
	// var_dump($Text->getArray());
	// echo "<br>testas<br>";
	// var_dump($Text->getArray());
	// var_dump($oText->getQuery());
	// var_dump($db->query($oText->getQuery()));

 ?>