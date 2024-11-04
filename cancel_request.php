<?php
// This is a script page for when a staff member wants to cancel one of their own requests
// This removes a request from TblRequests

header('Location: ' . $_POST['redirectURL']);
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 1, 0, 0);

// Display all values for testing
// echo('redirectURL: ' . $_POST['redirectURL'] . '<br>');
// echo('cancelledRequestID: ' . $_POST['cancelledRequestID'] . '<br>');

$stmt = $conn->prepare('DELETE FROM TblRequests WHERE RequestID = "' . $_POST['cancelledRequestID'] . '"');
$stmt->execute();
?>