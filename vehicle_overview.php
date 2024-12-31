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
    </head>
    <body>
        <h1>Vehicle Overview</h1>

        <?php
        hiddenDetailForm("vehicle_details.php", "vehicle_overview.php");

        $stmt = $conn->prepare('SELECT * FROM TblVehicles');
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            showVehicle($row);
        }
        ?>

        <br>
        <form method="post" action="add_vehicle.php">
            Reg number:<input type="text" name="RegNumber" minlength="7" maxlength="7" required><br>
            Capacity:<input type="number" name="Capacity" min="1" required><br>
            NotAvailableFrom:<input type="date" name="NotAvailableFrom" min="<?php echo(date("Y-m-d")); ?>" required><br>
            <input type="submit" value="Add Vehicle">
        </form>
    </body>
</html>