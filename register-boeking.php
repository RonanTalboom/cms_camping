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
	$boeking_datumd = date("Y-m-d H:i:s", strtotime($boeking_datum));
	$checkin_datumd = date("Y-m-d H:i:s", strtotime($checkin_datum));
	$checkuit_datumd = date("Y-m-d H:i:s", strtotime($checkuit_datum));
	if (isset($_POST["plaats"]) && isset($_POST["tarieven"])) {
		$plaats = $_GET["plaats_id"];
		$query = "SELECT * FROM `plaats_boekingen` INNER JOIN `boekingen` 
		ON plaats_boekingen.boeking_id = boekingen.id WHERE plaats_id = ? 
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
				"INSERT INTO `boekingen`(`klant_id`,`boeking_datum`, `checkin_datum`, `checkuit_datum`) VALUES (?,?,?,?)";
			$stmt = $conn->prepare($query);
			$rc = $stmt->bind_param(
				"isss",
				$klantID,
				$boeking_datumd,
				$checkin_datumd,
				$checkuit_datumd,
			);
			$stmt->execute();
			$boekingID = $conn->insert_id;

			$query = "SELECT * FROM `plaatsen` WHERE id=?";
			$stmt = $conn->prepare($query);
			$rc = $stmt->bind_param(
				"i",
				$plaats,
			);
			$stmt->execute();
			$res = $stmt->get_result();
			while ($row = $res->fetch_object()) {
				$query = "INSERT INTO `plaats_boekingen`(`plaats_id`, `boeking_id`, `kosten`) VALUES (?,?,?)";
				$stmt = $conn->prepare($query);
				$stmt->bind_param(
					"iid",
					$plaats,
					$boekingID,
					$row->kosten
				);
				$stmt->execute();
			}
			foreach ($_POST["tarieven"] as $tarief) {
				$query = "SELECT kosten FROM `tarieven` WHERE id=?";
				$stmt = $conn->prepare($query);
				$rc = $stmt->bind_param(
					"i",
					$tarief
				);
				$stmt->execute();
				$res = $stmt->get_result();
				while ($row = $res->fetch_object()) {
					$query = "INSERT INTO `boeking_tarieven`(`boeking_id`, `tarief_id`, `kosten`) VALUES (?,?,?)";
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
			<form method="post" class="form-horizontal">
				<div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md flex flex-col space-y-4">
					<div class="form-control">
						<label class="label">
							<span class="label-text">Plaats</span>
						</label>
						<select class="select select-bordered w-full max-w-xs" aria-label="Kies plaats" name="plaats" readonly>
							<?php
							$plaats_id = $_GET["plaats_id"];
							$ret = "select id, naam from plaatsen WHERE id = ?";
							$stmt = $conn->prepare($ret);
							$stmt->bind_param("i", $plaats_id);
							$stmt->execute();
							$res = $stmt->get_result();
							while ($row = $res->fetch_object()) { ?>
								<option value="<?php echo $row->id; ?>"><?php echo $row->naam; ?></option>
							<?php }
							?>
						</select>
					</div>

					<div class="form-control">
						<label class="label">
							<span class="label-text">Klant</span>
						</label>
						<select class="select select-bordered w-full max-w-xs" aria-label="Kies Klant" name="klantID" required>
							<?php
							$ret = "select id, naam from klant";
							$stmt = $conn->prepare($ret);
							$stmt->execute();
							$res = $stmt->get_result();
							while ($row = $res->fetch_object()) { ?>
								<option value="<?php echo $row->id; ?>"><?php echo $row->naam; ?></option>
							<?php }
							?>
						</select>
					</div>

					<div class="form-control">
						<label class="label">
							<span class="label-text">Boeking Datum</span>
						</label>
						<input type="datetime-local" class="input input-bordered" name="boeking_datum" required>
					</div>


					<div class="form-control">
						<label class="label">
							<span class="label-text">Check in Datum</span>
						</label>
						<input type="datetime-local" class="input input-bordered" name="checkin_datum" value="<?php echo $_GET["checkin_datum"] ?>" readonly>
					</div>
					<div class="form-control">
						<label class="col-sm-2 control-label">Check Uit datum</label>
						<input type="datetime-local" class="input input-bordered" name="checkuit_datum" value="<?php echo $_GET["checkuit_datum"] ?>" readonly>
					</div>

					<div class="form-control">
						<label class="label">
							<span class="label-text">Kosten</span>
						</label>
						<?php
						$ret = "select * from tarieven";
						$stmt = $conn->prepare($ret);
						$stmt->execute();
						$res = $stmt->get_result();
						while ($row = $res->fetch_object()) { ?>
							<label class="label">

								<span class="label-text">
									<?php echo $row->beschrijving; ?> €<?php echo $row->kosten; ?>
								</span>
								<input class="checkbox" type="checkbox" name="tarieven[]" value="<?php echo $row->id; ?>" />
							</label>
						<?php } ?>
					</div>


					<div class="form-control">
						<input type="submit" class="btn btn-primary" value="Submit" name="submit">
					</div>

				</div>
			</form>
		</main>
	</div>

</body>

</html>