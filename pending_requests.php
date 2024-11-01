<?php
include_once('connection.php');
include_once('functions.php');
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Pending Requests</title>
        <link rel="stylesheet" href="styles.css">
        <script src="functions.js" type="text/javascript"></script>
    </head>
    <body>
        <!-- Hidden form for scripting purposes - js powered button will add values and submit it -->
        <form id="goToDetailsForm" method="post" action="request_details.php">
            <input type="hidden" name="chosenRequestID" id="hiddenInput">
            <input type="hidden" name="redirectURL" value="pending_requests.php">
        </form>

        <h1>Pending Requests</h1>

        <?php
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