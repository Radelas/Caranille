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
				echo "$Inventory_0";
				echo '<p><table>';
		
					echo '<tr>';

						echo '<td>';
							echo "$Inventory_1";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_2";
						echo '</td>';

						echo '<td>';
							echo "$Inventory_3";
						echo '</td>';

						echo '<td>';
							echo "$Inventory_4";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_5";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_6";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_7";
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
							echo "+" .stripslashes($Armor['Item_HP_Effect']). " $Inventory_8";
							echo "+" .stripslashes($Armor['Item_MP_Effect']). " $Inventory_9";
							echo "+" .stripslashes($Armor['Item_Strength_Effect']). " $Inventory_10";
							echo "+" .stripslashes($Armor['Item_Magic_Effect']). " $Inventory_11";
							echo "+" .stripslashes($Armor['Item_Agility_Effect']). " $Inventory_12";
							echo "+" .stripslashes($Armor['Item_Defense_Effect']). " $Inventory_13";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Armor['Item_Purchase_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Accessory_Shop.php">';
							echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Armor_ID\">";
							echo "<input type=\"submit\" name=\"Buy\" value=\"$Inventory_14\">";
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}

				$Armor_Query->closeCursor();

				echo '</table></p>';
				if (empty($Armor_ID))
				{
					echo "$Inventory_15";
				}
			
				echo "$Inventory_16";
				echo '<p><table>';
		
					echo '<tr>';

						echo '<td>';
							echo "$Inventory_1";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_2";
						echo '</td>';

						echo '<td>';
							echo "$Inventory_3";
						echo '</td>';

						echo '<td>';
							echo "$Inventory_4";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_5";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_6";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_7";
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
							echo "+" .stripslashes($Boots['Item_HP_Effect']). " $Inventory_8";
							echo "+" .stripslashes($Boots['Item_MP_Effect']). " $Inventory_9";
							echo "+" .stripslashes($Boots['Item_Strength_Effect']). " $Inventory_10";
							echo "+" .stripslashes($Boots['Item_Magic_Effect']). " $Inventory_11";
							echo "+" .stripslashes($Boots['Item_Agility_Effect']). " $Inventory_12";
							echo "+" .stripslashes($Boots['Item_Defense_Effect']). " $Inventory_13";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Boots['Item_Purchase_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Accessory_Shop.php">';
							echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Boots_ID\">";
							echo "<input type=\"submit\" name=\"Buy\" value=\"$Inventory_14\">";
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}

				$Boots_Query->closeCursor();

				echo '</table></p>';
				if (empty($Boots_ID))
				{
					echo "$Inventory_17";
				}
			
				echo "$Inventory_18";
				echo '<p><table>';
		
					echo '<tr>';

						echo '<td>';
							echo "$Inventory_1";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_2";
						echo '</td>';

						echo '<td>';
							echo "$Inventory_3";
						echo '</td>';

						echo '<td>';
							echo "$Inventory_4";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_5";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_6";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_7";
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
							echo "+" .stripslashes($Gloves['Item_HP_Effect']). " $Inventory_8";
							echo "+" .stripslashes($Gloves['Item_MP_Effect']). " $Inventory_9";
							echo "+" .stripslashes($Gloves['Item_Strength_Effect']). " $Inventory_10";
							echo "+" .stripslashes($Gloves['Item_Magic_Effect']). " $Inventory_11";
							echo "+" .stripslashes($Gloves['Item_Agility_Effect']). " $Inventory_12";
							echo "+" .stripslashes($Gloves['Item_Defense_Effect']). " $Inventory_13";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Gloves['Item_Purchase_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Accessory_Shop.php">';
							echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Gloves_ID\">";
							echo "<input type=\"submit\" name=\"Buy\" value=\"$Inventory_14\">";
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}

				$Gloves_Query->closeCursor();

				echo '</table></p>';
				if (empty($Gloves_ID))
				{
					echo "$Inventory_19";
				}

				echo "$Inventory_20";
				echo '<p><table>';
		
					echo '<tr>';

						echo '<td>';
							echo "$Inventory_1";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_2";
						echo '</td>';

						echo '<td>';
							echo "$Inventory_3";
						echo '</td>';

						echo '<td>';
							echo "$Inventory_4";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_5";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_6";
						echo '</td>';
					
						echo '<td>';
							echo "$Inventory_7";
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
							echo "+" .stripslashes($Helmet['Item_HP_Effect']). " $Inventory_8";
							echo "+" .stripslashes($Helmet['Item_MP_Effect']). " $Inventory_9";
							echo "+" .stripslashes($Helmet['Item_Strength_Effect']). " $Inventory_10";
							echo "+" .stripslashes($Helmet['Item_Magic_Effect']). " $Inventory_11";
							echo "+" .stripslashes($Helmet['Item_Agility_Effect']). " $Inventory_12";
							echo "+" .stripslashes($Helmet['Item_Defense_Effect']). " $Inventory_13";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Helmet['Item_Purchase_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Accessory_Shop.php">';
							echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Helmet_ID\">";
							echo "<input type=\"submit\" name=\"Buy\" value=\"$Inventory_14\">";
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}
			
				$Helmet_Query->closeCursor();
				echo '</table></p>';
				if (empty($Helmet_ID))
				{
					echo "$Inventory_21";
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
						echo "$Inventory_22 $Item_Name<br /><br />";
						echo '<form method="POST" action="Accessory_Shop.php">';
						echo "<input type=\"submit\" name=\"Cancel\" value=\"$Inventory_23\">";
						echo '</form>';
					}
					else
					{
						echo "$Inventory_24";
					}
				}

				$Item_Query->closeCursor();
			}
		}
		if ($_SESSION['Town'] == 0)
		{
			echo "$Inventory_25";
		}
	}
	else
	{
		echo "$Inventory_26";
	}
	require_once("../HTML/Footer.php");
?>
