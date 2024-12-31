<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Staff Member Profiles</title>
        <link rel="stylesheet" href="styles.css">
        <script src="functions.js" type="text/javascript"></script>
    </head>
    <body>
        <h1>Staff Member Profiles</h1>

        <?php
        hiddenDetailForm("user_details.php", "staff_profiles.php");

        // Fetching & displaying list of records from TblUsers
        $stmt = $conn->prepare('SELECT UserID, Forename, Surname, Email FROM TblUsers WHERE IsRequestor = 1');
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            showStaffMember($row);
        }
        ?>
    </body>
</html>