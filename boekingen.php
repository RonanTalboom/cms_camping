<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<title>CAMPING</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/signin.css">
	<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="flex min-h-screen">
		<?php include "includes/sidebar.php"; ?>
		<main class="flex-1 p-6">
			<div class="container mx-auto">
				<div class="flex justify-between items-center">
					<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="search" type="text" placeholder="Search">
					<a href="check-availability.php" class="btn btn-primary">Nieuwe Boeking</a>
				</div>
				<h2 class="text-2xl font-bold">Boekingen</h2>

				<table class="table w-full mt-4">
					<thead>
						<tr>
							<th>#</th>
							<th>Klant Naam</th>
							<th>Boeking Datum</th>
							<th>Check in Tijd</th>
							<th>Check uit Tijd</th>
							<th>status</th>
							<th>Open</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$limit = 10; // number of rows to show per page
						$page = isset($_GET['page']) ? $_GET['page'] : 1; // current page
						$start = ($page - 1) * $limit; // calculate the start of the results

						$ret = "SELECT * FROM boekingen INNER JOIN klant ON boekingen.klantID = klant.klantID LIMIT $start, $limit";
						$stmt = $conn->prepare($ret);
						$stmt->execute();
						$res = $stmt->get_result();
						while ($row = $res->fetch_object()) { ?>
							<td><?php echo $row->boekingID; ?></td>
							<td><?php echo $row->naam; ?></td>
							<td><?php echo $row->boeking_datum; ?></td>
							<td><?php echo $row->checkin_datum; ?></td>
							<td><?php echo $row->checkuit_datum; ?></td>
							<td><?php echo $row->status; ?></td>
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
								<a href="view-boeking.php?id=<?php echo $row->boekingID; ?>" title="View">View</a>&nbsp;&nbsp;
								<a href="edit-boeking.php?id=<?php echo $row->boekingID; ?>" title="Edit">Edit</a>&nbsp;&nbsp;
								<a href="delete-boeking.php?id=<?php echo $row->boekingID; ?>" title="Delete">Delete</a>&nbsp;&nbsp;
							</td>
							</tr>
						<?php }
						$stmt = $conn->prepare("SELECT COUNT(*) FROM boekingen INNER JOIN klant ON boekingen.klantID = klant.klantID");
						$stmt->execute();
						$total_rows = $stmt->get_result()->fetch_row()[0];

						// calculate the total number of pages
						$total_pages = ceil($total_rows / $limit);
						?>
					</tbody>
				</table>
				<nav class="flex items-center justify-between p-4">
					<ul class="pagination">
						<li class="page-item <?= $page == 1 ? 'disabled' : '' ?>"><a href="?page=<?= max(1, $page - 1) ?>" class="page-link">Previous</a></li>
						<?php for ($i = 1; $i <= $total_pages; $i++) : ?>
							<li class="page-item <?= $page == $i ? 'active' : '' ?>"><a href="?page=<?= $i ?>" class="page-link"><?= $i ?></a></li>
						<?php endfor; ?>
						<li class="page-item <?= $page == $total_pages ? 'disabled' : '' ?>"><a href="?page=<?= min($total_pages, $page + 1) ?>" class="page-link">Next</a></li>
					</ul>
				</nav>
			</div>
		</main>
	</div>

</body>
<script src="https://cdn.tailwindcss.com"></script>
</html>