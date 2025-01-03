<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Pending Requests</title>
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
                    <h1>Pending Requests</h1>

                    <?php
                    hiddenDetailForm("request_details.php", "pending_requests_admin.php");

                    // All requests where DriverID is null --> all requests which need a driver and don't have one
                    // All requests where VehicleID is null --> all requests which need a vehicle and don't have one
                    $stmt = $conn->prepare('SELECT RequestID, DateOfJob, Purpose FROM TblRequests
                                            WHERE DriverID IS NULL OR VehicleID IS NULL
                                            AND DateOfJob >= "' . date("Y-m-d") . '"
                                            ORDER BY DateOfJob');
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        showRequestAlternative($row, $conn);
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>