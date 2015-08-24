<?php

include('includes/reqPost.php');

editPost($bdd);

$id_post = $_GET['id_post'];

$sql = "SELECT * FROM `posts` WHERE `id_post` = ?";
$result = $bdd->prepare($sql);
$result->execute(array($id_post));
$editInfos = $result->fetch();

//var_dump($id_post);
//var_dump($editInfos);

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
			<h1>~ Edition ~</h1>
		</header>
		<form method="POST" action="editPost.php?id_post=<?php echo $editInfos['id_post'];?>" name="addPost" class="marg" onsubmit="return verifPost()">
			<label for="title">Titre :</label>
			<input type="text" id="title" name="title" value="<?php echo $editInfos['title']; ?>"/>

			<label for="content">Contenu :</label>
			<textarea id="content" name="content" ><?php echo $editInfos['content']; ?></textarea>

			<label for="video">Video (YouTube/Dailymotion) :</label>
			<input type="text" id="video" name="video" value="<?php echo $editInfos['video']; ?>"/>

			<label for="tags">Tags :</label>
			<input type="text" id="tags" name="tags" placeholder="ex : #foot #musique" value="<?php echo $editInfos['tags']; ?>"/>

			<input type="hidden" name="id_post" value="<?php echo $editInfos['id_post']; ?>">

			<input type="submit" id="submitEdit" name="submitEdit" value="Editer"/>
		</form>
	</div>

</body>
</html>