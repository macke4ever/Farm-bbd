<?php 

	include_once "db.class.php";
	session_start();
	//Database server configuration
	$server = "pjauk.lt";
	$login = "farm";
	$pass= "belarus";
	$database = "farm";
	$dbPrefix = "";

	//Create new DB connection
	$db = new DB($server , $login, $pass, $database);
	$db->query("SET CHARACTER SET utf8");
 ?>
