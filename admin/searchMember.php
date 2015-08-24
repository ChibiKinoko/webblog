<?php
include('../includes/reqConnexion.php');
include('reqAdm.php');

$result = searchBlogger($bdd);

$paginationMembre = $result[0];
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
		<header class="title"><h1><a href="searchMember.php">~ Recherche Blogger ~</a></h1></header>

		<?php
		if($_SESSION['user']['id_status_blogger'] == 1 || $_SESSION['user']['id_status_blogger'] == 2)
		{
			?>
			<div id="bloc_center_large" class="marg">

				<form method="POST" action="searchMember.php" class="searchMember">
					<label for="loginSearch">Rechercher un membre : </label>
					<input type="search" id="loginSearch" name="loginSearch" placeholder="login"/>

					<input type="submit" id="searchMember" name="searchMember" value="ok"/>
				</form>
				<form method="POST" action="searchMember.php" class="searchMember">
					<label>Affichage par page : </label>
					<input type="number" id="affichage" name="affichage" min="1" value="<?php echo $limit; ?>" />

					<input type="hidden" id="loginSearch" name="loginSearch" value="<?php if(isset($_POST['loginSearch'])) echo $_POST['loginSearch']; ?>"/>

					<input type="submit" id="paginationMembre" name="paginationMembre" value="ok"/>
				</form>

				<?php
				if(!empty($paginationMembre))
				{
					?>
					<table id="tabResultat">
						<tr>
							<th>Login</th>
							<th>Email</th>
							<th>Status</th>
							<th>Infos</th>
						</tr>

						<?php
						foreach ($paginationMembre as $elem) 
						{
							?>
							<tr>
								<td><?php echo $elem['login']; ?></td>
								<td><?php echo $elem['email']; ?></td>
								<td><?php echo $elem['nom_status']; ?></td>
								<td><a href="">Fiche</a></td>
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
					
					?><p class="marg exclu">Aucun membre correspondant :(</p><?php
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