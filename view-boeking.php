<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
//code for add courses
if (isset($_POST["submit"])) {
    $klantID = $_POST["klantID"];
    $boeking_datum = $_POST["boeking_datum"];
    $checkin_datum = $_POST["checkin_datum"];
    $checkuit_datum = $_POST["checkuit_datum"];
    $status = $_POST["status"];
    $boeking_datumd = date("Y-m-d H:i:s", strtotime($boeking_datum));
    $checkin_datumd = date("Y-m-d H:i:s", strtotime($checkin_datum));
    $checkuit_datumd = date("Y-m-d H:i:s", strtotime($checkuit_datum));
    if (isset($_POST["plaats"]) && isset($_POST["tarieven"])) {
        $plaats = $_POST["plaats"];
        $query = "SELECT * FROM `plaats_boekingen` INNER JOIN `boekingen` 
		ON plaats_boekingen.boeking_id = boekingen.boekingID WHERE plaats_id = ? 
		AND ((checkin_datum < ? 
		AND checkuit_datum > ?) 
		OR (checkin_datum < ? 
		AND checkuit_datum > ?) 
		OR (checkin_datum > ? 
		AND checkuit_datum < ?)
		OR (checkin_datum <= ? 
		AND checkuit_datum >= ?))";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "issssssss",
            $plaats,
            $checkin_datumd,
            $checkin_datumd,
            $checkuit_datumd,
            $checkuit_datumd,
            $checkin_datumd,
            $checkuit_datumd,
            $checkin_datumd,
            $checkuit_datumd
        );
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            // The "plaats" has already been booked by a different "boeking" on the selected date
            echo "<script>alert('This plaats has already been booked on the selected date');</script>";
        } else {
            $query =
                "INSERT INTO `boekingen`(`klantID`,`boeking_datum`, `checkin_datum`, `checkuit_datum`, `status`) VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($query);
            $rc = $stmt->bind_param(
                "issss",
                $klantID,
                $boeking_datumd,
                $checkin_datumd,
                $checkuit_datumd,
                $status
            );
            $stmt->execute();
            $boekingID = $conn->insert_id;

            // The "plaats" is available on the selected date
            $query = "INSERT INTO `plaats_boekingen`(`plaats_id`, `boeking_id`) VALUES (?,?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param(
                "ii",
                $plaats,
                $boekingID,
            );
            $stmt->execute();
            foreach ($_POST["tarieven"] as $tarief) {
                $query = "SELECT kosten FROM `tarieven` WHERE ID=?";
                $stmt = $conn->prepare($query);
                $rc = $stmt->bind_param(
                    "i",
                    $tarief
                );
                $stmt->execute();
                $res = $stmt->get_result();
                while ($row = $res->fetch_object()) {
                    $query = "INSERT INTO `boeking_tarieven`(`boekingID`, `tariefID`, `kosten`) VALUES (?,?,?)";
                    $stmt = $conn->prepare($query);
                    $rc = $stmt->bind_param(
                        "iid",
                        $boekingID,
                        $tarief,
                        $row->kosten
                    );
                    $stmt->execute();
                }
            }
            header("location:boekingen.php");
        }
    }
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
    <title>Boeking </title>
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
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <?php
                                            $boekingID = $_GET["id"];
                                            $query = "SELECT plaats_boekingen.plaats_id, boekingen.boekingID, boekingen.klantID, boekingen.checkin_datum, boekingen.checkuit_datum, tarieven.kosten 
                                        FROM plaats_boekingen 
                                        INNER JOIN boekingen ON plaats_boekingen.boeking_id = boekingen.boekingID 
                                        INNER JOIN boeking_tarieven ON boekingen.boekingID = boeking_tarieven.boekingID 
                                        INNER JOIN tarieven ON boeking_tarieven.tariefID = tarieven.ID
                                        WHERE boekingen.boekingID = ?";
                                            $stmt = $conn->prepare($query);
                                            $stmt->bind_param("i", $boekingID);
                                            $stmt->execute();
                                            $res = $stmt->get_result();
                                            $row = $res->fetch_object();
                                            if ($row) {
                                                // Access the data in $row here
                                            ?>
                                                <h2>Reservering #<?php echo $row->boekingID; ?> </h2>
                                        </div>
                                        <div class="panel-body">
                                            <dl class="row">
                                                <dt class="col-sm-3">Check In Tijd</dt>
                                                <dd class="col-sm-9">
                                                    <?php echo $row->checkin_datum; ?>
                                                </dd>
                                                <dt class="col-sm-3">Check Out Tijd</dt>
                                                <dd class="col-sm-9">
                                                    <?php echo $row->checkuit_datum; ?>
                                                </dd>
                                                <dt class="col-sm-3">Plaats informatie</dt>
                                                <dd class="col-sm-9">
                                                    <dl class="row">
                                                        <?php
                                                        $query = "SELECT * FROM plaatsen WHERE ID=?";
                                                        $stmt = $conn->prepare($query);
                                                        $stmt->bind_param("i", $row->plaats_id);
                                                        $stmt->execute();
                                                        $res = $stmt->get_result();
                                                        $plaats = $res->fetch_object();

                                                        ?>
                                                        <dt class="col-sm-3">Naam</dt>
                                                        <dd class="col-sm-9">
                                                            <?php echo $plaats->naam; ?>
                                                        </dd>
                                                        <dt class="col-sm-3">Groot</dt>
                                                        <dd class="col-sm-9">
                                                            <?php if ($plaats->groot === 1) {
                                                                echo "Yes";
                                                            } else {
                                                                echo "No";
                                                            }  ?>
                                                        </dd>
                                                        <dt class="col-sm-3">Electriciteit</dt>
                                                        <dd class="col-sm-9">
                                                            <?php if ($plaats->Electriciteit === 1) {
                                                                echo "Yes";
                                                            } else {
                                                                echo "No";
                                                            }  ?>
                                                        </dd>
                                                        <dt class="col-sm-3">Kosten plaats per dag </dt>
                                                        <dd class="col-sm-9">
                                                            €<?php echo $plaats->kosten; ?>
                                                        </dd>

                                                    </dl>
                                                </dd>
                                                <dt class="col-sm-3">Klant informatie</dt>
                                                <dd class="col-sm-9">
                                                    <dl class="row">
                                                        <?php
                                                        $query = "SELECT * FROM klant WHERE klantID=?";
                                                        $stmt = $conn->prepare($query);
                                                        $stmt->bind_param("i", $row->klantID);
                                                        $stmt->execute();
                                                        $res = $stmt->get_result();
                                                        $klant = $res->fetch_object();

                                                        ?>
                                                        <dt class="col-sm-3">naam</dt>
                                                        <dd class="col-sm-9">
                                                            <?php echo $klant->naam; ?>
                                                        </dd>
                                                        <dt class="col-sm-3">Email</dt>
                                                        <dd class="col-sm-9">
                                                            <?php echo $klant->email; ?>
                                                        </dd>
                                                        <dt class="col-sm-3">Telefoon</dt>
                                                        <dd class="col-sm-9">
                                                            <?php echo $klant->telefoon; ?>
                                                        </dd>
                                                        <dt class="col-sm-3">Adres</dt>
                                                        <dd class="col-sm-9">
                                                            <?php echo $klant->adres; ?>
                                                        </dd>
                                                    </dl>

                                                </dd>

                                                <dt class="col-sm-3">Kosten over Verblijf</dt>
                                                <dd>
                                                <dt class="col-sm-3">Tarieven Per dag</dt>
                                                <dd class="col-sm-9">

                                                    <dl class="row">
                                                        <?php
                                                        $query = "SELECT tarieven.beschrijving, tarieven.kosten FROM tarieven 
                                                    INNER JOIN boeking_tarieven ON tarieven.ID = boeking_tarieven.tariefID 
                                                    WHERE boeking_tarieven.boekingID = ?";
                                                        $stmt = $conn->prepare($query);
                                                        $stmt->bind_param("i", $boekingID);
                                                        $stmt->execute();
                                                        $res = $stmt->get_result();
                                                        $daily_cost = 0;
                                                        while ($kosten = $res->fetch_object()) {
                                                        ?>
                                                            <dt class="col-sm-3">Beschrijving</dt>
                                                            <dd class="col-sm-9">
                                                                <?php echo $kosten->beschrijving; ?>
                                                            </dd>
                                                            <dt class="col-sm-3">Kosten</dt>
                                                            <dd class="col-sm-9">
                                                                €<?php echo $kosten->kosten; ?>
                                                            </dd>
                                                        <?php
                                                            $daily_cost += $kosten->kosten;
                                                        }

                                                        ?>
                                                        <dt class="col-sm-3">Totaal kosten per dag</dt>
                                                        <dd class="col-sm-9">
                                                            
                                                            €<?php $checkin = new DateTime($row->checkin_datum);
                                                                $checkout = new DateTime($row->checkuit_datum);
                                                                $interval = $checkin->diff($checkout);

                                                                $total_days = $interval->days;
                                                                $total_cost = $total_days * $daily_cost;
                                                                echo $daily_cost
                                                                ?>
                                                        </dd>
                                                    </dl>
                                                </dd>
                                                <dt class="col-sm-3">Totaal kosten over verblijf</dt>
                                                <dd class="col-sm-9">
                                                    €<?php $total_plaats = $plaats->kosten * $total_days;
                                                        echo $total_cost + $total_plaats; ?>
                                                         (Tarieven €<?php echo $total_cost ?> + Plaats kosten €<?php echo $total_plaats?>)
                                                </dd>
                                                </dd>


                                            </dl>

                                        <?php }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

    </script>
</body>

</html>