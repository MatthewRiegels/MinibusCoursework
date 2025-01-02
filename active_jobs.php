<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Active Jobs</title>
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
                    <h1>Active Jobs</h1>
                    <?php
                    hiddenDetailForm("request_details.php", "active_jobs.php");
                    
                    // All requests where DriverID is not null --> all requests which have a driver (or are self-driven)
                    // All requests where VehicleID is not null --> all requests which have been assigned a vehicle
                    $stmt = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                            WHERE DriverID IS NOT NULL AND VehicleID IS NOT NULL
                                            AND DateOfJob >= "' . date("Y-m-d") . '"
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