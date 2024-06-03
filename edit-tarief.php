<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_admin_login();
//code for add courses
if (isset($_POST["submit"])) {
	$beschrijving = $_POST["beschrijving"];
	$kosten = $_POST["kosten"];
	$id = $_GET["id"];
	$query =
		"update tarieven set beschrijving=?,kosten=? where ID=?";
	$stmt = $conn->prepare($query);
	$rc = $stmt->bind_param("sdi", $beschrijving, $kosten, $id);
	$stmt->execute();
	echo "<script>alert('tarief has been Updated successfully');</script>";
	header("location:tarieven.php");
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
	<title>Edit Tarief</title>
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
				<div class="content-wrapper">
					<div class="container-fluid">

						<div class="row">
							<div class="col-md-12">


								<div class="row">
									<div class="col-md-12">
										<div class="panel panel-default">
											<div class="panel-heading">Edit Tarief</div>
											<div class="panel-body">
												<form method="post" class="form-horizontal">
													<?php
													$id = $_GET["id"];
													$ret = "select * from tarieven where ID=?";
													$stmt = $conn->prepare($ret);
													$stmt->bind_param("i", $id);
													$stmt->execute(); //ok
													$res = $stmt->get_result();
													while ($row = $res->fetch_object()) { ?>
														<div class="hr-dashed"></div>
														<div class="form-group">
															<label class="col-sm-2 control-label">ID </label>
															<div class="col-sm-8">
																<input type="text" name="cc" value="<?php echo $row->ID; ?>" class="form-control" disabled>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-2 control-label">Beschrijving</label>
															<div class="col-sm-8">
																<input type="text" class="form-control" name="beschrijving" id="beschrijving" value="<?php echo $row->beschrijving; ?>" required="required">
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-2 control-label">Kosten in E</label>
															<div class="col-sm-8">
																<div class="input-group mb-3">
																	<span class="input-group-text">€</span>
																	<input type="number" step="0.01" class="form-control" name="kosten" value="<?php echo $row->kosten; ?>">
																</div>
															</div>
														</div>


													<?php }
													?>
													<div class="col-sm-8 col-sm-offset-2">

														<input class="btn btn-primary" type="submit" name="submit" value="Update">
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