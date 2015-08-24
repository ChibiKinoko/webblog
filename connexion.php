<?php
include('includes/reqConnexion.php'); 
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/styleConnexion.css" />


	<title>My Weblog - Connexion</title>
</head>
<body>
	<?php 
		include('includes/nav.php');
	?>

	<div id="main">
		<section class="marg">
			<h1 class="title">~ Connectez-vous ~</h1>

			<form id="connexionForm" method="POST" action="connexion.php" name="connexion">
				<label for="login">Login :</label>
				<input type="text" name="login" id="login" />

				<label for="password">Mot de passe :</label>
				<input type="password" name="password" id="password"/>

				<input type="submit" name="submitCo" id="submitCo" value="Connexion"/>
				<a href="inscription.php">Pas encore inscrit ?</a>
			</form>

		</section>
	</div>
	<script type="text/javascript" src="js/connexion.js"></script>

</body>
</html>
