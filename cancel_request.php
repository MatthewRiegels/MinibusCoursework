<?php
header('Location: ' . $_POST['redirectURL']);
include_once('connection.php');

// Display all values for testing
// echo('redirectURL: ' . $_POST['redirectURL'] . '<br>');
// echo('cancelledRequestID: ' . $_POST['cancelledRequestID'] . '<br>');

$stmt = $conn->prepare('DELETE FROM TblRequests WHERE RequestID = "' . $_POST['cancelledRequestID'] . '"');
$stmt->execute();
?>