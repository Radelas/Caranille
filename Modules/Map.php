<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");
	if (isset($_SESSION['ID']))
	{
		if ($_SESSION['Town'] == 0)
		{
			if (empty($_POST['entrer_Town']))
			{	
				echo 'Bienvenue dans la carte du monde<br /><br />';
				echo 'La carte du monde vous montrera tous les lieux où vous pouvez aller que çe soit pour vous balader ou pour une mission<br /><br />';
			
				$recherche_Towns = $bdd->prepare("SELECT * FROM Caranille_Towns 
				WHERE Town_Chapter <= ?");
				$recherche_Towns->execute(array($_SESSION['Chapter']));
				while ($Towns = $recherche_Towns->fetch())
				{
					$Town_Image = stripslashes($Towns['Town_Image']);
					echo "<img src=\"$Town_Image\"><br />";
					echo "" .stripslashes($Towns['Town_Name']). "<br />";
					$Town_ID = stripslashes($Towns['Town_ID']);

					echo '<form method="POST" action="Map.php">';
					echo "<input type=\"hidden\" name=\"Town_ID\" value=\"$Town_ID\">";
					echo '<input type="submit" name="entrer_Town" value="entrer">';
					echo '</form><br />';
				}
			}
			if (isset($_POST['entrer_Town']))
			{
				$Town_ID = htmlspecialchars(addslashes($_POST['Town_ID']));
				$recherche_information_Town = $bdd->prepare("SELECT * FROM Caranille_Towns WHERE Town_ID= ?");
				$recherche_information_Town->execute(array($Town_ID));
				while ($information_Town = $recherche_information_Town->fetch())
				{
					$_SESSION['Town_ID'] = stripslashes($information_Town['Town_ID']);
					$_SESSION['Town_Image'] = stripslashes($information_Town['Town_Image']);	
					$_SESSION['Town_Name'] = stripslashes($information_Town['Town_Name']);
					$_SESSION['Town_Description'] = stripslashes(nl2br($information_Town['Town_Description']));
					$_SESSION['Town_Price_INN'] = stripslashes($information_Town['Town_Price_INN']);
					$_SESSION['Town'] = 1;
				}
			}
		}
		//Si la session Town contient 1, c'est que l'utilisateur a bien selectioné une Town, on affiche donc le menu
		if ($_SESSION['Town'] == 1)
		{
			if (empty($_POST['Exit_Town']))
			{
				$Town_Image = htmlspecialchars(addslashes($_SESSION['Town_Image']));
				echo "<img src=\"$Town_Image\"><br />";
				echo "Bienvenue à " .htmlspecialchars(addslashes($_SESSION['Town_Name'])). "<br /><br />";
				echo "" .htmlspecialchars(addslashes($_SESSION['Town_Description'])). "<br /><br />";

			
				echo '<a href="Dungeon.php">S\'entrainer</a><br />';
				echo '<a href="Mission.php">Les missions</a><br />';
				echo '<a href="Weapon_Shop.php">Boutique d\'armes</a><br />';
				echo '<a href="Accessory_Shop.php">Boutique d\'accessoire</a><br />';
				echo '<a href="Magic_Shop.php">Boutique de magie</a><br />';
				echo '<a href="Item_Shop.php">Boutique d\'objets</a><br />';
				echo '<a href="Temple.php">Le temple</a><br />';
				echo '<a href="Inn.php">L\'auberge</a><br /><br />';
				echo '<form method="POST" action="Map.php">';
				echo '<input type="submit" name="Exit_Town" value="Quitter la Town">';
				echo '</form>';
			
			}
			//Si l'utilisateur décIDe de quitter la Town
			if (isset($_POST['Exit_Town']))
			{
				$_SESSION['Town'] = 0;
				echo '<p>Vous venez de quitter la Town';
				echo '<form method="POST" action="Map.php">';
				echo '<input type="submit" name="carte" value="Retourner à la carte du monde">';
				echo '</form></p>';
			}
		}
	}
	else
	{
		echo 'Vous devez être connecté pour accèder à cette zone';
	}
	require_once("../HTML/Footer.php");
?>
