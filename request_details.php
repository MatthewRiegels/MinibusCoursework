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
        // Request details
        $stmt = $conn->prepare('SELECT * FROM TblRequests WHERE RequestID = "' . $_POST['chosenRequestID'] . '"');
        $stmt->execute();
        $requestArr = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        echo('Date: ' . $requestArr['DateOfJob'] . '<br>');
        echo('Time: ' . $requestArr['TimeOut'] . '-' . $requestArr['TimeIn'] . '<br>');
        echo('Destination: ' . $requestArr['Destination'] . '<br>');
        echo('Postcode: ' . $requestArr['Postcode'] . '<br>');
        echo('Purpose: ' . $requestArr['Purpose'] . '<br>');
        echo('Required Capacity: ' . $requestArr['ReqCapacity'] . '<br>');

        // Requestor information
        $stmt = $conn->prepare('SELECT * FROM TblUsers WHERE UserID = "' . $requestArr['RequestorID'] . '"');
        $stmt->execute();
        $requestorArr = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        echo('<br><b>Requested by ' . $requestorArr['Forename'] . ' ' . $requestorArr['Surname'] . '</b><br>');
        echo('Email: ' . $requestorArr['Email'] . '<br>');
        echo('Telephone: ' . $requestorArr['TelephoneNumber'] . '<br>');

        // Driver information
        if ($requestArr['DriverID'] == null){
            echo('<br><b>Pending driver assignment</b><br>');
        }
        elseif ($requestArr['DriverID'] == $requestArr['RequestorID']){
            echo('<br><b>No driver required</b><br>');
        }
        else{
            $stmt = $conn->prepare('SELECT * FROM TblUsers WHERE UserID = "' . $requestArr['DriverID'] . '"');
            $stmt->execute();
            $driverArr = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            echo('<br><b>Driven by ' . $driverArr['Forename'] . ' ' . $driverArr['Surname'] . '</b><br>');
            echo('Email: ' . $driverArr['Email'] . '<br>');
            echo('Telephone: ' . $driverArr['TelephoneNumber'] . '<br>');
        }

        // Vehicle information
        if ($requestArr['VehicleID'] == null){
            echo('<br><b>Pending vehicle assignment</b><br>');
        }
        else{
            $stmt = $conn->prepare('SELECT * FROM TblVehicles WHERE VehicleID = "' . $requestArr['VehicleID'] . '"');
            $stmt->execute();
            $vehicleArr = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            echo('<br><b>Vehicle assigned:</b><br>');
            echo('Reg: ' . $vehicleArr['RegNumber'] . '<br>');
        }
        ?>
    </body>
</html>