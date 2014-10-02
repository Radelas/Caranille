<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");
	if (empty($_POST['Register']))
	{	
		echo 'Pour commencer une partie veuillez vous inscrire<br /><br />';
		echo '<div class="important">Inscription</div><br /><br />';
		echo '<form method="POST" action="Register.php">';
		echo 'Pseudo<br /> <input type="text" name="Pseudo"><br /><br />';
		echo 'Mot de passe<br /> <input type="password" name="Password"><br /><br />';
		echo 'Confirmer le mot de passe<br /> <input type="password" name="Password_Confirm"><br /><br />';
		echo 'Adresse e-mail<br /> <input type="text" name="Email"><br /><br />';
		echo '<iframe src="../LICENCE.txt"></iframe><br /><br />';
		echo '<input type="checkbox" name="Licence">J\'accepte le règlement<br /><br />';
		echo '<input type="submit" name="Register" value="S\'inscrire">';
		echo '</form>';
	}	
	if (isset($_POST['Register']))
	{
		$Pseudo = htmlspecialchars(addslashes($_POST['Pseudo']));
		$Password = htmlspecialchars(addslashes($_POST['Password']));
		if (isset($_POST['Pseudo']) && ($_POST['Password']) && ($_POST['Email']))
		{
			$Password = htmlspecialchars(addslashes($_POST['Password']));
			$Password_Confirm = htmlspecialchars(addslashes($_POST['Password_Confirm']));
			if ($Password == $Password_Confirm)
			{
				if (isset($_POST['Licence']))
				{
					$Pseudo_List_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts WHERE Account_Pseudo= ?");
					$Pseudo_List_Query->execute(array($_POST['Pseudo']));

					$Pseudo_List = $Pseudo_List_Query->rowCount();
					if ($Pseudo_List == 0)
					{
						$Pseudo = htmlspecialchars(addslashes($_POST['Pseudo']));
						$Password = md5(htmlspecialchars(addslashes($_POST['Password'])));
						$Email = htmlspecialchars(addslashes($_POST['Email']));
						$Date = date('Y-m-d H:i:s');
						$IP = $_SERVER["REMOTE_ADDR"];
						$Add_Account = $bdd->prepare("INSERT INTO Caranille_Accounts VALUES('', '0', :Pseudo, :Password, :Email, '1', '100', '0', '10', '0', '0', '0', '0', '0', '0', '0', '1', '0', '1', '1', 'Member', :Date, :IP, 'Authorized' , 'None')");
						$Add_Account->execute(array('Pseudo' => $Pseudo, 'Password' => $Password, 'Email' => $Email, 'Date' => $Date, 'IP' => $IP));
							

						$Account_Data_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts 
						WHERE Account_Pseudo= ?");
						$Account_Data_Query->execute(array($_POST['Pseudo']));

						while ($Account_Data = $Account_Data_Query->fetch())
						{	
							$ID = $Account_Data['Account_ID'];
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '$ID', '1', '1', 'Yes')");
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '$ID', '2', '1', 'Yes')");
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '$ID', '3', '1', 'Yes')");
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '$ID', '4', '1', 'Yes')");
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '$ID', '5', '1', 'Yes')");
						}
						$Account_Data_Query->closeCursor();

						echo 'Inscription effectuée, vous pouvez vous connecter';
					}
					else
					{
						echo 'Ce Pseudo est déjà utilisé';
					}
				}
				else
				{
					echo 'Vous devez accepter le règlement pour vous inscrire';
				}
			}
			else
			{
				echo 'Les deux mots de passes entrée ne sont pas identiques';
			}
		}
		else
		{
			echo 'vous n\'avez pas rempli tous les champs correctement';
		}
	}
	require_once("../HTML/Footer.php");
?>
