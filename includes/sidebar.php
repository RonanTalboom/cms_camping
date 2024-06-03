<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="width: 280px;">
	<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-black text-decoration-none">
		<span class="fs-4">LE  CRACK</span>
	</a>
	<hr>
	<ul class="nav nav-pills flex-column mb-auto">

		<?php if (isset($_SESSION["admin_id"])) { ?>
			<li class="nav-item"><a class="nav-link link-dark" href="dashboard.php"><i class="fa fa-desktop"></i>Dashboard</a></li>
			<li class="nav-item"><a class="nav-link link-dark" href="medewerkers.php"><i class="fa fa-desktop"></i>medewerkers</a></li>
			<li class="nav-item"><a class="nav-link link-dark" href="tarieven.php"><i class="fa fa-desktop"></i>Tarieven</a></li>
			<li class="nav-item"><a class="nav-link link-dark" href="klanten.php"><i class="fa fa-desktop"></i>klanten</a></li>
			<li class="nav-item"><a class="nav-link link-dark" href="boekingen.php"><i class="fa fa-desktop"></i>Boekingen</a></li>

		<?php } elseif (isset($_SESSION["id"])) { ?>
			<li><a class="nav-link link-dark" href="dashboard.php"><i class="fa fa-desktop"></i>Dashboard</a></li>
			<li><a class="nav-link link-dark" href="klanten.php"><i class="fa fa-desktop"></i>klanten</a></li>
			<li><a class="nav-link link-dark" href="boekingen.php"><i class="fa fa-desktop"></i>Boekingen</a></li>
			<li><a class="nav-link link-dark" href="plaatsen.php"><i class="fa fa-desktop"></i>Plaatsen</a></li>


		<?php } else { ?>

			<li><a class="nav-link link-dark" href="login.php"><i class="fa fa-users"></i>Login</a></li>
			
		<?php } ?>
	</ul>
	<?php if (
		$_SESSION["id"] ||
		$_SESSION["admin_id"]
	) { ?>
		<hr>
		<div class="dropdown">
			<a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
				<img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
				<strong><?php echo $_SESSION["email"] ?></strong>
			</a>
			<ul class="dropdown-menu text-small shadow">
				<li><a class="dropdown-item" href="#">Settings</a></li>
				<li><a class="dropdown-item" href="#">Profile</a></li>
				<li>
					<hr class="dropdown-divider">
				</li>
				<li><a class="dropdown-item" href="logout.php">Logout</a></li>
			</ul>
		</div>
	<?php } ?>

</nav>