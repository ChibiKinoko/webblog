<?php
include('../includes/reqConnexion.php');
include('reqAdm.php');

changeStatutPost($bdd);

$result = searchPost($bdd);

$pagination = $result[0];
$nbPages = $result[1];
$currentPage = $result[2];
$limit = $result[3];


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
		<header class="title"><h1><a href="searchPost.php">~ Recherche Article ~</a></h1></header>

		<?php
		if($_SESSION['user']['id_status_blogger'] == 1 || $_SESSION['user']['id_status_blogger'] == 2)
		{
			?>
			<div id="bloc_center_large" class="marg">

				<form method="POST" action="searchPost.php" class="searchMember">
					<label for="postSearch">Rechercher un article : </label>
					<input type="search" id="postSearch" name="postSearch" placeholder="titre"/>

					<input type="submit" id="searchMember" name="searchMember" value="ok"/>
				</form>
				<form method="POST" action="searchPost.php" class="searchMember">
					<label>Affichage par page : </label>
					<input type="number" id="affichage" name="affichage" min="1" value="<?php echo $limit; ?>" />

					<input type="hidden" id="postSearch" name="postSearch" value="<?php if(isset($_POST['postSearch'])) echo $_POST['postSearch']; ?>"/>

					<input type="submit" id="pagination" name="pagination" value="ok"/>
				</form>

				<?php
				if(!empty($pagination))
				{
					?>
					<table id="tabResultat">
						<tr>
							<th>Login</th>
							<th>Titre</th>
							<th>Date</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>

						<?php
						foreach ($pagination as $elem) 
						{
							?>
							<tr>
								<td><?php echo $elem['login']; ?></td>
								<td><?php echo $elem['title']; ?></td>
								<td><?php echo $elem['created']; ?></td>
								<td><?php echo $elem['nom_status']; ?></td>
								<td>
									
									<?
									if($elem['nom_status'] == "inactif")
									{
										?>
										<a href="../post.php?id_post=<?php echo $elem['id_post']; ?>">Lire</a>
										<a href="<?php echo "?"."&amp;id_post=".$elem['id_post']."&amp;restore=1"; ?>" > | Restaurer</a>
										<?php

									}
									elseif($elem['nom_status'] == "actif")
									{
										if($elem['id_user'] != 1 || ($elem['id_user']) == 1 && $_SESSION['user']['id_status_blogger'] == 1)
										{
											?>
											<a href="../post.php?id_post=<?php echo $elem['id_post']; ?>">Lire</a>
											<a href="<?php echo "?"."&amp;id_post=".$elem['id_post']."&amp;delete=1"; ?>" > | Supprimer</a>
											<?php
										}
									}
									else
									{
										?>
										<a href="../post.php?<?php echo "id_post=".$elem['id_post']."&amp;moderate=1"; ?>" >Modérer</a>
										<?php
									}
									?>
								</td>
							</tr>
							<?php
						}
						?>
					</table>

					<div class="marg">
						<?php 
						if($currentPage < $nbPages)
						{
							?>
							<a href='<?php echo "?"; if(isset($limit)) echo "&amp;limit=" .$limit; echo "&amp;page=" . ($currentPage+1); ?>' class="next" title="lien vers la page suivante">Suivant &rarr;</a>
							<?php
						}
						if($currentPage > 1)
						{
							?>
							<a href="<?php echo "?"; if(isset($limit)) echo "&amp;limit=" .$limit; echo "&amp;page=" . ($currentPage-1); ?>" class="previous" title="lien vers la page précédente">&larr; Précédent</a>
							<?php
						}
						?>
					</div>
					<?php
				}
				else
				{
					?><p class="marg exclu">Aucun article correspondant</p><?php
				}
				?>
			</div>
			<?php
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