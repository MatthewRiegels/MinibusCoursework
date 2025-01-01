<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Pending Requests</title>
        <link rel="stylesheet" href="styles.css">
        <script src="functions.js" type="text/javascript"></script>
    </head>
    <body>
        <h1>Pending Requests</h1>

        <?php
        hiddenDetailForm("request_details.php", "pending_requests_admin.php");

        // All requests where DriverID is null --> all requests which need a driver and don't have one
        // All requests where VehicleID is null --> all requests which need a vehicle and don't have one
        $stmt = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                WHERE DriverID IS NULL OR VehicleID IS NULL
                                ORDER BY DateOfJob');
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            showRequest($row);
        }
        ?>
    </body>
</html>