<nav>
	<div class="marg">
		<ul>
			<li><a href="../index.php" title="lien vers l'accueil">Home</a></li>
			<li><a href="../allPosts.php" title="lien vers tous les posts" class="nav">Posts </a></li>

			<?php
			if(isset($_SESSION['user']) && !empty($_SESSION['user']))
			{
				//var_dump($_SESSION['user']);
				?>
				<li><a href="../profil.php?id_membre=<?php echo $_SESSION['user']['id_user'];?>" title="lien vers ma page profil" class="nav">Profil</a></li>
				
				<?php
				if($_SESSION['user']['id_status_blogger'] == 1 || $_SESSION['user']['id_status_blogger'] == 2)
				{
					?>
					<li><a href="../admin/index.php" title="lien vers le panel administration" class="nav adm">Administration</a></li>
					<?php
				}
				?>
				
				<li><a href="../deco.php" title="lien pour se deconnecter" class="nav">Deconnexion (<?php echo $_SESSION['user']['login']; ?>)</a></li>
				<?php
			}
			?>
		</ul>
	</div>
</nav>