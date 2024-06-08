<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();
//code for add courses
if (isset($_POST["submit"])) {
	$naam = $_POST["naam"];
	$email = $_POST["email"];
	$telefoon = $_POST["telefoon"];
	$adres = $_POST["adres"];
	$id = $_GET["id"];
	$query = "update klant set naam=?,email=?,telefoon=?,adres=? where id=?";
	$stmt = $conn->prepare($query);
	$rc = $stmt->bind_param("ssssi", $naam, $email, $telefoon, $adres, $id);
	$stmt->execute();
	echo "<script>alert('klant has been Updated successfully');</script>";
	header("location:klanten.php");
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
		<main class="flex-1 p-6">
			<form method="post" class="form-horizontal">
				<?php
				$id = $_GET["id"];
				$ret = "select * from klant where id=?";
				$stmt = $conn->prepare($ret);
				$stmt->bind_param("i", $id);
				$stmt->execute();
				$res = $stmt->get_result();
				while ($row = $res->fetch_object()) { ?>
					<div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md flex flex-col space-y-4">

						<div class="form-control">
							<label class="label">
								<span class="label-text">Naam</span>
							</label>
							<input type="text" class="input input-bordered" name="naam" id="naam" required="required" value="<?php echo $row->naam; ?>">
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
								<span class="label-text">Adres</span>
							</label>
							<input type="text" class="input input-bordered" name="adres" value="<?php echo $row->adres; ?>">
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