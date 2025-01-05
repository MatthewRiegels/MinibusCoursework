<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 0);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Request Details</title>
        <link rel="stylesheet" href="styles.css">
        <script src="functions.js" type="text/javascript"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    </head>
    <body>
        <div id="viewport">
            <!-- Sidebar -->
            <?php loadSidebar($_SESSION); ?>
            <!-- Content -->
            <div id="content">
                <!-- Navbar -->
                <?php loadNavbar($_SESSION); ?>
                <!-- Stuff on the page -->
                <div class="container-fluid">
                    <?php
                    hiddenDetailForm('user_details.php', $_POST['redirectURL']);
                    echo('<a href="' . $_POST['redirectURL'] . '">Back to previous page</a>');

                    // Fetch the request record from TblRequests
                    $stmt = $conn->prepare('SELECT * FROM TblRequests WHERE RequestID = "' . $_POST['chosenID'] . '"');
                    $stmt->execute();
                    $requestArr = $stmt->fetch(PDO::FETCH_ASSOC);
                    $stmt->closeCursor();

                    // Declined request message box
                    $numDrivers = countDrivers($conn);
                    $numDeclinedDrivers = countDeclinedDrivers($_POST['chosenID'], $conn);
                    if ($numDrivers == $numDeclinedDrivers){
                        echo('<br><br>
                            <div class="alert alert-danger">
                                <strong>This request has been declined by all drivers.</strong>
                        ');
                        if ($_SESSION['UserID'] == $requestArr['RequestorID']){// Include explanation/direction message for staff members only
                            echo('
                                This means that none of our drivers are available at this time and so we cannot fulfill your request.
                                Please make another request at a different date and time and we can try to accomodate you.
                                You can cancel this request with the button below.
                            ');
                        }
                        echo('
                            </div>
                        ');
                    }
                    // Ignored request message box (pending requests past their date)
                    // This if statement essentially says if ((in the past) and (is still pending)) --> show message
                    else if (($requestArr['DateOfJob'] <= date('Y-m-d')) && ($requestArr['DriverID'] == null || $requestArr['VehicleID'] == null)){
                        echo('<br><br>
                            <div class="alert alert-danger">
                                <strong>This request has past its departure date without being assigned a driver and vehicle.</strong>
                        ');
                        if ($_SESSION['UserID'] == $requestArr['RequestorID']){// Include explanation/direction message for staff members only
                            echo('
                                This means that either none of our drivers volunteered for this job, or that no vehicle was available at the requested time.
                                Please make another request at a different date and time and we can try to accomodate you.
                                You can cancel this request with the button below.
                            ');
                        }
                        echo('
                            </div>
                        ');
                    }

                    // Page heading
                    echo('<h1>Request Details</h1>');

                    // Display request details
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

                    // Cancellling request (only available to requestor of this request, or admin)
                    if($_SESSION['UserID'] == $requestArr['RequestorID'] || $_SESSION['IsAdmin'] == 1){// If the current user is the requestor of this job or is admin
                        echo('<br>');
                        // Create a hidden form with only the submit button visible
                        // Inputs are autofilled: ID of request to be cancelled, and URL of previous page for redirecting
                        echo('<form id="cancelRequestForm" method="post" action="cancel_request.php">');
                        echo('<input type="hidden" name="cancelledRequestID" value="' . $_POST['chosenID'] . '">');
                        echo('<input type="hidden" name="redirectURL" value="' . $_POST['redirectURL'] . '">');
                        echo('<input class="cancel-request-submit-button" type="submit" value="Cancel request">');
                        echo('</form>');
                    }

                    // Accepting request (only available to drivers, and only if this request is pending driver assignment)
                    if($_SESSION['IsDriver'] == 1 && $requestArr['DriverID'] == null){// If the current user is a driver AND this request is pending driver assignment
                        echo('<br>');
                        // Create a hidden form with only the submit button visible
                        // Inputs are autofilled: ID of request to be accepted, ID of driver accepting it, and URL of previous page for redirecting
                        echo('<form id="acceptRequestForm" method="post" action="accept_request.php">');
                        echo('<input type="hidden" name="acceptedRequestID" value="' . $_POST['chosenID'] . '">');
                        echo('<input type="hidden" name="acceptingDriverID" value="' . $_SESSION['UserID'] . '">');
                        echo('<input type="hidden" name="redirectURL" value="' . $_POST['redirectURL'] . '">');
                        echo('<input class="accept-request-submit-button" type="submit" value="Accept request">');
                        echo('</form>');
                    }

                    // Declining request (only available to drivers who haven't declined the request already)
                    // This query is for determining whether the current user has declined this request
                    $stmt = $conn->prepare('SELECT * FROM TblDeclinedDrivers
                                            WHERE DriverID = "' . $_SESSION['UserID'] . '"
                                            AND  RequestID = "' . $_POST['chosenID'] . '"');
                    $stmt->execute();
                    $arr = $stmt->fetch(PDO::FETCH_ASSOC);// If this array is empty, there is no record on TblDeclinedDrivers with this UserID and RequestID
                    $stmt->closeCursor();
                    if($_SESSION['IsDriver'] == 1 && empty($arr)){// If the current user is a driver AND the current user has not declined this request
                        echo('<br>');
                        // Create a hidden form with only the submit button visible
                        // Inputs are autofilled: ID of request to be declined, ID of driver declining it, and URL of this page for redirecting
                        echo('<form id="declineRequestForm" method="post" action="decline_request.php">');
                        echo('<input type="hidden" name="declinedRequestID" value="' . $_POST['chosenID'] . '">');
                        echo('<input type="hidden" name="decliningDriverID" value="' . $_SESSION['UserID'] . '">');
                        echo('<input type="hidden" name="redirectURL" value="' . $_POST['redirectURL'] . '">');
                        echo('<input class="decline-request-submit-button" type="submit" value="Decline request">');
                        echo('</form>');
                    }

                    // Admin & driver view of which drivers have declined this job
                    // This query fetches all drivers that have declined this request
                    $stmt = $conn->prepare('SELECT UserID, Forename, Surname, TelephoneNumber, HoursWorked FROM TblUsers
                                            WHERE EXISTS (SELECT DriverID FROM TblDeclinedDrivers
                                                          WHERE TblUsers.UserID = TblDeclinedDrivers.DriverID
                                                          AND RequestID = "' . $_POST['chosenID'] . '")
                                            ORDER BY Surname');
                    $stmt->execute();
                    $arr = $stmt->fetch(PDO::FETCH_ASSOC);// If this array is empty, no drivers have declined this request

                    // If no driver assigned AND there is at least one driver that has declined this request AND the current user is an admin or driver
                    // Then show a list of drivers that have declined this request
                    if(($requestArr['DriverID'] == null) && (!empty($arr)) && ($_SESSION['IsAdmin'] == 1 || $_SESSION['IsDriver'] == 1)){
                        echo('<br><b>Declined by:</b>');
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            showDriver($row);
                        }
                    }
                    $stmt->closeCursor();

                    // List of drivers that have not reacted to the request
                    // This query fetches a list of all drivers that have not declined the request and have not accepted the request
                    $stmt = $conn->prepare('SELECT UserID, Forename, Surname, TelephoneNumber, HoursWorked FROM TblUsers
                                            WHERE NOT EXISTS (SELECT DriverID FROM TblDeclinedDrivers
                                                              WHERE TblUsers.UserID = TblDeclinedDrivers.DriverID
                                                              AND TblDeclinedDrivers.RequestID = "' . $_POST['chosenID'] . '")
                                            AND UserID != "' . $requestArr['DriverID'] . '"
                                            AND IsDriver = 1
                                            ORDER BY Surname');
                    $stmt->execute();
                    $arr = $stmt->fetch(PDO::FETCH_ASSOC);
                    if(($requestArr['DriverID'] == null) && (!empty($arr)) && ($_SESSION['IsAdmin'] == 1 || $_SESSION['IsDriver'] == 1)){
                        echo('<br><b>Request not viewed by:</b>');
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            showDriver($row);
                        }
                    }
                    $stmt->closeCursor();

                    // Vehicle assignment
                    // This is the section where Kristian selects a vehicle to assign to this request
                    // IF ((current user is admin) AND (Vehicle is not assigned) THEN ...
                    if (($_SESSION['IsAdmin'] == 1) && ($requestArr['VehicleID'] == null)){
                        // Breakdown of this query: vehicles selected follow:
                        //     Vehicle capacity is at least equal to the requested capacity of the job
                        //     The job's date is before the vehicle's NotAvailableFrom date
                        //     Exclude all vehicles that have requests assigned to them for which:
                        //         The date is the same as this request's date
                        //         This request's TimeOut is in between that request's TimeOut and TimeIn
                        //         This request's TimeIn is in between that request's TimeOut and TimeIn
                        $stmt = $conn->prepare('SELECT VehicleID, RegNumber, Capacity FROM TblVehicles
                                                WHERE Capacity >= "' . $requestArr['ReqCapacity'] . '"
                                                AND NotAvailableFrom > "' . $requestArr['DateOfJob'] . '"
                                                AND NOT EXISTS (
                                                                SELECT VehicleID FROM TblRequests
                                                                WHERE TblRequests.VehicleID = TblVehicles.VehicleID
                                                                AND DateOfJob = "' . $requestArr['DateOfJob'] . '"
                                                                AND (
                                                                     (TimeOut > "' . $requestArr['TimeOut'] . '" AND TimeOut < "' . $requestArr['TimeIn'] . '")
                                                                     OR (TimeIn > "' . $requestArr['TimeOut'] . '" AND TimeIn < "' . $requestArr['TimeIn'] . '")
                                                                     )
                                                                )
                                                ORDER BY Capacity
                                                ');
                        $stmt->execute();
                        // Form code for selecting vehicle
                        echo('
                            <br>
                            <form method="post" action="assign_vehicle.php">
                                <b>Assign vehicle:</b>
                                <select name="assignedVehicleID">
                                    <option value="null">Select a vehicle</option>
                        ');
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){// Iterate over the records returned by the query and make a dropdown option for each
                            echo(
                                    '<option value="' . $row['VehicleID'] . '">' . $row['RegNumber'] . ', Capacity ' . $row['Capacity'] . '</option>'
                            );
                        }
                        echo('
                                </select>
                                <input type="hidden" name="assignedRequestID" value="' . $_POST['chosenID'] . '">
                                <input type="hidden" name="redirectURL" value="' . $_POST['redirectURL'] . '">
                                <input type="submit" value="Go">
                            </form>
                        ');
                        $stmt->closeCursor();
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>