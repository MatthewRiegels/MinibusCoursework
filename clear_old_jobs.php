<?php
// This is a script page for when Kristian clears out the old requests on the history page

header('Location: job_history.php');
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);

// Show all details for testing
// echo("cutoffdate: " . $_POST["cutoffdate"] . "<br>");

// Delete record(s) from database TblRequests
$stmt = $conn->prepare('DELETE FROM TblRequests WHERE DateOfJob < "' . $_POST["cutoffdate"] . '"');
$stmt->execute();
?>