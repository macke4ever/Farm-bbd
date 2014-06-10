<?php 

	include_once "db.class.php";
	session_start();
	//Database server configuration
	$server = "localhost";
	$login = "root";
	$pass= "root";
	$database = "lrubik_agro";
	$dbPrefix = "";

	//Create new DB connection
	$db = new DB($server , $login, $pass, $database);
	$db->query("SET CHARACTER SET utf8");
 ?>
