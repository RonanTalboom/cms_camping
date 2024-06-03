<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_admin_login();
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
	<title>CAMPING</title>
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
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<?php include "includes/sidebar.php"; ?>
			<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-body">

									<?php
									$ret = "SELECT kosten FROM boeking_tarieven";
									$stmt = $conn->prepare($ret);
									$stmt->execute(); //ok
									$res = $stmt->get_result();
									$total = 0;
									while ($row = $res->fetch_object()) {
										$total += $row->kosten;
									}
									?>
									<h1> MONEY <?php echo $total ?></h1>



								</div>
							</div>


						</div>
					</div>



				</div>
			</main>
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
	<script src="js/sidebar.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>

</body>



</html>