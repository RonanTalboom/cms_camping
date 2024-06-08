<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_admin_login();
//code for add courses
if (isset($_POST["submit"])) {
    $beschrijving = $_POST["beschrijving"];
    $kosten = $_POST["kosten"];


    $query =
        "INSERT INTO `tarieven`(`beschrijving`, `kosten`) VALUES (?,?)";
    $stmt = $conn->prepare($query);
    $rc = $stmt->bind_param(
        "sd",
        $beschrijving,
        $kosten,
    );
    $stmt->execute();
    echo "<script>alert('medewerker has been created');</script>";
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
        <main class="flex-1 p-6">

            <h2 class="page-title">Nieuw Tarief </h2>
            <form method="post" class="form-horizontal">

                <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md flex flex-col space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Beschrijving</span>
                        </label>
                        <input type="text" class="input input-bordered" name="beschrijving" required="required">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Kosten in E</span>
                        </label>
                        <div class="relative">
                            <span class="absolute top-0 right-0 rounded-r-md">
                                <button class="btn btn-square btn-ghost" disabled>€</button>
                            </span>
                            <input type="number" step="0.01" class="input input-bordered pr-12" name="kosten">
                        </div>
                    </div>

					<div class="form-control">
						<input type="submit" class="btn btn-primary" value="submit" name="submit">
					</div>
                </div>

            </form>

        </main>
    </div>
</body>

</html>