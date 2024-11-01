<?php
include_once('connection.php');
session_start();

// This function creates a list item out of a TblRequests record
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
        <title>Pending Requests</title>
        <link rel="stylesheet" href="styles.css">
        <script type="text/javascript">
            // This js function handles the onclick event to redirect to request_details.php and post the chosen request id and this page's url
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
            <input type="hidden" name="redirectURL" value="pending_requests.php">
        </form>

        <h1>Pending Requests</h1>

        <?php
        // All requests where DriverID is null --> all requests which need a driver and don't have one
        $stmt = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests WHERE DriverID IS NULL');
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            showRequest($row);
        }
        ?>
    </body>
</html>