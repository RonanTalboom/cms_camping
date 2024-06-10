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
		"update tarieven set beschrijving=?,kosten=? where id=?";
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

			<h2 class="page-title">Nieuw Tarief </h2>
			<form method="post" class="form-horizontal">
				<?php
				$id = $_GET["id"];
				$ret = "select * from tarieven where id=?";
				$stmt = $conn->prepare($ret);
				$stmt->bind_param("i", $id);
				$stmt->execute(); //ok
				$res = $stmt->get_result();
				while ($row = $res->fetch_object()) { ?>


					<div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md flex flex-col space-y-4">
						<div class="form-control">
							<label class="label">
								<span class="label-text">Beschrijving</span>
							</label>
							<input type="text" class="input input-bordered" name="beschrijving" required="required" value="<?php echo $row->beschrijving; ?>">
						</div>

						<div class="form-control">
							<label class="label">
								<span class="label-text">Kosten in E</span>
							</label>
							<div class="relative">
								<span class="absolute top-0 right-0 rounded-r-md">
									<button class="btn btn-square btn-ghost" disabled>€</button>
								</span>
								<input type="number" step="0.01" class="input input-bordered pr-12" name="kosten" value="<?php echo $row->kosten; ?>">
							</div>
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