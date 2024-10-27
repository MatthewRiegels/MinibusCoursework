<?php
include_once('connection.php');
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Request Details</title>
    </head>
    <body>
        <h1>Request Details</h1>
        <?php
        $stmt = $conn->prepare('SELECT * FROM TblRequests WHERE RequestID = "' . $_POST['chosenRequestID'] . '"');
        $stmt->execute();
        $arr = $stmt->fetch(PDO::FETCH_ASSOC);
        echo('Date: ' . $arr['DateOfJob'] . '<br>');
        echo('Time: ' . $arr['TimeOut'] . '-' . $arr['TimeIn'] . '<br>');
        echo('Destination: ' . $arr['Destination'] . '<br>');
        echo('Postcode: ' . $arr['Postcode'] . '<br>');
        echo('Purpose: ' . $arr['Purpose'] . '<br>');
        echo('Required Capacity: ' . $arr['ReqCapacity'] . '<br');
        ?>
    </body>
</html>