<?php 
	session_start();
	include_once "../../../class.text.php";

	if ($_POST['shortLang'] != "") {
		$Text->changeLanguage($_POST['shortLang']);
	}
 ?>