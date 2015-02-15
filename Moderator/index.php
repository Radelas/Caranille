<?php
/*
Cette œuvre est mise à disposition sous licence Attribution - Pas d’Utilisation Commerciale - Partage dans les Mêmes Conditions 3.0 France. Pour voir une copie de cette licence, visitez http://creativecommons.org/licenses/by-nc-sa/3.0/fr/ ou écrivez à Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
*/
session_start();
$Config = '../Config.php';
if (file_exists($Config)) 
{
	require("../Config.php");
	require("../Refresh.php");
}
else
{
	?>
	<script language="Javascript">
	document.location.replace("../installation/index.php")
	</script>
	<?php
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Accueil - Administration</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="../design/design.css" />
	</head>

	<body>
		<p>
		<img src="../design/images/logo.png" alt="logo">
		</p>

		<nav>
			<?php
			require("templates/left.php");
			?>
		</nav>

		<section>
			<article>
				<?php
					/*
					CODE SECTION Modération
					*/
					if ($_GET['choix'] == "moderation")
					{
						require("modules/accueil/index.php");
					}
					if ($_GET['choix'] == "sanction")
					{
						require("modules/gestion_sanctions/index.php");
					}
						if ($_POST['ajouter_sanction'])
						{
							require("modules/gestion_sanctions/index.php");
						}
						if ($_POST['ajouter_fin_sanction'])
						{
							require("modules/gestion_sanctions/index.php");
						}
				?>
			</article>
		</section>

		<p>

		<footer>
			<?php
			require("../templates/footer.php");
			?>
			<br />
			<a href="http://www.caranille.fr">MMORPG crée avec Caranille</a>
		</footer>

		</p>

		<?php
		if($bdd)
		{
			$bdd = NULL;
		}
		?>
	</body>
</html>
