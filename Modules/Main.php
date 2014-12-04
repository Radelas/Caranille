<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");
	
	//Search and display game news
	$Resultat = $bdd->query("SELECT * FROM Caranille_News ORDER BY News_ID desc");
	while ($News = $Resultat->fetch())
	{
		echo '<table>';
			echo '<tr>';
				echo '<th>';
					echo "$Main_0 " .$News['News_Date']. " Par " .$News['News_Account_Pseudo']. "";
				echo '</th>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td>';
					echo '<h4>' .$News['News_Title']. '</h4>';
					echo '' .stripslashes(nl2br($News['News_Message'])). '';
				echo '</td>';
				
			echo '</tr>';
		echo '</table><br /><br />';
	}
	$Resultat->closeCursor();
	require_once("../HTML/Footer.php");
?>
