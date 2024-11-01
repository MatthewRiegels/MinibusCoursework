<?php
header('Location: ' . $_POST['redirectURL']);
include_once('connection.php');

// Display all values for testing
// echo('redirectURL: ' . $_POST['redirectURL'] . '<br>');
// echo('acceptedRequestID: ' . $_POST['acceptedRequestID'] . '<br>');
// echo('acceptingDriverID: ' . $_POST['acceptingDriverID'] . '<br>');

$stmt = $conn->prepare('UPDATE TblRequests SET DriverID = "' . $_POST['acceptingDriverID'] . '" WHERE RequestID = "' . $_POST['acceptedRequestID'] . '"');
$stmt->execute();
?>