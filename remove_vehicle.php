<?php
// This is a scripting page for removing a vehicle from the fleet (from the vehicle details page)

header('Location: vehicle_overview.php');
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);

// Output all form data for testing
// echo("removedVehicleID: " . $_POST["removedVehicleID"] . "<br>");

// Delete record from database
$stmt = $conn->prepare('DELETE FROM TblVehicles WHERE VehicleID = "' . $_POST["removedVehicleID"] . '"');
$stmt->execute();
?>