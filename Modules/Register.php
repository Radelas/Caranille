﻿<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if (empty($_POST['Register']))
	{	
		echo "$Register_0<br /><br />";
		echo "<div class=\"important\">$Register_1</div><br /><br />";
		echo '<form method="POST" action="Register.php">';
		echo "$Register_2<br /> <input type=\"text\" name=\"Account_Pseudo\"><br /><br />";
		echo "$Register_3<br /> <input type=\"password\" name=\"Account_Password\"><br /><br />";
		echo "$Register_4<br /> <input type=\"password\" name=\"Account_Password_Confirm\"><br /><br />";
		echo "$Register_5<br /> <input type=\"text\" name=\"Account_Email\"><br /><br />";
		echo '<iframe src="../LICENCE.txt"></iframe><br /><br />';
		echo "<input type=\"checkbox\" name=\Licence\">$Register_6<br /><br />";
		echo "<input type=\"submit\" name=\"Register\" value=\"$Register_7\">";
		echo '</form>';
	}	
	if (isset($_POST['Register']))
	{
		if (isset($_POST['Pseudo']) && ($_POST['Password']) && ($_POST['Email']))
		{
			$Account_Pseudo = htmlspecialchars(addslashes($_POST['Account_Pseudo']));
			$Account_Password = htmlspecialchars(addslashes($_POST['Account_Password']));
			$Account_Password_Confirm = htmlspecialchars(addslashes($_POST['Account_Password_Confirm']));
			$Account_Email = htmlspecialchars(addslashes($_POST['Account_Email']));
			$Account_Password = md5(htmlspecialchars(addslashes($_POST['Password'])));
			if ($Account_Password == $Account_Password_Confirm)
			{
				if (isset($_POST['Licence']))
				{
					SQL_Add_Account($Account_Pseudo, $Account_Password, $Account_Email);
				}
				else
				{
					echo "$Register_10";
				}
			}
			else
			{
				echo "$Register_11";
			}
		}
		else
		{
			echo "$Register_12";
		}
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
