<?php
include_once('connection.php');

// displaying all values for testing purposes
echo('DateOfJob: ' . $_POST['DateOfJob'] . '<br>');
echo('TimeOut: ' . $_POST['TimeOut'] . '<br>');
echo('TimeIn: ' . $_POST['TimeIn'] . '<br>');
echo('Destination: ' . $_POST['Destination'] . '<br>');
echo('Postcode: ' . $_POST['Postcode'] . '<br>');
echo('RequiredCapacity: ' . $_POST['RequiredCapacity'] . '<br>');
echo('Purpose: ' . $_POST['Purpose'] . '<br>');
echo('DriverRequired: ' . $_POST['DriverRequired'] . '<br>');

// validation
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
echo('<br>');
echo('Valid: ' . $valid . '<br>');

// Conversion to DateTimeIn
$DateTimeOut = $_POST['DateOfJob'] . ' ' . $_POST['TimeOut'];
echo($DateTimeOut);

// if ($valid == true){
//     $stmt = $conn->prepare("INSERT INTO TblRequests (RequestID,RegNumber,Capacity,)VALUES (null,:RegNumber,:Capacity,:NotAvailableFrom)");
//     $stmt->bindParam(':RegNumber', $_POST["RegNumber"]);
//     $stmt->execute();
//     $conn=null;
// }

?>