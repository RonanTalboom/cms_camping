<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_admin_login();
?>

<!doctype html>
<html lang="en">

<head>
	<title>CAMPING</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/signin.css">
	<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
	<script src="https://cdn.tailwindcss.com"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
</head>

<body>
	<div class="flex min-h-screen">

		<?php include "includes/sidebar.php"; ?>
		<main class="flex-1 p-6">
			<h1 class="text-3xl font-bold mb-6">Welcome to Your Dashboard</h1>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
				<div class="card bg-white shadow-lg p-4">
					<h2 class="text-lg font-semibold mb-2">Card 1</h2>
					<p>This is the content for card 1.</p>
				</div>
				<div class="card bg-white shadow-lg p-4">
					<h2 class="text-lg font-semibold mb-2">Card 2</h2>
					<p>This is the content for card 2.</p>
				</div>
				<div class="card bg-white shadow-lg p-4">
					<h2 class="text-lg font-semibold mb-2">Card 3</h2>
					<p>This is the content for card 3.</p>
				</div>
				<div class="card bg-white shadow-lg p-4">
					<h2 class="text-lg font-semibold mb-2">Card 4</h2>
					<p>This is the content for card 4.</p>
				</div>
				<div class="card bg-white shadow-lg p-4">
					<h2 class="text-lg font-semibold mb-2">Card 5</h2>
					<p>This is the content for card 5.</p>
				</div>
				<div class="card bg-white shadow-lg p-4">
					<h2 class="text-lg font-semibold mb-2">Card 6</h2>
					<p>This is the content for card 6.</p>
				</div>
			</div>
		</main>

		<div>

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

</body>



</html>