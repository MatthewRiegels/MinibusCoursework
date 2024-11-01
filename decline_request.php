<?php
header('Location: ' . $_POST['redirectURL']);
include_once('connection.php');

// Display all values for testing
echo('redirectURL: ' . $_POST['redirectURL'] . '<br>');
echo('declinedRequestID: ' . $_POST['declinedRequestID'] . '<br>');
echo('decliningDriverID: ' . $_POST['decliningDriverID'] . '<br>');

$stmt = $conn->prepare('INSERT INTO TblDeclinedDrivers (DriverID, RequestID) VALUES
("' . $_POST['decliningDriverID'] . '", "' . $_POST['declinedRequestID'] . '")');
$stmt->execute();
?>