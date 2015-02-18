<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	//Si le Access est Modo ou Admin
		if ($_SESSION['Access'] == "Modo" || $_SESSION['Access'] == "Admin")
	{
		?>
		<div class="important">Modération du jeu</div><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Moderator/Modules/Sanctions.php"; ?>">Gestion de sanctions</a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Moderator/Modules/Warnings.php"; ?>">Gestion des Avertissements</a><br />
		<?php
	}
	//Si le Access est autre que Admin, afficher le menu classique
	else
	{
		echo 'Aucun privilège';
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
