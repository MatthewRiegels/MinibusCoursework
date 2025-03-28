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
                </div>
            </div>
        </div>
    </body>
</html>