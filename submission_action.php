<?php
header('Location: submission.php');
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 1, 0, 0);

// Form input management
// The checkbox input will not define $_POST['DriverRequired'] if the box is unchecked, but will hold the value 'on' if it is checked
// These lines ensure that $_POST['DriverRequired'] always exists, and is set to either 'on' or 'off'
if (!isset($_POST['DriverRequired'])){ 
    $_POST['DriverRequired'] = 'off'; 
} 

// Displaying all values for testing purposes
// echo('DateOfJob: ' . $_POST['DateOfJob'] . '<br>');
// echo('TimeOut: ' . $_POST['TimeOut'] . '<br>');
// echo('TimeIn: ' . $_POST['TimeIn'] . '<br>');
// echo('Destination: ' . $_POST['Destination'] . '<br>');
// echo('Postcode: ' . $_POST['Postcode'] . '<br>');
// echo('RequiredCapacity: ' . $_POST['RequiredCapacity'] . '<br>');
// echo('Purpose: ' . $_POST['Purpose'] . '<br>');
// echo('DriverRequired: ' . $_POST['DriverRequired'] . '<br>');

// Validation
$valid = 'True';
// TimeIn must be greater than TimeOut
if ($_POST['TimeIn'] <= $_POST['TimeOut']){
    $valid = 'False';
}
// Postcode must be alphanumeric
$postcode_stripped = str_replace(' ', '', $_POST['Postcode']);// removes dividing space
if (!ctype_alnum($postcode_stripped)){
    $valid = 'False';
}

// Output validity for testing purposes
// echo('Valid: ' . $valid . '<br>');

// Determine how to add DriverID to table
// If driver is required, DriverID is left blank so it can be filled with the ID of a driver that accepts the job
// If no driver is required, DriverID is ID of requestor
if ($_POST['DriverRequired'] == 'on'){
    $driverID = null;
}
else{
    $driverID = $_SESSION['UserID'];
}

// Determine how to add RequestorID to table
$requestorID = $_SESSION['UserID'];

// Add record to TblRequests
if ($valid == true){
    $stmt = $conn->prepare('INSERT INTO TblRequests (RequestID,DateOfJob,TimeOut,TimeIn,Destination,Postcode,Purpose,ReqCapacity,DriverID,VehicleID,RequestorID)
                            VALUES (null,:DateOfJob,:TimeOut,:TimeIn,:Destination,:Postcode,:Purpose,:ReqCapacity,:DriverID,null,:RequestorID)');
    $stmt->bindParam(':DateOfJob', $_POST['DateOfJob']);
    $stmt->bindParam(':TimeOut', $_POST['TimeOut']);
    $stmt->bindParam(':TimeIn', $_POST['TimeIn']);
    $stmt->bindParam(':Destination', $_POST['Destination']);
    $stmt->bindParam(':Postcode', $_POST['Postcode']);
    $stmt->bindParam(':Purpose', $_POST['Purpose']);
    $stmt->bindParam(':ReqCapacity', $_POST['RequiredCapacity']);
    $stmt->bindParam(':DriverID', $driverID);
    $stmt->bindParam(':RequestorID', $requestorID);
    $stmt->execute();
    $conn=null;
}
?>