<?php
include_once('connection.php');
session_start();

// this function creates a list item out of a TblRequests record
function showRequest($requestData){
    echo(
        '<div class="list-item-container">' . 
        '<div class="date-container">' . $requestData['DateOfJob'] . '</div>' . 
        '<div class="time-container">' . $requestData['TimeOut'] . '-' . $requestData['TimeIn'] . '</div>' . 
        '<div class="purpose-container">' . $requestData['Purpose'] . '</div>' . 
        '<button class="details-button" onclick=\'goToDetails("' . $requestData['RequestID'] . '")\'>--></button>' . 
        '</div>'
    );
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Active Requests</title>
        <link rel="stylesheet" href="styles.css">
        <script type="text/javascript">
            // this js function handles the onclick event to redirect to request_details.php and post the chosen request id and this page's url
            function goToDetails($chosenID){
                document.getElementById('hiddenInput').value = $chosenID;
                document.getElementById('goToDetailsForm').submit();
            }
        </script>
    </head>
    <body>
        <!-- Hidden form for scripting purposes - js powered button will add values and submit it -->
        <form id="goToDetailsForm" method="post" action="request_details.php">
            <input type="hidden" name="chosenRequestID" id="hiddenInput">
            <input type="hidden" name="redirectURL" value="active_requests.php">
        </form>

        <?php
        // This just prints out the current user's name: "<h1>John Smith's Active Requests</h1>", for example
        echo('<h1>' . $_SESSION['Forename'] . ' ' . $_SESSION['Surname'] . "'s Active Requests</h1>");

        // These are jobs which have been assigned a driver and a vehicle (including jobs that are self-driven)
        echo('<h2>Accepted Jobs</h2>');
        $stmt1 = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                 WHERE RequestorID = ' . $_SESSION['UserID'] . ' AND DriverID IS NOT NULL AND VehicleID IS NOT NULL');
        $stmt1->execute();
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
            showRequest($row);
        }

        // Thses are jobs which have not been fully assigned (ie are missing either a driver or a vehicle or both)
        echo('<h2>Pending Jobs</h2>');
        $stmt2 = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                 WHERE RequestorID = ' . $_SESSION['UserID'] . ' AND ( DriverID IS NULL OR VehicleID IS NULL )');
        $stmt2->execute();
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
            showRequest($row);
        }
        ?>
    </body>
</html>