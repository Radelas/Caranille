<?php
if (isset($_SESSION['ID']))
{	
	?>
	<div class="important">RPG</div><br />
	<a href="Main.php"><?php echo $Left_0; ?></a><br />
	<a href="Story.php"><?php echo $Left_1; ?></a><br />
	<a href="Map.php"><?php echo $Left_2; ?></a><br /><br />
	<div class="important"><?php echo $Left_3; ?></div><br />
	<a href="Character.php"><?php echo $Left_4; ?></a><br />
	<a href="Inventory.php"><?php echo $Left_5; ?></a><br /><br />
	<div class="important"><?php echo $Left_6; ?></div><br />
	<a href="Top.php"><?php echo $Left_7; ?></a><br />
	<?php echo "<a href=\"Private_Message.php\">$Left_8 ($Total_Private_Message Message(s))</a><br />"; ?>
	<a href="Chat.php"><?php echo $Left_9; ?></a><br /><br />
	<a href="Logout.php"><?php echo $Left_10; ?></a><br /><br />
	<?php

	if ($_SESSION['Access'] == "Modo" || $_SESSION['Access'] == "Admin")
	{
		?>
		<a href="../Moderator/Modules/Main.php"><div class="important"><?php echo $Left_11; ?></div></a><br />
		<?php
	}
	if ($_SESSION['Access'] == "Admin")
	{
		?>
		<a href="../Admin/Modules/Main.php"><div class="important"><?php echo $Left_12; ?></div></a><br />
		<?php
	}
}	
//Si l'utilisateur n'est pas connecté
else
{
	?>
	<div class="important">RPG</div><br />
	<a href="Main.php"><?php echo $Left_13; ?></a><br />
	<a href="Presentation.php"><?php echo $Left_14; ?></a><br /><br />
	<div class="important"><?php echo $Left_15; ?></div><br />
	<a href="Register.php"><?php echo $Left_16; ?></a><br />
	<a href="Login.php"><?php echo $Left_17; ?></a><br /><br />
	<div class="important"><?php echo $Left_18; ?></div><br />
	<a href="Delete_Account.php"><?php echo $Left_19; ?></a><br /><br />
	<?php
}
?>
