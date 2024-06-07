<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $checkin_datum = $_GET["checkin_datum"];
    $checkuit_datum = $_GET["checkuit_datum"];

    $query = "SELECT * FROM plaatsen WHERE ID NOT IN (
        SELECT plaats_id FROM plaats_boekingen 
        INNER JOIN boekingen ON plaats_boekingen.boeking_id = boekingen.boekingID 
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
    <title>Nieuwe boeking </title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript" src="js/validation.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include "includes/sidebar.php"; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container-fluid">

                    <div class="row">
                        <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <label for="checkin_date">Check-in Date:</label>
                            <input type="datetime-local" id="checkin_date" name="checkin_datum" value="<?php echo isset($checkin_datum) ? $checkin_datum : ''; ?>" required>
                            <label for="checkuit_date">Check-uit Date:</label>
                            <input type="datetime-local" id="checkuit_date" name="checkuit_datum" value="<?php echo isset($checkuit_datum) ? $checkuit_datum : ''; ?>" required>
                            <input type="submit" value="Check Availability">
                        </form>

                        <?php if (!empty($available_plaatsen)) : ?>
                            <h2>Available Plaatsen:</h2>
                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Naam</th>
                                        <th>Beschrijving</th>
                                        <th>Groot</th>
                                        <th>Electriciteit</th>
                                        <th>Kosten in €</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($available_plaatsen as $plaats) : ?>
                                        <td><?php echo $plaats["ID"]; ?></td>
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
                                            <?php if (!strlen($_SESSION["id"]) == 0) { ?>
                                                <a href="register-boeking.php?plaats_id=<?php echo $plaats["ID"]; ?>&checkin_datum=<?php echo urlencode(date('Y-m-d\TH:i', strtotime($_GET["checkin_datum"]))); ?>&checkuit_datum=<?php echo urlencode(date('Y-m-d\TH:i', strtotime($_GET["checkuit_datum"]))); ?>" title="selectPlaats">Select Plaats</a>&nbsp;&nbsp;
                                            <?php } ?>
                                        </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        <?php endif; ?>

                    </div>
                </div>

            </main>
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
        <script src="js/sidebar.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>