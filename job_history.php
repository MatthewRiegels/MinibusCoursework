<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Job History</title>
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
                    <h1>Job History</h1>

                    <?php
                    hiddenDetailForm("request_details.php", "job_history.php");

                    // All requests where DateOfJob < current date --> all requests which are in the past
                    $stmt = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                            WHERE DateOfJob < "' . date('Y-m-d') . '"
                                            ORDER BY DateOfJob DESC');
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        showRequest($row);
                    }
                    ?>

                    <br>
                    <form method="post" action="clear_old_jobs.php">
                        Remove requests from before:
                        <?php echo("<input type='date' name='cutoffdate', max='" . date('Y-m-d') . "' required>"); ?>
                        <input type="submit" value="Go">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>