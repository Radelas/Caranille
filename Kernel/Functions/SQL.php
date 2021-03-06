<?php
//LAUNCH THE CONNECTION
    try 
    {
    	$bdd = new PDO($Dsn, $User, $Password);
    }
    catch (PDOException $e)
    {
    	echo 'An error as occured, Cannot connect to the database. Error: ' . $e->getMessage();
    }
// END OF LAUNCH THE CONNECTION

//LIST OF THE SQL FUNCTION
function SQL_Account_Connection($Account_Pseudo, $Account_Password)
{
    global $bdd;
    global $Login_6;
    global $Login_7;
    
    $Login_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts WHERE Account_Pseudo= ? AND Account_Password= ?");
	$Login_Query->execute(array($Account_Pseudo, $Account_Password));
	$Login = $Login_Query->rowCount();
	if ($Login >= 1)
	{
		$Data_Account_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts, Caranille_Levels
		WHERE Account_Pseudo= ?
		AND Account_Level = Level_Number");
		$Data_Account_Query->execute(array($Account_Pseudo));
		while ($Account_Data = $Data_Account_Query->fetch())
		{
	    	$Account_Array['Account']['ID'] = stripslashes($Account_Data['Account_ID']);
			$Account_Array['Account']['Guild_ID'] = stripslashes($Account_Data['Account_Guild_ID']);
			$Account_Array['Account']['Pseudo'] = stripslashes($Account_Data['Account_Pseudo']);
			$Account_Array['Account']['Email'] = stripslashes($Account_Data['Account_Email']);
			$Account_Array['Account']['Level'] = stripslashes($Account_Data['Account_Level']);
			$Account_Array['Account']['Strength'] = stripslashes($Account_Data['Level_Strength']);
			$Account_Array['Account']['Magic'] = stripslashes($Account_Data['Level_Magic']);
			$Account_Array['Account']['Agility'] = stripslashes($Account_Data['Level_Agility']);
			$Account_Array['Account']['Defense'] = stripslashes($Account_Data['Level_Defense']);
			$Account_Array['Account']['HP'] = stripslashes($Account_Data['Account_HP_Remaining']);
			$Account_Array['Account']['HP_MAX'] = stripslashes($Account_Data['Level_HP']);
			$Account_Array['Account']['HP_Bonus'] = stripslashes($Account_Data['Account_HP_Bonus']);
			$Account_Array['Account']['MP'] = stripslashes($Account_Data['Account_MP_Remaining']);
			$Account_Array['Account']['MP_MAX'] = stripslashes($Account_Data['Level_MP']);
			$Account_Array['Account']['MP_Bonus'] = stripslashes($Account_Data['Account_MP_Bonus']);
			$Account_Array['Account']['Strength_Bonus'] = stripslashes($Account_Data['Account_Strength_Bonus']);
			$Account_Array['Account']['Magic_Bonus'] = stripslashes($Account_Data['Account_Magic_Bonus']);
			$Account_Array['Account']['Agility_Bonus'] = stripslashes($Account_Data['Account_Agility_Bonus']);
			$Account_Array['Account']['Defense_Bonus'] = stripslashes($Account_Data['Account_Defense_Bonus']);
			$Account_Array['Account']['Sagesse_Bonus'] = stripslashes($Account_Data['Account_Sagesse_Bonus']);
			$Account_Array['Account']['Experience'] = stripslashes($Account_Data['Account_Experience']);
			$Account_Array['Account']['Gold'] = stripslashes($Account_Data['Account_Golds']);
			$Account_Array['Account']['Chapter'] = stripslashes($Account_Data['Account_Chapter']);
			$Account_Array['Account']['Mission'] = stripslashes($Account_Data['Account_Mission']);	
			$Account_Array['Account']['Access'] = stripslashes($Account_Data['Account_Access']);
			$Account_Array['Account']['Last_Connection'] = stripslashes($Account_Data['Account_Last_Connection']);
			$Account_Array['Account']['Last_IP'] = stripslashes($Account_Data['Account_Last_IP']);
			$Account_Array['Account']['Status'] = stripslashes($Account_Data['Account_Status']);
			$Account_Array['Account']['Reason'] = stripslashes($Account_Data['Account_Reason']);
			return $Account_Array['Account'];
		}
	}
	else
	{
	    echo $Login_6;
	}
}

