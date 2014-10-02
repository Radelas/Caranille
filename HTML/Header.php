<?php
session_start();
$Config = '../Config.php';
if (file_exists($Config)) 
{
	require_once("../Config.php");
	require_once("../Refresh.php");
}
else
{
	?>
	<script language="Javascript">
	document.location.replace("Install/Index.php")
	</script>
	<?php
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Caranille - Accueil</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="../Design/Design.css" />
	</head>

	<body>
		<p>
		<img src="../Design/Images/logo.png" alt="logo">
		</p>

		<nav>
			<?php
			require("../Templates/Left.php");
			?>
		</nav>

		<section>
			<article>
