<?php
include_once('connection.php');
session_start();

function showRequest($requestData){
    echo(
        '<div class="request-container">' . 
        '<div class="date-container">' . $requestData['DateOfJob'] . '</div>' . 
        '<div class="time-container">' . $requestData['TimeOut'] . '-' . $requestData['TimeIn'] . '</div>' . 
        '<div class="purpose-container">' . $requestData['Purpose'] . '</div>' . 
        '</div>'
    );
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Active Requests</title>
        <style>
            .request-container{
                background-color: #EAECF3;
                border: 2px solid black;
                border-radius: 10px;
                margin: 2px;
                padding: 5px;
                width: 380px;
            }
            .date-container{
                font-weight: bold;
                width: fit-content;
                display:inline-block;
                margin-right: 10px;
            }
            .time-container{
                font-style: italic;
                width: fit-content;
                display:inline-block;
                margin-right: 10px;
            }
            .purpose-container{
                width: fit-content;
                display:inline-block;
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
            showRequest($row);
        }

        echo('<h2>Pending Jobs</h2>');
        $stmt2 = $conn->prepare('SELECT DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                 WHERE RequestorID = ' . $_SESSION['UserID'] . ' AND ( DriverID IS NULL OR VehicleID IS NULL )');
        $stmt2->execute();
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
            showRequest($row);
        }
        ?>
    </body>
</html>