<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 1, 0, 0);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Active Requests</title>
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
                    hiddenDetailForm("request_details.php", "active_requests.php");

                    // This just prints out the current user's name: "<h1>John Smith's Active Requests</h1>", for example
                    echo('<h1>' . $_SESSION['Forename'] . ' ' . $_SESSION['Surname'] . "'s Active Requests</h1>");

                    // These are jobs which have been assigned a driver and a vehicle (including jobs that are self-driven)
                    echo('<h2>Accepted Jobs</h2>');
                    $stmt1 = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests 
                                            WHERE RequestorID = "' . $_SESSION['UserID'] . '" 
                                            AND DriverID IS NOT NULL 
                                            AND VehicleID IS NOT NULL 
                                            AND DateOfJob >= "' . date("Y-m-d") . '" 
                                            ORDER BY DateOfJob');
                    $stmt1->execute();
                    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
                        showRequest($row);
                    }

                    // Thses are jobs which have not been fully assigned (ie are missing either a driver or a vehicle or both)
                    echo('<h2>Pending Jobs</h2>');
                    $stmt2 = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests 
                                            WHERE RequestorID = "' . $_SESSION['UserID'] . '" 
                                            AND ( DriverID IS NULL OR VehicleID IS NULL ) 
                                            AND DateOfJob >= "' . date("Y-m-d") . '" 
                                            ORDER BY DateOfJob');
                    $stmt2->execute();
                    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
                        showRequest($row);
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>