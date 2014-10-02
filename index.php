<?php
$Config = 'Config.php';
if (file_exists($Config)) 
{
	?>
	<script language="Javascript">
	document.location.replace("Modules/Main.php")
	</script>
	<?php
}
else
{
	?>
	<script language="Javascript">
	document.location.replace("Install/index.php")
	</script>
	<?php
}
?>
