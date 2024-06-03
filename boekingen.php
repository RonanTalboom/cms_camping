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
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>My Complaints</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">

</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<?php include "includes/sidebar.php"; ?>
			<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-8 text-start">
							<h2 class="page-title" >Boekingen</h2>
						</div>
						<div class="col-md-4 text-end">
							<a href="register-boeking.php" class="btn btn-primary">Nieuwe Boeking</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
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
											$ret = "SELECT * FROM boekingen INNER JOIN klant ON boekingen.klantID = klant.klantID";
											$stmt = $conn->prepare($ret);
											$stmt->execute(); //ok
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
													}

													?>

												</td>

												<td>
													<a href="view-boeking.php?id=<?php echo $row->boekingID; ?>" title="View">View</a>&nbsp;&nbsp;
													<a href="edit-boeking.php?id=<?php echo $row->boekingID; ?>" title="Edit">Edit</a>&nbsp;&nbsp;
													<a href="delete-boeking.php?id=<?php echo $row->boekingID; ?>" title="Delete">Delete</a>&nbsp;&nbsp;
												</td>
												</tr>
											<?php }
											?>
										</tbody>
									</table>


								</div>
							</div>


						</div>
					</div>



				</div>
			</main>
		</div>
	</div>
		<!-- Loading Scripts -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap-select.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>
		<script src="js/Chart.min.js"></script>
		<script src="js/fileinput.js"></script>
		<script src="js/chartData.js"></script>
		<script src="js/main.js"></script>
		<script src="js/sidebar.js"></script>
		<script src="js/bootstrap.bundle.min.js"></script>
		

</body>

</html>