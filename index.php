<?php
$Config = 'Config.php';
$Size = filesize($Config); 
if ($Size == 0) 
{
	?>
	<script language="Javascript">
	document.location.replace("Install/index.php")
	</script>
	<?php
}
else
{
	?>
	<script language="Javascript">
	document.location.replace("Modules/Main.php")
	</script>
	<?php
}
?>
