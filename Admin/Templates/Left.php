<?php
if (isset($_SESSION['ID']))
{
	if ($_SESSION['Access'] == 'Admin')
	{
		echo '<a href="../../index.php"><div class="important">Retour au RPG</div></a><br /><br />';
		
		echo '<div class="important">Administration du RPG</div><br />';
		echo '<a href="Accounts.php">Gestion des Comptes</a><br />';
		echo '<a href="Configuration.php">Gestion du MMORPG</a><br /><br />';
		echo '<div class="important">Contenu du MMORPG</div><br />';
		echo '<a href="Chapters.php">Gestion des Chapitres</a><br />';
		echo '<a href="Invocations.php">Gestion des Chimères</a><br />';
		echo '<a href="Equipment.php">Gestion des Equipements</a><br />';
		echo '<a href="Magics.php">Gestion des Magies</a><br />';
		echo '<a href="Missions.php">Gestion des Missions</a><br />';
		echo '<a href="Monsters.php">Gestion des Monstres</a><br />';
		echo '<a href="News.php">Gestion des News</a><br />';
		echo '<a href="Items.php">Gestion des Objets</a><br />';
		echo '<a href="Parchments.php">Gestion des Parchemins</a><br />';
		echo '<a href="Towns.php">Gestion des Villes</a><br /><br />';
		echo '<div class="important">Gestion du Design</div><br />';
		echo '<a href="Design.php">Editer le design</a><br />';
	}
	else
	{
		echo 'Aucun privilège';
	}
}
else
{
	echo 'Vous devez être connecté et être administrateur pour accéder à cette partie du site';
}
?>

