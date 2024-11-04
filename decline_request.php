<?php
// This is a script page for a driver declining a request

header('Location: ' . $_POST['redirectURL']);
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 1, 0);

// Display all values for testing
// echo('redirectURL: ' . $_POST['redirectURL'] . '<br>');
// echo('declinedRequestID: ' . $_POST['declinedRequestID'] . '<br>');
// echo('decliningDriverID: ' . $_POST['decliningDriverID'] . '<br>');

// Adds a new record to TblDeclinedDrivers with this DriverID/RequestID pair
// Condition checks no such record exists already to prevent duplicate records (error: Integrity constraint violation)
$stmt1 = $conn->prepare('SELECT * FROM TblDeclinedDrivers
WHERE DriverID = "' . $_POST['decliningDriverID'] . '" AND RequestID = "' . $_POST['declinedRequestID'] .'"');
$stmt1->execute();
$arr = $stmt1->fetch(PDO::FETCH_ASSOC);
if (empty($arr)){// This returns true if there is no record in TblDeclinedDrivers with this pair --> we can add one without throwing error
    $stmt2 = $conn->prepare('INSERT INTO TblDeclinedDrivers (DriverID, RequestID) VALUES
    ("' . $_POST['decliningDriverID'] . '", "' . $_POST['declinedRequestID'] . '")');
    $stmt2->execute();
}

// These lines ensure that if a driver declines a request they've previously accepted, they stop accepting it
// Sets DriverID to NULL if this request is driven by this driver
$stmt3 = $conn->prepare('UPDATE TblRequests SET DriverID = NULL
WHERE RequestID = "' . $_POST['declinedRequestID'] . '" AND DriverID = "' . $_POST['decliningDriverID'] . '"');
$stmt3->execute();
?>