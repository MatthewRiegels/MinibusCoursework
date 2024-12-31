<?php
// This is a scripting page for changing the NotAvailableFrom date on a vehicle (from the vehicle details page)

header('Location: vehicle_overview.php');
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);

// Display all values for testing
// echo("editedVehicleID: " . $_POST["editedVehicleID"] . "<br>");
// echo("newVehicleDate: " . $_POST["newVehicleDate"] . "<br>");

// Update record
$stmt = $conn->prepare('UPDATE TblVehicles SET NotAvailableFrom = "' . $_POST["newVehicleDate"] . '" WHERE VehicleID = "' . $_POST["editedVehicleID"] . '"');
$stmt->execute();
?>