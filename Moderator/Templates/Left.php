<?php
	//Si le Access est Admin, afficher le menu de l'admin
	if ($_SESSION['Access'] == "Modo" || $_SESSION['Access'] == "Admin")
	{
		echo '<a href="../../index.php"><div class="important">Retour au jeu</div></a><br /><br />';

		echo '<div class="important">Modération du jeu</div><br />';
		echo '<a href="Sanctions.php">Gestion de sanctions</a><br />';
		echo '<a href="Warnings.php">Gestion des Avertissements</a><br />';
	}
	//Si le Access est autre que Admin, afficher le menu classique
	else
	{
		echo 'Aucun privilège';
	}
?>

