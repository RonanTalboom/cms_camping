<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();


if (!isset($_GET["checkin_datum"]) || !isset($_GET["checkuit_datum"]) || !isset($_GET["plaats_id"])) {
	header("location:check-availability.php");
}



//code for add courses
if (isset($_POST["submit"])) {
	$klantID = $_POST["klantID"];
	$boeking_datum = $_POST["boeking_datum"];
	$checkin_datum = $_GET["checkin_datum"];
	$checkuit_datum = $_GET["checkuit_datum"];
	$status = $_POST["status"];
	$boeking_datumd = date("Y-m-d H:i:s", strtotime($boeking_datum));
	$checkin_datumd = date("Y-m-d H:i:s", strtotime($checkin_datum));
	$checkuit_datumd = date("Y-m-d H:i:s", strtotime($checkuit_datum));
	if (isset($_POST["plaats"]) && isset($_POST["tarieven"])) {
		$plaats = $_GET["plaats_id"];
		$query = "SELECT * FROM `plaats_boekingen` INNER JOIN `boekingen` 
		ON plaats_boekingen.boeking_id = boekingen.boekingID WHERE plaats_id = ? 
		AND ((checkin_datum < ? 
		AND checkuit_datum > ?) 
		OR (checkin_datum < ? 
		AND checkuit_datum > ?) 
		OR (checkin_datum > ? 
		AND checkuit_datum < ?)
		OR (checkin_datum <= ? 
		AND checkuit_datum >= ?))";
		$stmt = $conn->prepare($query);
		$stmt->bind_param(
			"issssssss",
			$plaats,
			$checkin_datumd,
			$checkin_datumd,
			$checkuit_datumd,
			$checkuit_datumd,
			$checkin_datumd,
			$checkuit_datumd,
			$checkin_datumd,
			$checkuit_datumd
		);
		$stmt->execute();
		$res = $stmt->get_result();
		if ($res->num_rows > 0) {
			// The "plaats" has already been booked by a different "boeking" on the selected date
			echo "<script>alert('This plaats has already been booked on the selected date');</script>";
		} else {
			$query =
				"INSERT INTO `boekingen`(`klantID`,`boeking_datum`, `checkin_datum`, `checkuit_datum`, `status`) VALUES (?,?,?,?,?)";
			$stmt = $conn->prepare($query);
			$rc = $stmt->bind_param(
				"issss",
				$klantID,
				$boeking_datumd,
				$checkin_datumd,
				$checkuit_datumd,
				$status
			);
			$stmt->execute();
			$boekingID = $conn->insert_id;

			// The "plaats" is available on the selected date
			$query = "INSERT INTO `plaats_boekingen`(`plaats_id`, `boeking_id`) VALUES (?,?)";
			$stmt = $conn->prepare($query);
			$stmt->bind_param(
				"ii",
				$plaats,
				$boekingID,
			);
			$stmt->execute();
			foreach ($_POST["tarieven"] as $tarief) {
				$query = "SELECT kosten FROM `tarieven` WHERE ID=?";
				$stmt = $conn->prepare($query);
				$rc = $stmt->bind_param(
					"i",
					$tarief
				);
				$stmt->execute();
				$res = $stmt->get_result();
				while ($row = $res->fetch_object()) {
					$query = "INSERT INTO `boeking_tarieven`(`boekingID`, `tariefID`, `kosten`) VALUES (?,?,?)";
					$stmt = $conn->prepare($query);
					$rc = $stmt->bind_param(
						"iid",
						$boekingID,
						$tarief,
						$row->kosten
					);
					$stmt->execute();
				}
			}
			header("location:boekingen.php");
		}
	}
}
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
	<title>Nieuwe boeking </title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
	<script type="text/javascript" src="js/validation.min.js"></script>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<?php include "includes/sidebar.php"; ?>

			<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">

							<h2 class="page-title">Nieuwe boeking </h2>

							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-body">
											<form method="post" class="form-horizontal">

												<div class="hr-dashed"></div>

												<div class="form-group">
													<label class="col-sm-2 control-label">Plaats</label>

													<div class="col-sm-8">
														<select class="form-select" aria-label="Kies plaats" name="plaats" readonly>
															<?php
															$plaats_id = $_GET["plaats_id"];
															$ret = "select ID, naam from plaatsen WHERE ID = ?";
															$stmt = $conn->prepare($ret);
															$stmt->bind_param("i", $plaats_id );
															$stmt->execute();
															$res = $stmt->get_result();
															while ($row = $res->fetch_object()) { ?>
																<option value="<?php echo $row->ID; ?>"><?php echo $row->naam; ?></option>

															<?php }
															?>
														</select>

													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-2 control-label">Klant</label>

													<div class="col-sm-8">
														<select class="form-select" aria-label="Kies Klant" name="klantID" required>
															<?php
															$ret = "select klantID, naam from klant";
															$stmt = $conn->prepare($ret);
															$stmt->execute();
															$res = $stmt->get_result();
															while ($row = $res->fetch_object()) { ?>
																<option value="<?php echo $row->klantID; ?>"><?php echo $row->naam; ?></option>


															<?php }
															?>
														</select>

													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-2 control-label">Boeking Datum</label>
													<div class="col-sm-8">
														<input type="datetime-local" class="form-control" name="boeking_datum" required>
													</div>
												</div>
												<div class="form-group">
													
													<label class="col-sm-2 control-label">Check in Datum</label>
													<div class="col-sm-8">
														<input type="datetime-local" class="form-control" name="checkin_datum" value="<?php echo $_GET["checkin_datum"]?>" readonly>
													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-2 control-label">Check Uit datum</label>
													<div class="col-sm-8">
														<input type="datetime-local" class="form-control" name="checkuit_datum" value="<?php echo $_GET["checkuit_datum"]?>" readonly>
													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-2 control-label">Status</label>
													<div class="col-sm-8">
														<select class="form-select" aria-label="Kies status" name="status">
															<option value="0">Bevestigd</option>
															<option value="1">In afwachting</option>
															<option value="2">Geannuleerd</option>
													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-2 control-label">Kosten</label>
													<div class="col-sm-8">
														<?php
														$ret = "select * from tarieven";
														$stmt = $conn->prepare($ret);
														$stmt->execute();
														$res = $stmt->get_result();
														while ($row = $res->fetch_object()) { ?>
															<div class="form-check">
																<input class="form-check-input" type="checkbox" name="tarieven[]" id="tarief-<?php echo $row->ID; ?>" value="<?php echo $row->ID; ?>">
																<label class="form-check-label" for="tarief-<?php echo $row->ID; ?>">
																	<?php echo $row->beschrijving; ?> €<?php echo $row->kosten; ?>
																</label>
															</div>
														<?php }
														?>
													</div>
												</div>


												<div class="col-sm-8 col-sm-offset-2">

													<input class="btn btn-primary" type="submit" name="submit" value="Register">
												</div>
										</div>

										</form>

									</div>
								</div>


							</div>




						</div>
					</div>

				</div>
		</div>

		</main>
	</div>
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