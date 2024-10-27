<?php
include_once('connection.php');
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Active Requests</title>
        <style>
            .record-container{
                background-color: #EAECF3;
                border: 2px solid black;
                border-radius: 10px;
                margin: 2px;
                padding: 5px;
                width: 400px;
            }
        </style>
    </head>
    <body>
        <?php
        echo('<h1>' . $_SESSION['Forename'] . ' ' . $_SESSION['Surname'] . "'s Active Requests</h1>");

        echo('<h2>Accepted Jobs</h2>');
        $stmt1 = $conn->prepare('SELECT DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                 WHERE RequestorID = ' . $_SESSION['UserID'] . ' AND DriverID IS NOT NULL AND VehicleID IS NOT NULL');
        $stmt1->execute();
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
            echo('<div class="record-container"><b>' . $row['DateOfJob'] . '</b> <i>' . $row['TimeOut'] . '-' . $row['TimeIn'] . '</i> - ' . $row['Purpose'] . '</div>');
        }

        echo('<h2>Pending Jobs</h2>');
        $stmt2 = $conn->prepare('SELECT DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                 WHERE RequestorID = ' . $_SESSION['UserID'] . ' AND ( DriverID IS NULL OR VehicleID IS NULL )');
        $stmt2->execute();
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
            echo('<div class="record-container"><b>' . $row['DateOfJob'] . '</b> <i>' . $row['TimeOut'] . '-' . $row['TimeIn'] . '</i> - ' . $row['Purpose'] . '</div>');
        }
        ?>
    </body>
</html>