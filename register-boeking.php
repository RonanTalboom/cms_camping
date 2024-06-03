<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_admin_login();
//code for add courses
if (isset($_POST["submit"])) {
    $klantID = $_POST["klantID"];
    $boeking_datum = $_POST["boeking_datum"];
    $checkin_datum = $_POST["checkin_datum"];
    $checkuit_datum = $_POST["checkuit_datum"];
    $status = $_POST["status"];
    $boeking_datumd = date("Y-m-d H:i:s", strtotime($boeking_datum));
    $checkin_datumd = date("Y-m-d H:i:s", strtotime($checkin_datum));
    $checkuit_datumd = date("Y-m-d H:i:s", strtotime($checkuit_datum));
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
    echo "<script>alert('Boeking has been created');</script>";
    header("location:boekingen.php");
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
	<?php include "includes/header.php"; ?>
	<div class="ts-main-content">
		<?php include "includes/sidebar.php"; ?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Nieuwe boeking </h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										Nieuwe Boeking</div>
									<div class="panel-body">
										<form method="post" class="form-horizontal">

											<div class="hr-dashed"></div>

											<div class="form-group">
												<label class="col-sm-2 control-label">Klant</label>

												<div class="col-sm-8">
													<select class="form-select" aria-label="Kies Klant" name="klantID">
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
													<input type="datetime-local" class="form-control" name="boeking_datum">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label">Check in Datum</label>
												<div class="col-sm-8">
													<input type="datetime-local" class="form-control" name="checkin_datum">
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label">Check out datum</label>
												<div class="col-sm-8">
													<input type="datetime-local" class="form-control" name="checkuit_datum">
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


	</div>
	</div>
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

	</script>
</body>

</html>
