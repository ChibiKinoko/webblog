<?php
include('connectBDD.php');


?>
<aside id="footer">
	<div class="marg">
		<section id="contact">
			<header>Nous contacter</header>

			<form method="POST" action="index.php">
				<input type="text" name="email" placeholder="Email" />

				<textarea placeholder="Message..."></textarea>

				<input type="submit" name="msgContact" value="Envoyer"/>

			</form>
		</section>

		<section id="about">
			<header>Qui sommes nous ?</header>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</p>
		</section>
	</div>

	<div class="clear"></div>

</aside id="footer">

