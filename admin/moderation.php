<?php
include('../includes/reqConnexion.php');
include('reqAdm.php');

$result = moderation($bdd);

$moderation = $result[0];
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
		<header class="title"><h1><a href="moderation.php">~ Moderation ~</a></h1></header>

		<?php
		if($_SESSION['user']['id_status_blogger'] == 1 || $_SESSION['user']['id_status_blogger'] == 2)
		{
			?>
			<div id="bloc_center_large" class="marg">

				<form method="POST" action="searchPost.php" class="searchMember">
					<label>Affichage par page : </label>
					<input type="number" id="affichage" name="affichage" min="0" value="5" />

					<input type="submit" id="paginationMod" name="paginationMod" value="ok"/>
				</form>

				<?php
				if(!empty($moderation))
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
						foreach ($moderation as $elem) 
						{
							?>
							<tr>
								<td><?php echo $elem['login']; ?></td>
								<td><?php echo $elem['title']; ?></td>
								<td><?php echo $elem['created']; ?></td>
								<td><?php echo $elem['nom_status']; ?></td>
								<td><a href="../post.php?<?php echo "id_post=".$elem['id_post']."&amp;moderate=1"; ?>" >Modérer</a></td>
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
					?><p class="marg exclu">Aucun article à modérer</p><?php
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