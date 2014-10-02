<?php
	require_once("../HTML/Header.php");
	$ID = htmlspecialchars(addslashes($_SESSION['ID']));
	if (isset($_SESSION['ID']))
	{
		//Si le joueur est dans une ville, on regarde si il est actuellement en combat
		if ($_SESSION['Battle'] == 1)
		{
			//Si attaquer et fuir n'ont pas été choisir on affiche le menu de combat
			if (empty($_POST['Attack']) && empty($_POST['Magics']) && empty($_POST['End_Magics']) && empty($_POST['Invocations']) && empty($_POST['End_Invocations']) && empty($_POST['Items']) && empty($_POST['End_Items']) && (empty($_POST['Escape'])))
			{
				//Si la HP du monstre est supérieur à 0 et que la HP du personnage est supérieur à zero le combat commence ou continue
				if ($_SESSION['Monster_HP'] > 0 && $_SESSION['HP'] > 0)
				{
					$Monster_Image = $_SESSION['Monster_Image'];
					if ($_SESSION['Arena'] = 0)
					{
						echo "<img src=\"$Monster_Image\"><br />";
					}
					echo "Combat de " .htmlspecialchars(addslashes($_SESSION['Monster_Name'])). " Contre " .htmlspecialchars(addslashes($_SESSION['Pseudo'])). "<br /><br />";
					echo "HP de " .htmlspecialchars(addslashes($_SESSION['Monster_Name'])). " " .htmlspecialchars(addslashes($_SESSION['Monster_HP'])). " HP<br />";
					echo "Vos HP: " .htmlspecialchars(addslashes($_SESSION['HP'])). " HP<br /><br />";
					echo '<form method="POST" action="Battle.php">';
					echo '<input type="submit" name="Attack" value="Attaquer"><br />';
					echo '</form>';
					echo '<form method="POST" action="Battle.php">';
					echo '<input type="submit" name="Magics" value="Magies"><br />';
					echo '</form>';
					echo '<form method="POST" action="Battle.php">';
					echo '<input type="submit" name="Invocations" value="Invocation"><br />';
					echo '</form>';
					echo '<form method="POST" action="Battle.php">';
					echo '<input type="submit" name="Items" value="Objets"><br />';
					echo '</form>';
					echo '<form method="POST" action="Battle.php">';
					echo '<input type="submit" name="Escape" value="fuir"><br />';
					echo '</form>';
				}
			}
			//Si l'utilisateur à choisit attaquer
			if (isset($_POST['Attack']))
			{
				$MIN_Strength = htmlspecialchars(addslashes($_SESSION['Strength_Total'])) / 1.1;
				$MAX_Strength = htmlspecialchars(addslashes($_SESSION['Strength_Total'])) * 1.1;
				$MIN_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) / 1.1;
				$MAX_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) * 1.1;

				$Monster_MIN_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) / 1.1;
				$Monster_MAX_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) * 1.1;
				$Monster_MIN_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) / 1.1;
				$Monster_MAX_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) * 1.1;

				$Positive_Damage_Player = mt_rand($MIN_Strength, $MAX_Strength);
				$Negative_Damage_Player = mt_rand($Monster_MIN_Defense, $Monster_MAX_Defense);
				$Total_Damage_Player = htmlspecialchars(addslashes($Positive_Damage_Player)) - htmlspecialchars(addslashes($Negative_Damage_Player));

				$Monster_Positive_Damage = mt_rand($Monster_MIN_Strength, $Monster_MAX_Strength);
				$Monster_Negative_Damage = mt_rand($MIN_Defense, $MAX_Defense);
				$Total_Damage_Monster = htmlspecialchars(addslashes($Monster_Positive_Damage)) - htmlspecialchars(addslashes($Monster_Negative_Damage));
				//Si les dégats du joueurs ou du monstre sont égal ou inférieur à zero
				if ($Total_Damage_Monster <=0)	
				{
					$Total_Damage_Monster = 0;
				}
				if ($Total_Damage_Player <=0)
				{
					$Total_Damage_Player = 0;
				}
				$_SESSION['Monster_HP'] = htmlspecialchars(addslashes($_SESSION['Monster_HP'])) - htmlspecialchars(addslashes($Total_Damage_Player));
				$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'])) - htmlspecialchars(addslashes($Total_Damage_Monster));
				$Monster_Image = htmlspecialchars(addslashes($_SESSION['Monster_Image']));
				echo "<img src=\"$Monster_Image\"><br />";
				echo "Votre attaque a infligé $Total_Damage_Player HP de dégat au " .htmlspecialchars(addslashes($_SESSION['Monster_Name'])). "<br /><br />";
				echo "Le " .htmlspecialchars(addslashes($_SESSION['Monster_Name'])). " vous a infligé $Total_Damage_Monster HP de dégat<br /><br />";

				$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :Remaining_HP WHERE Account_ID= :ID");
				$Update_Account->execute(array('Remaining_HP'=> $Remaining_HP, 'ID'=> $ID));

				echo '<form method="POST" action="Battle.php">';
				echo '<input type="submit" name="Continue" value="continuer">';
				echo '</form>';
				
			}
			if (isset($_POST['Magics']))
			{
					echo '<form method="POST" action="Battle.php">';
					echo 'Quelle magie souhaitez-vous utiliser ?<br /><br />';
					echo '<select name="Magic" ID="Magic">';
		
					$List_Query_Magics = $bdd->prepare("SELECT * FROM Caranille_Inventory_Magics, Caranille_Magics 
					WHERE Inventory_Magic_Magic_ID = Magic_ID
					AND Inventory_Magic_Account_ID = ?
					ORDER BY Magic_Name ASC");
					$List_Query_Magics->execute(array($ID));

					while ($List_Magics = $List_Query_Magics->fetch())
					{
						$Magic_MP_Cost = stripslashes($List_Magics['Magic_MP_Cost']);
						$Magic_Description = stripslashes($List_Magics['Magic_Description']);
						$Magic = stripslashes($List_Magics['Magic_Name']);
						echo "<option value=\"$Magic\">$Magic ($Magic_Description, $Magic_MP_Cost MP)</option>";
						echo "<br />Description: $Magic_Description<br /><br />";
					}

					$List_Query_Magics->closeCursor();

					
					echo '</select><br /><br />';
					echo "<input type=\"hidden\" name=\"Magic_MP_Cost\" value=\"$Magic_MP_Cost\">";
					echo '<input type="submit" name="End_Magics" value="Lancer le sort">';
					echo '</form>';
					echo '<form method="POST" action="Battle.php">';
					echo '<input type="submit" name="Cancel" value="Annuler"><br />';
					echo '</form>';
			}
			if (isset($_POST['End_Magics']))
			{
				$Magic_Choice = htmlspecialchars(addslashes($_POST['Magic']));
				$Magic_MP_Cost = htmlspecialchars(addslashes($_POST['Magic_MP_Cost']));
				if ($_SESSION['MP'] >= $Magic_MP_Cost)
				{
					$Magics_List_Query = $bdd->query("SELECT * FROM Caranille_Magics 
					WHERE Magic_Name = '$Magic_Choice'");
					while ($Magic_List = $Magics_List_Query->fetch())
					{
						$Magic_MP_Cost = stripslashes($Magic_List['Magic_MP_Cost']);
						$Magic_Effect = stripslashes($Magic_List['Magic_Effect']);
						$Magic_Name = stripslashes($Magic_List['Magic_Name']);
						$Magic_Type = stripslashes($Magic_List['Magic_Type']);
					}

					$Magics_List_Query->closeCursor();

					if ($Magic_Type == "Attack")
					{
						$MIN_Magic = htmlspecialchars(addslashes($_SESSION['Magic_Total'])) / 1.1;
						$MAX_Magic = htmlspecialchars(addslashes($_SESSION['Magic_Total'])) * 1.1;
						$MIN_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) / 1.1;
						$MAX_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) * 1.1;

						$Monster_MIN_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) / 1.1;
						$Monster_MAX_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) * 1.1;
						$Monster_MIN_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) / 1.1;
						$Monster_MAX_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) * 1.1;

						$Positive_Magic_Damage_Player = mt_rand($MIN_Magic, $MAX_Magic) + $Magic_Effect;
						$Negative_Magic_Damage_Player = mt_rand($Monster_MIN_Defense, $Monster_MAX_Defense);
						$Player_Total_Magic_Damage = htmlspecialchars(addslashes($Positive_Magic_Damage_Player)) - htmlspecialchars(addslashes($Negative_Magic_Damage_Player));
						
						$Monster_Positive_Damage = mt_rand($Monster_MIN_Strength, $Monster_MAX_Strength);
						$Monster_Negative_Damage = mt_rand($MIN_Defense, $MAX_Defense);
						$Total_Damage_Monster = htmlspecialchars(addslashes($Monster_Positive_Damage)) - htmlspecialchars(addslashes($Monster_Negative_Damage));
						//Si les dégats du joueurs ou du monstre sont égal ou inférieur à zero
						if ($Total_Damage_Monster <=0)	
						{
							$Total_Damage_Monster = 0;
						}
						if ($Player_Total_Magic_Damage <=0)
						{
							$Player_Total_Magic_Damage = 0;
						}
						$_SESSION['Monster_HP'] = htmlspecialchars(addslashes($_SESSION['Monster_HP'])) - htmlspecialchars(addslashes($Player_Total_Magic_Damage));
						$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'])) - htmlspecialchars(addslashes($Total_Damage_Monster));
						$Remaining_MP = htmlspecialchars(addslashes($_SESSION['MP'])) - htmlspecialchars(addslashes($Magic_MP_Cost));
						$Monster_Image = htmlspecialchars(addslashes($_SESSION['Monster_Image']));
						echo "<img src=\"$Monster_Image\"><br />";
						echo "$Magic_Choice a infligé $Player_Total_Magic_Damage HP de dégat au " .htmlspecialchars(addslashes($_SESSION['Monster_Name'])). "<br /><br />";
						echo "Le " .htmlspecialchars(addslashes($_SESSION['Monster_Name'])). " vous a infligé $Total_Damage_Monster HP de dégat<br /><br />";

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :Remaining_HP , Account_MP_Remaining= :Remaining_MP WHERE Account_ID= :ID");
						$Update_Account->execute(array('Remaining_HP'=> $Remaining_HP, 'Remaining_MP'=> $Remaining_MP, 'ID'=> $ID));
						
						echo '<form method="POST" action="Battle.php">';
						echo '<input type="submit" name="Continue" value="continuer">';
						echo '</form>';
						
					}
					elseif ($Magic_Type == "Health")
					{
						$MIN_Magic = htmlspecialchars(addslashes($_SESSION['Magic'])) / 1.1;
						$MAX_Magic = htmlspecialchars(addslashes($_SESSION['Magic'])) * 1.1;
						$MIN_Defense = htmlspecialchars(addslashes($_SESSION['Defense'])) / 1.1;
						$MAX_Defense = htmlspecialchars(addslashes($_SESSION['Defense'])) * 1.1;

						$Monster_MIN_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) / 1.1;
						$Monster_MAX_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) * 1.1;
						$Monster_MIN_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) / 1.1;
						$Monster_MAX_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) * 1.1;

						$Player_Health = mt_rand($MIN_Magic, $MAX_Magic) + $Magic_Effect;

						$Monster_Positive_Damage = mt_rand($Monster_MIN_Strength, $Monster_MAX_Strength);
						$Monster_Negative_Damage = mt_rand($MIN_Defense, $MAX_Defense);
						$Total_Damage_Monster = htmlspecialchars(addslashes($Monster_Positive_Damage)) - htmlspecialchars(addslashes($Monster_Negative_Damage));
						//Si les dégats du monstre sont en dessous de 0, on applique 0 de dégat pour éviter de soigner le personnage
						if ($Total_Damage_Monster <=0)	
						{
							$Total_Damage_Monster = 0;
						}
						$Life_Difference = htmlspecialchars(addslashes($_SESSION['HP_Total'])) - htmlspecialchars(addslashes($_SESSION['HP']));
						if ($Player_Health >= $Life_Difference)
						{
							$_SESSION['HP'] = htmlspecialchars(addslashes($_SESSION['HP'])) + htmlspecialchars(addslashes($Life_Difference));
							$Player_Health = htmlspecialchars(addslashes($Player_Health));
						}
						else
						{
							$_SESSION['HP'] = htmlspecialchars(addslashes($_SESSION['HP'])) + htmlspecialchars(addslashes($Player_Health));
						}
						$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'])) - htmlspecialchars(addslashes($Total_Damage_Monster));
						$Remaining_MP = htmlspecialchars(addslashes($_SESSION['MP'])) - htmlspecialchars(addslashes($Magic_MP_Cost));
						$Monster_Image = htmlspecialchars(addslashes($_SESSION['Monster_Image']));
						echo "<img src=\"$Monster_Image\"><br />";
						echo "$Magic_Name vous a soigné de $Player_Health <br /><br />";
						echo "Le " .htmlspecialchars(addslashes($_SESSION['Monster_Name'])). " vous a infligé $Total_Damage_Monster HP de dégat<br /><br />";

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :Remaining_HP , Account_MP_Remaining= :Remaining_MP WHERE Account_ID= :ID");
						$Update_Account->execute(array('Remaining_HP'=> $Remaining_HP, 'Remaining_MP'=> $Remaining_MP, 'ID'=> $ID));
						
						echo '<form method="POST" action="Battle.php">';
						echo '<input type="submit" name="Continue" value="continuer">';
						echo '</form>';
					}
				}
				else
				{
					echo 'Vous n\'avez pas assez de MP';
					echo '<form method="POST" action="Battle.php">';
					echo '<input type="submit" name="Continue" value="continuer">';
					echo '</form>';
				}
			}
			if (isset($_POST['Invocations']))
			{
					$List_Query_Invocations = $bdd->prepare("SELECT * FROM Caranille_Inventory_Invocations, Caranille_Invocations 
					WHERE Inventory_Invocation_Invocation_ID = Invocation_ID
					AND Inventory_Invocation_Account_ID = ?
					ORDER BY Invocation_Name ASC");
					$List_Query_Invocations->execute(array($ID));

					$Quantity_Invocations = $List_Query_Invocations->rowCount();
					if ($Quantity_Invocations >=1)
					{
						echo '<form method="POST" action="Battle.php">';
						echo 'Quelle chimère souhaitez-vous invoquer ?<br /><br />';
						echo '<select name="Invocation" id="Invocation">';

						while ($Invocations_List = $List_Query_Invocations->fetch())
						{
							$Invocation = stripslashes($Invocations_List['Invocation_Name']);
							echo "<option value=\"$Invocation\">$Invocation</option>";
						}
						echo '</select>';
						echo '<br /><br />Combien de MP souhaitez-vous utiliser pour l\'invoquer ?<br /><br />';
						echo '<input type="text" name="MP_Choice"><br /><br />';
						echo '<input type="submit" name="End_Invocations" value="invoquer">';
						echo '</form>';
						
					}
					else
					{
						echo 'Vous n\'avez aucune chimère à invoquer';
					}
					$List_Query_Invocations->closeCursor();
					
					echo '<form method="POST" action="Battle.php">';
					echo '<input type="submit" name="Cancel" value="Annuler"><br />';
					echo '</form>';
			}
			if (isset($_POST['End_Invocations']))
			{
				$Invocation_Choice = htmlspecialchars(addslashes($_POST['Invocation']));
				$MP_Choice = htmlspecialchars(addslashes($_POST['MP_Choice']));
				if ($_SESSION['MP'] >= $MP_Choice)
				{
					$Invocations_List_Query = $bdd->prepare("SELECT * FROM Caranille_Invocations 
					WHERE Invocation_Name = ?");
					$Invocations_List_Query->execute(array($Invocation_Choice));

					while ($Invocations_List = $Invocations_List_Query->fetch())
					{
						$Invocation_Damage = $Invocations_List['Invocation_Damage'];
					}
					$Invocations_List_Query->closeCursor();
					$MIN_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) / 1.1;
					$MAX_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) * 1.1;

					$Monster_MIN_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) / 1.1;
					$Monster_MAX_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) * 1.1;
					$Monster_MIN_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) / 1.1;
					$Monster_MAX_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) * 1.1;

					$Monster_Positive_Damage = mt_rand($Monster_MIN_Strength, $Monster_MAX_Strength);
					$Monster_Negative_Damage = mt_rand($MIN_Defense, $MAX_Defense);
					$Total_Damage_Monster = htmlspecialchars(addslashes($Monster_Positive_Damage)) - htmlspecialchars(addslashes($Monster_Negative_Damage));

					$Invocation_Total_Damage = htmlspecialchars(addslashes($Invocation_Damage)) * htmlspecialchars(addslashes($MP_Choice));
					//Si les dégats du monstre sont en dessous de 0, on applique 0 de dégat pour éviter de soigner le personnage
					if ($Total_Damage_Monster <=0)
					{
						$Total_Damage_Monster = 0;
					}
					$_SESSION['Monster_HP'] = htmlspecialchars(addslashes($_SESSION['Monster_HP'])) - htmlspecialchars(addslashes($Invocation_Total_Damage));
					$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'])) - htmlspecialchars(addslashes($Total_Damage_Monster));
					$Remaining_MP = htmlspecialchars(addslashes($_SESSION['MP'])) - htmlspecialchars(addslashes($MP_Choice));
					$Monster_Image = htmlspecialchars(addslashes($_SESSION['Monster_Image']));
					echo "<img src=\"$Monster_Image\"><br />";
					echo "$Invocation_Choice a infligé $Invocation_Total_Damage HP de dégat au " .htmlspecialchars(addslashes($_SESSION['Monster_Name'])). "<br /><br />";
					echo "Le " .htmlspecialchars(addslashes($_SESSION['Monster_Name'])). " vous a infligé $Total_Damage_Monster HP de dégat<br /><br />";

					$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :Remaining_HP , Account_MP_Remaining= :Remaining_MP WHERE Account_ID= :ID");
					$Update_Account->execute(array('Remaining_HP'=> $Remaining_HP, 'Remaining_MP'=> $Remaining_MP, 'ID'=> $ID));

					echo '<form method="POST" action="Battle.php">';
					echo '<input type="submit" name="Continue" value="continuer">';
					echo '</form>';
					
				}
				else
				{
					echo 'Vous n\'avez pas assez de MP';
					echo '<form method="POST" action="Battle.php">';
					echo '<input type="submit" name="continuer_combat" value="continuer">';
					echo '</form>';
				}
			}
			if (isset($_POST['Items']))
			{
					$Items_Quantity_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
					WHERE Inventory_Item_ID = Items_ID
					AND Inventory_Account_ID = ?
					ORDER BY Item_Name ASC");
					$Items_Quantity_Query->execute(array($ID));

					$Item_Quantity = $Items_Quantity_Query->rowCount();
					if ($Item_Quantity >=1)
					{
						
						echo '<form method="POST" action="Battle.php">';
						echo 'Quel objet souhaitez-vous utiliser ?<br /><br />';
						echo '<select name="objet" id="objet">';
						echo '<optgroup label="Soin de HP">';
						
				
						$HP_Item_List = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
						WHERE Inventory_Item_ID = Item_ID
						AND Item_Type = 'Health'
						AND Inventory_Account_ID = ?
						ORDER BY Item_Name ASC");
						$HP_Item_List->execute(array($ID));

						while ($Item_List = $HP_Item_List->fetch())
						{
							$Inventory_ID = stripslashes($Item_List['Inventory_ID']);
							$Item = stripslashes($Item_List['Item_Name']);
							$Item_Quantity = stripslashes($Item_List['Item_Quantity']);
							$Item_HP_Effect = stripslashes($Item_List['Item_HP_Effect']);
							echo "<option value=\"$Item\">$Item (+$Item_HP_Effect HP)</option>";
						}

						$Items_Quantity_Query->closeCursor();
						
						echo '</optgroup>';
						echo '<optgroup label="Soin de MP">';
						
						$MP_Item_List_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
						WHERE Inventory_Item_ID = Item_ID
						AND Item_Type = 'Magic'
						AND Inventory_Account_ID = ?
						ORDER BY Item_Name ASC");
						$MP_Item_List_Query->execute(array($ID));

						while ($Item_List = $MP_Item_List_Query->fetch())
						{
							$Inventory_ID = stripslashes($Item_List['Inventory_ID']);
							$Item = stripslashes($Item_List['Item_Name']);
							$Item_MP_Effect = stripslashes($Item_List['Item_MP_Effect']);
							echo "<option value=\"$Item\">$Item (+$Item_MP_Effect MP)</option>";
						}

						$MP_Item_List_Query->closeCursor();

						echo '</optgroup>';
						echo '</select>';
									
						$HP_Item = $HP_Item_List_Query->rowCount();
						$MP_Item = $MP_Item_List_Query->rowCount();
						if ($HP_Item >= 1 || $MP_Item >= 1 || $HP_Item >= 1 || $MP_Item >= 1)
						{
							echo "<br /><br /><input type=\"hidden\" name=\"Item_Quantity\" value=\"$Item_Quantity\">"; 
							echo '<br /><br /><input type="submit" name="objets_fin_combat" value="Utiliser">';
							echo '</form>';
						}
						else
						{	
							echo '</form>';
						}
					}
					else
					{
						echo 'Vous n\'avez aucun objet à utiliser';
					}
					
					echo '<form method="POST" action="Battle.php">';
					echo '<br /><br /><input type="submit" name="Cancel" value="Annuler"><br />';
					echo '</form>';
			}
			if (isset($_POST['End_Items']))
			{
					$Item_Choice = htmlspecialchars(addslashes($_POST['Item']));
					$Item_List_Query = $bdd->prepare("SELECT * FROM Caranille_Items 
					WHERE Item_Name = ?");
					$Item_List_Query->execute(array($Item_Choice));

					while ($Item_List = $Item_List_Query->fetch())
					{
						$Item_ID = stripslashes($Item_List['Item_ID']);
						$Item_Name = stripslashes($Item_List['Item_Name']);
						$Item_Type = stripslashes($Item_List['Item_Type']);
						$Item_MP_Effect = stripslashes($Item_List['Item_MP_Effect']);
					}

					$Item_List_Query->closeCursor();

					$recuperation_Item_Quantitys = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
					WHERE Inventory_Item_ID = Item_ID
					AND Inventory_Account_ID = ?
					ORDER BY Item_Name ASC");
					$recuperation_Item_Quantitys->execute(array($ID));

					while ($Item_Quantity = $recuperation_Item_Quantitys->fetch())
					{
						$Inventory_ID = stripslashes($Item_Quantity['Inventory_ID']);
						$Item_Quantity = stripslashes($Item_Quantity['Item_Quantity']);
					}
					$recuperation_Item_Quantitys->closeCursor();

					if ($Item_Type == "Soin des HP")
					{
						$MIN_Magic = htmlspecialchars(addslashes($_SESSION['Magic_Total'])) / 1.1;
						$MAX_Magic = htmlspecialchars(addslashes($_SESSION['Magic_Total'])) * 1.1;
						$MIN_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) / 1.1;
						$MAX_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) * 1.1;

						$Monster_MIN_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) / 1.1;
						$Monster_MAX_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) * 1.1;
						$Monster_MIN_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) / 1.1;
						$Monster_MAX_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) * 1.1;
						
						$Monster_Positive_Damage = mt_rand($Monster_MIN_Strength, $Monster_MAX_Strength);
						$Monster_Negative_Damage = mt_rand($MIN_Defense, $MAX_Defense);
						$Total_Damage_Monster = htmlspecialchars(addslashes($Monster_Positive_Damage)) - htmlspecialchars(addslashes($Monster_Negative_Damage));
						//Si les dégats du monstre sont en dessous de 0, on applique 0 de dégat pour éviter de soigner le personnage
						if ($Total_Damage_Monster <=0)
						{
							$Total_Damage_Monster = 0;
						}
						$Life_Difference = htmlspecialchars(addslashes($_SESSION['HP_Total'])) - htmlspecialchars(addslashes($_SESSION['HP']));
						if ($Item_Effect >= $Life_Difference)
						{
							$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'])) + htmlspecialchars(addslashes($Life_Difference));
							$Item_Effect = htmlspecialchars(addslashes($Life_Difference));
						}
						else
						{
							$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'])) + htmlspecialchars(addslashes($Item_HP_Effect));
						}
						$Item_Quantity = htmlspecialchars(addslashes($_POST['Item_Quantity']));
						$_SESSION['HP'] = htmlspecialchars(addslashes($_SESSION['HP'])) - htmlspecialchars(addslashes($Total_Damage_Monster));
						$Monster_Image = htmlspecialchars(addslashes($_SESSION['Monster_Image']));
						echo "<img src=\"$Monster_Image\"><br />";
						echo "$Item_Name vous a soigné de $Item_Effect <br /><br />";
						echo "Le " .htmlspecialchars(addslashes($_SESSION['Monster_Name'])). " vous a infligé $Total_Damage_Monster HP de dégat<br /><br />";

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :Remaining_HP WHERE Account_ID= :ID");
						$Update_Account->execute(array('Remaining_HP'=> $Remaining_HP, 'ID'=> $ID));

						if ($Item_Quantity >=2)
						{
							$Add_Item = $bdd->prepare("UPDATE Caranille_Inventory
							SET Item_Quantity = Item_Quantity -1
							WHERE Inventory_ID = '$Inventory_ID'");
							$Add_Item->execute(array('Inventory_ID'=> $Inventory_ID));
						}
						else
						{
							$Add_Item = $bdd->prepare("DELETE FROM Caranille_Inventory
							WHERE Inventory_ID = :Inventory_ID");
							$Add_Item->execute(array('Inventory_ID'=> $Inventory_ID));
						}
						echo '<form method="POST" action="Battle.php">';
						echo '<input type="submit" name="Continue" value="continuer">';
						echo '</form>';								
					}
					if ($Item_Type == "Soin des MP")
					{
						$MIN_Magic = htmlspecialchars(addslashes($_SESSION['Magic_Total'])) / 1.1;
						$MAX_Magic = htmlspecialchars(addslashes($_SESSION['Magic_Total'])) * 1.1;
						$MIN_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) / 1.1;
						$MAX_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) * 1.1;

						$Monster_MIN_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) / 1.1;
						$Monster_MAX_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) * 1.1;
						$Monster_MIN_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) / 1.1;
						$Monster_MAX_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) * 1.1;
						
						$Monster_Positive_Damage = mt_rand($Monster_MIN_Strength, $Monster_MAX_Strength);
						$Monster_Negative_Damage = mt_rand($MIN_Defense, $MAX_Defense);
						$Total_Damage_Monster = htmlspecialchars(addslashes($Monster_Positive_Damage)) - htmlspecialchars(addslashes($Monster_Negative_Damage));
						//Si les dégats du monstre sont en dessous de 0, on applique 0 de dégat pour éviter de soigner le personnage
						if ($Total_Damage_Monster <=0)
						{
							$Total_Damage_Monster = 0;
						}
						$Magic_Difference = htmlspecialchars(addslashes($_SESSION['MP_Total'])) - htmlspecialchars(addslashes($_SESSION['MP']));
						if ($Item_Effect >= $Magic_Difference)
						{
							$Remaining_MP = htmlspecialchars(addslashes($_SESSION['MP'])) + htmlspecialchars(addslashes($Magic_Difference));
							$Item_Effect = htmlspecialchars(addslashes($Magic_Difference));
						}
						else
						{
							$Remaining_MP = htmlspecialchars(addslashes($_SESSION['MP'])) + htmlspecialchars(addslashes($Item_MP_Effect));
						}
						$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'] - $Total_Damage_Monster));
						$Monster_Image = htmlspecialchars(addslashes($_SESSION['Monster_Image']));
						echo "<img src=\"$Monster_Image\"><br />";
						echo "$Item_Name vous a soigné de $Item_Effect <br /><br />";
						echo "Le " .htmlspecialchars(addslashes($_SESSION['Monster_Name'])). " vous a infligé $Total_Damage_Monster HP de dégat<br /><br />";

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :Remaining_HP , Account_MP_Remaining= :Remaining_MP WHERE Account_ID= :ID");
						$Update_Account->execute(array('Remaining_HP'=> $Remaining_HP, 'Remaining_MP'=> $Remaining_MP, 'ID'=> $ID));

						if ($Item_Quantity >=2)
						{
							$Add_Item = $bdd->prepare("UPDATE Caranille_Inventory
							SET Item_Quantity = Item_Quantity -1
							WHERE Inventory_ID = '$Inventory_ID'");
							$Add_Item->execute(array('Inventory_ID'=> $Inventory_ID));
						}
						else
						{
							$Add_Item = $bdd->prepare("DELETE FROM Caranille_Inventory
							WHERE Inventory_ID = :Inventory_ID");
							$Add_Item->execute(array('Inventory_ID'=> $Inventory_ID));
						}
						echo '<form method="POST" action="Battle.php">';
						echo '<input type="submit" name="Continue" value="continuer">';
						echo '</form>';
					}
			}
			//Si l'utilisateur à choisit la fuite
			if (isset($_POST['Escape']))
			{
				echo 'Vous avez fuit le combat<br />';
				echo '<form method="POST" action="Main.php">';
				echo '<input type="submit" name="End_Battle" value="continuer">';
				echo '</form>';
			}
			//Si l'utilisateur continue le combat on vérifie si il y a un gagnant ou un perdant
			if (isset($_POST['Continue']))
			{	
				//Si la HP du monstre est inférieur ou égale à zero le joueur à gagné le combat
				if ($_SESSION['Monster_HP'] <= 0)
				{	
					$Gold_Gained = htmlspecialchars(addslashes($_SESSION['Monster_Golds']));
					$_SESSION['Battle'] = 0;
					echo "Vous avez remporté le combat !!!<br /><br />";
					echo "Pièces d'or (PO) + $Gold_Gained <br /><br />";
					if ($_SESSION['Arena_Battle'] == 1)
					{
					
					}
					else
					{
						$Experience_Gained = htmlspecialchars(addslashes($_SESSION['Monster_Experience']));
						$Experience_Bonus = $_SESSION['Sagesse_Bonus'] * $Experience_Gained /100;
						$Experience_Total = $Experience_Gained + $Experience_Bonus;
						echo "Experience (XP) + $Experience_Total <br />";
						if ($_SESSION['Monster_Item_One'] >= 1)
						{
							$Monster_Item_One_Rate = mt_rand(0, 100);
							if ($Monster_Item_One_Rate <= $_SESSION['Monster_Item_One_Rate'])
							{
								$Monster_Item_One = htmlspecialchars(addslashes($_SESSION['Monster_Item_One']));
								$Item_One = $bdd->prepare("SELECT * From Caranille_Items
								WHERE Item_ID= ?");
								$Item_One->execute(array($Monster_Item_One));
								while ($Item_Name = $Item_One->fetch())
								{
									$Item_Name_One = stripslashes($Item_Name['Item_Name']);
									echo "Vous avez gagné l'objet suivant: $Item_Name_One<br />";

									$One_Item_Verification = $bdd->prepare("SELECT * FROM Caranille_Inventory
									WHERE Inventory_Item_ID= ?
									AND Inventory_Account_ID= ?");
									$One_Item_Verification->execute(array($Monster_Item_One, $ID));

									$Item_Quantity = $One_Item_Verification->rowCount();
									if ($Item_Quantity>=1)
									{
										$Update_Account = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Quantity = Inventory_Item_Quantity + 1
										WHERE Inventory_Account_ID = :ID
										AND Inventory_Item_ID= :Monster_Item_One");
										$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_One'=> $Monster_Item_One));
									}
									else
									{
										$Update_Account = $bdd->prepare("INSERT INTO Caranille_Inventory VALUES('', :ID, :Monster_Item_One, '1', 'No')");
										$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_One'=> $Monster_Item_One));
									}
								}
								$Item_One->closeCursor();
							}
						}
						if ($_SESSION['Monster_Item_Two'] >= 1)
						{
							$Monster_Item_Two_Rate = mt_rand(0, 100);
							if ($Monster_Item_Two_Rate <= $_SESSION['Monster_Item_One_Rate'])
							{
								$Monster_Item_Two = htmlspecialchars(addslashes($_SESSION['Monster_Item_Two']));
								$Item_Two = $bdd->prepare("SELECT * From Caranille_Items
								WHERE Item_ID= ?");
								$Item_Two->execute(array($Monster_Item_Two));
								while ($Item_Name = $Item_Two->fetch())
								{
									$Item_Name_Two = stripslashes($Item_Name['Item_Name']);
									echo "Vous avez gagné l'objet suivant: $Item_Name_Two<br />";

									$Two_Item_Verification = $bdd->prepare("SELECT * FROM Caranille_Inventory
									WHERE Inventory_Item_ID= ?
									AND Inventory_Account_ID= ?");
									$Two_Item_Verification->execute(array($Monster_Item_Two, $ID));

									$Item_Quantity = $Two_Item_Verification->rowCount();
									if ($Item_Quantity>=1)
									{
										$Update_Account = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Quantity = Inventory_Item_Quantity + 1
										WHERE Inventory_Account_ID = :ID
										AND Inventory_Item_ID= :Monster_Item_Two");
										$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_Two'=> $Monster_Item_Two));
									}
									else
									{
										$Update_Account = $bdd->prepare("INSERT INTO Caranille_Inventory VALUES('', :ID, :Monster_Item_Two, '1', 'No')");
										$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_Two'=> $Monster_Item_Two));
									}
								}
								$Item_Two->closeCursor();
							}
						}
						if ($_SESSION['Monster_Item_Three'] >= 1)
						{
							$Monster_Item_Three_Rate = mt_rand(0, 100);
							if ($Monster_Item_Three_Rate <= $_SESSION['Monster_Item_Three_Rate'])
							{
								$Monster_Item_Three = htmlspecialchars(addslashes($_SESSION['Monster_Item_Three']));
								$Item_Three = $bdd->prepare("SELECT * From Caranille_Items
								WHERE Item_ID= ?");
								$Item_Three->execute(array($Monster_Item_Three));
								while ($Item_Name = $Item_Three->fetch())
								{
									$Item_Name_Three = stripslashes($Item_Name['Item_Name']);
									echo "Vous avez gagné l'objet suivant: $Item_Name_Three<br />";

									$Three_Item_Verification = $bdd->prepare("SELECT * FROM Caranille_Inventory
									WHERE Inventory_Item_ID= ?
									AND Inventory_Account_ID= ?");
									$Three_Item_Verification->execute(array($Monster_Item_Three, $ID));

									$Item_Quantity = $Three_Item_Verification->rowCount();
									if ($Item_Quantity>=1)
									{
										$Update_Account = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Quantity = Inventory_Item_Quantity + 1
										WHERE Inventory_Account_ID = :ID
										AND Inventory_Item_ID= :Monster_Item_Three");
										$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_Three'=> $Monster_Item_Three));
									}
									else
									{
										$Update_Account = $bdd->prepare("INSERT INTO Caranille_Inventory VALUES('', :ID, :Monster_Item_Three, '1', 'No')");
										$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_Three'=> $Monster_Item_Three));
									}
								}
								$Item_Three->closeCursor();
							}
						}
					}
					if ($_SESSION['Arena_Battle'] == 1)
					{
						$_SESSION['Notoriety'] = htmlspecialchars(addslashes($_SESSION['Notoriety'])) + 1;
						$Player_ID = htmlspecialchars(addslashes($_SESSION['Monster_ID']));
						echo "Votre victoire dans l'arène vous rapporte 1 points de notoriete<br />";	
							
						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Notoriety= Account_Notoriety + 1 WHERE Account_ID= :ID");
						$Update_Account->execute(array('ID'=> $ID));

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Notoriety= Account_Notoriety - 1 WHERE Account_ID= :Player_ID");
						$Update_Account->execute(array('Player_ID'=> $Player_ID));
					}
					if ($_SESSION['Chapter_Battle'] == 1)
					{	
						echo '<form method="POST" action="Main.php">';
						echo "Votre niveau dans l'histoire augmente de 1 point<br />";								
						echo $_SESSION['Chapter_Ending'];
						$_SESSION['Chapter'] = htmlspecialchars(addslashes($_SESSION['Chapter'])) + 1;
						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Experience= Account_Experience + :Experience_Total, Account_Golds= Account_Golds + :Gold_Gained, Account_Chapter= Account_Chapter + 1 WHERE Account_ID= :ID");
						$Update_Account->execute(array('Experience_Total'=> $Experience_Total, 'Gold_Gained'=> $Gold_Gained, 'ID'=> $ID));
					}
					if ($_SESSION['Dungeon_Battle'] == 1)
					{
						echo '<form method="POST" action="Map.php">';
						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Experience= Account_Experience + :Experience_Total, Account_Golds= Account_Golds + :Gold_Gained WHERE Account_ID= :ID");
						$Update_Account->execute(array('Experience_Total'=> $Experience_Total, 'Gold_Gained'=> $Gold_Gained, 'ID'=> $ID));
					}
					if ($_SESSION['Mission_Battle'] == 1)
					{
						echo '<form method="POST" action="Map.php">';
						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Experience= Account_Experience + :Experience_Total, Account_Golds= Account_Golds + :Gold_Gained, Account_Mission = Account_Mission + 1 WHERE Account_ID= :ID");
						$Update_Account->execute(array('Experience_Total'=> $Experience_Total, 'Gold_Gained'=> $Gold_Gained, 'ID'=> $ID));
					}
					
					
					echo '<input type="submit" name="End_Battle" value="continuer">';
					echo '</form>';
					
				}
				//Si la HP du personnage et inférieur ou égale à 0 le joueur à perdu le combat et sera soigné
				if ($_SESSION['HP'] <= 0)
				{
					$_SESSION['Battle'] = 0;
					$HP_Total = htmlspecialchars(addslashes($_SESSION['HP_Total']));
					if ($_SESSION['Arena_Battle'] == 1)
					{
						echo "Vous avez perdu le combat";
						$Player_ID = htmlspecialchars(addslashes($_SESSION['Monster_ID']));
						echo "Votre défaite dans l'arène vous fait perdre 1 points de notorieté<br />";
						
						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :HP_Total, Account_Notoriety= Account_Notoriety - 1 AND WHERE Account_ID= :ID");
						$Update_Account->execute(array('HP_Total'=> $HP_Total, 'ID'=> $ID));

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Notoriety= Account_Notoriety + 1 WHERE Account_ID= :Player_ID");
						$Update_Account->execute(array('Player_ID'=> $Player_ID));
					}
					if ($_SESSION['Chapter_Battle'] == 1)
					{
						echo htmlspecialchars(addslashes($_SESSION['Chapter_Defeate']));

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :HP_Total WHERE Account_ID= :ID");
						$Update_Account->execute(array('HP_Total'=> $HP_Total, 'ID'=> $ID));
					}
					if ($_SESSION['Dungeon_Battle'] == 1)
					{
						echo 'Vous êtes morts...<br />Vous avez été emmené d\'urgence à l\'auberge et les soins vous ont été facturé ' .htmlspecialchars(addslashes($_SESSION['Town_Price_INN'])). ' Pièce d\'or<br />';
						$Current_Money = htmlspecialchars(addslashes($_SESSION['Gold'])) - htmlspecialchars(addslashes($_SESSION['Town_Price_INN']));

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :HP_Total, Account_Golds= :Current_Money WHERE Account_ID= :ID");
						$Update_Account->execute(array('HP_Total'=> $HP_Total, 'Current_Money'=> $Current_Money, 'ID'=> $ID));
					}
					if ($_SESSION['Mission_Battle'] == 1)
					{
						echo $_SESSION['Mission_Defeate'];
						$Current_Money = htmlspecialchars(addslashes($_SESSION['Gold'])) - htmlspecialchars(addslashes($_SESSION['Town_Price_INN']));

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :HP_Total, Account_Golds= :Current_Money WHERE Account_ID= :ID");
						$Update_Account->execute(array('HP_Total'=> $HP_Total, 'Current_Money'=> $Current_Money, 'ID'=> $ID));
					}
					
					echo '<br /><br /><form method="POST" action="Main.php">';
					echo '<input type="submit" name="End" value="Continuer">';
					echo '</form>';
				}
			}
		}
	}
	//Si il n'existe pas de données dans la session pseudo, demander de se connecter
	else
	{
		echo 'Vous devez être connecté pour accèder à cette page';
	}
	require_once("../HTML/Footer.php");
?>
