<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';

	session_destroy();
	echo "$Logout_0<br /><br />";
	echo "<a href=\"Main.php\">$Logout_1</a>";

	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
