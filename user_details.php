<?php
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 0);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Details</title>
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
                    <a href="<?php echo($_POST['redirectURL']); ?>">Back to previous page</a>

                    <?php
                    hiddenDetailForm("request_details.php", $_POST["redirectURL"]);

                    // Fetch and display record data from TblUsers
                    $stmt = $conn->prepare('SELECT * FROM TblUsers WHERE UserID = "' . $_POST["chosenID"] . '"');
                    $stmt->execute();
                    $arr = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo("<h1>" . $arr["Forename"] . " " . $arr["Surname"] . "'s details</h1>");
                    echo("Email: " . $arr["Email"] . "<br>");
                    echo("Tel: " . $arr["TelephoneNumber"] . "<br>");
                    if ($arr["IsDriver"] == 1) {
                        echo("Unpaid Hours: " . $arr["HoursWorked"] . "<br>");
                    }
                    
                    // Admin-only section
                    if ($_SESSION["IsAdmin"] == 1) {
                        // Driver-only section
                        if ($arr["IsDriver"] == 1) {
                            // Resetting a driver's unpaid hours
                            echo("
                                <br>
                                <form method='post' action='reset_driver_hours.php'>
                                    <input type='hidden' name='resetDriverID' value='" . $arr["UserID"] . "'>
                                    <input type='hidden' name='redirectURL' value='" . $_POST["redirectURL"] . "'>
                                    <b>Reset unpaid hours:</b> <input type='submit' value='Go'>
                                </form>
                            ");

                            // Listing all future jobs assigned to this driver
                            echo("<br><b>" . $arr["Forename"] . " " . $arr["Surname"] . "'s assigned jobs</b>");
                            $stmt = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                                    WHERE DriverID = "' . $_POST["chosenID"] . '"
                                                    AND DateOfJob >= "' . date("Y-m-d") . '"
                                                    ORDER BY DateOfJob');
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                showRequest($row);
                            }

                            // Listing all past jobs driven by this driver
                            echo("<br><b>" . $arr["Forename"] . " " . $arr["Surname"] . "'s job history</b>");
                            $stmt = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                                    WHERE DriverID = "' . $_POST["chosenID"] . '"
                                                    AND DateOfJob < "' . date("Y-m-d") . '"
                                                    ORDER BY DateOfJob DESC');
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                showRequest($row);
                            }
                        }

                        // Staff member-only section
                        if ($arr["IsRequestor"] == 1){
                            // Listing all the staff member's current requests
                            echo("<br><b>" . $arr["Forename"] . " " . $arr["Surname"] . "'s current requests</b>");
                            $stmt = $conn->prepare('SELECT RequestID, DateOfJob, Purpose FROM TblRequests
                                                    WHERE RequestorID = "' . $_POST["chosenID"] . '"
                                                    AND DateOfJob >= "' . date("Y-m-d") . '"
                                                    ORDER BY DateOfJob');
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                showRequestAlternative($row);
                            }

                            // Listing the staff member's request history
                            echo("<br><b>" . $arr["Forename"] . " " . $arr["Surname"] . "'s request history</b>");
                            $stmt = $conn->prepare('SELECT RequestID, DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests
                                                    WHERE RequestorID = "' . $_POST["chosenID"] . '"
                                                    AND DateOfJob < "' . date("Y-m-d") . '"
                                                    ORDER BY DateOfJob DESC');
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                showRequest($row);
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>