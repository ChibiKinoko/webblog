<?php

$localhost = 'mysql:dbname=chibi_my_webblog;unix_socket=/var/run/mysqld/mysqld.sock';
try
{
	$bdd = new PDO($localhost, 'chibi', 'CujCtoy!');
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}


?>