<?php
if (isset($_SESSION['ID']))
{	
	?>
	<div class="important">MMORPG</div><br />
	<a href="Main.php">L'actualitée</a><br />
	<a href="Story.php">L'histoire</a><br />
	<a href="Map.php">La carte</a><br /><br />
	<div class="important">Mon Compte</div><br />
	<a href="Character.php">Mon personnage</a><br />
	<a href="Inventory.php">Mon inventaire</a><br />
	<a href="Order.php">Mon Ordre</a><br /><br />
	<div class="important">La Communauté</div><br />
	<a href="Top.php">Top 100</a><br />
	<a href="Battlegrounds.php">Champs de Batailles</a><br />
	<?php echo "<a href=\"Private_Message.php\">Message privé ($Total_Private_Message Message(s))</a><br />"; ?>
	<a href="Chat.php">Le chat</a><br /><br />
	<a href="Logout.php">Déconnexion</a><br /><br />
	<?php

	if ($_SESSION['Access'] == "Modo" || $_SESSION['Access'] == "Admin")
	{
		?>
		<a href="../Moderator/Modules/Main.php"><div class="important">Modération</div></a><br />
		<?php
	}
	if ($_SESSION['Access'] == "Admin")
	{
		?>
		<a href="../Admin/Modules/Main.php"><div class="important">Administration</div></a><br />
		<?php
	}
}	
//Si l'utilisateur n'est pas connecté
else
{
	?>
	<div class="important">MMORPG</div><br />
	<a href="Main.php">Accueil</a><br />
	<a href="Presentation.php">Présentation</a><br /><br />
	<div class="important">Espace Joueurs</div><br />
	<a href="Register.php">Inscription</a><br />
	<a href="Login.php">Connexion</a><br /><br />
	<div class="important">Informations</div><br />
	<a href="Delete_Account.php">Supprimer mon compte</a><br /><br />
	<?php
}
?>
