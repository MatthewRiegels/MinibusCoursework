<?php
// This page contains the script called for a driver to accept a request

header('Location: ' . $_POST['redirectURL']);
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 1, 0);

// Display all values for testing
// echo('redirectURL: ' . $_POST['redirectURL'] . '<br>');
// echo('acceptedRequestID: ' . $_POST['acceptedRequestID'] . '<br>');
// echo('acceptingDriverID: ' . $_POST['acceptingDriverID'] . '<br>');

// Update DriverID of the request to match the UserID of the driver
$stmt = $conn->prepare('UPDATE TblRequests SET DriverID = "' . $_POST['acceptingDriverID'] . '" WHERE RequestID = "' . $_POST['acceptedRequestID'] . '"');
$stmt->execute();
$stmt->closeCursor();

// These lines ensure that when a driver accepts a request they've previously declined, they stop declining it
$stmt = $conn->prepare('DELETE FROM TblDeclinedDrivers
WHERE DriverID = "' . $_POST['acceptingDriverID'] . '" AND RequestID = "' . $_POST['acceptedRequestID'] . '"');
$stmt->execute();
?>