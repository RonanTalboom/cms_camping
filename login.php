<?php
session_start();
include('includes/config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Include database connection
	// Get email and password from the form
	$email = $_POST['email'];
	$password = $_POST['password'];
	// Prepare SQL statement to prevent SQL injection
	$stmt = $conn->prepare("SELECT id, manager FROM medewerkers WHERE email = ? AND wachtwoord = ?");
	$stmt->bind_param("ss", $email, $password);

	$stmt->execute(); // Execute the query
	$stmt->store_result(); // Store the result
	// Check if the user exists
	if ($stmt->num_rows == 1) {

		$stmt->bind_result($id, $manager); // Bind the result to variables
		$stmt->fetch(); // Fetch the result
		//  authentication successful, store user details in session
		$_SESSION['id'] = $id;
		$_SESSION['email'] = $email;
		if ($manager == 1) {
			$_SESSION['admin_id'] = $id;
		}


		header("location:dashboard.php"); // Redirect to a secure page
		exit(); // Always exit after a header redirect
	} else {
		// Authentication failed, display an error message
		$error = "Invalid email or password";
	}
	$stmt->close();
}
?>

<!doctype html>
<html lang="en">

<head>
	<title>CAMPING</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/signin.css">
	<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
	<script src="https://cdn.tailwindcss.com"></script>
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
	<main class="bg-gray-100 flex items-center justify-center min-h-screen">

		<div class="card w-full max-w-sm shadow-2xl bg-base-100">
			<div class="card-body">
				<h2 class="card-title">Login</h2>
				<div>
					<?php if (isset($error)) {
						echo "<div class='error'>$error</div>";
					} ?>
				</div>
				<form action="" class="mt" method="post">
					<div class="form-control">
						<label class="input input-bordered flex items-center gap-2">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70">
								<path d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z" />
								<path d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z" />
							</svg>
							<input type="text" class="grow" placeholder="Email" name="email" />
						</label>
					</div>
					<div class="form-control">
						<label class="input input-bordered flex items-center gap-2">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70">
								<path fill-rule="evenodd" d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z" clip-rule="evenodd" />
							</svg>
							<input type="password" class="grow" placeholder="password" name="password" />
						</label>
					</div>

					<div class="form-control mt-6">
						<button class="btn btn-primary" type="submit">Login</button>
					</div>
				</form>
			</div>
		</div>
	</main>
</body>

</html>