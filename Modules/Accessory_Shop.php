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
				echo 'Voici toutes les armures<br />';
				echo '<p><table>';
		
					echo '<tr>';

						echo '<td>';
							echo 'Image';
						echo '</td>';
					
						echo '<td>';
							echo 'Niveau requis';
						echo '</td>';

						echo '<td>';
							echo 'Nom';
						echo '</td>';

						echo '<td>';
							echo 'Description';
						echo '</td>';
					
						echo '<td>';
							echo 'Effet';
						echo '</td>';
					
						echo '<td>';
							echo 'Prix (PO)';
						echo '</td>';
					
						echo '<td>';
							echo 'Action';
						echo '</td>';

					echo '</tr>';
				
				$Armor_Query = $bdd->prepare("SELECT * FROM Caranille_Items
				WHERE Item_Type = 'Armor'
				AND Item_Town = ?");
				$Armor_Query->execute(array($Town));
				while ($Armor = $Armor_Query->fetch())
				{
					echo '<tr>';
				
						$image_Armor = stripslashes($Armor['Item_Image']);
						$Armor_ID = stripslashes($Armor['Item_ID']);
					
						echo '<td>';
							echo "<img src=\"$image_Armor\"><br />";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Armor['Item_Level_Required']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Armor['Item_Name']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes(nl2br($Armor['Item_Description'])). '';
						echo '</td>';
					
						echo '<td>';
							echo '+' .stripslashes($Armor['Item_HP_Effect']). ' HP<br />';
							echo '+' .stripslashes($Armor['Item_MP_Effect']). ' MP<br />';
							echo '+' .stripslashes($Armor['Item_Strength_Effect']). ' Force<br />';
							echo '+' .stripslashes($Armor['Item_Magic_Effect']). ' Magie<br />';
							echo '+' .stripslashes($Armor['Item_Agility_Effect']). ' Agilité<br />';
							echo '+' .stripslashes($Armor['Item_Defense_Effect']). ' Defense';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Armor['Item_Purchase_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Accessory_Shop.php">';
							echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Armor_ID\">";
							echo '<input type="submit" name="Buy" value="acheter">';
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}

				$Armor_Query->closeCursor();

				echo '</table></p>';
				if (empty($Armor_ID))
				{
					echo 'Il n\'y a actuellement aucune Armure en vente, revenez plus tard<br />';
				}
			
				echo 'Voici toutes les bottes en ventes<br />';
				echo '<p><table>';
		
					echo '<tr>';

						echo '<td>';
							echo 'Image';
						echo '</td>';
					
						echo '<td>';
							echo 'Niveau requis';
						echo '</td>';

						echo '<td>';
							echo 'Nom';
						echo '</td>';

						echo '<td>';
							echo 'Description';
						echo '</td>';
					
						echo '<td>';
							echo 'Effet';
						echo '</td>';
					
						echo '<td>';
							echo 'Prix (PO)';
						echo '</td>';
					
						echo '<td>';
							echo 'Action';
						echo '</td>';

					echo '</tr>';
				
				$Boots_Query = $bdd->prepare("SELECT * FROM Caranille_Items
				WHERE Item_Type = 'Boots'
				AND Item_Town = ?");
				$Boots_Query->execute(array($Town));
				while ($Boots = $Boots_Query->fetch())
				{
					echo '<tr>';
				
						$image_Boots = stripslashes($Boots['Item_Image']);
						$Boots_ID = stripslashes($Boots['Item_ID']);
					
						echo '<td>';
							echo "<img src=\"$image_Boots\"><br />";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Boots['Item_Level_Required']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Boots['Item_Name']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes(nl2br($Boots['Item_Description'])). '';
						echo '</td>';
					
						echo '<td>';
							echo '+' .stripslashes($Boots['Item_HP_Effect']). ' HP<br />';
							echo '+' .stripslashes($Boots['Item_MP_Effect']). ' MP<br />';
							echo '+' .stripslashes($Boots['Item_Strength_Effect']). ' Force<br />';
							echo '+' .stripslashes($Boots['Item_Magic_Effect']). ' Magie<br />';
							echo '+' .stripslashes($Boots['Item_Agility_Effect']). ' Agilité<br />';
							echo '+' .stripslashes($Boots['Item_Defense_Effect']). ' Defense';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Boots['Item_Purchase_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Accessory_Shop.php">';
							echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Boots_ID\">";
							echo '<input type="submit" name="Buy" value="acheter">';
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}

				$Boots_Query->closeCursor();

				echo '</table></p>';
				if (empty($Boots_ID))
				{
					echo 'Il n\'y a actuellement aucune bottes en vente, revenez plus tard<br />';
				}
			
				echo 'Voici tous les gants en ventes<br />';
				echo '<p><table>';
		
					echo '<tr>';

						echo '<td>';
							echo 'Image';
						echo '</td>';
					
						echo '<td>';
							echo 'Niveau requis';
						echo '</td>';

						echo '<td>';
							echo 'Nom';
						echo '</td>';

						echo '<td>';
							echo 'Description';
						echo '</td>';
					
						echo '<td>';
							echo 'Effet';
						echo '</td>';
					
						echo '<td>';
							echo 'Prix (PO)';
						echo '</td>';
					
						echo '<td>';
							echo 'Action';
						echo '</td>';

					echo '</tr>';
				
				$Gloves_Query = $bdd->prepare("SELECT * FROM Caranille_Items
				WHERE Item_Type = 'Gloves'
				AND Item_Town = ?");
				$Gloves_Query->execute(array($Town));
				while ($Gloves = $Gloves_Query->fetch())
				{
					echo '<tr>';
				
						$image_Gloves = stripslashes($Gloves['Item_Image']);
						$Gloves_ID = stripslashes($Gloves['Item_ID']);
					
						echo '<td>';
							echo "<img src=\"$image_Gloves\"><br />";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Gloves['Item_Level_Required']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Gloves['Item_Name']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes(nl2br($Gloves['Item_Description'])). '';
						echo '</td>';
					
						echo '<td>';
							echo '+' .stripslashes($Gloves['Item_HP_Effect']). ' HP<br />';
							echo '+' .stripslashes($Gloves['Item_MP_Effect']). ' MP<br />';
							echo '+' .stripslashes($Gloves['Item_Strength_Effect']). ' Force<br />';
							echo '+' .stripslashes($Gloves['Item_Magic_Effect']). ' Magie<br />';
							echo '+' .stripslashes($Gloves['Item_Agility_Effect']). ' Agilité<br />';
							echo '+' .stripslashes($Gloves['Item_Defense_Effect']). ' Defense';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Gloves['Item_Purchase_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Accessory_Shop.php">';
							echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Gloves_ID\">";
							echo '<input type="submit" name="Buy" value="acheter">';
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}

				$Gloves_Query->closeCursor();

				echo '</table></p>';
				if (empty($Gloves_ID))
				{
					echo 'Il n\'y a actuellement aucune protection en vente, revenez plus tard<br />';
				}

				echo 'Voici tous les casques en ventes<br />';
				echo '<p><table>';
		
					echo '<tr>';

						echo '<td>';
							echo 'Image';
						echo '</td>';
					
						echo '<td>';
							echo 'Niveau requis';
						echo '</td>';

						echo '<td>';
							echo 'Nom';
						echo '</td>';

						echo '<td>';
							echo 'Description';
						echo '</td>';
					
						echo '<td>';
							echo 'Effet';
						echo '</td>';
					
						echo '<td>';
							echo 'Prix (PO)';
						echo '</td>';
					
						echo '<td>';
							echo 'Action';
						echo '</td>';

					echo '</tr>';
				
				$Helmet_Query = $bdd->prepare("SELECT * FROM Caranille_Items
				WHERE Item_Type = 'Helmet'
				AND Item_Town = ?");
				$Helmet_Query->execute(array($Town));
				while ($Helmet = $Helmet_Query->fetch())
				{
					echo '<tr>';
				
						$image_Helmet = stripslashes($Helmet['Item_Image']);
						$Helmet_ID = stripslashes($Helmet['Item_ID']);
					
						echo '<td>';
							echo "<img src=\"$image_Helmet\"><br />";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Helmet['Item_Level_Required']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Helmet['Item_Name']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes(nl2br($Helmet['Item_Description'])). '';
						echo '</td>';
					
						echo '<td>';
							echo '+' .stripslashes($Helmet['Item_HP_Effect']). ' HP<br />';
							echo '+' .stripslashes($Helmet['Item_MP_Effect']). ' MP<br />';
							echo '+' .stripslashes($Helmet['Item_Strength_Effect']). ' Force<br />';
							echo '+' .stripslashes($Helmet['Item_Magic_Effect']). ' Magie<br />';
							echo '+' .stripslashes($Helmet['Item_Agility_Effect']). ' Agilité<br />';
							echo '+' .stripslashes($Helmet['Item_Defense_Effect']). ' Defense';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Helmet['Item_Purchase_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Accessory_Shop.php">';
							echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Helmet_ID\">";
							echo '<input type="submit" name="Buy" value="acheter">';
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}
			
				$Helmet_Query->closeCursor();
				echo '</table></p>';
				if (empty($Helmet_ID))
				{
					echo 'Il n\'y a actuellement aucun casque en vente, revenez plus tard<br />';
				}
			}
			if (isset($_POST['Buy']))
			{
				$Item_ID = htmlspecialchars(addslashes($_POST['Item_ID']));
				$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Items
				WHERE Item_ID= ?
				AND Item_Town= ?");
				$Item_Query->execute(array($Item_ID, $Town));
				while ($Item = $Item_Query->fetch())
				{
					$Item_ID = stripslashes($Item['Item_ID']);
					$Item_Price = stripslashes($Item['Item_Purchase_Price']);
					$Item_Name = stripslashes($Item['Item_Name']);
				
					if ($_SESSION['Gold'] >= $Item_Price)
					{
						$Gold = htmlspecialchars(addslashes($_SESSION['Gold'])) - htmlspecialchars(addslashes($Item_Price));
					
						$Item_Quantity_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory
						WHERE Inventory_Item_ID= ?
						AND Inventory_Account_ID= ?");
						$Item_Quantity_Query->execute(array($Item_ID, $ID));
					
						$Item_Quantity = $Item_Quantity_Query->rowCount();
						if ($Item_Quantity>=1)
						{
							$Add_Item = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Quantity = Inventory_Item_Quantity + 1
								WHERE Inventory_Item_ID= :Item_ID
								AND Inventory_Account_ID = :ID");
							$Add_Item->execute(array('Item_ID'=> $Item_ID, 'ID'=> $ID));
						
							$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Golds= :Gold WHERE Account_ID= :ID");
							$Update_Account->execute(array('Gold'=> $Gold, 'ID'=> $ID));
						}
						else
						{
							$Add_Item = $bdd->prepare("INSERT INTO Caranille_Inventory VALUES('', :ID, :Item_ID, '1', 'No')");
							$Add_Item->execute(array('ID'=> $ID, 'Item_ID'=> $Item_ID));
						
							$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Golds= :Gold WHERE Account_ID= :ID");
							$Update_Account->execute(array('Gold'=> $Gold, 'ID'=> $ID));
						}
						echo "Vous avez acheté $Item_Name<br /><br />";
						echo '<form method="POST" action="Accessory_Shop.php">';
						echo '<input type="submit" name="Cancel" value="Retourner en ville">';
						echo '</form>';
					}
					else
					{
						echo 'Vous n\'avez pas assez d\'argent';
					}
				}

				$Item_Query->closeCursor();
			}
		}
		if ($_SESSION['Town'] == 0)
		{
			echo 'Vous n\'êtes dans aucune villes';
		}
	}
	else
	{
		echo 'Vous devez être connecté pour accèder à cette page';
	}
	require_once("../HTML/Footer.php");
?>
