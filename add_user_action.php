<?php
// header('Location: add_user.php');
include_once('connection.php');
include_once('functions.php');
session_start();
checkRole($_SESSION, 0, 0, 1);

// Role management
$isAdmin = 0;
$isRequestor = 0;
$isDriver = 0;

switch ($_POST['Role']){
    case 'Admin':
        $isAdmin = 1;
        break;
    case 'StaffMember':
        $isRequestor = 1;
        break;
    case 'Driver':
        $isDriver = 1;
        break;
}

// Random password generation
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$randomPassword = '';
for ($i = 0; $i < 10; $i++) {
    $randomPassword = $randomPassword . $characters[random_int(0, strlen($characters) - 1)];
}

// Test outputs
echo('$isAdmin: ' . $isAdmin . '<br>');
echo('$isRequestor: ' . $isRequestor . '<br>');
echo('$isDriver: ' . $isDriver . '<br>');
echo('$randomPassword: ' . $randomPassword . '<br>');

// Inserting record into TblUsers
$stmt = $conn->prepare('INSERT INTO TblUsers (Password, Email, TelephoneNumber, Forename, Surname, IsDriver, IsAdmin, IsRequestor, HoursWorked)
VALUES (:Password, :Email, :TelephoneNumber, :Forename, :Surname, :IsDriver, :IsAdmin, :IsRequestor, :HoursWorked)');
$stmt->bindParam(':Password', $randomPassword);
$stmt->bindParam(':Email', $_POST['Email']);
$stmt->bindParam(':TelephoneNumber', $_POST['TelephoneNumber']);
$stmt->bindParam(':Forename', $_POST['Forename']);
$stmt->bindParam(':Surname', $_POST['Surname']);
$stmt->bindParam(':IsDriver', $isDriver);
$stmt->bindParam(':IsAdmin', $isAdmin);
$stmt->bindParam(':IsRequestor', $isRequestor);
$stmt->bindParam(':hoursWorked', $hoursWorked);
// $stmt->execute();

// Generating and sending email
$to = $_POST['Email'];
$subject = 'Please confirm your transport reservation account';
$msg = 'Hi ' . $_POST['Forename'] . ' ' . $_POST['Surname'] . ', your transport reservation account is ready for you.' . "\r\n";
$msg .= 'Your randomly-generated password is "' . $randomPassword . '"' . "\r\n";
$msg .= 'You\'re receiving this email because you requested to be addded to the transport reservation system.';
$msg .= 'If you were not expecting this email, you can safely ignore it.';
$headers = 'From:oundletransport@gmail.com';
// mail($to, $subject, $msg, $headers)

// Email outputs for testing
echo('To: ' . $to . '<br>');
echo('Subject: ' . $subject . '<br>');
echo('Message: ' . $msg . '<br>');
echo('Headers: ' . $headers . '<br>');
?>