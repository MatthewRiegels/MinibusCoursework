<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Driver Profiles</title>
        <link rel="stylesheet" href="styles.css">
        <script src="functions.js" type="text/javascript"></script>
    </head>
    <body>
        <!-- Hidden form for scripting purposes - js powered button will add values and submit it -->
        <form id="goToDetailsForm" method="post" action="user_details.php">
            <input type="hidden" name="chosenUserID" id="hiddenInput">
            <input type="hidden" name="redirectURL" value="driver_profiles.php">
        </form>

        <h1>Driver Profiles</h1>

        <?php
        // Fetching & displaying list of records from TblUsers
        $stmt = $conn->prepare('SELECT UserID, Forename, Surname, TelephoneNumber, HoursWorked FROM TblUsers WHERE IsDriver = 1');
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            showDriver($row);
        }
        ?>
    </body>
</html>