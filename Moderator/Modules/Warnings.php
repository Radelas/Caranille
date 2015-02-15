<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';

	//Si le Access est Modo ou Admin
	if ($_SESSION['Access'] == "Modo" || $_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Add']) && (empty($_POST['End_Add'])))
		{
			echo 'Que souhaitez-vous faire ?<br />';
			echo '<form method="POST" action="Warnings.php">';
			echo '<input type="submit" name="Add" value="Ajouter un avertissement">';
			echo '</form>';
		}
		if (isset($_POST['Add']))
		{
			echo '</form><br /><br />';
			echo '<form method="POST" action="Warnings.php">';
			echo 'Type de l\'avertissement <br /> <input type="text" name="Avert_Type"><br /><br />';	
			echo 'Message<br /> <input type="text" name="Avert_Message"><br /><br />';
			echo '<label for="Receiver">Choix du joueur</label><br />';
			echo '<select name="Receiver" ID="Receiver">';
			$Players_List_Query = $bdd->query("SELECT * FROM Caranille_Accounts ORDER BY Account_Pseudo ASC");
			while ($Players_List = $Players_List_Query->fetch())
			{
				$Receiver = stripslashes($Players_List['Account_Pseudo']);
				echo "<option value=\"$Receiver\">$Receiver</option>";
			}

			$Players_List_Query->closecursor();

			echo '</select><br /><br />';
			echo '<input type="submit" name="End_Add" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['End_Add']))
		{
			if (isset($_POST['Avert_Type']) && ($_POST['Avert_Message']) && ($_POST['Receiver']))
			{
				$Avert_Type = htmlspecialchars(addslashes($_POST['Avert_Type']));	
				$Avert_Message = htmlspecialchars(addslashes($_POST['Avert_Message']));
				$Avert_Transmitter = htmlspecialchars(addslashes($_SESSION['Pseudo']));
				$Account_Pseudo = htmlspecialchars(addslashes($_POST['Receiver']));

				$recherche_Avert_Receiver = $bdd->prepare("SELECT Account_ID 
				FROM Caranille_Accounts
				WHERE Account_Pseudo = ?");
				$recherche_Avert_Receiver->execute(array($Account_Pseudo));

				while ($Account_ID = $recherche_Avert_Receiver->fetch())
				{
					$Avert_Receiver = stripslashes($Account_ID['Account_ID']);
				}
				$recherche_Avert_Receiver->closeCursor();

				$Add_Avert = $bdd->prepare("INSERT INTO Caranille_Sanctions VALUES ('', :Avert_Type, :Avert_Message, :Avert_Transmitter, :Avert_Receiver)");
				$Add_Avert->execute(array('Avert_Type'=> $Avert_Type, 'Avert_Message'=> $Avert_Message, 'Avert_Transmitter'=> $Avert_Transmitter, 'Avert_Receiver'=> $Avert_Receiver));
				echo 'Avertissement ajoutée';
			}
			else
			{
				echo 'Tous les champs n\'ont pas été remplis';
			}
		}
	}
	else
	{
		echo "<center>";
		echo "Vous ne possèdez pas le Access nécessaire pour accèder à cette partie du site";
		echo "</center>";
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
