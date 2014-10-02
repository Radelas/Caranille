<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");
	if (isset($_SESSION['ID']))
	{
		if ($_SESSION['Town'] == 1)
		{
			if (empty($_POST['Buy']))
			{	
				$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				echo 'Voici toutes les magies en ventes<br />';
				echo '<table>';
		
					echo '<tr>';

						echo '<td>';
							echo 'Image';
						echo '</td>';

						echo '<td>';
							echo 'Nom';
						echo '</td>';

						echo '<td>';
							echo 'Description';
						echo '</td>';

						echo '<td>';
							echo 'Prix (PO)';
						echo '</td>';
					
						echo '<td>';
							echo 'Action';
						echo '</td>';

					echo '</tr>';
				
				$Magic_Query = $bdd->prepare("SELECT * FROM Caranille_Magics
				WHERE Magic_Town = ?");
				$Magic_Query->execute(array($Town));
				while ($Magic = $Magic_Query->fetch())
				{
					echo '<tr>';
				
						$Magic_ID = stripslashes($Magic['Magic_ID']);
						$Magic_Image = stripslashes($Magic['Magic_Image']);
						$Magic_Type = stripslashes($Magic['Magic_Type']);
					
						echo '<td>';
							echo "<img src=\"$Magic_Image\"><br />";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Magic['Magic_Name']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes(nl2br($Magic['Magic_Description'])). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Magic['Magic_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Magic_Shop.php">';
							echo "<input type=\"hidden\" name=\"Magic_ID\" value=\"$Magic_ID\">";
							echo '<input type="submit" name="Buy" value="acheter">';
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}

				$Magic_Query->closeCursor();

				echo '</table>';
				if (empty($Magic_ID))
				{
					echo 'Il n\'y a actuellement aucune magie en vente, revenez plus tard';
				}
			}
			if (isset($_POST['Buy']))
			{
				$Magic_ID = htmlspecialchars(addslashes($_POST['Magic_ID']));
				$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				$Magic_Query = $bdd->prepare("SELECT * FROM Caranille_Magics
				WHERE Magic_ID= ?
				AND Magic_Town= ?");
				$Magic_Query->execute(array($Magic_ID, $Town));
				while ($Magic = $Magic_Query->fetch())
				{
					$_SESSION['Magic_ID'] = stripslashes($Magic['Magic_ID']);
					$_SESSION['Magic_Image'] = stripslashes($Magic['Magic_Image']);
					$_SESSION['Magic_Name'] = stripslashes($Magic['Magic_Name']);
					$_SESSION['Magic_Description'] = stripslashes(nl2br($Magic['Magic_Description']));
					$_SESSION['Magic_Effect'] = stripslashes($Magic['Magic_Effect']);
					$_SESSION['Magic_Price'] = stripslashes($Magic['Magic_Price']);
					$_SESSION['Magic_Type'] = stripslashes($Magic['Magic_Type']);
					$_SESSION['Magic_Town'] = stripslashes($Magic['Magic_Town']);
					$_SESSION['objet'] = 0;
					if ($_SESSION['Gold'] >= $_SESSION['Magic_Price'])
					{
						$Magic_ID = htmlspecialchars(addslashes($_SESSION['Magic_ID']));
						$verification_Magic_Quantitys = $bdd->prepare("SELECT * FROM Caranille_Inventory_Magics
						WHERE Inventory_Magic_Magic_ID= ?
						AND Inventory_Magic_Account_ID= ?");
						$verification_Magic_Quantitys->execute(array($Magic_ID, $ID));
						$Magic_Quantity = $verification_Magic_Quantitys->rowCount();
						if ($Magic_Quantity>=1)
						{
							echo 'Vous possédez déjà cette magie';
							echo "<form method=\"POST\" action=\"Magic_Shop.php\">";
							echo '<input type="submit" name="Cancel" value="Retourner en ville">';
							echo '</form>';
						}
						else
						{
							$Gold = htmlspecialchars(addslashes($_SESSION['Gold'])) - htmlspecialchars(addslashes($_SESSION['Magic_Price']));
							$Magic = htmlspecialchars(addslashes($_SESSION['Magic_Name']));
							$Magic_Effect = htmlspecialchars(addslashes($_SESSION['Magic_Effect']));
						
							$Add_Magic = $bdd->prepare("INSERT INTO Caranille_Inventory_Magics VALUES(:ID, :Magic_ID)");
							$Add_Magic->execute(array('ID'=> $ID, 'Magic_ID'=> $Magic_ID));
						
							$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Golds= :Gold WHERE Account_ID= :ID");
							$Update_Account->execute(array('Gold'=> $Gold, 'ID'=> $ID));
						
							echo "Vous avez acheté la magie $Magic<br /><br />";
							echo '<form method="POST" action="Magic_Shop.php">';
							echo '<input type="submit" name="Cancel" value="Retourner en ville">';
							echo '</form>';
						}
					}
					else
					{
						echo 'Vous n\'avez pas assez d\'argent';
						echo '<form method="POST" action="Magic_Shop.php">';
						echo '<input type="submit" name="Cancel" value="Retourner en ville">';
						echo '</form>';
					}
				}
				$Magic_Query->closeCursor();
			}
		}
		if ($_SESSION['Town'] == 0)
		{
			echo 'Vous n\'êtes dans aucune villes';
		}
	}
	else
	{
		echo 'Vous devez être connecté pour accèder à cette zone';
	}
	require_once("../HTML/Footer.php");
?>