function SQL_Add_Account($Account_Pseudo, $Account_Password, $Account_Email)
{
	global $bdd;
	global $Register_8;
	global $Register_9;

	$Pseudo_List_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts WHERE Account_Pseudo= ?");
	$Pseudo_List_Query->execute(array($Account_Pseudo));
	
	$Pseudo_List = $Pseudo_List_Query->rowCount();
	if ($Pseudo_List == 0)
	{
	    $Email_List_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts WHERE Account_Pseudo= ?");
	    $Email_List_Query->execute(array($Account_Pseudo));
	    
	    $Email_List = $Email_List_Query->rowCount();
	    if ($Email_List == 0)
	    {
		$Date = date('Y-m-d H:i:s');
		$IP = $_SERVER["REMOTE_ADDR"];
	
		$Add_Account = $bdd->prepare("INSERT INTO Caranille_Accounts VALUES(
		'', 
		'0', 
		:Pseudo, 
		:Password, 
		:Email, 
		'1', 
		'100', 
		'0', 
		'10', 
		'0', 
		'0', 
		'0', 
		'0', 
		'0', 
		'0', 
		'0', 
		'0', 
		'1', 
		'1', 
		'Admin', 
		:Date, 
		:IP, 
		'Authorized', 
		'None')");
	
		$Add_Account->execute(array(
		'Pseudo' => $Account_Pseudo, 
		'Password' => $Account_Password, 
		'Email' => $Account_Email, 
		'Date' => $Date, 
		'IP' => $IP));
		echo $Register_16;
	 }
	else
	{
		echo $Register_15;
	}
	else
	{
		echo $Register_14;
	}
}

function SQL_Create_Table($Dsn, $User, $Password)
{
	try
	{
		$bdd = new PDO($Dsn, $User, $Password);
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
					
		
		$bdd->exec("CREATE TABLE `Caranille_News` (
					`News_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`News_Title` VARCHAR(30) NOT NULL,
					`News_Message` TEXT NOT NULL,
					`News_Account_Pseudo` VARCHAR(15) NOT NULL,
					`News_Date` DATETIME NOT NULL
					)");
		
		$Date = date('Y-m-d H:i:s');
		$bdd->exec("INSERT INTO Caranille_News VALUES(
				'',
				'Installation of CaranilleNG',
				'Congratulation CaranilleNG has installed',
				'Admin',
				'$Date')");
				
				$HP_Choice = 20;
				$MP_Choice = 2;
				$MP_Choice = 2;
				$Magic_Choice = 2;
				$Agility_Choice = 2;
				$Defense_Choice = 2;
				$Experience_Choice = 2000;
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
					$bdd->exec("INSERT INTO Caranille_Levels VALUES(
					'', 
					'$Level', 
					'$Experience', 
					'$HP', 
					'$MP', 
					'$Strength', 
					'$Magic', 
					'$Agility', 
					'$Defense')");
				}

	}
	catch (PDOException $e)
	{
		echo 'An error has occurred: The creation of the tables has failed. Error: ' . $e->getMessage();
	}
}

function SQL_News_List()
{
    global $bdd;
    global $Main_0;
    global $Main_1;
        
	$Resultat = $bdd->query("SELECT * FROM Caranille_News ORDER BY News_ID desc");
	while ($News = $Resultat->fetch())
	{
		echo '<table>';
			echo '<tr>';
				echo '<th>';
					echo "$Main_0 " .$News['News_Date']. " $Main_1 " .$News['News_Account_Pseudo']. "";
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
}
?>
