<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $checkin_datum = $_GET["checkin_datum"];
    $checkuit_datum = $_GET["checkuit_datum"];
    if (isset($_GET["checkin_datum"]) && isset($_GET["checkuit_datum"])) {
        if (strtotime($checkuit_datum) <= strtotime($checkin_datum)) {
            echo "<script>alert('Check-uit date should be greater than check-in date');</script>";
        } else {

            $query = "SELECT * FROM plaatsen WHERE id NOT IN (
        SELECT plaats_id FROM plaats_boekingen 
        INNER JOIN boekingen ON plaats_boekingen.boeking_id = boekingen.id 
        WHERE (checkin_datum <= ? AND checkuit_datum >= ?) 
        OR (checkin_datum < ? AND checkuit_datum > ?) 
        OR (checkin_datum > ? AND checkuit_datum < ?)
    )";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssss", $checkuit_datum, $checkin_datum, $checkuit_datum, $checkin_datum, $checkin_datum, $checkuit_datum);
            $stmt->execute();
            $res = $stmt->get_result();
            $available_plaatsen = $res->fetch_all(MYSQLI_ASSOC);
        }
    }
}

?>


<!doctype html>
<html>

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
            <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md flex flex-col space-y-4">
                <div class="form-control">
                    <label for="checkin_date" class="label"><span class="label-text">Check-in Date:</span></label>
                    <input type="datetime-local" id="checkin_date" name="checkin_datum" value="<?php echo isset($checkin_datum) ? $checkin_datum : ''; ?>" required class="input input-bordered">
                </div>
                <div class="form-control">
                    <label for="checkuit_date" class="label"><span class="label-text">Check-uit Date:</span></label>
                    <input type="datetime-local" id="checkuit_date" name="checkuit_datum" value="<?php echo isset($checkuit_datum) ? $checkuit_datum : ''; ?>" required class="input input-bordered">
                </div>
                <input type="submit" value="Check Availability" class="btn btn-primary">
            </form>




            <?php if (!empty($available_plaatsen) && isset($_GET["checkin_datum"]) && isset($_GET["checkuit_datum"])) : ?>
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Naam</th>
                                <th>Beschrijving</th>
                                <th>Groot</th>
                                <th>Electriciteit</th>
                                <th>Kosten in €</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($available_plaatsen as $plaats) : ?>
                                <td><?php echo $plaats["id"]; ?></td>
                                <td><?php echo $plaats["naam"] ?></td>
                                <td><?php echo $plaats["beschrijving"]; ?></td>
                                <td><?php if ($plaats["groot"] === 1) {
                                        echo "Yes";
                                    } else {
                                        echo "No";
                                    } ?>
                                </td>
                                <td><?php if ($plaats["electriciteit"] === 1) {
                                        echo "Yes";
                                    } else {
                                        echo "No";
                                    } ?>
                                </td>
                                <td>€ <?php echo $plaats["kosten"]; ?> .-</td>
                                <td>
                                    <?php if (!strlen($_SESSION["id"]) == 0 && isset($_GET["checkin_datum"]) && isset($_GET["checkuit_datum"])) { ?>
                                        <button class="btn btn-ghost btn-xs"><a href="register-boeking.php?plaats_id=<?php echo $plaats["id"]; ?>&checkin_datum=<?php echo urlencode(date('Y-m-d\TH:i', strtotime($_GET["checkin_datum"]))); ?>&checkuit_datum=<?php echo urlencode(date('Y-m-d\TH:i', strtotime($_GET["checkuit_datum"]))); ?>" title="selectPlaats">Select</a></button>
                                    <?php } ?>
                                </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                <?php endif; ?>
                </div>
        </main>
    </div>


</body>

</html>