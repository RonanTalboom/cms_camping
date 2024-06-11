<button id="hamburger" class="lg:hidden p-2 base-500 text-black rounded hover:base-600 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50" style="position: fixed; top: 0; left: 0;">
	<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
		<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
	</svg>
</button>
<nav id="sidebar" class="w-64 bg-base-200 p-4 flex flex-col lg:block hidden lg:flex" style="max-height: 100vh;">
	<img src="assets/La_Rustique-removebg-preview.png" alt="Menu Icon">
	<ul class="menu flex-grow">
		<li class="menu-title">
			<span>Menu</span>
		</li>

		<?php if (isset($_SESSION["admin_id"])) { ?>
			<li><a href="dashboard.php">Dashboard</a></li>
			<li><a href="boekingen.php">Boekingen</a></li>
			<li><a href="medewerkers.php">Medewerkers</a></li>
			<li><a href="klanten.php">Klanten</a></li>
			<li><a href="plaatsen.php">Plaatsen</a></li>
			<li><a href="tarieven.php">Tarieven</a></li>

		<?php } elseif (isset($_SESSION["id"])) { ?>
			<li><a href="boekingen.php">Boekingen</a></li>
			<li><a href="klanten.php">Klanten</a></li>
			<li><a href="plaatsen.php">Plaatsen</a></li>

		<?php } else { ?>
			<li><a href="login.php">Login</a></li>
		<?php }  ?>
	</ul>
	<?php if (
		$_SESSION["id"] ||
		$_SESSION["admin_id"]
	) { ?>
		<a href="#" class="flex items-center overflow-hidden">
			<img src="https://github.com/Nichaela.png" alt="" width="32" height="32" class="rounded-full me-2">
			<div class="flex flex-col">
				<strong class="text-black no-underline"><?php echo $_SESSION["email"] ?></strong>
				<?php if (isset($_SESSION["admin_id"])) { ?>
					Admin
				<?php } ?>
			</div>
		</a>
		<hr>
		<ul class="menu mt-auto">
			<li><a href="logout.php">Logout</a></li>
		</ul>
	<?php } ?>

</nav>
<script>
	document.getElementById('hamburger').addEventListener('click', function() {
		var sidebar = document.getElementById('sidebar');
		sidebar.classList.toggle('hidden');
	});
</script>