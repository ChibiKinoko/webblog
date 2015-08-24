<?php
include('../includes/reqConnexion.php');
include('reqAdm.php');

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="../css/style.css" />

	<title>My Weblog - Administration</title>
</head>
<body>
	<?php 
	include('../includes/navADM.php');
	?>

	<div id="main">
		<header class="title"><h1>~ Administration ~</h1></header>

		<?php
		if(isset($_SESSION['user']))
		{
			if($_SESSION['user']['id_status_blogger'] == 1 || $_SESSION['user']['id_status_blogger'] == 2)
			{
				?>
				<div id="bloc_center_large">
					<section class="admSection">
						<header>Gérer les blogger</header>
						<p>Nombre total de membre : <?php echo $nbMembre; ?></p>

						<form method="POST" action="searchMember.php">
							<label for="loginSearch">Rechercher un membre : </label>
							<input type="search" id="loginSearch" name="loginSearch" placeholder="login"/>

							<input type="submit" id="searchMember" name="searchMember" value="ok"/>
						</form>
					</section>

					<section class="admSection">
						<header>Gérer les articles</header>
						<p>Nombre total d'articles : <?php echo $nbArticle; ?></p>

						<form method="POST" action="searchPost.php">
							<label for="postSearch">Rechercher un article : </label>
							<input type="search" id="postSearch" name="postSearch" placeholder="titre"/>

							<input type="submit" id="searchPost" name="searchPost" value="ok"/>
						</form>
					</section>

					<section class="admSection">
						<header>Derniers Articles</header>
						<p>Nombre d'articles à modérer : <?php echo $nbModeration; ?></p>
						<?php
						if($nbModeration > 0)
						{
							?>
							<a href="moderation.php">Voir &rarr;</a>
							<?php
						}
						?>
					</section>
				</div>
				<?php
			}
			else
			{
				?>
				<p class="marg exclu">Tu n'as strictement rien à faire ici.</p>
				<?php
			}
		}
		else
		{
			?>
			<p class="marg exclu">Tu n'as strictement rien à faire ici.</p>
			<?php
		}
		?>

	</div>


</body>
</html>