<?php

include('includes/reqConnexion.php');

var_dump($_SESSION['user']);

if(!empty($_SESSION['user']))
{
	session_destroy();
	//echo "<script>alert(\"reussi !!!\")</script>";
	header('Location: index.php');
}
else
{
	echo "<script>alert(\"Erreur de deconnexion !!!\")</script>";
	header('Location: index.php');
}

?>