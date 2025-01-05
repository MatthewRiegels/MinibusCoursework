<?php
// This is the action page for when Kristian assigns a vehicle to a request

header('Location: ' . $_POST['redirectURL']);
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);

// Diplay form data for testing purposes
echo("redirectURL: " . $_POST['redirectURL'] . "<br>");
echo("assignedRequestID: " . $_POST['assignedRequestID'] . "<br>");
echo("assignedVehicleID: " . $_POST['assignedVehicleID'] . "<br>");

// Update record on TblRequests
$stmt = $conn->prepare('UPDATE TblRequests
                        SET VehicleID = "' . $_POST["assignedVehicleID"] . '"
                        WHERE RequestID = "' . $_POST["assignedRequestID"] . '"');
$stmt->execute();
$stmt->closeCursor();
?>