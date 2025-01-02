<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 1, 0);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Accepted Jobs</title>
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
                    hiddenDetailForm("request_details.php", "accepted_jobs.php");

                    // This just prints out the current user's name: "<h1>Ronald Ferret's Accepted Jobs</h1>", for example
                    echo('<h1>' . $_SESSION['Forename'] . ' ' . $_SESSION['Surname'] . "'s Accepted Jobs</h1>");

                    $stmt = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                            WHERE DriverID = "' . $_SESSION['UserID'] . '"
                                            ORDER BY DateOfJob');
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        showRequest($row);
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>