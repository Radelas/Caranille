<?php
	require_once("../HTML/Header.php");
	require_once("../../Global.php");
	if ($_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['End_Edit']))
		{
			$Design = file_get_contents("../../Design/Design.css");
			$Header = file_get_contents("../../HTML/Header.php");
			$Footer = file_get_contents("../../HTML/Footer.php");
			$Left = file_get_contents("../../Templates/Left.php");
			$Right = file_get_contents("../../Templates/Right.php");
			echo '<form method="POST" action="Design.php">';
			echo "Code CSS de votre MMORPG: <br /><textarea name=\"Design\" ID=\"message\" rows=\"20\" cols=\"75\">$Design</textarea><br /><br />";
			echo "En tête du MMORPG: <br /><textarea name=\"Header\" ID=\"message\" rows=\"20\" cols=\"75\">$Header</textarea><br /><br />";
			echo "Pied de page du MMORPG: <br /><textarea name=\"Footer\" ID=\"message\" rows=\"20\" cols=\"75\">$Footer</textarea><br /><br />";
			echo "Colone de Gauche (Menu du MMORPG): <br /><textarea name=\"Left\" ID=\"message\" rows=\"20\" cols=\"75\">$Left</textarea><br /><br />";
			echo "Colone de droit (Statistiques): <br /><textarea name=\"Right\" ID=\"message\" rows=\"20\" cols=\"75\">$Right</textarea><br /><br />";
			echo '<input type="submit" name="End_Edit" value="Terminer">';
			echo '</form>';
		}
		else
		{
			$Design = $_POST['Design'];
			$Header = $_POST['Header'];
			$Footer = $_POST['Footer'];
			$Left = $_POST['Left'];
			$Right = $_POST['Right'];
			
			$Open_Config = fopen("../../Design/Design.css", "w");
			fwrite($Open_Config, "$Design");
			fclose($Open_Config);
			
			$Open_Config = fopen("../../HTML/Header.php", "w");
			fwrite($Open_Config, "$Header");
			fclose($Open_Config);
			
			$Open_Config = fopen("../../HTML/Footer.php", "w");
			fwrite($Open_Config, "$Footer");
			fclose($Open_Config);
			
			$Open_Config = fopen("../../Templates/Left.php", "w");
			fwrite($Open_Config, "$Left");
			fclose($Open_Config);
			
			$Open_Config = fopen("../../Templates/Right.php", "w");
			fwrite($Open_Config, "$Right");
			fclose($Open_Config);
			
			echo 'Le design vient d\'être mis à jour';
			echo '<form method="POST" action="Design.php">';
			echo '<input type="submit" name="Accueil" value="Continuer">';
			echo '</form>';
		}
	}
	else
	{
		echo '<center>';
		echo 'Vous ne possèdez pas les droits nécessaire pour accèder à cette partie du site';
		echo '</center>';
	}
	require_once('../HTML/Footer.php');
?>