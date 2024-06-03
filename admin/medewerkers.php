<?php
session_start();
include "../includes/config.php";
include "../includes/checklogin.php";
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
	<title>My Complaints</title>
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="../css/bootstrap-social.css">
	<link rel="stylesheet" href="../css/bootstrap-select.css">
	<link rel="stylesheet" href="../css/fileinput.min.css">
	<link rel="stylesheet" href="../css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="../css/style.css">

</head>

<body>
	<?php include "../includes/header.php"; ?>

	<div class="ts-main-content">
			<?php include "../includes/sidebar.php"; ?>
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title" style="margin-top:4%">Medewerkers Camping le qrukoe</h2>
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
											<th>Manager</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
    										<th>id</th>
    										<th>Naam</th>
    										<th>Email</th>
    										<th>Telefoon</th>
    										<th>MAnager</th>
    										<th>Action</th>
										</tr>
									</tfoot>
									<tbody>
<?php
$ret = "SELECT * FROM medewerkers";
$stmt = $conn->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($row = $res->fetch_object()) { ?>
<td><?php echo $row->medewerkerID; ?></td>
<td><?php echo $row->naam; ?></td>
<td><?php echo $row->email; ?></td>
<td><?php echo $row->telefoon; ?></td>
<td><?php if ($row->manager === 1) {
    echo "Yes";
} else {
    echo "No";
} ?></td>

<td>
<a href="edit-medewerker.php?id=<?php echo $row->medewerkerID; ?>" title="Edit">Edit</a>&nbsp;&nbsp;
<a href="delete-medewerker.php?id=<?php echo $row->medewerkerID; ?>" title="Delete">Delete</a>&nbsp;&nbsp;
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
