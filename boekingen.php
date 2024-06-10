<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();
?>
<!doctype html>
<html lang="en" data-theme="lemonade">

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
								<ul class="menu menu-horizontal">
									<li><a href="view-boeking.php?id=<?php echo $row->id; ?>" title="View" class="tooltip" data-tip="View">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="h-3 w-3"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
												<path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
											</svg>
										</a>
									</li>
									<li>
										<a href="edit-boeking.php?id=<?php echo $row->id; ?>" title="Edit" class="tooltip" data-tip="Edit" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-3 w-3"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
												<path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
											</svg></a>
									</li>
									<li>
										<a href="delete-boeking.php?id=<?php echo $row->id; ?>" title="Delete" class="tooltip" data-tip="Delete">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-3 w-3"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
												<path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
											</svg>
										</a>
									</li>
								</ul>
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