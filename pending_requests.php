<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 1, 0);
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
        hiddenDetailForm("request_details.php", "pending_requests.php");

        // All requests where DriverID is null --> all requests which need a driver and don't have one
        // And RequestID is not one that the user has declined already
        $stmt = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests WHERE DriverID IS NULL
                                AND RequestID NOT IN (SELECT RequestID FROM TblDeclinedDrivers WHERE DriverID = "' . $_SESSION['UserID'] . '")');
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            showRequest($row);
        }
        ?>
    </body>
</html>