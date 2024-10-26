<?php
include_once('connection.php');
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Active Requests</title>
    </head>
    <body>
        <?php
        echo("<h1>" . $_SESSION['Forename'] . ' ' . $_SESSION['Surname'] . "'s Active Requests</h1>");
        $stmt = $conn->prepare('SELECT DateOfJob, TimeOut, TimeIn, Purpose FROM TblRequests WHERE RequestorID = ' . $_SESSION['UserID']);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo($row['DateOfJob'] . ' ' . $row['TimeOut'] . '-' . $row['TimeIn'] . ' - ' . $row['Purpose'] . '<br>');
        }
        ?>
    </body>
</html>