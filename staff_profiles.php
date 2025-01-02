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
                    <h1>Staff Member Profiles</h1>

                    <?php
                    hiddenDetailForm("user_details.php", "staff_profiles.php");

                    // Fetching & displaying list of records from TblUsers
                    $stmt = $conn->prepare('SELECT UserID, Forename, Surname, Email FROM TblUsers
                                            WHERE IsRequestor = 1
                                            ORDER BY Surname');
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        showStaffMember($row);
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>