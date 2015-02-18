<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	//Si le Access est Modo ou Admin
	if ($_SESSION['Access'] == "Modo" || $_SESSION['Access'] == "Admin")
	{
		echo 'Bienvenue dans la partie Modération de votre jeu<br /><br />';
		echo 'Ici vous pourrez Ajouter/Modifier les paramètres de votre jeu<br />';
		echo 'Choisissez ce que vous souhaitez faire dans le menu de gauche';
	}
	//Si le Access n'est pas Modo ou Admin
	else
	{
		echo '<center>';
		echo 'Vous ne possèdez pas les droits nécessaire pour accèder à cette partie du site';
		echo '</center>';
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
