<?php
	require_once("../HTML/Header.php");
	require_once("../../Global.php");
	//Si le Access est Admin, afficher le menu de l'admin
	if ($_SESSION['Access'] == "Admin")
	{
		echo "Bienvenue dans la partie Administration de votre rpg<br /><br />";
		echo "Ici vous pourrez Ajouter/Modifier les paramètres de votre rpg<br />";
		echo "Choisissez ce que vous souhaitez faire dans le menu de gauche";
	}
	//Si le Access n'est pas Admin
	else
	{
		echo "<center>";
		echo "Vous ne possèdez pas le Access nécessaire pour accèder à cette partie du site";
		echo "</center>";
	}
	require_once("../HTML/Footer.php");
?>
