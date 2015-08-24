<?php
include('includes/reqConnexion.php'); ?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="css/styleConnexion.css" />
	<script type="text/javascript" src="js/inscription.js"></script>

	<title>My Weblog - Inscription</title>
</head>
<body>
	<?php include('includes/nav.php');

	?>

	<div id="main">
		<section class="marg">
			<h1 class="title">~ Inscrivez-vous ~</h1>

			<form method="POST" action="inscription.php" name="inscription" onsubmit="return verifInscript()">
				<label for="email">Email :</label>
				<input type="text" name="email" id="email" value="<?php echo $email; ?>"/>

				<label for="login">Login : </label>
				<input type="text" name="login" id="login" placeholder="4 caractères minimun" value="<?php echo $login; ?>" />

				<label for="password">Mot de passe :</label>
				<input type="password" name="password" id="password" placeholder="6 caractères minimun" />

				<label for="confirm">Confirmation :</label>
				<input type="password" name="confirm" id="confirm" />

				<input type="submit" name="submitInscrip" id="submitInscrip" value="Inscription"/>
			</form>

		</section>
	</div>

</body>
</html>
