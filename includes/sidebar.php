<nav class="ts-sidebar">
			<ul class="ts-sidebar-menu">

				<li class="ts-label">Main</li>
					<?php if (isset($_SESSION["admin_id"])) { ?>
					<li><a href="dashboard.php"><i class="fa fa-desktop"></i>Dashboard</a></li>
					<li><a href="medewerkers.php"><i class="fa fa-desktop"></i>medewerkers</a></li>
					<li><a href="../klanten.php"><i class="fa fa-desktop"></i>klanten</a></li>

				<?php } elseif (isset($_SESSION["id"])) { ?>
					<li><a href="dashboard.php"><i class="fa fa-desktop"></i>Dashboard</a></li>
					<li><a href="klanten.php"><i class="fa fa-desktop"></i>klanten</a></li>


<?php } else { ?>

				<li><a href="registration.php"><i class="fa fa-files-o"></i> User Registration</a></li>
				<li><a href="login.php"><i class="fa fa-users"></i> User Login</a></li>
				<li><a href="admin"><i class="fa fa-user"></i> Admin Login</a></li>
				<?php } ?>

			</ul>
		</nav>
