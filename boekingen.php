<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();
?>
<!doctype html>
<html>

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<title>CAMPING</title>
	<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
	<div class="flex min-h-screen">
		<?php include "includes/sidebar.php"; ?>
		<main class="flex-1 p-6 overflow-y-auto" style="height: 100vh;">
			<div class="container mx-auto">
				<div class="flex justify-between items-center">
					<h2 class="text-2xl font-bold">Boekingen</h2>
					<a href="check-availability.php" class="btn btn-primary">Nieuwe Boeking</a>
				</div>

				<table class="table w-full mt-4 overflow-x-auto">
					<thead>
						<tr>
							<th>#</th>
							<th>Klant Naam</th>
							<th>Boeking Datum</th>
							<th>Check in Tijd</th>
							<th>Check uit Tijd</th>
							<th>Open</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php

						$ret = "SELECT boekingen.*, klant.naam as naam FROM boekingen INNER JOIN klant ON boekingen.klant_id = klant.id ORDER BY boekingen.id ASC ";
						$stmt = $conn->prepare($ret);
						$stmt->execute();
						$res = $stmt->get_result();
						while ($row = $res->fetch_object()) { ?>
							<td><?php echo $row->id; ?></td>
							<td><?php echo $row->naam; ?></td>
							<td><?php echo $row->boeking_datum; ?></td>
							<td><?php echo $row->checkin_datum; ?></td>
							<td><?php echo $row->checkuit_datum; ?></td>
							<td>
								<?php $checkuit_datum = new DateTime($row->checkuit_datum); // assuming $row->checkuit_datum is the check-out date from your database
								$now = new DateTime();

								if ($checkuit_datum > $now) {
									echo "Open";
								} else {
									echo "Closed";
								} ?>
							</td>
							<td>
								<a href="view-boeking.php?id=<?php echo $row->id; ?>" title="View">View</a>&nbsp;&nbsp;
								<a href="edit-boeking.php?id=<?php echo $row->id; ?>" title="Edit">Edit</a>&nbsp;&nbsp;
								<a href="delete-boeking.php?id=<?php echo $row->id; ?>" title="Delete">Delete</a>&nbsp;&nbsp;
							</td>
							</tr>
						<?php }
						$stmt = $conn->prepare("SELECT COUNT(*) FROM boekingen INNER JOIN klant ON boekingen.klant_id = klant.id");
						$stmt->execute();
						$total_rows = $stmt->get_result()->fetch_row()[0];

						// calculate the total number of pages
						$total_pages = ceil($total_rows / $limit);
						?>
					</tbody>
				</table>
			</div>
		</main>
	</div>

</body>

</html>