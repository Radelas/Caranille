<?php
if (isset($_SESSION['ID']))
{
	if (isset($Next_Level))
	{
                ?>
		<?php echo "<div class=\"important\">Pseudo :</div> " . $_SESSION['Pseudo'] ?> <br />
		<?php echo "<div class=\"important\">Ordre :</div> " . $_SESSION['Order_Name'] ?> <br /><br />
		<div class="important">Niveau</div> : <?php echo $_SESSION['Level']; ?> <br />
		<div class="important">Force</div> : <?php echo $_SESSION['Strength_Total']; ?> <br />
		<div class="important">Magie</div> : <?php echo $_SESSION['Magic_Total']; ?> <br />
		<div class="important">Agilité</div> : <?php echo $_SESSION['Agility_Total']; ?> <br />
		<div class="important">Défense</div> : <?php echo $_SESSION['Defense_Total']; ?> <br />
		<div class="important">HP</div> : <?php echo $_SESSION['HP']. "/" .$_SESSION['HP_Total']; ?> <br />
		<div class="important">MP</div> : <?php echo $_SESSION['MP']. "/" .$_SESSION['MP_Total']; ?> <br /><br />
		<div class="important">PO</div> : <?php echo $_SESSION['Gold']; ?> <br />
		<div class="important">XP</div> : <?php echo $_SESSION['Experience']; ?> <br />
		<div class="important">Prochain niveau</div> : <?php echo $Next_Level; ?><br />
		<div class="important">Notoriété</div> : <?php echo $_SESSION['Notoriety']; ?><br /><br />
		<?php
	}
	?>
	Caranille <?php echo "$version"; ?>
	<?php
}
?>
