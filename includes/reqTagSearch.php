<?php
if(isset($_POST['submitTag']))
{
	$tags = htmlspecialchars($_POST['tags']);

	if(str_word_count($tags) > 1)
	{
		echo "<script>alert(\"Un seul tag a la fois !\")</script>";

	}
	else
	{
		/*recuperation des commentaires du post*/
		$sql = 'SELECT * FROM `posts` WHERE `tags` LIKE "%'.$tags.'%"';
		$result = $bdd->prepare($sql);
		$result->execute();
		$pagination = $result->fetchAll();

		$nbPosts = count($pagination); // compte le nombre de posts avec le tag recherche

		echo "nbPost : ".$nbPosts."\n";

		$limit = 2;

		if(isset($_GET['page'])) // recupration de la page courante
		{
			$currentPageTag = $_GET['page'];
		}
		else
		{
			$currentPageTag = 1; //remet sur page 1 si aucune page definie
		}

		$sql .= 'ORDER BY `created` DESC LIMIT '.(($currentPageTag - 1)*$limit).", $limit";

		$result = $bdd->prepare($sql);
		$result->execute();
		$postWithTag = $result->fetchAll();

		var_dump($sql);

		$nbPagesTag = ceil($nbPosts/$limit);

		echo "nbPages : ".$nbPagesTag."\n";
		echo "page courante : ".$currentPageTag."\n";
	}
}

?>