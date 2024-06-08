<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_admin_login();
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<title>CAMPING</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/signin.css">
	<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
	<script src="https://cdn.tailwindcss.com"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
</head>

<body>
	<div class="flex min-h-screen">
		<?php include "includes/sidebar.php"; ?>
		<main class="flex-1 p-6">
			<div class="container mx-auto">
				<div class="flex justify-between items-center">
					<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="search" type="text" placeholder="Search">
					<a href="register-tarief.php" class="btn btn-primary">Voeg Tarief Toe</a>
				</div>
				<h2 class="text-2xl font-bold">Tarieven</h2>

				<table class="table w-full mt-4">
					<thead>
						<tr>
							<th>#</th>
							<th>Beschrijving</th>
							<th>Kosten in €</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$ret = "SELECT * FROM tarieven";
						$stmt = $conn->prepare($ret);
						$stmt->execute(); //ok
						$res = $stmt->get_result();
						while ($row = $res->fetch_object()) { ?>
							<td><?php echo $row->id; ?></td>
							<td><?php echo $row->beschrijving; ?></td>
							<td>€ <?php echo $row->kosten; ?> .-</td>

							<td>
								<a href="edit-tarief.php?id=<?php echo $row->id; ?>" title="Edit">Edit</a>&nbsp;&nbsp;
								<a href="delete-tarief.php?id=<?php echo $row->id; ?>" title="Delete">Delete</a>&nbsp;&nbsp;
							</td>
							</tr>
						<?php }
						?>
					</tbody>
				</table>
			</div>
		</main>
	</div>
</body>

</html>