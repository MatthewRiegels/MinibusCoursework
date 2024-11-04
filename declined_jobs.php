<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 1, 0);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Declined Jobs</title>
        <link rel="stylesheet" href="styles.css">
        <script src="functions.js" type="text/javascript"></script>
    </head>
    <body>
        <!-- Hidden form for scripting purposes - js powered button will add values and submit it -->
        <form id="goToDetailsForm" method="post" action="request_details.php">
            <input type="hidden" name="chosenRequestID" id="hiddenInput">
            <input type="hidden" name="redirectURL" value="declined_jobs.php">
        </form>

        <?php
        // This just prints out the current user's name: "<h1>Ronald Ferret's Declined Jobs</h1>", for example
        echo('<h1>' . $_SESSION['Forename'] . ' ' . $_SESSION['Surname'] . "'s Declined Jobs</h1>");

        $stmt = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                 WHERE EXISTS (SELECT RequestID FROM TblDeclinedDrivers
                                               WHERE TblRequests.RequestID = TblDeclinedDrivers.RequestID AND DriverID = "' . $_SESSION['UserID'] . '")');
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            showRequest($row);
        }
        ?>
    </body>
</html>