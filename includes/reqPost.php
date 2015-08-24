<?php
include('reqConnexion.php');
include('reqVid.php');
include('includes/pagination.php');

/*Recuperation de tous les posts pour la page Allposts*/
function recupPost($bdd)
{
	/*recuperation des post*/
	$sql = 'SELECT * FROM `posts` WHERE `id_status_post` = 1 AND `id_status_blogger` != 4 ORDER BY `created` DESC';

	$result = pagination($bdd, $sql);
	return $result;
}


/*Page Post*/
function changeStatutPost($bdd)
{
	if(isset($_GET['id_post']))
	{
		$id_post = $_GET['id_post'];
	}
	/*SUPPRESSION / RESTAURATION ARTICLE*/
	if(isset($_GET['delete']))
	{	
		$id_post = $_GET['id_post'];
		$sql = "UPDATE `posts` SET `id_status_post` = '3' WHERE `id_post` = ?";
		$update = $bdd->prepare($sql);
		$update->execute(array($id_post));

		header('Location: index.php');
	}
	if(isset($_GET['moderate']))
	{	
		if($_GET['moderate'] == 2)
		{
			$id_post = $_GET['id_post'];
			$sql = "UPDATE `posts` SET `id_status_post` = '1' WHERE `id_post` = ?";
			$update = $bdd->prepare($sql);
			$update->execute(array($id_post));

			header('Location: admin/moderation.php');
		}
	}
}
function post($bdd)
{
	if(isset($_GET['id_post']))
	{
		$id_post = $_GET['id_post'];
	}
	elseif (isset($_POST['id_post'])) 
	{
		$id_post = $_POST['id_post'];
	}
	$placeholder = array($id_post);

	/*recuperation donnees post*/
	$sql = 'SELECT * FROM `posts` WHERE `id_post` = ?';
	$result = $bdd->prepare($sql);
	$result->execute($placeholder);
	$infoPost = $result->fetch();

	/*recuperation des commentaires du post*/
	$sqlCom = 'SELECT * FROM `coms` WHERE `id_post` =  ? ORDER BY `date` DESC';
	
	$result = pagination($bdd, $sqlCom, $placeholder);
	return array($infoPost, $result, $id_post);
}

/*Ajout d'un post*/
function addPost($bdd)
{
	if(isset($_POST['submitPost']))
	{
		$id_user = $_POST['id_user'];
		$title = htmlspecialchars($_POST['title']);
		$content = htmlspecialchars($_POST['content']);
		$video = htmlspecialchars($_POST['video']);
		$tags = htmlspecialchars($_POST['tags']);

		if(!empty($video))
		{
        //echo "<script>alert(\"je suis la !!!!\")</script>";
			$video = checkVid($video);
		}

		$login = $_SESSION['user']['login'];
		$id_status_blogger = $_SESSION['user']['id_status_blogger'];

		if(!empty($title) && !empty($content))
		{
			$sql = "INSERT INTO `posts` (`id_user`, `login`, `created`, `title`, `content`, `video`, `tags`, `id_status_post`, `id_status_blogger`) VALUES ('$id_user', '$login', NOW(), '$title', '$content', '$video', '$tags', '2', '$id_status_blogger')";
			$bdd->query($sql);
		}

		header('Location: index.php');
	}
}

/*Ajout d'un commentaire*/
function addCom($bdd)
{
	if(isset($_POST['submitCom']))
	{	
		if(empty($_POST['id_user']))
		{
			$login = $_POST['login']." (visiteur)";
		}
		else
		{
			$login = $_POST['login'];
		}

		$id_post = $_POST['id_post'];
		$id_user = $_POST['id_user'];
		$content = htmlspecialchars($_POST['content']);

		$sql = "INSERT INTO `coms` (`id_post`, `id_user`, `login`, `content`, `date`) VALUES ('$id_post', '$id_user', '$login', '$content', NOW())";
		$bdd->query($sql);

		header('Location: post.php?id_post='.$id_post.'#pagination');
	}
}

/*Edition d'un post*/
function editPost($bdd)
{
	if(isset($_POST['submitEdit']))
	{
		$id_post = $_GET['id_post'];
		//$id_user = $_POST['id_user'];
		$title = htmlspecialchars($_POST['title']);
		$content = htmlspecialchars($_POST['content']);
		$video = htmlspecialchars($_POST['video']);
		$tags = htmlspecialchars($_POST['tags']);

		if(!empty($video))
		{
        //echo "<script>alert(\"je suis la !!!!\")</script>";
			$video = checkVid($video);
		}
		
		$placeholder = array($title, $content, $video, $tags, $id_post);
		print_r($placeholder);

		if(!empty($title) && !empty($content))
		{
			$sql = "UPDATE `posts` SET `title` = ?, `content` = ?, `video` = ?, `tags` = '?' WHERE `id_post` = ?";
			$update = $bdd->prepare($sql);
			$update->execute($placeholder);

			var_dump($sql);

			//header('Location: post.php?id_post='.$id_post);

		}
	//echo "<script>alert(\"connexion reussie!\")</script>";
	//header('Location: index.php');

	}
}


?>