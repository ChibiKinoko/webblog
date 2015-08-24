<?php
include('includes/connectBDD.php');
include('includes/reqPost.php');

changeStatutPost($bdd);

//affichqge des 3 derniers posts
$sql = $bdd->query('SELECT * FROM `posts` WHERE `id_status_post` = 1 AND `id_status_blogger` != 4 ORDER BY `created` DESC LIMIT 3');
$lastPost = $sql->fetchAll();

?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="css/style.css" />
	<script type="text/javascript" src="js/tagSearch.js"></script>

	<title>My_Weblog</title>
</head>
<body>
	<div id="main">
		<?php include('includes/nav.php'); ?>

		<header class="title">
			<h1><a href="index.php" title="lien vers l'accueil">~ My Weblog ~</a></h1>
			<div class="marg">
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
			</div>
			<div class="clear"></div>
		</header>
		<div id="bloc_center" class="marg">
			<?php
			if(empty($lastPost))
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
				foreach ($lastPost as $elem) 
				{
					?>
					<section class="result">
						<article class="clear">
							<h2><?php echo $elem['title'];?></h2>
							<div class="content">
								<?php echo substr($elem['content'], 0, 50)."...";?>
								<a href="post.php?id_post=<?php echo $elem['id_post']; ?>" class="more">Lire la suite &rarr;</a>
							</div>
							<?php
							if(!empty($elem['video']))
							{
								?>
								<div class="video">
									<iframe width="480" height="270" frameborder="2"  src="<?php echo $elem['video']; ?>" allowfullscreen></iframe>
								</div>
								<?php
							}
							?>
							<aside class="tagsPost">
								<?php
								if(!empty($elem['tags']))
								{
									?><p>Tags : </p><?php
									$tabTags = str_word_count($elem['tags'], 1);
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
								<p>By : <?php echo $elem['login']; ?></p>
								<p>Le : <?php echo $elem['created']; ?></p>
								<?php
								if($elem['created'] != $elem['updated'])
								{
									?>
									<p>Edit le : <?php echo $elem['updated']; ?></p>
									<?php
								}
								?>
								<div class="clear"></div>
								<a href="post.php?id_post=<?php echo $elem['id_post'];?>#commentaire" class="bouton">Commenter</a>

								<?php
								if(isset($_SESSION['user']))
								{
									if($elem['login'] == $_SESSION['user']['login'] || $_SESSION['user']['id_status_blogger'] == 1 || $_SESSION['user']['id_status_blogger'] == 2)
									{
										?>
										<a href="editPost.php?id_post=<?php echo $elem['id_post']; ?>" class="bouton">Editer</a>
										<?php
											//var_dump($elem['id_status_blogger']);
										if($elem['id_status_blogger'] != 1 || ($elem['id_status_blogger'] == 1 && $_SESSION['user']['id_status_blogger'] == 1))
										{
											?>											
											<a href="post.php?<?php echo "&amp;id_post=".$elem['id_post']."&amp;delete=1"; ?>" class="bouton">Supprimer</a>
											<?php
										}
									}
								}
								?>
								<div class="clear"></div>
								<a href="post.php?id_post=<?php echo $elem['id_post'];?>#pagination">&rarr; voir les commentaires</a>
							</footer>
						</article>
					</section>
					<?php
				}
			}

			?>
		</div>

		<?php include('includes/footer.php'); ?>
	</div>

</body>
</html>