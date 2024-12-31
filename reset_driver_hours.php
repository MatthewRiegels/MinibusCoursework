<?php
// This is a script page for resetting a driver's unpaid hours to zero

header('Location: ' . $_POST['redirectURL']);
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);

// Displaying all form data for testing
// echo("redirectURL: " . $_POST['redirectURL'] . "<br>");
// echo("resetDriverID: " . $_POST['resetDriverID'] . "<br>");

// Updating record on TblUsers
$stmt = $conn->prepare('UPDATE TblUsers SET HoursWorked = 0 WHERE UserID = "' . $_POST["resetDriverID"] . '"');
$stmt->execute();
?>