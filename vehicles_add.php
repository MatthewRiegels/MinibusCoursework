<?php
header('Location: vehicles.php'); // if it breaks, comment this line first

include_once("connection.php");

array_map("htmlspecialchars", $_POST);

// print these out onto the page for the sake of debugging
// these lines are effectively useless unless the header is commented out so they wont affect user experience
echo("RegNumber: " . $_POST["RegNumber"]."<br>");
echo("Capacity: " . $_POST["Capacity"]."<br>");
echo("NotAvailableFrom: " . $_POST["NotAvailableFrom"]."<br>");

// insert a record with the appropraite information into TblVehicles
$stmt = $conn->prepare("INSERT INTO TblVehicles (VehicleID,RegNumber,Capacity,NotAvailableFrom)VALUES (null,:RegNumber,:Capacity,:NotAvailableFrom)");
$stmt->bindParam(':RegNumber', $_POST["RegNumber"]);
$stmt->bindParam(':Capacity', $_POST["Capacity"]);
$stmt->bindParam(':NotAvailableFrom', $_POST["NotAvailableFrom"]);
$stmt->execute();
$conn=null;