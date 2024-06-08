<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
//code for add courses

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
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex min-h-screen">
        <?php include "includes/sidebar.php"; ?>
        <main class="flex-1 p-6">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <?php
                                        $boekingID = $_GET["id"];
                                        $query = "SELECT plaats_boekingen.plaats_id, boekingen.id, boekingen.klant_id, boekingen.checkin_datum, boekingen.checkuit_datum, tarieven.kosten 
                                        FROM plaats_boekingen 
                                        INNER JOIN boekingen ON plaats_boekingen.boeking_id = boekingen.id 
                                        INNER JOIN boeking_tarieven ON boekingen.id = boeking_tarieven.boeking_id 
                                        INNER JOIN tarieven ON boeking_tarieven.tarief_id = tarieven.id
                                        WHERE boekingen.id = ?";
                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param("i", $boekingID);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        $row = $res->fetch_object();
                                        if ($row) {
                                            // Access the data in $row here
                                        ?>
                                            <h2>Reservering #<?php echo $row->id; ?> </h2>
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
                                                    $query = "SELECT * FROM plaatsen WHERE id=?";
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
                                                    $query = "SELECT * FROM klant WHERE id=?";
                                                    $stmt = $conn->prepare($query);
                                                    $stmt->bind_param("i", $row->id);
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
                                                    INNER JOIN boeking_tarieven ON tarieven.id = boeking_tarieven.tarief_id 
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
                                                (Tarieven €<?php echo $total_cost ?> + Plaats kosten €<?php echo $total_plaats ?>)
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