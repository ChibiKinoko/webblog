<?php
include('includes/reqConnexion.php');
include('includes/reqPost.php');


if(isset($_GET['tags']))
{
	$tags = $_GET['tags'];
}
else
{
	$tags = htmlspecialchars($_POST['tags']);
}

if(str_word_count($tags) > 1)
{
	echo "<script>alert(\"Un seul tag a la fois !\")</script>";

}
else
{
	//echo "<script>alert(\"je suis la !!\")</script>";

	if(isset($_POST['pagination']))
	{
		$limit = $_POST['limit'];

		if(isset($_GET['page'])) // recupration de la page courante
		{
			$currentPage = $_GET['page'];
		}
		else
		{
			$currentPage = 1; //remet sur page 1 si aucune page definie
		}

		$sql = 'SELECT * FROM `posts` WHERE `tags` LIKE "%'.$tags.'%" ORDER BY `created` DESC LIMIT '.(($currentPage - 1)*$limit).", $limit";
		$result = $bdd->prepare($sql);
		$result->execute();
		$pagination = $result->fetchAll();

		$nbPosts = count($pagination); // compte le nombre de posts avec le tag recherche

		//var_dump($nbPosts);

		$postWithTag = array();
		$postWithTag = $pagination;

		//var_dump($sql);
		//var_dump($postWithTag);

		$nbPages = ceil($nbPosts/$limit);

	}
	else
	{
		/*recuperation des commentaires du post*/
		$sql = 'SELECT * FROM `posts` WHERE `tags` LIKE "%'.$tags.'%"';
		$result = $bdd->prepare($sql);
		$result->execute();
		$pagination = $result->fetchAll();

		$nbPosts = count($pagination); // compte le nombre de posts avec le tag recherche

		$limit = 10;

		if(isset($_GET['page'])) // recupration de la page courante
		{
			$currentPage = $_GET['page'];
		}
		else
		{
			$currentPage = 1; //remet sur page 1 si aucune page definie
		}

		$sql .= ' ORDER BY `created` DESC ';

		if(isset($_GET['limit']))
		{
			$limit = $_GET['limit'];
			$sql .= ' LIMIT '.(($currentPage - 1)*$limit).", $limit";
		}
		else
		{
			$sql .= ' LIMIT '.(($currentPage - 1)*$limit).", $limit";
		}

		$result = $bdd->prepare($sql);
		$result->execute();
		$postWithTag = $result->fetchAll();

		//var_dump($sql);

		$nbPages = ceil($nbPosts/$limit);
}
}


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
		<section id="bloc_center" class="marg">
			<section id="pagination">
				<form method="GET" action="searchTag.php">
					<label>Affichage par page : </label>
					<input type="number" id="limit" name="limit" value="5" min="0"/>

					<input type="hidden" id="tags" name="tags" value="<?php echo $tags; ?>"/>

					<input type="submit" name="pagination" id="pagination" value="ok">
				</form>
			</section>
			<?php

			if(empty($postWithTag))
			{
				?>
				<section id="noResult" class="clear">
					<p>Aucun article avec tag correspondant :(</p>
				</section>
				<?php
			}
			else
			{
				foreach ($postWithTag as $unPost) 
				{
					?>
					<section class="result">
						<article class="clear">
							<header><?php echo $unPost['title'];?></header>
							<div class="content">
								<?php echo substr($unPost['content'], 0, 50)."...";?>
								<a href="post.php?id_post=<?php echo $unPost['id_post']; ?>" class="more">Lire la suite &rarr;</a>
							</div>
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
										<?
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
										if($unPost['id_status_blogger'] != 1)
										{
											?>
											<a href="post.php?id_post=<?php echo $unPost['id_post']; ?>" class="bouton">Supprimer</a>
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
			}
			?>
			<section id="arrow">
				<?php
				if($currentPage < $nbPages)
				{
					?>
					<a href='<?php echo "?"; if(isset($limit)) echo "&amp;limit=" .$limit; echo "&amp;page=" . ($currentPage+1); echo "&amp;tags=".$tags; ?>' class="next" title="lien vers la page suivante">Suivant &rarr;</a>
					<?php
				}
				if($currentPage > 1)
				{
					?>
					<a href="<?php echo "?"; if(isset($limit)) echo "&amp;limit=" .$limit; echo "&amp;page=" . ($currentPage-1); echo "&amp;tags=".$tags; ?>" class="previous" title="lien vers la page précédente">&larr; Précédent</a>
					<?php
				}
				?>
			</section>

		</section>

	</div>
</body>
</html>