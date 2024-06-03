<nav class="ts-sidebar">
			<ul class="ts-sidebar-menu">

				<li class="ts-label">Main</li>
					<?php if (isset($_SESSION["admin_id"])) { ?>
					<li><a href="dashboard.php"><i class="fa fa-desktop"></i>Dashboard</a></li>
					<li><a href="medewerkers.php"><i class="fa fa-desktop"></i>medewerkers</a></li>

				<?php } elseif (isset($_SESSION["id"])) { ?>
					<li><a href="dashboard.php"><i class="fa fa-desktop"></i>Dashboard</a></li>


<?php } else { ?>

				<li><a href="registration.php"><i class="fa fa-files-o"></i> User Registration</a></li>
				<li><a href="index.php"><i class="fa fa-users"></i> User Login</a></li>
				<li><a href="admin/login.php"><i class="fa fa-user"></i> Admin Login</a></li>
				<?php } ?>

			</ul>
		</nav>
