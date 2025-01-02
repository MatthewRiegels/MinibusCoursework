<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Vehicle Overview</title>
        <link rel="stylesheet" href="styles.css">
        <script src="functions.js" type="text/javascript"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    </head>
    <body>
        <div id="viewport">
            <!-- Sidebar -->
            <?php loadSidebar($_SESSION); ?>
            <!-- Content -->
            <div id="content">
                <!-- Navbar -->
                <?php loadNavbar($_SESSION); ?>
                <!-- Stuff on the page -->
                <div class="container-fluid">
                    <h1>Vehicle Overview</h1>

                    <?php
                    hiddenDetailForm("vehicle_details.php", "vehicle_overview.php");

                    $stmt = $conn->prepare('SELECT * FROM TblVehicles
                                            ORDER BY RegNumber');
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        showVehicle($row);
                    }
                    ?>

                    <br><h2>Add new vehicle</h2>
                    <form method="post" action="add_vehicle.php">
                        Reg number:<input type="text" name="RegNumber" minlength="7" maxlength="7" required><br>
                        Capacity:<input type="number" name="Capacity" min="1" required><br>
                        NotAvailableFrom:<input type="date" name="NotAvailableFrom" min="<?php echo(date("Y-m-d")); ?>" required><br>
                        <input type="submit" value="Add Vehicle">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>