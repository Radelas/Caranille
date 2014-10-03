<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");
	if (isset($_SESSION['ID']))
	{
		echo '<p>Voici le top 100 des meilleurs joueurs classé par niveau</p>';
		echo '<p>Les statistiques ne tienne pas compte de l\'équipement ni des bonus</p>';
		echo '<table>';

				echo '<td>';
				echo 'Niveau';
				echo '</td>';

				echo '<td>';
				echo 'Pseudo';
				echo '</td>';
			
			echo '</tr>';
	
		$Account_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts, Caranille_Levels
		WHERE Account_Level = Level_Number
		ORDER BY Account_Level DESC
		LIMIT 0, 99");
		$Account_Query->execute(array($Order_ID));
		while ($Account = $Account_Query->fetch())
		{
			$Account_ID = stripslashes($Account['Account_ID']);
	
			echo '<tr>';

				echo '<td>';
				 echo '' .stripslashes($Account['Account_Level']). ''; 
				echo '</td>';

				echo '<td>';
				 echo '' .stripslashes($Account['Account_Pseudo']). ''; 
				echo '</td'>;
				
			echo '</tr>';
		}
		$Account_Query->closeCursor();

		echo '</table>';
	}
	else
	{
		echo 'Vous devez être connecté pour accèder à cette zone';
	}	
	require_once("../HTML/Footer.php");
?>
