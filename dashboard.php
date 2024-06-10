<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_admin_login();
$query = "SELECT checkin_datum, checkuit_datum, kosten FROM boekingen INNER JOIN boeking_tarieven ON boekingen.id = boeking_tarieven.boeking_id";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$costsPerDay = [];
while ($row = $result->fetch_assoc()) {
	$begin = new DateTime($row['checkin_datum']);
	$end = new DateTime($row['checkuit_datum']);
	$interval = DateInterval::createFromDateString('1 day');
	$period = new DatePeriod($begin, $interval, $end);

	foreach ($period as $dt) {
		$date = $dt->format("Y-m-d");
		if (!isset($costsPerDay[$date])) {
			$costsPerDay[$date] = 0;
		}
		$costsPerDay[$date] += $row['kosten'];
	}
}

$runningTotal = 0;
ksort($costsPerDay); 
foreach ($costsPerDay as $date => $cost) {
	$runningTotal += $cost;
	$costsPerDay[$date] = $runningTotal;
}

$labels = array_keys($costsPerDay);
$data = array_values($costsPerDay);
?>

<!doctype html>
<html lang="en">

<head>
	<title>CAMPING</title>

	<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
	<script src="https://cdn.tailwindcss.com"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
</head>

<body>
	<div class="flex min-h-screen">

		<?php include "includes/sidebar.php"; ?>
		<main class="flex-1 p-6">
			<div class="flex min-h-screen">
				<canvas id="myChart"></canvas>
			</div>
		</main>
	</div>

</body>
<script>
	var ctx = document.getElementById('myChart')
	new Chart(ctx, {
		type: 'line',
		data: {
			labels: JSON.parse('<?php echo json_encode($labels); ?>'),
			datasets: [{
				label: 'Total kosten in € (<?php echo $runningTotal; ?>) ',
				data: JSON.parse('<?php echo json_encode($data); ?>'),
				backgroundColor: 'rgba(75, 192, 192, 0.2)',
				borderColor: 'rgba(75, 192, 192, 1)',
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				x: {
					type: 'time',
					time: {
						unit: 'day'
					}
				},
				y: {
					beginAtZero: true
				}
			}
		}
	});
</script>


</html>