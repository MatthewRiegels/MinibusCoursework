<?php
// This is a scripting page used when Kristian adds a new vehicle to the fleet (on the vehicle overview page)

header('Location: vehicle_overview.php');
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);

// output posted information for testing purposes
// echo("RegNumber: " . $_POST["RegNumber"] . "<br>");
// echo("Capacity: " . $_POST["Capacity"] . "<br>");
// echo("NotAvailableFrom: " . $_POST["NotAvailableFrom"] . "<br>");

// add record to TblVehicles
$stmt = $conn->prepare("INSERT INTO TblVehicles (RegNumber, Capacity, NotAvailableFrom)
                        VALUES (:RegNumber, :Capacity, :NotAvailableFrom)");
$stmt->bindParam(":RegNumber", $_POST["RegNumber"]);
$stmt->bindParam(":Capacity", $_POST["Capacity"]);
$stmt->bindParam(":NotAvailableFrom", $_POST["NotAvailableFrom"]);
$stmt->execute();
?>