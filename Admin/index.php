<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	//Si le Access est Admin
	if ($_SESSION['Access'] == "Admin")
	{
		?>
		
		<div class="important">Administration du RPG</div><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Accounts.php"; ?>">Gestion des Comptes</a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Configuration.php"; ?>">Gestion du RPG</a><br /><br />
		<div class="important">Contenu du RPG</div><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Chapters.php"; ?>">Gestion des Chapitres</a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Invocations.php"; ?>">Gestion des Chimères</a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Equipment.php"; ?>">Gestion des Equipements</a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Magics.php"; ?>">Gestion des Magies</a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Missions.php"; ?>">Gestion des Missions</a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Monsters.php"; ?>">Gestion des Monstres</a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/News.php"; ?>">Gestion des News</a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Items.php"; ?>">Gestion des Objets</a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Parchments.php"; ?>">Gestion des Parchemins</a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Towns.php"; ?>">Gestion des Villes</a><br /><br />
		<div class="important">Gestion du Design</div><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Design.php"; ?>">Editer le design</a><br />
		<?php
	}
	//Si le Access est autre que Admin, afficher le menu classique
	else
	{
		echo 'Aucun privilège';
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
