<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if ($_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Edit']) && empty($_POST['Second_Edit']) && empty($_POST['End_Edit']) && (empty($_POST['Delete'])))
		{
			echo 'Que souhaitez-vous faire ?<br />';
			echo '<form method="POST" action="Accounts.php">';
			echo '<input type="submit" name="Edit" value="Modifier un Compte">';
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			$Account_List_Query = $bdd->query("SELECT * FROM Caranille_Accounts");
			while ($Account_List = $Account_List_Query->fetch())
			{
				echo 'Nom: ' .htmlspecialchars(addslashes($Account_List['Account_Pseudo'])). '<br />';
				$Account_ID = htmlspecialchars(addslashes($Account_List['Account_ID']));
				echo '<form method="POST" action="Accounts.php">';
				echo "<input type=\"hidden\" name=\"Account_ID\" value=\"$Account_ID\">";
				echo '<input type="submit" name="Second_Edit" value="modifier">';
				echo '<input type="submit" name="Delete" value="supprimer">';
				echo '</form>';
			}
			$Account_List_Query->closeCursor();

		}
		if (isset($_POST['Second_Edit']))
		{
			$Account_ID = htmlspecialchars(addslashes($_POST['Account_ID']));
			$Account_List_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts WHERE Account_ID= ?");
			$Account_List_Query->execute(array($Account_ID));

			while ($Account_List = $Account_List_Query->fetch())
			{
				$_SESSION['Account_ID'] = stripslashes($Account_List['Account_ID']);
				$Account_Pseudo = stripslashes($Account_List['Account_Pseudo']);
				$Account_Email = stripslashes($Account_List['Account_Email']);
				$Account_Level = stripslashes($Account_List['Account_Level']);
				$Account_HP_Remaining = stripslashes($Account_List['Account_HP_Remaining']);
				$Account_HP_Bonus = stripslashes($Account_List['Account_HP_Bonus']);
				$Account_MP_Remaining = stripslashes($Account_List['Account_MP_Remaining']);
				$Account_MP_Bonus = stripslashes($Account_List['Account_MP_Bonus']);
				$Account_Strength_Bonus = stripslashes($Account_List['Account_Strength_Bonus']);
				$Account_Magic_Bonus = stripslashes($Account_List['Account_Magic_Bonus']);
				$Account_Agility_Bonus = stripslashes($Account_List['Account_Agility_Bonus']);
				$Account_Defense_Bonus = stripslashes($Account_List['Account_Defense_Bonus']);
				$Account_Sagesse_Bonus = stripslashes($Account_List['Account_Sagesse_Bonus']);
				$Account_Experience = stripslashes($Account_List['Account_Experience']);
				$Account_Golds = stripslashes($Account_List['Account_Golds']);
				$Account_Chapter = stripslashes($Account_List['Account_Chapter']);
				$Account_Mission = stripslashes($Account_List['Account_Mission']);
				$Account_Access = stripslashes($Account_List['Account_Access']);
			}
			$Account_List_Query->closeCursor();

			echo '<br /><br />';
			echo '<form method="POST" action="Accounts.php">';
			echo "Pseudo<br /> <input type=\"text\" name=\"Account_Pseudo\" value=\"$Account_Pseudo\"><br /><br />";
			echo "Email<br /> <input type=\"text\" name=\"Account_Email\" value=\"$Account_Email\"><br /><br />";
			echo "Niveau<br /> <input type=\"text\" name=\"Account_Level\" value=\"$Account_Level\"><br /><br />";
			echo "HP restant<br /> <input type=\"text\" name=\"Account_HP_Remaining\" value=\"$Account_HP_Remaining\"><br /><br />";
			echo "HP Bonus<br /> <input type=\"text\" name=\"Account_HP_Bonus\" value=\"$Account_HP_Bonus\"><br /><br />";
			echo "MP restant<br /> <input type=\"text\" name=\"Account_MP_Remaining\" value=\"$Account_MP_Remaining\"><br /><br />";
			echo "MP Bonus<br /> <input type=\"text\" name=\"Account_MP_Bonus\" value=\"$Account_MP_Bonus\"><br /><br />";
			echo "Force Bonus<br /> <input type=\"text\" name=\"Account_Strength_Bonus\" value=\"$Account_Strength_Bonus\"><br /><br />";
			echo "Magie Bonus<br /> <input type=\"text\" name=\"Account_Magic_Bonus\" value=\"$Account_Magic_Bonus\"><br /><br />";
			echo "Agilité Bonus<br /> <input type=\"text\" name=\"Account_Agility_Bonus\" value=\"$Account_Agility_Bonus\"><br /><br />";
			echo "Defense Bonus<br /> <input type=\"text\" name=\"Account_Defense_Bonus\" value=\"$Account_Defense_Bonus\"><br /><br />";
			echo "Sagesse Bonus<br /> <input type=\"text\" name=\"Account_Sagesse_Bonus\" value=\"$Account_Sagesse_Bonus\"><br /><br />";
			echo "Experience (XP)<br /> <input type=\"text\" name=\"Account_Experience\" value=\"$Account_Experience\"><br /><br />";
			echo "Pièces d'or (PO)<br /> <input type=\"text\" name=\"Account_Golds\" value=\"$Account_Golds\"><br /><br />";
			echo "Niveau chapitre<br /> <input type=\"text\" name=\"Account_Chapter\" value=\"$Account_Chapter\"><br /><br />";
			echo "Niveau Mission<br /> <input type=\"text\" name=\"Account_Mission\" value=\"$Account_Mission\"><br /><br />";
			echo "Access du compte<br /> <select name=\"Account_Access\" ID=\"Account_Access\">";
			if ($Account_Access == "Member")
			{
				echo "<option selected=\"selected\" value=\"$Account_Access\">$Account_Access</option>";
				echo '<option value="Modo">Modo</option>';
				echo '<option value="Admin">Admin</option>';
			}
			if ($Account_Access == "Modo")
			{
				echo "<option selected=\"selected\" value=\"$Account_Access\">$Account_Access</option>";
				echo '<option value="Member">Member</option>';
				echo '<option value="Admin">Admin</option>';
			}
			if ($Account_Access == "Admin")
			{
				echo "<option selected=\"selected\" value=\"$Account_Access\">$Account_Access</option>";
				echo '<option value="Member">Member</option>';
				echo '<option value="Modo">Modo</option>';
			}
			echo '</select><br /><br />';
			echo "<input type=\"hidden\" name=\"Account_ID\" value=\"$Account_ID\">";
			echo '<input type="submit" name="End_Edit" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['End_Edit']))
		{
			if (isset($_POST['Account_Pseudo']) && ($_POST['Account_Email']) && ($_POST['Account_Chapter']) && ($_POST['Account_Access']))
			{
				$Account_ID = htmlspecialchars(addslashes($_SESSION['Account_ID']));
				$Account_Pseudo = htmlspecialchars(addslashes($_POST['Account_Pseudo']));
				$Account_Email = htmlspecialchars(addslashes($_POST['Account_Email']));
				$Account_Level = htmlspecialchars(addslashes($_POST['Account_Level']));
				$Account_HP_Remaining = htmlspecialchars(addslashes($_POST['Account_HP_Remaining']));
				$Account_HP_Bonus = htmlspecialchars(addslashes($_POST['Account_HP_Bonus']));
				$Account_MP_Remaining = htmlspecialchars(addslashes($_POST['Account_MP_Remaining']));
				$Account_MP_Bonus = htmlspecialchars(addslashes($_POST['Account_MP_Bonus']));
				$Account_Strength_Bonus = htmlspecialchars(addslashes($_POST['Account_Strength_Bonus']));
				$Account_Magic_Bonus = htmlspecialchars(addslashes($_POST['Account_Magic_Bonus']));
				$Account_Agility_Bonus = htmlspecialchars(addslashes($_POST['Account_Agility_Bonus']));
				$Account_Defense_Bonus = htmlspecialchars(addslashes($_POST['Account_Defense_Bonus']));
				$Account_Sagesse_Bonus = htmlspecialchars(addslashes($_POST['Account_Sagesse_Bonus']));
				$Account_Experience = htmlspecialchars(addslashes($_POST['Account_Experience']));
				$Account_Golds = htmlspecialchars(addslashes($_POST['Account_Golds']));
				$Account_Chapter = htmlspecialchars(addslashes($_POST['Account_Chapter']));
				$Account_Mission = htmlspecialchars(addslashes($_POST['Account_Mission']));
				$Account_Access = htmlspecialchars(addslashes($_POST['Account_Access']));

				$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts 
				SET Account_Pseudo= :Account_Pseudo, 
				Account_Email= :Account_Email, 
				Account_Level= :Account_Level, 
				Account_HP_Remaining= :Account_HP_Remaining, 
				Account_HP_Bonus= :Account_HP_Bonus, 
				Account_MP_Remaining= :Account_MP_Remaining, 
				Account_MP_Bonus= :Account_MP_Bonus, 
				Account_Strength_Bonus= :Account_Strength_Bonus, 
				Account_Magic_Bonus= :Account_Magic_Bonus, 
				Account_Agility_Bonus= :Account_Agility_Bonus, 
				Account_Defense_Bonus= :Account_Defense_Bonus, 
				Account_Sagesse_Bonus= :Account_Sagesse_Bonus, 
				Account_Experience= :Account_Experience, 
				Account_Golds= :Account_Golds, 
				Account_Chapter= :Account_Chapter, 
				Account_Mission= :Account_Mission, 
				Account_Access= :Account_Access 
				WHERE Account_ID= :Account_ID");
				
				$Update_Account->execute(array(
				'Account_Pseudo'=> $Account_Pseudo, 
				'Account_Email'=> $Account_Email, 
				'Account_Level'=> $Account_Level, 
				'Account_HP_Remaining'=> $Account_HP_Remaining, 
				'Account_HP_Bonus'=> $Account_HP_Bonus, 
				'Account_MP_Remaining'=> $Account_MP_Remaining, 
				'Account_MP_Bonus'=> $Account_MP_Bonus, 
				'Account_Strength_Bonus'=> $Account_Strength_Bonus, 
				'Account_Magic_Bonus'=> $Account_Magic_Bonus, 
				'Account_Agility_Bonus'=> $Account_Agility_Bonus, 
				'Account_Defense_Bonus'=> $Account_Defense_Bonus, 
				'Account_Sagesse_Bonus'=> $Account_Sagesse_Bonus, 
				'Account_Experience'=> $Account_Experience, 
				'Account_Golds'=> $Account_Golds, 
				'Account_Chapter'=> $Account_Chapter, 
				'Account_Mission'=> $Account_Mission, 
				'Account_Access'=> $Account_Access, 
				'Account_ID'=> $Account_ID));
				
				echo 'Le compte a bien été modifié';
			}
			else
			{
				echo 'Tous les champs n\'ont pas été remplis';
			}
		}
		if (isset($_POST['Delete']))
		{
			$Account_ID = htmlspecialchars(addslashes($_POST['Account_ID']));

			$Delete = $bdd->prepare("DELETE FROM Caranille_Accounts WHERE Account_ID= ?");
			$Delete->execute(array($Account_ID));
			echo 'Le compte a bien été supprimé';
		}
	}
	else
	{
		echo '<center>';
		echo 'Vous ne possèdez pas les droits nécessaire pour accèder à cette partie du site';
		echo '</center>';
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
