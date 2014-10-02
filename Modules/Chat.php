<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");
	if (isset($_SESSION['ID']))
	{
		if (isset($_POST['Send']))
		{
			$ID = htmlspecialchars(addslashes($_SESSION['ID']));
			$Message = htmlspecialchars(addslashes($_POST['Message']));
			$Send_Message = $bdd->prepare("INSERT INTO Caranille_Chat VALUES('', :ID, :Message)");
			$Send_Message->execute(array('ID' => $ID, 'Message' => $Message));
		}
		echo 'Bienvenue dans le chat publique<p>';
		echo 'Le chat va vous permettre de discuter en temps réel avec les autres joueurs<br >et ainsi peut être trouver votre futur compagnon d\'arme<br />';
		echo '<table>';
			echo '<tr>';
				echo '<td>';
					echo 'Pseudo';
				echo '</td>';
				echo '<td>';
					echo 'Message';
				echo '</td>';
		
			if ($_SESSION['Access'] == "Admin")
			{
				echo '<td>';
					echo 'Action';
				echo '</td>';
			}
		
		echo '</tr>';
		$Messages_Query = $bdd->query("SELECT * FROM Caranille_Chat, Caranille_Accounts 
		WHERE Caranille_Chat.Chat_Pseudo_ID = Caranille_Accounts.Account_ID
		ORDER BY Chat_Message_ID DESC
		LIMIT 0, 10");
		while ($Messages = $Messages_Query->fetch())
		{
			echo '</tr>';

			$Pseudo = stripslashes($Messages['Account_Pseudo']);
			$ID_message = stripslashes($Messages['Chat_Message_ID']);

			echo '<td>';
				 echo "<div class=\"important\">$Pseudo</div>"; 
			echo '</td>';
		
			echo '<td>';
				 echo stripslashes($Messages['Chat_Message']); 
			echo '</td>';
		
		
			if ($_SESSION['Access'] == "Admin")
			{
			
				echo '<td>';
					echo '<form method="POST" action="Chat.php">';
					 echo "<input type=\"hidden\" name=\"ID_message\" value=\"$ID_message\">"; 
					echo '<input type="submit" name="Delete" value="X">';
					echo '</form>';
				echo '</td>';
			}
			echo '<br>';
		}
		$Messages_Query->closeCursor();
	
		echo '</table><br />';
		echo '<form method="POST" action="Chat.php">';
		echo '<input type="text" name="Message"><br />';
		echo '<input type="submit" name="Send" value="Envoyer">';
		echo '<input type="submit" name="Refresh" value="Actualiser">';
	
		if ($_SESSION['Access'] == "Admin")
		{
			echo '<br /><input type="submit" name="Clear" value="Vider le chat">';
		}
		echo '</form>';
		
		if (isset($_POST['Delete']))
		{
			if ($_SESSION['Access'] == "Admin")
			{
				$ID_Message = htmlspecialchars(addslashes($_POST['ID_message']));
				$Delete_Message = $bdd->prepare("DELETE FROM Caranille_Chat WHERE Chat_Message_ID=:ID_Message");
				$Delete_Message->execute(array('ID_Message' => $ID_Message));
				echo 'Le message a bien été supprimé';
			}
		}
		if (isset($_POST['Clear']))
		{
			if ($_SESSION['Access'] == "Admin")
			{
				$bdd->exec("DELETE FROM Caranille_Chat");
				echo 'Tous les messages ont bien été supprimé';
			}
		}
	}
	else
	{
		echo 'Vous devez être connecté pour accèder à cette page';
	}
	require_once("../HTML/Footer.php");
?>
