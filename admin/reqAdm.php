<?php
include('../includes/connectBDD.php');
include('../includes/pagination.php');

if(isset($_SESSION['user']))
{
	if($_SESSION['user']['id_status_blogger'] == 1 || $_SESSION['user']['id_status_blogger'] == 2)
	{
		/*nombre total de membres*/
		$sql = 'SELECT `id_user` FROM `blogger` WHERE `id_status` != 4';
		$result = $bdd->query($sql);
		$nbMembre = $result->fetchAll();
		$nbMembre = count($nbMembre);

		/*nombre total d'articles*/
		$sql = 'SELECT `id_post` FROM `posts` WHERE `id_status_blogger` != 4 AND `id_status_post` = 1';
		$result = $bdd->query($sql);
		$nbArticle = $result->fetchAll();
		$nbArticle = count($nbArticle);

		/*nombre d'articles a moderer*/
		$sql = 'SELECT `id_post` FROM `posts` WHERE `id_status_post` = 2';
		$result = $bdd->query($sql);
		$nbModeration = $result->fetchAll();
		$nbModeration = count($nbModeration);

	}
}

/*Affichage recherche blogger*/
function searchBlogger($bdd)
{
	//echo "<script>alert(\"je suis la !!!!\")</script>";
	if(isset($_POST['loginSearch']))
	{
		$loginSearch = $_POST['loginSearch'];
	}
	else
	{
		$loginSearch = "";
	}

	$sql = 'SELECT `login`, `email`, `nom_status` FROM `blogger` 
	LEFT JOIN `status_blogger` ON `blogger`.`id_status` = `status_blogger`.`id_status_blogger` 
	WHERE `login` LIKE "%'.$loginSearch.'%" ORDER BY `login`';

	$result = pagination($bdd, $sql);
	return $result;
}

/*Affichage recherche posts*/

function searchPost($bdd)
{
	//echo "<script>alert(\"je suis la !!!!\")</script>";
	if(isset($_POST['postSearch']))
	{
		$postSearch = $_POST['postSearch'];
	}
	else
	{
		$postSearch = "";
	}

	$sql = 'SELECT `id_post`, `id_user`, `login`, `title`, `created`, `nom_status` FROM `posts` 
	LEFT JOIN `status_post` ON `posts`.`id_status_post` = `status_post`.`id_status_post` 
	WHERE `title` LIKE "%'.$postSearch.'%" ORDER BY `title`, `created` DESC';

	$result = pagination($bdd, $sql);
	return $result;

}

/*SUPPRESSION / RESTAURATION ARTICLE*/
function changeStatutPost($bdd)
{
	if(isset($_GET['delete']))
	{	
		$id_post = $_GET['id_post'];
		$sql = "UPDATE `posts` SET `id_status_post` = '3' WHERE `id_post` = '".$id_post."'";
		$bdd->query($sql);

		header('Location: searchPost.php');
	}
	if(isset($_GET['restore']))
	{
		$id_post = $_GET['id_post'];
		$sql = "UPDATE `posts` SET `id_status_post` = '1' WHERE `id_post` = '".$id_post."'";
		$bdd->query($sql);

		header('Location: searchPost.php');
	}
}


/*PAGE MODERATION*/
function moderation($bdd)
{
	$sql = "SELECT `id_post`, `id_user`, `login`, `title`, `created`, `nom_status` FROM `posts` 
	LEFT JOIN `status_post` ON `posts`.`id_status_post` = `status_post`.`id_status_post` 
	WHERE `posts`.`id_status_post`= 2 ORDER BY `created` DESC";

	$result = pagination($bdd, $sql);
	return $result;
}


?>