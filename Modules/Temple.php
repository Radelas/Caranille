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
				echo 'Bienvenue dans le temps, ici vous allez pouvoir acheter de puissante invocation pour vous aider au combats<br />';
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
				
				$Invocation_Query = $bdd->prepare("SELECT * FROM Caranille_Invocations
				WHERE Invocation_Town = ?");
				$Invocation_Query->execute(array($Town));
				while ($Invocation = $Invocation_Query->fetch())
				{
					echo '<tr>';
				
						$Invocation_Image = stripslashes($Invocation['Invocation_Image']);
						$Invocation_ID = stripslashes($Invocation['Invocation_ID']);
					
						echo '<td>';
							echo "<img src=\'$Invocation_Image\'><br />";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Invocation['Invocation_Name']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes(nl2br($Invocation['Invocation_Description'])). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Invocation['Invocation_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Temple.php">';
							echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Invocation_ID\">";
							echo '<input type="submit" name="Buy" value="acheter">';
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}
				$Invocation_Query->closeCursor();

				echo '</table>';
				if (empty($Invocation_ID))
				{
					echo 'Il n\'y a actuellement aucune chimère dans le temple, revenez plus tard';
				}
			}
			if (isset($_POST['Buy']))
			{
				$Item_ID = $_POST['Item_ID'];
				$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Invocations
				WHERE Invocation_ID= ?
				AND Invocation_Town = ?");
				$Item_Query->execute(array($Item_ID, $Town));

				while ($Item = $Item_Query->fetch())
				{
					$_SESSION['Item_ID'] = stripslashes($Item['Invocation_ID']);
					$_SESSION['Item_Price'] = stripslashes($Item['Invocation_Price']);

					if ($_SESSION['Gold'] >= $_SESSION['Item_Price'])
					{
						$Item_ID = htmlspecialchars(addslashes($_SESSION['Item_ID']));

						$Item_Quantity_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory_Invocations
						WHERE Inventory_Invocation_Invocation_ID= ?
						AND Inventory_Invocation_Account_ID= ?");
						$Item_Quantity_Query->execute(array($Item_ID, $ID));

						$Item_Quantity = $Item_Quantity_Query->rowCount();
						if ($Item_Quantity>=1)
						{
							echo 'Vous possédez déjà cet objet';
							echo '<form method="POST" action="Temple.php">';
							echo '<input type="submit" name="Cancel" value="Retourner en ville">';
							echo '</form>';
						}
						else
						{
							$Item_ID = htmlspecialchars(addslashes($_SESSION['Item_ID']));
							$Gold = htmlspecialchars(addslashes($_SESSION['Gold'])) - htmlspecialchars(addslashes($_SESSION['Item_Price']));
							$Item = htmlspecialchars(addslashes($_SESSION['Item_Name']));
						
							$Add_Invocation = $bdd->prepare("INSERT INTO Caranille_Inventory_Invocations VALUES(:ID, :Item_ID)");
							$Add_Invocation->execute(array('ID'=> $ID, 'Item_ID'=> $Item_ID));
						
							$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Gold = :Gold WHERE Account_ID = :ID)");
							$Update_Account->execute(array('Gold'=> $Gold, 'ID'=> $ID));
						
							echo "Vous avez obtenu $Invocation<br /><br />";
							echo '<form method="POST" action="Temple.php">';
							echo '<input type="submit" name="Cancel" value="Retourner en ville">';
							echo '</form>';
						}
					}
					else
					{
						echo 'Vous n\'avez pas assez d\'argent';
					}
				}
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
