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
	<?php include "includes/header.php"; ?>

	<div class="ts-main-content">
			<?php include "includes/sidebar.php"; ?>
		<div class="content-wrapper">
			<div class="container-fluid">
			    <div class="row">
                    <div class="col-md-8">
                        <h2 class="page-title" style="margin-top:4%">Klanten</h2>
                    </div>
                    <div class="col-md-4">
                        <a href="register-klant.php" class="btn btn-primary">Voeg Klant Toe</a>
                    </div>
			    </div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">Medewerkers</div>
							<div class="panel-body">
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>id</th>
											<th>Naam</th>
											<th>Email</th>
											<th>Telefoon</th>
											<th>Adres</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
    										<th>id</th>
    										<th>Naam</th>
    										<th>Email</th>
    										<th>Telefoon</th>
    										<th>Adres</th>
    										<th>Action</th>
										</tr>
									</tfoot>
									<tbody>
<?php
$ret = "SELECT * FROM klant";
$stmt = $conn->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($row = $res->fetch_object()) { ?>
<td><?php echo $row->klantID; ?></td>
<td><?php echo $row->naam; ?></td>
<td><?php echo $row->email; ?></td>
<td><?php echo $row->tel; ?></td>
<td><?php echo $row->adres; ?></td>

<td>
<a href="edit-klant.php?id=<?php echo $row->klantID; ?>" title="Edit">Edit</a>&nbsp;&nbsp;
<a href="delete-klant.php?id=<?php echo $row->klantID; ?>" title="Delete">Delete</a>&nbsp;&nbsp;
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

</body>

</html>
