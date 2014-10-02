<?php
	require_once("../HTML/Header.php");
	require_once("../../Global.php");
	//Si le Access est Modo ou Admin
	if ($_SESSION['Access'] == "Modo" || $_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Add']) && (empty($_POST['End_Add'])))
		{
			echo 'Que souhaitez-vous faire ?<br />';
			echo '<form method="POST" action="Warnings.php">';
			echo '<input type="submit" name="Add" value="Ajouter une sanction">';
			echo '</form>';
		}
		if (isset($_POST['Add']))
		{
			echo '</form><br /><br />';
			echo '<form method="POST" action="Warnings.php">';
			echo 'Type de la sanction <br /> <input type="text" name="Sanction_Type"><br /><br />';	
			echo 'Message<br /> <input type="text" name="Sanction_Message"><br /><br />';
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
			if (isset($_POST['Sanction_Type']) && ($_POST['Sanction_Message']) && ($_POST['Receiver']))
			{
				$Sanction_Type = htmlspecialchars(addslashes($_POST['Sanction_Type']));	
				$Sanction_Message = htmlspecialchars(addslashes($_POST['Sanction_Message']));
				$Sanction_Transmitter = htmlspecialchars(addslashes($_SESSION['Pseudo']));
				$Account_Pseudo = htmlspecialchars(addslashes($_POST['Receiver']));

				$recherche_Sanction_Receiver = $bdd->prepare("SELECT Account_ID 
				FROM Caranille_Accounts
				WHERE Account_Pseudo = ?");
				$recherche_Sanction_Receiver->execute(array($Account_Pseudo));

				while ($Account_ID = $recherche_Sanction_Receiver->fetch())
				{
					$Sanction_Receiver = stripslashes($Account_ID['Account_ID']);
				}
				$recherche_Sanction_Receiver->closeCursor();

				$Add_Sanction = $bdd->prepare("INSERT INTO Caranille_Warnings.php VALUES ('', :Sanction_Type, :Sanction_Message, :Sanction_Transmitter, :Sanction_Receiver)");
				$Add_Sanction->execute(array('Sanction_Type'=> $Sanction_Type, 'Sanction_Message'=> $Sanction_Message, 'Sanction_Transmitter'=> $Sanction_Transmitter, 'Sanction_Receiver'=> $Sanction_Receiver));
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
	require_once("../HTML/Footer.php");
?>
