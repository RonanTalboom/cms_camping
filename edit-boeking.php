<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();
//code for add courses
if (isset($_POST["submit"])) {
    $id = $_GET["id"];
    $tarieven = $_POST["tarieven"];
    // Delete old tarieven
    $query = "DELETE FROM boeking_tarieven WHERE boeking_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    // Insert new tarieven
    $query = "INSERT INTO boeking_tarieven (boeking_id, tarief_id, kosten) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    foreach ($tarieven as $tarief_id) {
         // Fetch kosten for the tarief
         $query_kosten = "SELECT kosten FROM tarieven WHERE id = ?";
         $stmt_kosten = $conn->prepare($query_kosten);
         $stmt_kosten->bind_param('i', $tarief_id);
         $stmt_kosten->execute();
         $result_kosten = $stmt_kosten->get_result();
         $kosten = $result_kosten->fetch_object()->kosten;
 
         $stmt->bind_param('iii', $id, $tarief_id, $kosten);
         $stmt->execute();
    }

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

                        <?php
                        // Fetch selected tarieven ids
                        $query = "SELECT tarief_id FROM boeking_tarieven WHERE boeking_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('i', $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $selected_tarieven = array();
                        while ($tarief = $result->fetch_object()) {
                            $selected_tarieven[] = $tarief->tarief_id;
                        }

                        // Fetch all tarieven
                        $query = "SELECT * FROM tarieven";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $tarieven = $stmt->get_result();
                        ?>

                        <!-- Your form fields -->

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Kosten</span>
                            </label>
                            <?php while ($tarief = $tarieven->fetch_object()) { ?>
                                <label class="label">
                                    <span class="label-text">
                                        <?php echo $tarief->beschrijving; ?> €<?php echo $tarief->kosten; ?>
                                    </span>
                                    <input class="checkbox" type="checkbox" name="tarieven[]" id="tarief-<?php echo $tarief->id; ?>" value="<?php echo $tarief->id; ?>" <?php echo in_array($tarief->id, $selected_tarieven) ? 'checked' : ''; ?> />
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