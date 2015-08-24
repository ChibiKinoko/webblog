<?php

include('includes/connectBDD.php');
include('includes/reqPost.php');

addPost($bdd);

?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/styleAddPost.css" />
	<script type="text/javascript" src="js/addPost.js"></script>

	<title>My_Weblog</title>
</head>
<body>
	<div id="main">
		<?php include('includes/nav.php'); ?>

		<header class="title">
			<h1>~ Nouvel article ~</h1>
		</header>
		<form method="POST" action="addPost.php" name="addPost" class="marg" onsubmit="return verifPost()">
			<label for="title">Titre :</label>
			<input type="text" id="title" name="title"/>

			<label for="content">Contenu :</label>
			<textarea id="content" name="content"></textarea>

			<label for="video">Video (YouTube/Dailymotion) :</label>
			<input type="text" id="video" name="video"/>

			<label for="tags">Tags :</label>
			<input type="text" id="tags" name="tags" placeholder="ex : #foot #musique"/>

			<input type="hidden" name="id_user" value="<?php echo $_SESSION['user']['id_user']; ?>">

			<input type="submit" id="submitPost" name="submitPost" value="Poster"/>
		</form>
	</div>

</body>
</html>