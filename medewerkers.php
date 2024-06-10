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
		<main class="flex-1 p-6 overflow-y-auto" style="height: 100vh;">
			<div class="container mx-auto">
				<div class="flex justify-between items-center">
				<h2 class="text-2xl font-bold">Medewerkers</h2>
					<a href="register-medewerker.php" class="btn btn-primary">Voeg Medewerker Toe</a>
				</div>

				<table class="table w-full mt-4 overflow-x-auto">
					<thead>
						<tr>
							<th>id</th>
							<th>Naam</th>
							<th>Email</th>
							<th>Telefoon</th>
							<th>Manager</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$ret = "SELECT * FROM medewerkers";
						$stmt = $conn->prepare($ret);
						$stmt->execute(); //ok
						$res = $stmt->get_result();
						while ($row = $res->fetch_object()) { ?>
							<td><?php echo $row->id; ?></td>
							<td><?php echo $row->naam; ?></td>
							<td><?php echo $row->email; ?></td>
							<td><?php echo $row->telefoon; ?></td>
							<td><?php if ($row->manager === 1) {
									echo "Yes";
								} else {
									echo "No";
								} ?></td>

							<td>
								<a href="edit-medewerker.php?id=<?php echo $row->id; ?>" title="Edit">Edit</a>&nbsp;&nbsp;
								<a href="delete-medewerker.php?id=<?php echo $row->id; ?>" title="Delete">Delete</a>&nbsp;&nbsp;
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