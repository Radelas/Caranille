<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");
	if (isset($_SESSION['ID']))
	{
		if (empty($_POST['Change_Password']) && empty($_POST['Finish']))
		{
			echo 'Bienvenue sur la page de votre personnage<br /><br />';
			echo 'Cette page présente votre personnage avec ses caractéristiques et sont équipement.<br /><br />';
			echo '<div class="important">Pseudo</div> : ' .htmlspecialchars(addslashes($_SESSION['Pseudo'])). '<br />';
			echo '<div class="important">Ordre</div> : ' .htmlspecialchars(addslashes($_SESSION['Order_Name'])). '<br />';
			echo '<div class="important">Adresse e-mail</div> : ' .htmlspecialchars(addslashes($_SESSION['Email'])). '<br />';
			echo '<div class="important">Niveau</div> : ' .htmlspecialchars(addslashes($_SESSION['Level'])). '<br />';
			echo '<div class="important">Force</div> : ' .htmlspecialchars(addslashes($_SESSION['Strength_Base'])). '<br />';
			echo '<div class="important">Magie</div> : ' .htmlspecialchars(addslashes($_SESSION['Magic_Base'])). '<br />';
			echo '<div class="important">Agilité</div> : ' .htmlspecialchars(addslashes($_SESSION['Agility_Base'])). '<br />';
			echo '<div class="important">Défense</div> : ' .htmlspecialchars(addslashes($_SESSION['Defense_Base'])). '<br />';
			echo '<div class="important">HP</div> : ' .htmlspecialchars(addslashes($_SESSION['HP'])). '/' .htmlspecialchars(addslashes($_SESSION['HP_MAX'])). '<br />';
			echo '<div class="important">MP</div> : ' .htmlspecialchars(addslashes($_SESSION['MP'])). '/' .htmlspecialchars(addslashes($_SESSION['MP_MAX'])). '<br />';
			echo '<div class="important">Arme</div> : ' .htmlspecialchars(addslashes($_SESSION['Weapon'])). '<br />';
			echo '<div class="important">Bottes</div> : ' .htmlspecialchars(addslashes($_SESSION['Boots'])). '<br />';
			echo '<div class="important">Casque</div> : ' .htmlspecialchars(addslashes($_SESSION['Helmet'])). '<br />';
			echo '<div class="important">Gants</div> : ' .htmlspecialchars(addslashes($_SESSION['Gloves'])). '<br />';
			echo '<div class="important">Protection</div> : ' .htmlspecialchars(addslashes($_SESSION['Armor'])). '<br />';
			echo '<div class="important">Pièces d\'or (PO)</div> : ' .htmlspecialchars(addslashes($_SESSION['Gold'])). '<br />';
			echo '<div class="important">Experience (XP)</div> : ' .htmlspecialchars(addslashes($_SESSION['Experience'])). '<br />';
			echo "<div class=\"important\">Prochain niveau</div> : $Next_Level<br />";
			echo '<div class="important">Notoriété</div> : ' .htmlspecialchars(addslashes($_SESSION['Notoriety'])). '<br />';
			echo '<div class="important">Chapitre</div> : ' .htmlspecialchars(addslashes($_SESSION['Chapter'])). '<br />';
			echo '<div class="important">Nombre de mission réussie</div> : ' .htmlspecialchars(addslashes($_SESSION['Mission'])). '<br />';
			echo '<div class="important">Access</div> : ' .htmlspecialchars(addslashes($_SESSION['Access'])). '<br /><br />';
			echo '<form method="POST" action="Character.php"><br />';
			echo '<input type="submit" name="Change_Password" value="Changer mon mot de passe">';
			echo '</form>';
		}
		if (isset($_POST['Change_Password']))
		{
			echo 'Pour changer votre mot de passe veuillez compléter le formulaire ci-dessous<br /><br />';
			echo '<form method="POST" action="Character.php"><br />';
			echo 'Nouveau mot de passe: <input type="password" name="New_Password"><br />';
			echo 'Confirmation du mot de passe <input type="password" name="New_Password_Confirmation"><br />';
			echo '<input type="submit" name="Finish" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['Finish']))
		{
			$New_Password = md5(htmlspecialchars(addslashes($_POST['New_Password'])));
			$New_Password_Confirmation = md5(htmlspecialchars(addslashes($_POST['New_Password_Confirmation'])));
			if ($New_Password == $New_Password_Confirmation)
			{
				echo 'Votre mot de passe à bien été modifié';
				$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Password= :New_Password WHERE Account_ID= :ID");
				$Update_Account->execute(array('New_Password'=> $New_Password, 'ID'=> $ID));
				echo '<form method="POST" action="Character.php"><br />';
				echo '<input type="submit" name="Cancel" value="Retour">';
				echo '</form>';
			}
			else
			{
				echo 'Les deux mots de passe ne sont pas identiques';
				echo '<form method="POST" action="Character.php"><br />';
				echo '<input type="submit" name="Cancel" value="Retour">';
				echo '</form>';
			}
		}
	}
	require_once('../HTML/Footer.php');
?>
