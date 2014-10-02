<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");
	if (isset($_SESSION['ID']))
	{
		if ($_SESSION['Order_ID'] == 1)
		{
			echo 'Pour pouvoir participer au PVP (Player Versus Player) vous devez choisir un ordre';
		}
		else
		{
			if (empty($_POST['Launch_Battle']))
			{	
				echo '<p>Bienvenue dans le champ de bataille</p><p>Dans ce lieu vous allez pouvoir affronter les joueurs de l\'ordre opposé<br />';
				echo 'Chaque victoire vous apportera un point de notoriété et fera perdre un point à votre adversaire<br />';
				echo 'En cas de défaite vous perdrez un point et votre adversaire en gagnera un</p>';
				echo '<p>Voici la liste des joueurs prêt au combat</p>';
				echo '<table>';

						echo '<td>';
						echo 'Pseudo';
						echo '</td>';

						echo '<td>';
						echo 'HP';
						echo '</td>';

						echo '<td>';
						echo 'Action';
						echo '</td>';
					
					echo '</tr>';
			
				$Account_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts, Caranille_Levels
				WHERE Account_Level = Level_Number
				AND Account_Order != 1
				AND Account_Order != ?
				ORDER BY Account_Pseudo");
				$Account_Query->execute(array($Order_ID));
				while ($Account = $Account_Query->fetch())
				{
					if ($Account['Account_ID'] == $ID)
					{

					}
					else
					{
						$Account_ID = stripslashes($Account['Account_ID']);
					
						echo '<tr>';
							echo '<td>';
							 echo '' .stripslashes($Account['Account_Pseudo']). ''; 
							echo '</td>';

							echo '<td>';
							 echo '' .stripslashes($Account['Account_HP_Remaining']). '/' .stripslashes($Account['Level_HP']). ''; 
							echo '</td>';

							echo '<td>';
								echo '<form method="POST" action="Battlegrounds.php">';
								echo "<input type=\"hidden\" name=\"Account_ID\" value=\"$Account_ID\">"; 
								echo '<input type="submit" name="Launch_Battle" value="combattre">';
								echo '</form>';
							echo '</td>';
						echo '</tr>';
					}
				}
				$Account_Query->closeCursor();

				echo '</table>';
			}
			if (isset($_POST['Launch_Battle']))
			{
				$Account_ID = htmlspecialchars(addslashes($_POST['Account_ID']));
				$Account_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts, Caranille_Levels
				WHERE Account_ID= ?
				AND Account_Level = Level_Number");
				$Account_Query->execute(array($Account_ID));
				while ($Account = $Account_Query->fetch())
				{
					echo 'Pseudo : ' .stripslashes($Account['Account_Pseudo']). '<br />';
					echo 'HP : '  .stripslashes($Account['Account_HP_Remaining']). '<br />';
					$_SESSION['Monster_Image'] = "";
					$_SESSION['Monster_ID'] = stripslashes($Account['Account_ID']);
					$_SESSION['Monster_Name'] = stripslashes($Account['Account_Pseudo']);
					$_SESSION['Monster_Strength'] = stripslashes($Account['Level_Strength']);
					$_SESSION['Monster_Defense'] = stripslashes($Account['Level_Defense']);
					$_SESSION['Monster_HP'] = stripslashes($Account['Account_HP_Remaining']);
					$_SESSION['Monster_Golds'] = stripslashes($Account['Account_Golds']);
					$_SESSION['Battle'] = 1;

					$_SESSION['Arena_Battle'] = 1;
					$_SESSION['Chapter_Battle'] = 0;
					$_SESSION['Dungeon_Battle'] = 0;
					$_SESSION['Mission_Battle'] = 0;
				
					echo '<form method="POST" action="Battle.php">';
					echo '<input type="submit" name="Battle" value="Lancer le combat">';
					echo '</form>';
				}
				$Account_Query->closeCursor();
			}
		}
	}
	else
	{
		echo 'Vous devez être connecté pour accèder à cette zone';
	}	
	require_once("../HTML/Footer.php");
?>
