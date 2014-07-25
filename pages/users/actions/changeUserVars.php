<?php 
	session_start();
	include_once "../../../class.text.php";
	include "../../../dbConfig.php";

	if ($_POST['shortLang'] != "") {
		$Text->changeLanguage($_POST['shortLang']);
	}

	if ($_POST['season'] != "") {
		$db->query("UPDATE users SET `season_id` = '".$_POST['season']."';");
		$_SESSION['user_season'] = $_POST['season'];
	}
 ?>