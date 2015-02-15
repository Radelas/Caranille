<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");

	session_destroy();
	echo "$Logout_0<br /><br />";
	echo "<a href=\"Main.php\">$Logout_1</a>";

	require_once("../HTML/Footer.php");
?>
