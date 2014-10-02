<?php
session_start();
?>
<!DOCTYPE html>
<html>
		<head>
			<title>Caranille - Installation du MMORPG</title>
			<meta charset="utf-8" />
			<link rel="stylesheet" media="screen" type="text/css" title="design" href="../Design/Design.css" />
		</head>

		<body>

			<p>
			<img src="../Design/Images/logo.png">
			</p>
			
			<section>
				<?php
				if (empty($_POST['Accept']) && empty($_POST['Create_Configuration']) && empty($_POST['Choose_Curve']) && empty($_POST['Start_Installation']) && empty($_POST['Configure']) && empty($_POST['Finish']))
				{
					?>
					<div class="important">Installation de caranille - Etape 1/5 (License d'utilisation)</div><p>
					Bienvenue dans l'assistant d'installation de Caranille<br />
					Cet assistant vous guidera tout au long de l'installation de Caranille<br />
					pour vous offrir la meilleur experience possible dans la création de votre RPG<p>
					
					Pour commencer l'installation de Caranille veuillez lire et accepter la license d'utilisation<br /><br />
					<a rel="license" href="http://creativecommons.org/licenses/by/4.0/deed.fr"><img alt="Licence Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by/4.0/88x31.png" /></a><br />Ce(tte) œuvre est mise à disposition selon les termes de la <a rel="license" href="http://creativecommons.org/licenses/by/4.0/deed.fr">Licence Creative Commons Attribution 4.0 International</a>.
					<br /><br /><iframe src="../LICENCE.txt">
					</iframe><br /><br />
					<form method="POST" action="index.php">
					<input type="submit" name="Accept" value="J'accepte la license d'utilisation de caranille et je la respecte"><br /><br />
					<div class="important">Si vous n'acceptez pas la license d'utilisation, veuillez supprimer caranille</div>
					</form>
					<?php
				}
				if (isset($_POST['Accept']))
				{
					?>
					<div class="important">Installation de caranille - Etape 2/5 (Configuration de la base de donnée)</div>
					<p>Caranille à besoins d'une base de donnée pour stocker toutes les informations de votre jeu<br />
					en passant par les données des joueurs, des objets, des monstres etc...</p>
					
					<p>Veuillez compléter le formulaire suivant avec les informations de connexion à votre base de donnée<br />
					Si vous possedez un hébergement mutualisé il vous suffit de vous connecter sur le site de votre prestataire<br />
					et de chercher les informations de votre base de donnée</p>
					<form method="POST" action="index.php">
					Adresse de votre serveur SQL<br /><input type="text" name="Server"><br /><br />
					Nom d'utilisateur<br /> <input type="text" name="User"><br /><br />
					Mot de passe<br /> <input type="password" name="Password"><br /><br />
					Nom de la base<br /> <input type="text" name="Database"><br /><br />
					<input type="submit" name="Create_Configuration" value="Creer la configuration du MMORPG">
					</form>
					<?php
				}
				if (isset($_POST['Create_Configuration']))
				{
					$Server = htmlspecialchars(addslashes($_POST['Server']));
					$User = htmlspecialchars(addslashes($_POST['User']));
					$Password = htmlspecialchars(addslashes($_POST['Password']));
					$Database = htmlspecialchars(addslashes($_POST['Database']));
					$Open_Config = fopen("../Config.php", "w");
					fwrite($Open_Config, "
					<?php

					//Version du rpg de caranille
					\$version = \"5.0.0\";
					
					\$bdd = new PDO('mysql:host=$Server;dbname=$Database', '$User', '$Password');
						
					?>");
					fclose($Open_Config);
					if (file_exists("../Config.php"))
					{
						?>
						<form method="POST" action="index.php">
						Félicitation Le fichier de configuration à votre base de donnée à bien été crée<p>
						Ce fichier va permettre à Caranille de communiquer à votre base de donnée.<br />
						<br /><br />
						<input type="submit" name="Choose_Curve" value="Continuer">
						</form>
						<?php
					}
					else
					{
						echo 'Le fichier de configuration n\'a pu être crée. Veuillez vérifier que PHP à bien les droits d\'écriture';
					}
                }
				if (isset($_POST['Choose_Curve']))
				{
					?>
					Veuillez choisir la courbe d'experience
					<form method="POST" action="index.php">
					Gain de HP par niveau: <br /> <input type="text" name="HP_Level"><br /><br />
					Gain de MP par niveau: <br /> <input type="text" name="MP_Level"><br /><br />
					Gain de Force par niveau: <br /> <input type="text" name="Strength_Level"><br /><br />
					Gain de Magie par niveau: <br /> <input type="text" name="Magic_Level"><br /><br />
					Gain de Agilité par niveau: <br /> <input type="text" name="Agility_Level"><br /><br />  
					Gain de Défense par niveau: <br /> <input type="text" name="Defense_Level"><br /><br />                                  
					Experience demandée en plus par niveau: <br /> <input type="text" name="Experience_Level"><br /><br />
					<input type="submit" name="Start_Installation" value="Lancer l'installation">
					</form>
					<?php
				}
				if (isset($_POST['Start_Installation']))
				{
					require("../Config.php");
					?>
					<div class="important">Installation de caranille - Etape 3/5 (Création des tables dans la base de donnée)</div><br /><br />
					<?php
					
					$bdd->exec("CREATE TABLE `Caranille_Accounts` (
					`Account_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Account_Guild_ID` int(11) NOT NULL,
					`Account_Pseudo` VARCHAR(30) NOT NULL,
					`Account_Password` TEXT NOT NULL,
					`Account_Email` VARCHAR(30) NOT NULL,
					`Account_Level` int(11) NOT NULL,
					`Account_HP_Remaining` int(11) NOT NULL,
					`Account_HP_Bonus` int(11) NOT NULL,
					`Account_MP_Remaining` int(11) NOT NULL,
					`Account_MP_Bonus` int(11) NOT NULL,
					`Account_Strength_Bonus` int(11) NOT NULL,
					`Account_Magic_Bonus` int(11) NOT NULL,
					`Account_Agility_Bonus` int(11) NOT NULL,
					`Account_Defense_Bonus` int(11) NOT NULL,
					`Account_Sagesse_Bonus` int(11) NOT NULL,
					`Account_Experience` bigint(255) NOT NULL,
					`Account_Golds` int(11) NOT NULL,
					`Account_Chapter` int(11) NOT NULL,
					`Account_Mission` int(11) NOT NULL,
					`Account_Access` VARCHAR(10) NOT NULL,
					`Account_Last_Connection` DATETIME NOT NULL,
					`Account_Last_IP` TEXT NOT NULL,
					`Account_Status` TEXT NOT NULL,
					`Account_Reason` TEXT NOT NULL
					)");
					echo "Table Caranille_Accounts installée<br />";
				
					$bdd->exec("CREATE TABLE `Caranille_Chapters` (
					`Chapter_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Chapter_Number` int(5) NOT NULL,
					`Chapter_Name` VARCHAR(30) NOT NULL,
					`Chapter_Opening` TEXT NOT NULL,
					`Chapter_Ending` TEXT NOT NULL,
					`Chapter_Defeate` TEXT NOT NULL,
					`Chapter_Monster` int(5) NOT NULL
					)");
					echo "Table Caranille_Chapters installée<br />";

					$bdd->exec("CREATE TABLE `Caranille_Chat` (
					`Chat_Message_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Chat_Pseudo_ID` INT(5) NOT NULL,
					`Chat_Message` TEXT NOT NULL
					)");
					echo "Table Caranile_Chat installée<br />";

					$bdd->exec("CREATE TABLE `Caranille_Configuration` (
					`Configuration_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Configuration_RPG_Name` VARCHAR(30) NOT NULL,
					`Configuration_Presentation` TEXT NOT NULL,
					`Configuration_Access` VARCHAR(10) NOT NULL
					)");
					echo "Table Caranille_Configuration installée<br />";

					$bdd->exec("CREATE TABLE `Caranille_Inventory` (
					`Inventory_ID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Inventory_Account_ID` int(5) NOT NULL,
					`Inventory_Item_ID` int(5) NOT NULL,
					`Inventory_Item_Quantity` int(5) NOT NULL,
					`Inventory_Item_Equipped` VARCHAR(10) NOT NULL
					)");
					echo "Table Caranille_Inventory installée<br />";
				
					$bdd->exec("CREATE TABLE `Caranille_Inventory_Invocations` (
					`Inventory_Invocation_Account_ID` int(5) NOT NULL,
					`Inventory_Invocation_Invocation_ID` int(5) NOT NULL
					)");
					echo "Table Caranille_Inventory_Invocations installée<br />";
				
					$bdd->exec("CREATE TABLE `Caranille_Inventory_Magics` (
					`Inventory_Magic_Account_ID` int(5) NOT NULL,
					`Inventory_Magic_Magic_ID` int(5) NOT NULL
					)");
					echo "Table Caranille_Inventory_Magics installée<br />";
					
					$bdd->exec("CREATE TABLE `Caranille_Invocations` (
					`Invocation_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Invocation_Image` TEXT NOT NULL,	
					`Invocation_Name` VARCHAR(30) NOT NULL,
					`Invocation_Description` TEXT NOT NULL,
					`Invocation_Damage` int(11) NOT NULL,
					`Invocation_Town` int(5) NOT NULL,
					`Invocation_Price` int(11) NOT NULL
					)");
					echo "Table caranille_chimères installée<br />";
					
					$bdd->exec("CREATE TABLE `Caranille_Items` (
					`Item_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Item_Image` TEXT NOT NULL,	
					`Item_Type` VARCHAR(30) NOT NULL,
					`Item_Level_Required` VARCHAR(30) NOT NULL,
					`Item_Name` VARCHAR(30) NOT NULL,
					`Item_Description` TEXT NOT NULL,
					`Item_HP_Effect` int(11) NOT NULL,
					`Item_MP_Effect` int(11) NOT NULL,
					`Item_Strength_Effect` int(11) NOT NULL,
					`Item_Magic_Effect` int(11) NOT NULL,
					`Item_Agility_Effect` int(11) NOT NULL,
					`Item_Defense_Effect` int(11) NOT NULL,
					`Item_Sagesse_Effect` int(11) NOT NULL,
					`Item_Town` int(5) NOT NULL,
					`Item_Purchase_Price` int(11) NOT NULL,
					`Item_Sale_Price` int(11) NOT NULL
					)");
					echo "Table Caranille_Items installée<br />";
					
					$bdd->exec("CREATE TABLE `Caranille_Levels` (
					`Level_ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Level_Number` int(11) NOT NULL,
					`Level_Experience_Required` bigint(255) NOT NULL,
					`Level_HP` bigint(255) NOT NULL,
					`Level_MP` bigint(255) NOT NULL,
					`Level_Strength` bigint(255) NOT NULL,
					`Level_Magic` bigint(255) NOT NULL,
					`Level_Agility` bigint(255) NOT NULL,
					`Level_Defense` bigint(255) NOT NULL
					);");
					echo "Table Caranille_Levels installée<br />";
					
					$bdd->exec("CREATE TABLE `Caranille_Magics` (
					`Magic_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Magic_Image` TEXT NOT NULL,	
					`Magic_Name` VARCHAR(30) NOT NULL,
					`Magic_Description` TEXT NOT NULL,
					`Magic_Type` VARCHAR(30) NOT NULL,
					`Magic_Effect` int(11) NOT NULL,
					`Magic_MP_Cost` int(11) NOT NULL,
					`Magic_Town` int(5) NOT NULL,
					`Magic_Price` int(11) NOT NULL
					)");
					echo "Table Caranille_Magics installée<br />";
					
					$bdd->exec("CREATE TABLE `Caranille_Missions` (
					`Mission_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Mission_Town` int(5) NOT NULL,
					`Mission_Number` int(5) NOT NULL,
					`Mission_Name` VARCHAR(30) NOT NULL,
					`Mission_Introduction` TEXT NOT NULL,
					`Mission_Victory` TEXT NOT NULL,
					`Mission_Defeate` TEXT NOT NULL,
					`Mission_Monster` int(5) NOT NULL
					)");
					echo "Table Caranille_Missions installée<br />";
					
					$bdd->exec("CREATE TABLE `Caranille_Missions_Successful` (
					`Mission_Successful_Mission_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Mission_Successful_Account_ID` int(5) NOT NULL
					)");
					echo "Table Caranille_Missions_Successful installée<br />";

					$bdd->exec("CREATE TABLE `Caranille_Monsters` (
					`Monster_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Monster_Image` TEXT NOT NULL,	
					`Monster_Name` VARCHAR(30) NOT NULL,
					`Monster_Description` TEXT NOT NULL,
					`Monster_Level` int(11) NOT NULL,
					`Monster_Strength` int(11) NOT NULL,
					`Monster_Defense` int(11) NOT NULL,
					`Monster_HP` int(11) NOT NULL,
					`Monster_MP` int(11) NOT NULL,
					`Monster_Golds` int(11) NOT NULL,
					`Monster_Experience` bigint(255) NOT NULL,
					`Monster_Town` int(5) NOT NULL,
					`Monster_Item_One` int(11) NOT NULL,
					`Monster_Item_One_Rate` int(11) NOT NULL,
					`Monster_Item_Two` int(11) NOT NULL,
					`Monster_Item_Two_Rate` int(11) NOT NULL,
					`Monster_Item_Three` int(11) NOT NULL,
					`Monster_Item_Three_Rate` int(11) NOT NULL,
					`Monster_Access` VARCHAR(30) NOT NULL
					)");
					echo "Table Caranille_Monsters installée<br />";
					
					$bdd->exec("CREATE TABLE `Caranille_News` (
					`News_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`News_Title` VARCHAR(30) NOT NULL,
					`News_Message` TEXT NOT NULL,
					`News_Account_Pseudo` VARCHAR(15) NOT NULL,
					`News_Date` DATETIME NOT NULL
					)");
					echo "Table Caranille_News installée<br />";
		
					$bdd->exec("CREATE TABLE `Caranille_Private_Messages` (
					`Private_Message_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Private_Message_Transmitter` int(5) NOT NULL,
					`Private_Message_Receiver` VARCHAR(20) NOT NULL,
					`Private_Message_Subject` TEXT NOT NULL,
					`Private_Message_Message` TEXT NOT NULL
					)");
					echo "Table Caranille_Private_Messages installée<br />";
				
					$bdd->exec("CREATE TABLE `Caranille_Sanctions` (
					`Sanction_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Sanction_Type` VARCHAR(15) NOT NULL,
					`Sanction_Message` TEXT NOT NULL,
					`Sanction_Transmitter` VARCHAR(50) NOT NULL,
					`Sanction_Receiver` INT(11) NOT NULL
					)");
					echo "Table Caranille_Sanctions installée<br />";

					$bdd->exec("CREATE TABLE `Caranille_Towns` (
					`Town_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Town_Image` TEXT NOT NULL,		
					`Town_Name` VARCHAR(30) NOT NULL,
					`Town_Description` TEXT NOT NULL,
					`Town_Price_INN` int(10) NOT NULL,
					`Town_Chapter` int(5) NOT NULL
					)");
					echo "Table Caranille_Towns installée<br />";

					$Level = 1;
					$Experience = 0;
					$HP = 100;
					$MP = 10;
					$Strength= 10;
					$Magic = 10;
					$Agility = 10;
					$Defense = 10;
                                        
					$bdd->exec("INSERT INTO Caranille_Levels VALUES('', '$Level', '$Experience', '$HP', '$MP', '$Strength', '$Magic', '$Agility', '$Defense')");
                                        
                                        $HP_Choice = $_POST['HP_Level'];
                                        $MP_Choice = $_POST['MP_Level'];
                                        $MP_Choice = $_POST['Strength_Level'];
                                        $Magic_Choice = $_POST['Magic_Level'];
                                        $Agility_Choice = $_POST['Agility_Level'];
                                        $Defense_Choice = $_POST['Defense_Level'];
                                        $Experience_Choice = $_POST['Experience_Level'];
					while ($Level < 200)
					{
						$HP = $HP + $HP_Choice;

						$MP = $MP + $MP_Choice;

						$Strength = $Strength + $MP_Choice;

						$Magic = $Magic + $Magic_Choice;

						$Agility = $Agility + $Agility_Choice;
						
						$Defense = $Defense + $Defense_Choice;
						
						$Experience = $Experience + $Experience_Choice;

						$Level = $Level +1;
						$bdd->exec("INSERT INTO Caranille_Levels VALUES('', '$Level', '$Experience', '$HP', '$MP', '$Strength', '$Magic', '$Agility', '$Defense')");
					}
						
					?>
					Installation de caranille terminée avec succès<br />
					Dans la suite de l'installation vous allez devoir configurer les bases de votre RPG<br />
					<form method="POST" action="index.php">
					<input type="submit" name="Configure" value="Configurer mon MMORPG">
					</form>
					<?php
				}
				if (isset($_POST['Configure']))
				{
					require("../Config.php");
					?>
					<div class="important">Installation de caranille - Etape 4/5 (Préparation de la configuration de base du RPG)</div><br /><br />
					Dernière étape avant de pouvoir commencer votre RPG<p>
					Cette étape est l'une des plus importantes pour votre jeu<br />
					C'est ici que vous allez devoir donner un nom à votre RPG ainsi que une courte introduction<br /><br />
					
					De plus vous allez créer votre propre compte qui sera le compte administrateur</p>
					<form method="POST" action="index.php">
					Nom de votre RPG<br /> <input type="text" name="RPG_Name"><br /><br />
					Présentation<br /><textarea name="Presentation" ID="Presentation" rows="10" cols="50"></textarea><br /><br />
					Pseudo<br /> <input type="text" name="Pseudo"><br /><br />
					Mot de passe<br /> <input type="password" name="Password"><br /><br />
					Confirmer le mot de passe<br /> <input type="password" name="Password_Confirm"><br /><br />
					Adresse e-mail<br /> <input type="text" name="Email"><br /><br />
					<input type="submit" name="Finish" value="Terminer">
					</form>
					<?php
				}
				if (isset($_POST['Finish']))
				{
					require("../Config.php");
					echo '<div class="important">Installation de caranille - Etape 5/5 (Installation des données de base du MMORPG)</div><br /><br />';
					$RPG_Name = htmlspecialchars(addslashes($_POST['RPG_Name']));
					$Presentation = htmlspecialchars(addslashes($_POST['Presentation']));
					$Pseudo = htmlspecialchars(addslashes($_POST['Pseudo']));
					$Email = htmlspecialchars(addslashes($_POST['Email']));

					if (isset($_POST['RPG_Name']) && ($_POST['Presentation']) && ($_POST['Pseudo']) && ($_POST['Password']) && ($_POST['Email']))
					{
						$Password = htmlspecialchars(addslashes($_POST['Password']));
						$Password_Confirm = htmlspecialchars(addslashes($_POST['Password_Confirm']));
						if ($Password == $Password_Confirm)
						{
							$bdd->exec("INSERT INTO Caranille_Invocations VALUES('', 'http://localhost', 'Trident', 'Chimère qui provient du fond des océans', '10', '1', '200')");

							$Date = date('Y-m-d H:i:s');
							$IP = $_SERVER["REMOTE_ADDR"];
							$Password = md5(htmlspecialchars(addslashes($_POST['Password'])));
							$Add_Account = $bdd->prepare("INSERT INTO Caranille_Accounts VALUES('', '0', :Pseudo, :Password, :Email, '1', '100', '0', '10', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', 'Admin', :Date, :IP, 'Authorized' , 'None')");
							$Add_Account->execute(array('Pseudo' => $Pseudo, 'Password' => $Password, 'Email' => $Email, 'Date' => $Date, 'IP' => $IP));
							
							$MMORPG = $bdd->prepare("INSERT into Caranille_Configuration VALUES('', :RPG_Name, :Presentation, 'Yes')");
							$MMORPG->execute(array('RPG_Name' => $RPG_Name, 'Presentation' => $Presentation));

							$bdd->exec("INSERT into Caranille_Guilds_competences VALUES('1', '1', '1', '1', '1')");
							
							$bdd->exec("INSERT into Caranille_Chapters VALUES('', '1', 'Chapitre 1 - Le commencement', 'Bienvenue dans Indicia, une ville d\'habitude très agréable, malheureusement un monstre bloque l\'accé à la ville', 'Vous avez sauvé la ville', 'Vous êtes morts en héro', '3')");

							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '1', '1', '1', 'No')");
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '1', '2', '1', 'No')");
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '1', '3', '1', 'No')");
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '1', '4', '1', 'No')");
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '1', '5', '1', 'No')");

							$bdd->exec("INSERT INTO Caranille_Inventory_Invocations VALUES('1', '1')");

							$bdd->exec("INSERT INTO Caranille_Inventory_Magics VALUES('1', '1')");

							$bdd->exec("INSERT INTO Caranille_News VALUES('', 'Installation de Caranille', 'Félicitation Caranille est bien installé, vous pouvez éditer cette news ou la supprimer', '$Pseudo', '$Date')");

							$bdd->exec("INSERT INTO Caranille_Magics VALUES('', 'http://localhost', 'Feu', 'Petite boule de feu', 'Attack', '5', '10', '1', '50')");
							$bdd->exec("INSERT INTO Caranille_Magics VALUES('', 'http://localhost', 'Soin', 'Un peu de HP en plus', 'Health', '10', '5', '1', '50')");

							$bdd->exec("INSERT INTO Caranille_Missions VALUES('', '1', '1', 'Mission 01 - Affronter un dragon', 'Un dragon menace le village de Indicia, aller l\'affronter pour sauver le village', 'Vous avez sauvé le village', 'Le dragon vient de détruire le village', '2')");
						
							$bdd->exec("INSERT INTO Caranille_Monsters VALUES('', 'http://localhost', 'Plop', 'Petit monstre vert', '1', '15', '5', '40', '30', '5', '5', '1', '', '', '', '', '', '', 'Battle')");
							$bdd->exec("INSERT INTO Caranille_Monsters VALUES('', 'http://localhost', 'Dragon', 'Monstre qui crache du feu', '1', '50', '30', '1000', '100', '100', '100', '1', '', '', '', '', '', '', 'Mission')");
							$bdd->exec("INSERT INTO Caranille_Monsters VALUES('', 'http://localhost', 'Plop doree', 'Petit monstre en or', '1', '75', '10', '300', '30', '5', '5', '1', '', '', '', '', '', '', 'Chapter')");

							$bdd->exec("INSERT INTO Caranille_Items VALUES('', 'http://localhost', 'Weapon', '1', 'Epée de cuivre', 'Une petite Epée', '0', '0', '0', '0', '0', '0', '0', '1', '10', '5')");
							$bdd->exec("INSERT INTO Caranille_Items VALUES('', 'http://localhost', 'Armor', '1', 'Armure de cuivre', 'Une petite armure', '0', '0', '0', '0', '0', '0', '0', '1', '10', '5')");
							$bdd->exec("INSERT INTO Caranille_Items VALUES('', 'http://localhost', 'Boots', '1', 'Bottes de cuivre', 'Des petites bottes', '0', '0', '0', '0', '0', '0', '0', '1', '10', '5')");
							$bdd->exec("INSERT INTO Caranille_Items VALUES('', 'http://localhost', 'Gloves', '1', 'Gants de cuivre', 'Des petits gants', '0', '0', '0', '0', '0', '0', '0', '1', '10', '5')");
							$bdd->exec("INSERT INTO Caranille_Items VALUES('', 'http://localhost', 'Helmet', '1', 'Casque de cuivre', 'Un petit casque', '0', '0', '0', '0', '0', '0', '0', '1', '0', '10', '5')");
							$bdd->exec("INSERT INTO Caranille_Items VALUES('', 'http://localhost', 'Parchment', '1', 'Parchemin vide', 'Un parchemin vide', '0', '0', '0', '0', '0', '0', '0', '1', '10', '5')");
							$bdd->exec("INSERT INTO Caranille_Items VALUES('', 'http://localhost', 'Health', '1', 'Potion', 'Redonne 50 HP', '0', '0', '0', '0', '0', '0', '0', '1', '10', '5')");
							$bdd->exec("INSERT INTO Caranille_Items VALUES('', 'http://localhost', 'Magic', '1', 'Ether', 'Redonne 5 MP', '0', '0', '0', '0', '0', '0', '0', '1', '10', '5')");
					
							$bdd->exec("INSERT INTO Caranille_Towns VALUES('', 'http://localhost', 'Indicia', 'Petite ville cotière', '10', '1')");
						
							?>
							Félicitation Votre RPG a bien été crée<p/>
							Vous allez maintenant pouvoir créer et modifier votre jeu et donner vie à une communauté de joueurs<br /><br />
							
							Par mesure de sécurité veuillez de supprimer le répertoire "Install" de votre serveur FTP<br />
							<form method="POST" action="../index.php">
							<input type="submit" name="accueil" value="retourner à l'accueil">
							</form>
							<?php
						}
						else
						{
							?>
							ATTENTION: Les deux mots de passe entrée ne sont pas identiques
							<form method="POST" action="index.php">
							<input type="submit" name="Finish" value="Recommencer">
							</form>
							<?php
						}
					}
					else
					{
						?>
						ATTENTION: Vous n'avez pas rempli tous les champs correctement
						<form method="POST" action="index.php">
						<input type="submit" name="Finish" value="Recommencer">
						</form>
						<?php
					}
				}
				?>
		</section>
	</body>
</html>
