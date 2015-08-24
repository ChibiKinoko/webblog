<?php
include('includes/reqConnexion.php');
include('includes/reqPost.php');

changeStatutPost($bdd); //pour suppression et moderation

addCom($bdd);

$post = post($bdd);

$infoPost = $post[0]; //recuperation info post

$commentaire = $post[1][0]; // recuperation commentaire du post

$nbPages = $post[1][1];
$currentPage = $post[1][2];
$limit = $post[1][3];

$id_post = $post[2];


?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/styleAddCom.css" />
	<script type="text/javascript" src="js/addPost.js"></script>

	<title>My_Weblog</title>
</head>
<body>
	<div id="main">
		<?php include('includes/nav.php'); ?>

		<header class="title">
			<h1>~ My Weblog ~</h1>
		</header>

		<div id="bloc_center" class="marg">
			<div class="result">

				<article class="clear">

					<h2><?php echo $infoPost['title'];?></h2>
					<div class="content"><?php echo $infoPost['content'];?></div>

					<?php
					if(!empty($infoPost['video']))
					{
						?>
						<div class="video">
							<iframe width="480" height="270" frameborder="2"  src="<?php echo $infoPost['video']; ?>" allowfullscreen></iframe>
						</div>
						<?php
					}
					?>

					<aside class="tagsPost">
						<?php
						if(!empty($infoPost['tags']))
						{
							?><p>Tags : </p><?php
							$tabTags = str_word_count($infoPost['tags'], 1);
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
						<p>By : <?php echo $infoPost['login']; ?></p>
						<p>Le : <?php echo $infoPost['created']; ?></p>
						<?php
						if($infoPost['created'] != $infoPost['updated'])
						{
							?>
							<p>Edit le : <?php echo $infoPost['updated']; ?></p>
							<?php
						}
						?>
						<div class="clear"></div>

						<?php
						if(isset($_SESSION['user']))
						{
							if($infoPost['login'] == $_SESSION['user']['login'] || $_SESSION['user']['id_status'] == 2 || $_SESSION['user']['id_status'] == 1)
							{
								?>
								<a href="editPost.php?id_post=<?php echo $infoPost['id_post']; ?>"><button>Editer</button></a>
								<?php
								if(isset($_GET['moderate']))
								{
									?>
									<a href="<?php echo "?id_post=".$infoPost['id_post']."&amp;moderate=2"; ?>"><button id="publier">Publier</button></a>
									<?php
								}
								?>
								<a href="post.php?id_post=<?php echo $infoPost['id_post']."&amp;delete=1"; ?>" ><button>Supprimer</button></a>
								<?php
							}
						}
						?>
					</footer>
				</article>
			</div>
			<div class="pagination">
				<form method="POST" action="post.php">
					<label>Affichage par page : </label>
					<input type="number" id="affichage" name="affichage" min="1" value="<?php echo $limit; ?>" />

					<input type="hidden" id="id_post" name="id_post" value="<?php echo $id_post; ?>"/>
					<input type="submit" name="pagination" id="pagination" value="ok">
				</form>
				<?php
				foreach ($commentaire as $unCom)
				{
					?>
					<div class="unCom">
						<h3><?php echo $unCom['login']; ?><span> <?php echo $unCom['date'];?> </span></h3>
						<div class="comContent"><?php echo $unCom['content']; ?></div>
					</div>
					<?php
				}
				?>
			</div>
			<div id="arrow">
				<?php
				if($currentPage < $nbPages)
				{
					?>
					<a href='<?php echo "?id_post=".$id_post; if(isset($limit)) echo "&amp;limit=" .$limit; echo "&amp;page=" . ($currentPage+1); ?>' class="next" title="lien vers la page suivante">Suivant &rarr;</a>
					<?php
				}
				if($currentPage > 1)
				{
					?>
					<a href="<?php echo "?id_post=".$id_post; if(isset($limit)) echo "&amp;limit=" .$limit; echo "&amp;page=" . ($currentPage-1); ?>" class="previous" title="lien vers la page précédente">&larr; Précédent</a>
					<?php
				}
				?>
			</div>
			<div class="clear"></div>
			<section id="postCom">

				<h2 id="commentaire">Commentez :</h2>

				<form method="POST" action="post.php?id_post=<?php echo $id_post; ?>" name="commentaire" onSubmit="return verifCom()">
					<label>Pseudo :</label>
					<input type="text" id="login" name="login" placeholder="<?php if(isset($_SESSION['user'])) echo $_SESSION['user']['login']; ?>" value="<?php if(isset($_SESSION['user'])) echo $_SESSION['user']['login']; ?>"/>

					<textarea id="content" name="content" placeholder="votre commentaire"></textarea>

					<input type="hidden" id="id_user" name="id_user" value="<?php if(isset($_SESSION['user'])) echo $_SESSION['user']['id_user']; ?>"/>

					<input type="hidden" id="id_post" name="id_post" value="<?php echo $id_post; ?>"/>

					<input type="submit" id="submitCom" name="submitCom" value="Envoyer" />
				</form>
			</div>
		</div>
	</div>

</body>
</html>