<?php
session_start();
include('includes/config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Include database connection
	// Get email and password from the form
	$email = $_POST['email'];
	$password = $_POST['password'];
	// Prepare SQL statement to prevent SQL injection
	$stmt = $conn->prepare("SELECT medewerkerID FROM medewerkers WHERE email = ? AND wachtwoord = ?");
	$stmt->bind_param("ss", $email, $password);

	$stmt->execute(); // Execute the query
	$stmt->store_result(); // Store the result
	// Check if the user exists
	if ($stmt->num_rows == 1) {

		$stmt->bind_result($id); // Bind the result to variables
		$stmt->fetch(); // Fetch the result
		//  authentication successful, store user details in session
		$_SESSION['id'] = $id;
		$_SESSION['email'] = $email;

		header("location: dashboard.php"); // Redirect to a secure page
		exit(); // Always exit after a header redirect
	} else {
		// Authentication failed, display an error message
		$error = "Invalid email or password";
	}
	// Close statement
	$stmt->close();
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
	<title>CAMPING</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/signin.css">
	<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
	<script type="text/javascript" src="js/validation.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript">
		function valid() {
			if (document.registration.password.value != document.registration.cpassword.value) {
				alert("Password and Re-Type Password Field do not match  !!");
				document.registration.cpassword.focus();
				return false;
			}
			return true;
		}
	</script>
</head>

<body>
	<div class="container-fluid">
		<div class="row">

			<?php include('includes/sidebar.php'); ?>

			<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 text-center sign-in">

				<div class="form-signin">
					<h1 class="h3 mb-3 fw-normal">Please sign in</h1>
					<div>
						<?php if (isset($error)) {
							echo "<div class='error'>$error</div>";
						} ?>
					</div>
					<form action="" class="mt" method="post">
						<div class="form-floating">
							<label for="" class="text-uppercase text-sm">Email</label>
							<input type="text" placeholder="Email" name="email" class="form-control mb">
						</div>
						<div class="form-floating">
							<label for="" class="text-uppercase text-sm">Password</label>
							<input type="password" placeholder="Password" name="password" class="form-control mb">
						</div>


						<button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
					</form>
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
</body>

</html>