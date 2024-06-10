<?php
session_start();
include "includes/config.php";
include "includes/checklogin.php";
check_login();

if (isset($_POST["submit"])) {
    $beschrijving = $_POST["beschrijving"];
    $naam = $_POST["naam"];
    $kosten = $_POST["kosten"];
    $groot = $_POST["groot"];
    $grooti = 0;
    if ($groot) {
        $grooti = 1;
    }
    $electriciteit = $_POST["electriciteit"];
    $electriciteiti = 0;
    if ($electriciteit) {
        $electriciteiti = 1;
    }
    $id = $_GET["id"];
    $query =
        "update plaatsen set naam=?, beschrijving=?, groot=?, electriciteit=?, kosten=? where ID=?";
    $stmt = $conn->prepare($query);
    $rc = $stmt->bind_param("ssiidi", $naam, $beschrijving, $grooti, $electriciteiti, $kosten,  $id);
    $stmt->execute();
    echo "<script>alert('plaats has been Updated successfully');</script>";
    header("location:plaatsen.php");
}
?>
<!doctype html>
<html lang="en" data-theme="lemonade">
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

            <form method="post" class="form-horizontal">
                <?php
                $id = $_GET["id"];
                $ret = "select * from plaatsen where id=?";
                $stmt = $conn->prepare($ret);
                $stmt->bind_param("i", $id);
                $stmt->execute(); //ok
                $res = $stmt->get_result();
                while ($row = $res->fetch_object()) { ?>
                    <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md flex flex-col space-y-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Naam</span>
                            </label>
                            <input type="text" class="input input-bordered" name="naam" required="required" value="<?php echo $row->naam; ?>">
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Beschrijving</span>
                            </label>
                            <textarea class="textarea textarea-bordered" name="beschrijving" required="required"><?php echo $row->beschrijving; ?></textarea>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <input type="checkbox" class="checkbox checkbox-primary" name="groot" id="groot" <?php echo $row->groot === 1 ? 'checked' : ''; ?>>
                                <span class="label-text">Kleine / Grote plaats</span>
                            </label>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <input type="checkbox" class="checkbox checkbox-primary" name="electriciteit" id="electriciteit" <?php echo $row->electriciteit === 1 ? 'checked' : ''; ?>>
                                <span class="label-text">Electriciteit</span>
                            </label>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Kosten in E</span>
                            </label>
                            <div class="relative">
                                <input type="number" step="0.01" class="input input-bordered pr-12" name="kosten" value="<?php echo $row->kosten; ?>">
                                <span class="absolute top-0 right-0 rounded-r-md">
                                    <button class="btn btn-square btn-ghost" disabled>€</button>
                                </span>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <div class="form-control">
                        <input type="submit" class="btn btn-primary" value="submit" name="submit">
                    </div>
                    </div>

            </form>
        </main>
    </div>
</body>

</html>