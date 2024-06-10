<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_admin_login();
//code for add courses
if (isset($_POST["submit"])) {
	$naam = $_POST["naam"];
	$email = $_POST["email"];
	$telefoon = $_POST["telefoon"];
	$id = $_GET["id"];
	$query =
		"update medewerkers set naam=?,email=?,telefoon=? where id=?";
	$stmt = $conn->prepare($query);
	$rc = $stmt->bind_param("sssi", $naam, $email, $telefoon, $id);
	$stmt->execute();
	echo "<script>alert('medewerker has been Updated successfully');</script>";
	header("location:medewerkers.php");
}
?>
<!doctype html>


<html lang="en">

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
			<form method="post" class="form-horizontal space-y-4">
				<?php
				$id = $_GET["id"];
				$ret = "select * from medewerkers where id=?";
				$stmt = $conn->prepare($ret);
				$stmt->bind_param("i", $id);
				$stmt->execute(); //ok
				$res = $stmt->get_result();
				while ($row = $res->fetch_object()) { ?>
					<div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md flex flex-col space-y-4">
						<div class="form-control">
							<label class="label">
								<span class="label-text">Naam</span>
							</label>
							<input type="text" class="input input-bordered" name="naam" id="naam"  value="<?php echo $row->naam; ?>" required="required">
						</div>
						<div class="form-control">
							<label class="label">
								<span class="label-text">Email</span>
							</label>
							<input type="email" class="input input-bordered" name="email" value="<?php echo $row->email; ?>">
						</div>
						<div class="form-control">
							<label class="label">
								<span class="label-text">Telefoon</span>
							</label>
							<input type="text" class="input input-bordered" name="telefoon" value="<?php echo $row->telefoon; ?>">
						</div>
						<div class="form-control">
							<label class="label">
								<span class="label-text">Wachtwoord</span>
							</label>
							<input type="password" class="input input-bordered" name="wachtwoord" value="<?php echo $row->wachtwoord; ?>">
						</div>
					<?php } ?>
					<div class="form-control">
						<input type="submit" class="btn btn-primary" value="submit" name="submit">
					</div>
					</div>
			</form>
		</main>
	</div>
</body>

</html>