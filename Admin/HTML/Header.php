<?php
/*
Cette œuvre est mise à disposition sous licence Attribution - Pas d’Utilisation Commerciale - Partage dans les Mêmes Conditions 3.0 France. Pour voir une copie de cette licence, visitez http://creativecommons.org/licenses/by-nc-sa/3.0/fr/ ou écrivez à Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*/
session_start();
$Config = '../../Config.php';
if (file_exists($Config)) 
{
	require_once("../../Config.php");
	require_once("../../Refresh.php");
}
else
{
	?>
	<script language="Javascript">
	document.location.replace("Installation/Index.php")
	</script>
	<?php
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Caranille - Accueil</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="../../Design/Design.css" />
	</head>

	<body>
		<p>
		<img src="../../Design/Images/logo.png" alt="logo">
		</p>

		<nav>
			<?php
			require("../Templates/Left.php");
			?>
		</nav>

		<section>
			<article>
