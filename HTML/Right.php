<?php
if (isset($_SESSION['Account']))
{
    ?>
	<?php echo "<div class=\"important\">$Right_0</div>: $Pseudo"; ?> <br />
	<div class="important"><?php echo $Right_1; ?></div> : <?php echo $Level; ?> <br />
	<div class="important"><?php echo $Right_2; ?></div> : <?php echo $Strength ?> <br />
	<div class="important"><?php echo $Right_3; ?></div> : <?php echo $Magic; ?> <br />
	<div class="important"><?php echo $Right_4; ?></div> : <?php echo $Agility; ?> <br />
	<div class="important"><?php echo $Right_5; ?></div> : <?php echo $Defense; ?> <br />
	<div class="important"><?php echo $Right_6; ?></div> : <?php echo $Sagesse_Bonus; ?> <br />
	<div class="important"><?php echo $Right_7; ?></div> : <?php echo $HP. "/" .$HP_MAX; ?> <br />
	<div class="important"><?php echo $Right_8; ?></div> : <?php echo $MP. "/" .$MP_MAX; ?> <br /><br />
	<div class="important"><?php echo $Right_9; ?></div> : <?php echo $Gold; ?> <br />
	<div class="important"><?php echo $Right_10; ?></div> : <?php echo $Experience; ?> <br />
	<div class="important"><?php echo $Right_11; ?></div> : <?php echo $Next_Level; ?><br /><br />
	<?php
	?>
	Caranille <?php echo "$version"; ?>
	<?php
}
?>
