<?php
include('../includes/reqConnexion.php'); 
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="../css/style.css" />
	<link rel="stylesheet" href="../css/styleConnexion.css" />


	<title>My Weblog - Administration</title>
</head>
<body>
	<?php 
		include('../includes/nav.php');
	?>

	<div id="main">
		<section class="marg">
			<h1 class="title">~ Administration ~</h1>

			<form method="POST" action="connexionADM.php" name="connexionADM">
				<label for="login">Login :</label>
				<input type="text" name="login" id="login" />

				<label for="password">Mot de passe :</label>
				<input type="password" name="password" id="password"/>

				<input type="submit" name="submitADM" id="submitADM" value="Valider"/>
			</form>

		</section>
	</div>

</body>
</html>
