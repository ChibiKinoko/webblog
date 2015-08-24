<?php
include('includes/reqConnexion.php');
include('includes/reqPost.php');

$result = recupPost($bdd);

$posts = $result[0];
$nbPages = $result[1];
$currentPage = $result[2];
$limit = $result[3];

?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="css/style.css" />
	<script type="text/javascript" src="js/addPost.js"></script>
	<script type="text/javascript" src="js/tagSearch.js"></script>

	<title>My_Weblog</title>
</head>

<body>
	<div id="main">
		<?php include('includes/nav.php'); ?>

		<header class="title">
			<h1>~ Articles ~</h1>
			<section class="marg">
				<?php
				if(isset($_SESSION['user']))
				{
					?>
					<a href="addPost.php" class="addPost">&rarr; Ecrire un nouvel article</a>
					<?php
				}
				?>
				<!-- Recherche par Tag -->
				<form method="POST" action="searchTag.php" id="tagSearch" name="tagSearch" onsubmit="return tagSearch();"> 
					<input type="search" name="tags" id="tags" placeholder="Entrez un tag : #musique ..." />
					<input type="submit" name="submitTag" value="Rechercher" />
				</form>
			</section>
			<div class="clear"></div>
		</header>
		<div id="bloc_center" class="marg">
			<div class="pagination">
				<form method="POST" action="allPosts.php">
					<label>Affichage par page : </label>
					<input type="number" id="affichage" name="affichage" min="1" value="<?php echo $limit; ?>" />

					<input type="submit" name="pagination" id="pagination" value="ok">
				</form>
			</div>
			<?php
			
			if(empty($posts))
			{
				?>
				<div id="noResult" class="clear">
					<p>Aucun article récent :(</p>
					<a href="<?php if(isset($_SESSION['user'])) echo "addPost.php"; else echo "connection.php";?>">Rédigez un post</a>
				</div>
				<?php
			}
			else
			{
				foreach ($posts as $unPost) 
				{
					?>
					<section class="result">
						<article class="clear">
							<h2><?php echo $unPost['title'];?></h2>
							<div class="content">
								<?php echo substr($unPost['content'], 0, 50)."...";?>
								<a href="post.php?id_post=<?php echo $unPost['id_post']; ?>" class="more">Lire la suite &rarr;</a>
							</div>
							<?php
							if(!empty($unPost['video']))
							{
								?>
								<div class="video">
									<iframe width="480" height="270" frameborder="2"  src="<?php echo $unPost['video']; ?>" allowfullscreen></iframe>
								</div>
								<?php
							}
							?>
							<aside class="tagsPost">
								<?php
								if(!empty($unPost['tags']))
								{
									?><p>Tags : </p><?php
									$tabTags = str_word_count($unPost['tags'], 1);
									foreach ($tabTags as $unTag) 
									{
										?>
										<span>#<?php echo $unTag; ?></span>
										<?php
									}
								}
								?>
							</aside>
							<footer class="footerBlog">
								<p>By : <?php echo $unPost['login']; ?></p>
								<p>Le : <?php echo $unPost['created']; ?></p>
								<?php
								if($unPost['created'] != $unPost['updated'])
								{
									?>
									<p>Edit le : <?php echo $unPost['updated']; ?></p>
									<?php
								}
								?>
								<div class="clear"></div>
								<a href="post?id_post=<?php echo $unPost['id_post'];?>#commentaire" class="bouton">Commenter</a>
								<?php
								if(isset($_SESSION['user']))
								{
									if($unPost['login'] == $_SESSION['user']['login'] || $_SESSION['user']['id_status_blogger'] == 2 || $_SESSION['user']['id_status_blogger'] == 1)
									{
										?>
										<a href="editPost.php?id_post=<?php echo $unPost['id_post']; ?>" class="bouton">Editer</a>
										<?php
										if($unPost['id_status_blogger'] != 1 || ($unPost['id_status_blogger'] == 1 && $_SESSION['user']['id_status_blogger'] == 1))
										{
											?>
											<a href="post.php?id_post=<?php echo $unPost['id_post']."&amp;delete=1"; ?>" class="bouton">Supprimer</a>
											<?php
										}
									}
								}
								?>
								<div class="clear"></div>
								<a href="post?id_post=<?php echo $unPost['id_post'];?>#pagination">&rarr; voir les commentaires</a>
							</footer>
						</article>
					</section>
					<?php
				}
				?>
				<div id="arrow">
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
			?>

		</div>

	</div>
</body>
</html>