<?php
include_once('connection.php');
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Request Details</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <a href="<?php echo($_POST['redirectURL']); ?>">Back to previous page</a>
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
        if ($requestArr['DriverID'] == null){// DriverID is null --> driver is required but has not yet been assigned
            echo('<br><b>Pending driver assignment</b><br>');
        }
        elseif ($requestArr['DriverID'] == $requestArr['RequestorID']){// DriverID = RequestorID --> this job is self-driven ie no driver requeired
            echo('<br><b>No driver required</b><br>');
        }
        else{// DriverID has a value but not RequestorID --> this must be an ID of a driver --> driver has been assigned
            $stmt = $conn->prepare('SELECT * FROM TblUsers WHERE UserID = "' . $requestArr['DriverID'] . '"');
            $stmt->execute();
            $driverArr = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            echo('<br><b>Driven by ' . $driverArr['Forename'] . ' ' . $driverArr['Surname'] . '</b><br>');
            echo('Email: ' . $driverArr['Email'] . '<br>');
            echo('Telephone: ' . $driverArr['TelephoneNumber'] . '<br>');
        }

        // Vehicle information
        if ($requestArr['VehicleID'] == null){// VehicleID is null --> vehicle has not yet been assigned
            echo('<br><b>Pending vehicle assignment</b><br>');
        }
        else{// VehicleID has a value --> vehicle has been assigned
            $stmt = $conn->prepare('SELECT * FROM TblVehicles WHERE VehicleID = "' . $requestArr['VehicleID'] . '"');
            $stmt->execute();
            $vehicleArr = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            echo('<br><b>Vehicle assigned:</b><br>');
            echo('Reg: ' . $vehicleArr['RegNumber'] . '<br>');
        }

        // Cancellling request (only available to requestor of this request)
        if($_SESSION['UserID'] == $requestArr['RequestorID'] || $_SESSION['IsAdmin'] == 1){// If the current user is the requestor of this job or is admin
            echo('<br>');
            // Create a hidden form with only the submit button visible
            // Inputs are autofilled: ID of request to be cancelled, and URL of previous page for redirecting
            echo('<form id="cancelRequestForm" method="post" action="cancel_request.php">');
            echo('<input type="hidden" name="cancelledRequestID" value="' . $_POST['chosenRequestID'] . '">');
            echo('<input type="hidden" name="redirectURL" value="' . $_POST['redirectURL'] . '">');
            echo('<input class="cancel-request-submit-button" type="submit" value="Cancel request">');
            echo('</form>');
        }
        ?>
    </body>
</html>