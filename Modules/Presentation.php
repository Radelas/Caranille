<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");
	$recherche_presentation = $bdd->query("SELECT * FROM Caranille_Configuration");
	while ($presentation = $recherche_presentation->fetch())
	{
		echo stripslashes(nl2br($presentation['Configuration_Presentation']));
	}
		
	$recherche_presentation->closeCursor();
	require_once("../HTML/Footer.php");
?>
