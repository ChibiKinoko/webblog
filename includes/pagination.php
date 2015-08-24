<?php

function pagination($bdd, $sql, $placeholder = NULL)
{
	if(isset($_GET['limit'])) 
	{
		$limit = $_GET['limit'];
	}
	elseif(isset($_POST['affichage'])) 
	{
		$limit = $_POST['affichage'];
	}
	else
	{
		$limit = 10;
	}
	$result = $bdd->prepare($sql);
	if(isset($placeholder))
	{
		$result->execute($placeholder);
	}
	else
	{
		$result->execute();
	}
	$pagination = $result->fetchAll();

	$nbMembre = count($pagination); 

	$nbPages = ceil($nbMembre/$limit);

	if(isset($_GET['page'])) // recupration de la page courante
	{
		$currentPage = $_GET['page'];
	}
	else
	{
		$currentPage = 1; //remet sur page 1 si aucune page definie
	}

	$sql .= ' LIMIT '.(($currentPage - 1)*$limit).", $limit";

	$result = $bdd->prepare($sql);
	if(isset($placeholder))
	{
		$result->execute($placeholder);
	}
	else
	{
		$result->execute();
	}
	//var_dump($sql);
	$pagination = $result->fetchAll();

	$tabReturn =  array($pagination, $nbPages, $currentPage, $limit);

	return $tabReturn;
}

?>