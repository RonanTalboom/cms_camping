<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();
//code for add courses
if (isset($_POST["submit"])) {
    
    header("location:boekingen.php");
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

            <form method="post" class="form-horizontal">
                <?php
                $id = $_GET["id"];
                $ret = "SELECT boekingen.*, klant.naam as klant_naam, plaatsen.naam as plaatsen_naam 
                FROM boekingen 
                INNER JOIN klant ON boekingen.klant_id = klant.id 
                INNER JOIN plaats_boekingen ON boekingen.id = plaats_boekingen.boeking_id
                INNER JOIN plaatsen ON plaats_boekingen.plaats_id = plaatsen.id
                WHERE boekingen.id = ? ";
                $stmt = $conn->prepare($ret);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($row = $res->fetch_object()) { ?>
                    <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md flex flex-col space-y-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Plaats</span>
                            </label>
                            <select class="select select-bordered w-full max-w-xs" aria-label="plaats" name="plaats" readonly>

                                <option value="<?php echo $row->ID; ?>"><?php echo $row->plaatsen_naam; ?></option>
                            </select>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Klant</span>
                            </label>
                            <select class="select select-bordered w-full max-w-xs" aria-label="Kies Klant" name="klantID" readonly>

                                <option value="<?php echo $row->klantID; ?>"><?php echo $row->klant_naam; ?></option>
                            </select>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Boeking Datum</span>
                            </label>
                            <input type="datetime-local" class="input input-bordered" name="boeking_datum" required value="<?php echo $row->boeking_datum; ?>">
                        </div>


                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Check in Datum</span>
                            </label>
                            <input type="datetime-local" class="input input-bordered" name="checkin_datum" value="<?php echo $row->checkin_datum; ?>" readonly>
                        </div>
                        <div class="form-control">
                            <label class="col-sm-2 control-label">Check Uit datum</label>
                            <input type="datetime-local" class="input input-bordered" name="checkuit_datum" value="<?php echo $row->checkuit_datum; ?>" readonly>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Status</span>
                            </label>
                            <select class="select select-bordered w-full max-w-xs" aria-label="Kies Status" name="status" required>
                                <option value="0">Bevestigd</option>
                                <option value="1">In afwachting</option>
                                <option value="2">Geannuleerd</option>
                            </select>

                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Kosten</span>
                            </label>
                            <?php
                            $ret = "select * from tarieven";
                            $stmt = $conn->prepare($ret);
                            $stmt->execute();
                            $res = $stmt->get_result();
                            while ($row = $res->fetch_object()) { ?>
                                <label class="label">

                                    <span class="label-text">
                                        <?php echo $row->beschrijving; ?> €<?php echo $row->kosten; ?>
                                    </span>
                                    <input class="checkbox" type="checkbox" name="tarieven[]" id="tarief-<?php echo $row->ID; ?>" value="<?php echo $row->ID; ?>" />
                                </label>
                            <?php } ?>
                        </div>



                    <?php }
                    ?>
                    <div class="form-control">
                        <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                    </div>

                    </div>

            </form>

        </main>
    </div>
</body>

</html>