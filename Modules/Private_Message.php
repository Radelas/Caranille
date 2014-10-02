<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");
	if (isset($_SESSION['ID']))
	{
		//Si rien n'as été choisie, afficher la page d'accueil de la messagerie
		if (empty($_POST['Write']) && empty($_POST['Read']) && empty($_POST['Send']) && empty($_POST['Reply']) && empty($_POST['Delete']))
		{
			echo 'Bienvenue dans votre messagerie privé<br /><br />';
			echo 'Grâce à votre messagerie vous allez pouvoir communiquer avec d\'autres membres<br />';
			echo 'Et ainsi garder contact avec vos amis...<br /><br />';
			echo '<form method="POST" action="Private_Message.php">';
			echo '<input type="submit" name="Write" value="Ecrire un message">';
			echo '<input type="submit" name="Read" value="Lire mes messages">';
			echo '</form>';
		}
		if (isset($_POST['Write']))
		{
			echo 'Pour écrire un message, veuillez complèter le formulaire suivant, puis cliquez sur envoyer<br /><br />';
			echo '<form method="POST" action="Private_Message.php">';
			echo '<label for="Receiver">Choix du joueur</label><br />';
			echo '<select name="Receiver" ID="Receiver">';
			$Player_List_Query = $bdd->query("SELECT * FROM Caranille_Accounts ORDER BY Account_Pseudo ASC");
			while ($Player_List = $Player_List_Query->fetch())
			{
				$Receiver = stripslashes($Player_List['Account_Pseudo']);
				echo "<option value=\"$Receiver\">$Receiver</option>";
			}
			$Player_List_Query->closeCursor();
			echo '</select><br /><br />';
			echo 'Objet: <input type="text" name="Message_Subject"><br />';
			echo 'Message<br /><textarea name="Message" ID="message" rows="10" cols="50"></textarea><br /><br />';
			echo '<input type="submit" name="Send" value="Envoyer le message">';
			echo '</form>';
		}
		if (isset($_POST['Send']))
		{
			$Transmitter = htmlspecialchars(addslashes($_SESSION['ID']));
			$Receiver = htmlspecialchars(addslashes($_POST['Receiver']));
			$Message_Subject = htmlspecialchars(addslashes($_POST['Message_Subject']));
			$Message = htmlspecialchars(addslashes($_POST['Message']));
			$Add_Message = $bdd->prepare("INSERT INTO Caranille_Private_Messages VALUES('', :Transmitter, :Receiver, :Message_Subject, :Message)");
			$Add_Message->execute(array('Transmitter' => $Transmitter, 'Receiver' => $Receiver, 'Message_Subject' => $Message_Subject, 'Message' => $Message));
			echo 'Votre message a bien été envoyé';
		}
		if (isset($_POST['Read']))
		{
			$Pseudo = $_SESSION['Pseudo'];
			$Message_List_Query = $bdd->prepare("SELECT * FROM Caranille_Private_Messages, Caranille_Accounts 
			WHERE Caranille_Private_Messages.Private_Message_Receiver = ?
			AND Account_ID = ?");
			$Message_List_Query->execute(array($Pseudo, $ID));
			while ($Message_List = $Message_List_Query->fetch())
			{
				$Private_Message_ID = $Message_List['Private_Message_ID'];
				$Receiver = stripslashes($Message_List['Private_Message_Receiver']);
				$Transmitter = stripslashes($Message_List['Private_Message_Transmitter']);
				$Message_Subject = stripslashes($Message_List['Private_Message_Subject']);
				$Message = stripslashes(nl2br($Message_List['Private_Message_Message']));
			
				$ID_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts 
				WHERE Account_ID = ?");
				$ID_Query->execute(array($Transmitter));
				while ($ID = $ID_Query->fetch())
				{
					$Transmitter = $ID['Account_Pseudo'];
					echo "<div class=\"important\">De : </div> $Transmitter<br /><br />";
					echo "<div class=\"important\">Objet : </div> $Message_Subject<br /><br />";
					echo "$Message<br />";
					echo '<form method="POST" action="Private_Message.php">';
					echo "<input type=\"hidden\" name=\"Private_Message_ID\" value =\"$Private_Message_ID\">";
					echo "<input type=\"hidden\" name=\"Transmitter\" value =\"$Transmitter\">";
					echo "<input type=\"hidden\" name=\"Message_Subject\" value =\"$Message_Subject\">";
					echo "<input type=\"hidden\" name=\"Message\" value =\"$Message\">";
					echo '<input type="submit" name="Reply" value="Répondre">';
					echo '<input type="submit" name="Delete" value="Supprimer"><br /><br />';
					echo '</form>';
				}
				$ID_Query->closeCursor();
			}
		
			$Message_List_Query->closeCursor();

			if (empty($Private_Message_ID))
			{
				echo 'Vous n\'avez aucun nouveau message';
			}
		}
	
		//Si l'utilisateur souhaite supprimé un message
		if (isset($_POST['Reply']))
		{
			$Receiver = htmlspecialchars(addslashes($_POST['Transmitter']));
			$Message_Subject = htmlspecialchars(addslashes($_POST['Message_Subject']));
			$Message = htmlspecialchars(addslashes($_POST['Message']));
			echo 'Pour répondre au message, veuillez complèter le formulaire suivant, puis cliquez sur envoyer<br /><br />';
			echo '<form method="POST" action="Private_Message.php">';
			echo "Répondre à: <input type=\"text\" name=\"Receiver\" value=\"$Receiver\"><br />";
			echo "Objet: <input type=\"text\" name=\"Message_Subject\" value=\"$Message_Subject\"><br />";
			echo "Message<br /><textarea name=\"Message\" ID=\"Message\" rows=\"10\" cols=\"50\">$Message</textarea><br /><br />";
			echo '<input type="submit" name="Send" value="Envoyer le message">';
			echo '</form>';
		}
		//Si l'utilisateur souhaite supprimé un message
		if (isset($_POST['Delete']))
		{
			$Private_Message_ID = htmlspecialchars(addslashes($_POST['Private_Message_ID']));
			$Delete = $bdd->prepare("DELETE FROM Caranille_Private_Messages WHERE Private_Message_ID= :Private_Message_ID");
			$Delete->execute(array('Private_Message_ID' => $Private_Message_ID));
			echo 'Votre message a bien été supprimé';
		}
	}
	else
	{
		echo 'Vous devez être connecté pour accèder à cette zone';
	}
	require_once("../HTML/Footer.php");
?>
