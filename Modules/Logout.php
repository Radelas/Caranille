<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");

	session_destroy();
	echo 'Déconnection effectuée<br /><br />';
	echo '<a href="Main.php">Retour à l\'accueil</a>';

	require_once("../HTML/Footer.php");
?>
