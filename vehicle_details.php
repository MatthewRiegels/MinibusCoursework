<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Vehicle Details</title>
        <link rel="stylesheet" href="styles.css">
        <script src="functions.js" type="text/javascript"></script>
    </head>
    <body>
        <a href="<?php echo($_POST['redirectURL']); ?>">Back to previous page</a>
        <h1>Vehicle Details</h1>
        <?php
        // Fetch vehicle details from database
        $stmt = $conn->prepare('SELECT * FROM TblVehicles WHERE VehicleID = "' . $_POST["chosenID"] . '"');
        $stmt->execute();
        $vehicleArr = $stmt->fetch(PDO::FETCH_ASSOC);
        echo('Reg Number: ' . $vehicleArr['RegNumber'] . '<br>');
        echo('Capacity: ' . $vehicleArr['Capacity'] . '<br>');
        echo('NotAvailableFrom: ' . $vehicleArr['NotAvailableFrom'] . '<br>');
        ?>
        
        <!-- edit last available date -->
        <br>
        <b>Edit last available date</b>
        <form method="post" action="edit_vehicle_date.php">
            New date: <input type="date" name="newVehicleDate" min="<?php echo(date('Y-m-d')); ?>">
            <input type="hidden" name="editedVehicleID" value="<?php echo($_POST['chosenID']); ?>">
            <input type="submit" value="Edit">
        </form>

        <!-- remove the vehicle from the fleet -->
        <br>
        <b>Remove vehicle from the fleet</b>
        <form method="post" action="remove_vehicle.php">
            <input type="hidden" name="removedVehicleID" value="<?php echo($_POST['chosenID']); ?>">
            <input type="submit" value="Go">
        </form>
    </body>
</html>