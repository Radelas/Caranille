<?php
	require_once("../HTML/Header.php");
	require_once("../../Global.php");
	//Si le Access est administration, afficher le menu de l'administration
	if ($_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Edit']) && empty($_POST['Second_Edit']) && empty($_POST['Add']) && empty($_POST['End_Add']))
		{
			echo 'Que souhaitez-vous faire ?<br />';
			echo '<form method="POST" action="Orders.php">';
			echo '<input type="submit" name="Edit" value="Modifier un Ordre">';
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			echo 'Voici la liste des ordres du MMORPG<br /><br />';
			$Orders_List_Query = $bdd->query("SELECT * FROM Caranille_Orders WHERE Order_Name != 'Neutre'");
			while ($Orders_List = $Orders_List_Query->fetch())
			{
				echo $Orders_List['Order_Name'];
				$Order_ID = stripslashes($Orders_List['Order_ID']);
				echo '<form method="POST" action="Orders.php">';
				echo "<input type=\"hidden\" name=\"Order_ID\" value=\"$Order_ID\">";
				echo '<input type="submit" name="Second_Edit" value="Modifier l\'Ordre">';
				echo '<input type="submit" name="Delete" value="supprimer">';
				echo '</form>';
			}
			$Orders_List_Query->closeCursor();

		}
		if (isset($_POST['Second_Edit']))
		{
			$Order_ID = $_POST['Order_ID'];
			$Orders_List_Query = $bdd->prepare("SELECT * FROM Caranille_Orders WHERE Order_ID= ?");
			$Orders_List_Query->execute(array($Order_ID));

			while ($Order_List = $Orders_List_Query->fetch())
			{
				$_SESSION['Order_ID_Choice'] = stripslashes($Order_List['Order_ID']);
				$Order_Name = stripslashes($Order_List['Order_Name']);
				$Order_Description = stripslashes($Order_List['Order_Description']);
			}
			$Orders_List_Query->closeCursor();

			echo '</form><br /><br />';
			echo '<form method="POST" action="Orders.php">';
			echo "Nom de l'ordre<br /> <input type=\"text\" name=\"Order_Name\" value=\"$Order_Name\"><br /><br />";
			echo "Description de l'ordre<br /><textarea name=\"Order_Description\" ID=\"message\" rows=\"10\" cols=\"50\">$Order_Description</textarea><br /><br />";
			echo '<input type="submit" name="End_Edit" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['End_Edit']))
		{
			if (isset($_POST['Order_Name']) && ($_POST['Order_Description']))
			{
				$Order_ID = htmlspecialchars(addslashes($_SESSION['Order_ID_Choice']));
				$Order_Name = htmlspecialchars(addslashes($_POST['Order_Name']));
				$Order_Description = htmlspecialchars(addslashes($_POST['Order_Description']));
				
				$Update = $bdd->prepare("UPDATE Caranille_Orders SET Order_Name='$Order_Name', Order_Description='$Order_Description' WHERE Order_ID='$Order_ID'");
				$Update->execute(array('Order_Name'=> $Order_Name, 'Order_Description'=> $Order_Description, 'Order_ID'=> $Order_ID));
				
				echo 'L\'ordre a été mit à jour';
			}
			else
			{
				echo 'Tous les champs n\'ont pas été remplis';
			}
		}
	}
	else
	{
		echo '<center>';
		echo 'Vous ne possèdez pas les droits nécessaire pour accèder à cette partie du site';
		echo '</center>';
	}
	require_once("../HTML/Footer.php");
?>
