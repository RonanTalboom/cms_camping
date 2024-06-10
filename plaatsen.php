<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();
?>
<!doctype html>
<html lang="en" data-theme="lemonade">

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
				<h2 class="text-2xl font-bold">Plaatsen</h2>
					<a href="register-plaats.php" class="btn btn-primary">Voeg Plaats Toe</a>
				</div>

				<table class="table w-full mt-4 overflow-x-auto">
					<thead>
						<tr>
							<th>#</th>
							<th>Naam</th>
							<th>Beschrijving</th>
							<th>Groot</th>
							<th>Electriciteit</th>
							<th>Kosten in €</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$ret = "SELECT * FROM plaatsen";
						$stmt = $conn->prepare($ret);
						$stmt->execute(); //ok
						$res = $stmt->get_result();
						while ($row = $res->fetch_object()) { ?>
							<td><?php echo $row->id; ?></td>
							<td><?php echo $row->naam; ?></td>
							<td><?php echo $row->beschrijving; ?></td>
							<td><?php if ($row->groot === 1) {
									echo "Yes";
								} else {
									echo "No";
								} ?>
							</td>
							<td><?php if ($row->electriciteit === 1) {
									echo "Yes";
								} else {
									echo "No";
								} ?>
							</td>
							<td>€ <?php echo $row->kosten; ?> .-</td>

							<td>
								<a href="edit-plaats.php?id=<?php echo $row->id; ?>" title="Edit">Edit</a>&nbsp;&nbsp;
								<?php if (!strlen($_SESSION["admin_id"]) == 0) { ?>
									<a href="delete-plaats.php?id=<?php echo $row->id; ?>" title="Delete">Delete</a>&nbsp;&nbsp;
								<?php } ?>

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