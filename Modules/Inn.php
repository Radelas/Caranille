<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");
	if (isset($_SESSION['ID']))
	{
		if ($_SESSION['Town'] == 1)
		{
			if (empty($_POST['Rest']))
			{
				echo 'Bienvenue à l\'auberge<br /><br >';
				echo 'Ici vous pouvez vous reposer et ainsi récuperer tous vos HP et MP pour être prêt à recombattre<br /><br />';
				echo 'Pour vous soigner, cela vous coutera ' .$_SESSION['Town_Price_INN']. ' Pièce d\'or<br />';
				echo '<form method="POST" action="Inn.php">';
				echo '<input type="submit" name="Rest" value="Accepter">';
				echo '</form>';
			}
			if (isset($_POST['Rest']))
			{
				if ($_SESSION['Gold'] >= $_SESSION['Town_Price_INN'])
				{
					echo 'Vous avez récupéré toutes vos forces<br />';
					$Gold = htmlspecialchars(addslashes($_SESSION['Gold'])) - htmlspecialchars(addslashes($_SESSION['Town_Price_INN']));
					$HP_Total = htmlspecialchars(addslashes($_SESSION['HP_Total']));
					$MP_Total = htmlspecialchars(addslashes($_SESSION['MP_Total']));
					$Account_Update = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining=:HP_Total, Account_MP_Remaining=:MP_Total, Account_Golds=:Gold WHERE Account_ID=:ID");
					$Account_Update->execute(array('HP_Total'=> $HP_Total, 'MP_Total'=> $MP_Total, 'Gold'=> $Gold, 'ID'=> $ID));
				
					echo '<form method="POST" action="Map.php">';
					echo '<input type="submit" name="Inn" value="Retourner en ville">';
					echo '</form>';
				}
				else
				{
					echo 'Vous n\'avez pas assez d\'argent';
				}
			}
		}
		if ($_SESSION['Town'] == 0)
		{
			echo 'Vous n\'êtes dans aucune ville';
		}
	}
	else
	{
		echo 'Vous devez être connecté pour accèder à cette zone';
	}	
	require_once("../HTML/Footer.php");
?>
