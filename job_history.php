<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Job History</title>
        <link rel="stylesheet" href="styles.css">
        <script src="functions.js" type="text/javascript"></script>
    </head>
    <body>
        <!-- Hidden form for scripting purposes - js powered button will add values and submit it -->
        <form id="goToDetailsForm" method="post" action="request_details.php">
            <input type="hidden" name="chosenRequestID" id="hiddenInput">
            <input type="hidden" name="redirectURL" value="job_history.php">
        </form>

        <h1>Job History</h1>

        <?php
        // All requests where DateOfJob <= current date --> all requests which are in the past
        $stmt = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                WHERE DateOfJob <= "' . date('Y-m-d') . '"');
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            showRequest($row);
        }
        ?>

        <br>
        <form method="post" action="clear_old_jobs.php">
            Remove requests from before:
            <?php echo("<input type='date' name='cutoffdate', max='" . date('Y-m-d') . "' required>"); ?>
            <input type="submit" value="Go">
        </form>
    </body>
</html>